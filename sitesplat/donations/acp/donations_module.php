<?php
/**
*
* @package BBdonations
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\donations\acp;

class donations_module
{
	public $u_action;

	public function main($id, $mode)
	{
		global $db, $phpbb_container, $request, $config, $phpbb_extension_manager, $template, $user, $phpbb_root_path, $phpEx;

		// Requests
		$action = $request->variable('action', '');
		$user_id = $request->variable('user_id', 0);
		$submit = $request->is_set_post('submit');

		// Load a template from adm/style
		$this->tpl_name = 'acp_donations';

		// Set the page title
		$this->page_title = $user->lang('ACP_DONATIONS');
		
		// Get tables
		$table_donations = $phpbb_container->getParameter('sitesplat.donation.tables.donations');
		$table_countries = $phpbb_container->getParameter('sitesplat.donation.tables.countries');
		$this->config_text = $phpbb_container->get('config_text');

		$this->manager = $phpbb_container->get('sitesplat.donations.manager');
		$currency_symbol = $this->manager->currency(0, $config['donations_currency']);
		
		$template->assign_vars(array('U_ACTION' => $this->u_action));

		// Perform any actions submitted by the user
		switch ($action)
		{
			case 'details':
				$user->add_lang_ext('sitesplat/donations', 'info_acp_donations');
				$phpbb_container->get('sitesplat.BBCore.helper')->detail('sitesplat/donations');
				$this->tpl_name = 'acp_ext_details';
			break;
			
			default:
				if ($request->variable('status', '') == 'change')
				{
					$sql = 'SELECT id, user_id, payment_status, payment_date, mc_currency, mc_gross FROM ' . $table_donations . ' 
							WHERE id = ' . $request->variable('txn_id', 0);
					$result = $db->sql_query($sql);
					$row = $db->sql_fetchrow($result);
					$mc_gross = ($row['mc_currency'] == 'BBPOINTS') ? (int) $row['mc_gross'] / 100 : (int) $row['mc_gross'];
					$group_amount = json_decode($config['donations_group_id'], true);
					$membership = (isset($group_amount['amount']) && 
								   (($group_amount['time'] == -1) ? 300 : 
								   ($group_amount['time'] * 86400)) + $row['payment_date'] > time() ||
								   $group_amount['time'] == 0) ? true: false;
		
					$row['payment_status'] = ($row['payment_status'] != 'Completed' && $membership) ? 'Completed' : (($row['payment_status'] == 'Not verified') ? 'Expired' : 'Not verified');	
					$sql = 'UPDATE ' . $table_donations . ' SET payment_status = "' . $row['payment_status'] . '" 
							WHERE id = ' . $row['id'];
					$db->sql_query($sql);
					
					$sql = 'SELECT SUM(mc_gross) AS total FROM  ' . $table_donations . " 
							WHERE payment_status = 'Completed' OR payment_status = 'Expired'" . (($user_id) ? ' AND user_id = ' . $user_id: '');
					$result = $db->sql_query($sql);
					$total = $db->sql_fetchfield('total');
					
					$this->manager->add_delete_groups($row['user_id']);					
					$return_ary = array(
						'status'	=> $row['payment_status'],
						'id'		=> $row['id'],
						'total'		=> number_format($total, 2)
					);
					echo json_encode($return_ary);
					exit();
				}
		
				if (!$user_id)
				{
					if ($submit)
					{
						$old_donations_group_id = $config['donations_group_id'];
						$old_donations_fallbackgroup = $config['donations_fallbackgroup'];
						
						$option_ary = $request->variable('donations_options', array('' => ''));
						$config->set('donations_options', json_encode($option_ary));

						$config->set('donations_paypal_email',	$request->variable('donations_paypal_email', ''));
						$config->set('donations_bitcoin',	json_encode(array(
									'key' => $request->variable('donations_bitcoin_key', ''),
									'secret' => $request->variable('donations_bitcoin_secret', ''))));
						$config->set('donations_fallbackgroup',	$request->variable('donations_fallbackgroup', ''));
						$config->set('donations_currency', $request->variable('donations_country', 'EUR'));
		
						$donation_ary = $request->variable('donations', array(0 => array('' => '')), true);
						$group_ary = $request->variable('donations_group', array('' => ''));
						$group_ary['default'] = isset($group_ary['default']) ? 1 : 0;
						foreach($donation_ary as $key => $value)
						{
							if ($value['amount'] && ctype_digit($value['amount']))
							{
								$donation[$key] = array('amount' => $value['amount'], 'symbol' => $value['symbol']);
								$donation_txt[$key] = $value['text'];
							}
						}
						$config->set('donations_group_id', json_encode($group_ary));
						$config->set('donations_amounts', json_encode($donation));
						$this->config_text->set('donations_text', implode("\n", $donation_txt));
		
						if ($old_donations_group_id != $config['donations_group_id'] || $old_donations_fallbackgroup != $config['donations_fallbackgroup'])
						{
							$rows = array();
							$sql = 'SELECT DISTINCT user_id FROM '. $table_donations;
							$result = $db->sql_query($sql);
							while ($row = $db->sql_fetchrow($result))
							{
								$rows[] = $row['user_id'];
							}
							$this->manager->add_delete_groups($rows);

							if ($old_donations_fallbackgroup != $config['donations_fallbackgroup'])
							{
								include_once($phpbb_root_path . 'includes/functions_user.' . $phpEx);
								group_user_del($old_donations_fallbackgroup, $rows);
							}
						}
						
						trigger_error($user->lang['CONFIG_UPDATED'] . adm_back_link($this->u_action));
						$submit = false;
					}
		
					$sql = 'SELECT group_id, group_type, group_name FROM ' . GROUPS_TABLE . ' ORDER BY group_name ASC'; 
					$result = $db->sql_query($sql);
					$group_ary[0] = '----';
					while ($row = $db->sql_fetchrow($result))
					{
						$group_ary[$row['group_id']] = ($row['group_type'] == GROUP_SPECIAL) ? $user->lang['G_' . $row['group_name']] : $row['group_name'];
					}
								
					$group_amount = json_decode($config['donations_group_id'], true);
					for ($i = 0; $i < 1; $i++)
					{
						$template->assign_vars(array(
							'DONATIONS_AMOUNT'	=> $group_amount['amount'],
							'DONATIONS_TIME'	=> $group_amount['time'],
							'DONATIONS_DEFAULT'	=> ($group_amount['default']) ? ' checked="checked"' : ''
						));
						foreach ($group_ary as $key => $value)
						{
							$template->assign_block_vars('groups' . $i, array(
								'GROUP_ID'		=> $key,
								'GROUP_NAME'    => $value,
								'SELECTED' 		=> ($key == $group_amount['group']) ? ' selected="selected"' : '',
							));
						}
					}
	
					foreach ($group_ary as $key => $value)
					{
						$template->assign_block_vars('fallbackgroup', array(
							'GROUP_ID'		=> $key,
							'GROUP_NAME'    => $value,
							'SELECTED' 		=> ($key == $config['donations_fallbackgroup']) ? ' selected="selected"' : '',
						));
					}

					$donations_text = explode("\n", $this->config_text->get('donations_text'));
					$donations_amounts = json_decode($config['donations_amounts'], true);
					foreach ($donations_amounts as $key => $value)
					{
						$options = '';
						foreach ($this->manager->symbols() as $symbolkey => $symbol)
						{
							$options .= '<option value="' . $symbolkey . '"' . (($symbolkey == $value['symbol']) ? ' selected="selected"' : '') . '">' . $symbol . '</option>';	
						}
						$template->assign_block_vars('amounts', array(
							'ID'		=> $key,
							'VALUE'		=> $value['amount'],
							'TXT'		=> (isset($donations_text[$key])) ? $donations_text[$key] : '',
							'OPTIONS'	=> $options
						));
					}

					$sql = 'SELECT SUM(mc_gross) AS total FROM  ' . $table_donations . " WHERE payment_status = 'Completed' OR payment_status = 'Expired'";
					$db->sql_query($sql);
					$total = $db->sql_fetchfield('total');
		
					$bitcoin = json_decode($config['donations_bitcoin'], true);
					$options = json_decode($config['donations_options'], true);
					$template->assign_vars(array(
						'DONATIONS_SANDBOX'			=> $options['sandbox'],
						'DONATIONS_MESSAGE'			=> $options['message'],
						'DONATIONS_LIST'			=> $options['list'],
						'DONATIONS_PAYPAL_EMAIL'	=> $config['donations_paypal_email'],
						'DONATIONS_BITCOIN_KEY'		=> isset($bitcoin['key']) ? $bitcoin['key'] : '',
						'DONATIONS_BITCOIN_SECRET'	=> isset($bitcoin['secret']) ? $bitcoin['secret'] : '',
						'DONATIONS_CURRENCY'		=> $currency_symbol,
						'DONATIONS_CURRENCIES'		=> $this->manager->currency($config['donations_currency']),
						'DONATIONS_TOTAL'        	=> number_format(($total) ? $total : 0, 2),
						'EXT_PATH'	=> $phpbb_container->get('path_helper')->update_web_root_path($phpbb_extension_manager->get_extension_path('sitesplat/donations', true)),			
					));
				}

				if ($user_id > 1)
				{
					$sql = 'SELECT u.user_id, u.username, u.user_colour, d.sender, d.payer_email, d.address, c.country
							FROM ' . USERS_TABLE . ' u
							LEFT JOIN ' . $table_donations . ' d ON u.user_id = d.user_id
							LEFT JOIN ' . $table_countries . ' c ON c.country_code = d.address_country_code
							WHERE u.user_id = ' . $user_id;
					$result = $db->sql_query($sql);
					$row = $db->sql_fetchrow($result);
					$user_id = $row['user_id'];
					$payer_email = $row['payer_email'];
					
					$template->assign_vars(array(
						'DONATIONS_CURRENCY'			=> $currency_symbol,
						'DONATIONS_ADDRESS'				=> $row['address'],
						'DONATIONS_COUNTRY'				=> $row['country'],
						'USER_PROFILE'      			=> ($user_id != 1) ? $row['username'] : $row['sender'],
						'S_USER_SELECTED'   			=> true,
					));
		
					$sql = 'SELECT *
							FROM ' . $table_donations . '
							WHERE ' . (($user_id != 1) ? 'user_id = ' . $user_id : 'payer_email="' . $payer_email . '"') . '
							ORDER BY payment_date DESC';
					$result = $db->sql_query($sql);
					$total_amount = 0;
					while ($row = $db->sql_fetchrow($result))
					{
						$template->assign_block_vars('transactions', array(
							'ID'				=> $row['id'],
							'PAYMENT_TYPE'		=> ($row['payment_type'] == 1) ? 'fa-paypal' : 'fa-bitcoin',
							'PP_TRANSACTION'	=> $row['txn_id'],
							'AMOUNT'        	=> number_format($row['mc_gross'], 2),
							'STATUS'			=> $row['payment_status'],
							'U_PAYMENT_STATUS'	=> '../../' . $this->u_action . '&amp;user_id=' . $row['user_id'] . '&amp;txn_id=' . $row['id'] . '&amp;status=change',
							'TIME'           	=> $user->format_date($row['payment_date']),
						));
						$total_amount += ($row['payment_status'] == 'Completed' || $row['payment_status'] == 'Expired') ? $row['mc_gross'] : 0;
					}
					$db->sql_freeresult($result);
					$template->assign_vars(array(
						'DONATIONS_TOTAL'	=> number_format($total_amount, 2),
					));

				} else
				{
				// generate the users list - This is a memory killer on large baords.
                // line 108 acp_donations.html				
				//	$sql = 'SELECT user_id, username
				//			FROM ' . USERS_TABLE . '
				//			WHERE ' . $db->sql_in_set('user_type', array(USER_INACTIVE, USER_IGNORE), true) . '
				//			ORDER BY username';
				//	$db->sql_query($sql);
				//	$result = $db->sql_query($sql);
				//	while ($row = $db->sql_fetchrow($result))
				//	{
				//		$template->assign_block_vars('users', array(
				//			'USER_NAME'			=> $row['username'],
				//			'USER_ID_URL'		=> $this->u_action . '&amp;user_id=' . $row['user_id'],
				//		));
				//	}
					
					$sql = 'SELECT COUNT(id) AS total FROM ' . $table_donations;
					$result = $db->sql_query($sql);
					$total = $db->sql_fetchfield('total');
					$config['topics_per_page'] = 10;
					
					$pagination = $phpbb_container->get('pagination');
					$start = $request->variable('start', 0);
					$start = $pagination->validate_start($start, $config['topics_per_page'], $total);

					$sql = 'SELECT d.id, d.txn_id, d.user_id, d.sender, d.payer_email, d.mc_gross, d.payment_type, d.payment_status, d.payment_date, u.username, u.user_email 
							FROM ' . $table_donations . ' d	
							LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = d.user_id
							ORDER BY d.payment_date DESC, u.username ASC'; 
					$result = $db->sql_query_limit($sql, $config['topics_per_page'], $start);
					while ($row = $db->sql_fetchrow($result))
					{
						$template->assign_block_vars('donations', array(
							'ID'				=> $row['id'],
							'PAYMENT_TYPE'		=> ($row['payment_type'] == 1) ? 'fa-paypal' : 'fa-bitcoin',
							'USERNAME'			=> ($row['user_id'] > 1) ? $row['username'] : $row['sender'],
							'EMAIL'				=> ($row['user_id'] > 1) ? $row['user_email'] : $row['payer_email'],
							'DONATIONURL'		=> $this->u_action . '&amp;user_id=' . $row['user_id'],
							'PP_TRANSACTION'	=> $row['txn_id'],
							'AMOUNT'        	=> number_format($row['mc_gross'], 2),
							'STATUS'			=> $row['payment_status'],
							'U_PAYMENT_STATUS'	=> '../../' . $this->u_action . '&amp;txn_id=' . $row['id'] . '&amp;status=change',
							'TIME'           	=> $user->format_date($row['payment_date']),
						));
					}
					
					$base_url = $this->u_action;
					$pagination->generate_template_pagination($base_url, 'pagination', 'start', $total, $config['topics_per_page'], $start);
				}
			break;
		}
	}
}
