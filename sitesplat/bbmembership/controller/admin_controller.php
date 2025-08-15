<?php
/**
*
* BBmembership extension for the phpBB Forum Software package.
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbmembership\controller;
use phpbb\db\driver\driver_interface;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\user;
use phpbb\config\config;
use phpbb\pagination;
use phpbb\json_response;

/**
* Main controller
*/
class admin_controller
{
	protected $db;
	protected $request;
	protected $template;
	protected $user;
	protected $config;
	protected $pagination;
	protected $root_path;
	protected $php_ext;
	protected $bbmembership_table;
	protected $bbmembership_helper;

	/**
	* Constructor
	*
	* @access public
	*/
	public function __construct(driver_interface $db, request $request, template $template, user $user, config $config, pagination $pagination, $root_path, $php_ext, $bbmembership_table, $bbmembership_helper)
	{
		$this->db = $db;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->config = $config;
		$this->pagination = $pagination;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		$this->bbmembership_table = $bbmembership_table;
		$this->bbmembership_helper = $bbmembership_helper;
		$this->bbmembership_groups = json_decode($this->config['bbmembership_groups'], true);
		$this->bbmembership_package = json_decode($this->config['bbmembership_package'], true);
	}

	/**
	* Badge Award Close Notice
	*
	* @return null
	* @access public
	*/
	public function close_notice()
	{
		$response = $this->set_close_notice_cookie();

		// Send a JSON response if an AJAX request was used
		if ($this->request->is_ajax())
		{
			$json_response = new \phpbb\json_response;
			$json_response->send(array(
				'success' => $response,
			));
		}
		exit();
	}

	/**
	* Set a cookie to keep an notice closed
	*
	* @return bool True
	* @access protected
	*/
	protected function set_close_notice_cookie()
	{
		// Store the close_notice in a cookie with a 1 year expiration
		$this->user->set_cookie('bbmem', 'bbmembership_notice_closed', time() + 31536000);

		return true;
	}
	/**
	* Display the page
	*
	* @access public
	*/
	public function display()
	{
		if (check_link_hash($this->request->variable('hash', ''), 'close_notice'))
		{
			$this->close_notice();
		}

		$cookie = $this->request->variable($this->config['cookie_name'] . '_bbmem', '', true, \phpbb\request\request_interface::COOKIE);
		$this->template->assign_vars(array(
			'S_NOTICE_BBPOINTS'			=> (!$this->bbmembership_helper->bbpoints_enabled() && !$cookie) ? $this->user->lang['BBPOINTS_NOTICE'] : '',
			'BBPOINTS_ENABLED'			=> $this->bbmembership_helper->bbpoints_enabled(),
			'U_BBPOINTS_NOTICE_CLOSE'	=> $this->u_action . '&amp;hash=' . generate_link_hash('close_notice')
		));

		if ($this->request->variable('status', '') == 'change')
		{
			$sql = 'SELECT id, user_id, membership, payment_status, payment_date, mc_currency, mc_gross FROM ' . $this->bbmembership_table . ' 
					WHERE id = ' . $this->request->variable('txn_id', 0);
			$result = $this->db->sql_query($sql);
			$row = $this->db->sql_fetchrow($result);

			$mc_gross = $this->bbmembership_helper->find_membership($this->bbmembership_package, 'id', (int) $row['membership']);	
			$membership = (isset($this->bbmembership_groups[$mc_gross]) && 
						   (($this->bbmembership_groups[$mc_gross]['expire'] == -1) ? 300 : 
						   ($this->bbmembership_groups[$mc_gross]['expire'] * 86400)) + $row['payment_date'] > time() ||
						   $this->bbmembership_groups[$mc_gross]['expire'] == 0) ? true: false;

			$row['payment_status'] = ($row['payment_status'] != 'Completed' && $membership) ? 'Completed' : (($row['payment_status'] == 'Not verified') ? 'Expired' : 'Not verified');	
			$sql = 'UPDATE ' . $this->bbmembership_table . ' SET payment_status = "' . $row['payment_status'] . '" 
					WHERE id = ' . $row['id'];
			$this->db->sql_query($sql);
			
			if ($row['payment_status'] == 'Completed' && $membership)
			{
				$this->bbmembership_helper->add_group($row['user_id'], $mc_gross, $row['id']);
			} else
			{
				$this->bbmembership_helper->dell_group($row['user_id'], $mc_gross);
			}
			
			$return_ary = array(
				'status'	=> $row['payment_status'],
				'id'		=> $row['id'],
			);
			echo json_encode($return_ary);
			exit();
		}
				
		if ($this->request->is_set_post('submit'))
		{
			$this->config->set('bbmembership_sandbox', $this->request->variable('bbmembership_sandbox', 1));
			$this->config->set('bbmembership_clubmode', $this->request->variable('bbmembership_clubmode', 1));
			$this->config->set('bbmembership_paypal_email', $this->request->variable('bbmembership_paypal_email', ''));
			$this->config->set('bbmembership_currency', $this->request->variable('bbmembership_currency', ''));
			$this->config->set('bbmembership_bbpoints', $this->request->variable('bbmembership_bbpoints', 0));
			$this->config->set('bbmembership_countdown', $this->request->variable('bbmembership_countdown', 0));

			$donation_ary = $this->request->variable('bbmembership_amount', array(0 => 0));
			$group_ary = $this->request->variable('bbmembership_group', array(0 => 0));
			$expire_ary = $this->request->variable('bbmembership_expire', array(0 => 365));
			$package_ary = $this->request->variable('bbmembership_package', array(0 => ''));
			$default_ary = $this->request->variable('bbmembership_default', array(0 => 0));
			$hide_ary = $this->request->variable('bbmembership_hide', array(0 => 0));

			$group_amount = array();
			foreach ($donation_ary as $key => $value)
			{
				$group_amount[$value] = array(
					'group'		=> $group_ary[$key],
					'expire'	=> $expire_ary[$key],
					'default'	=> (isset($default_ary[$key])) ? 1 : 0,
					'hide'		=> (isset($hide_ary[$key])) ? 1 : 0,
				);
			}
			
			(sizeof($group_amount) == 4) ? $this->config->set('bbmembership_groups', json_encode($group_amount)) : 
											$this->show_result($this->user->lang['ACP_BBMEMBERSHIP_SAVE_ERROR']);

			$group_amount = array();
			$i = 0;
			foreach ($donation_ary as $key => $value)
			{
				$group_amount[$value] = array(
					'id'		=> ++$i,
					'package'	=> $package_ary[$key],
				);
			}

			$this->config->set('bbmembership_package', json_encode($group_amount));

			trigger_error($this->user->lang('CONFIG_UPDATED') . adm_back_link($this->u_action));
		}
				
		$sql = 'SELECT group_id, group_type, group_name	FROM ' . GROUPS_TABLE . ' ORDER BY group_name ASC';
		$result = $this->db->sql_query($sql);
		$group_ary[0] = '----';
		while ($row = $this->db->sql_fetchrow($result))
		{
			$group_ary[$row['group_id']] = ($row['group_type'] == GROUP_SPECIAL) ? $this->user->lang('G_' . $row['group_name']) : $row['group_name'];
		}

		if (!empty($this->bbmembership_groups))
		{
			$count = 0;
			foreach ($this->bbmembership_groups as $key => $value)
			{
				$this->template->assign_block_vars('membership', array(
					'BBMEMBERSHIP_ID'		=> $count,
					'BBMEMBERSHIP_AMOUNT'	=> $key,
					'BBMEMBERSHIP_EXPIRE'	=> $value['expire'],
					'BBMEMBERSHIP_PACKAGE'	=> $this->bbmembership_package[$key]['package'],
					'BBMEMBERSHIP_DEFAULT'	=> ($value['default']) ? ' checked="checked"' : '',
					'BBMEMBERSHIP_HIDE'		=> ($value['hide']) ? ' checked="checked"' : ''
				));

				foreach ($group_ary as $key2 => $value)
				{
					$this->template->assign_block_vars('membership.groups', array(
						'GROUP_ID'		=> $key2,
						'GROUP_NAME'	=> $value,
						'SELECTED'		=> ($key2 == $this->bbmembership_groups[$key]['group']) ? ' selected="selected"' : ''
					));
				}
				$count++;
			}
		}

		$sql = 'SELECT 
				SUM(CASE WHEN mc_currency = "BBPOINTS" THEN mc_gross ELSE 0 END) AS bbpoints, 
				SUM(CASE WHEN mc_currency <> "BBPOINTS" THEN mc_gross ELSE 0 END) AS euro 
				FROM ' . $this->bbmembership_table . "
				WHERE payment_status <> 'Not verified'";
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$bbpointstotal = $row['bbpoints'];
		$eurototal = $row['euro'];

		$this->template->assign_vars(array(
			'U_ACTION'						=> $this->u_action,
			'BBMEMBERSHIP_SANDBOX'			=> $this->config['bbmembership_sandbox'],
			'BBMEMBERSHIP_CLUBMODE'			=> $this->config['bbmembership_clubmode'],
			'BBMEMBERSHIP_PAYPAL_EMAIL'		=> $this->config['bbmembership_paypal_email'],
			'BBMEMBERSHIP_CURRENCY_OPTIONS'	=> $this->bbmembership_helper->currency($this->config['bbmembership_currency']),
			'BBMEMBERSHIP_CURRENCY'			=> $this->bbmembership_helper->currency(0, $this->config['bbmembership_currency']),
			'BBMEMBERSHIP_TOTAL'			=> number_format(($eurototal) ? $eurototal : 0, 2),
			'BBMEMBERSHIP_BBPOINTS_TOTAL'	=> number_format(($bbpointstotal) ? $bbpointstotal : 0, 2),
			'BBMEMBERSHIP_BBPOINTS'			=> $this->config['bbmembership_bbpoints'],
			'BBMEMBERSHIP_COUNTDOWN'		=> $this->config['bbmembership_countdown'],
			'LAST_MEMBERSHIP_CHECK'			=> ($this->config['bbmembership_last_gc']) ? $this->user->format_date($this->config['bbmembership_last_gc']) : '-',
			'UA_PROGRESS_BAR'				=> html_entity_decode($this->u_action . '&amp;action=progressbar&time=' . time()),
			'BBMEMBERSHIP_SEARCH'			=> $this->root_path . 'bbmembership/search_user'
		));

		$txn_id = $this->request->variable('txn_id', 0);
		$user_id = $this->request->variable('user_id', 0);
		if ($txn_id || ($user_id > 1))
		{
			$sql = 'SELECT u.user_id, u.username, u.user_colour, d.sender, d.payer_email, d.address, d.address_country_code
					FROM ' . $this->bbmembership_table . ' d
					LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = d.user_id
					WHERE ' . (($txn_id) ? 'd.id = ' . $txn_id : 'u.user_id = ' . $user_id);
			$result = $this->db->sql_query($sql);
			$row = $this->db->sql_fetchrow($result);
			$user_id = $row['user_id'];
			$payer_email = $row['payer_email'];
			
			$this->template->assign_vars(array(
				'TRANSACTION_CURRENCY'		=> $this->bbmembership_helper->currency(0, $this->config['bbmembership_currency']),
				'USER_ADDRESS'				=> $row['address'],
				'USER_COUNTRY'				=> $row['address_country_code'],
				'USER_PROFILE'      		=> ($user_id != 1) ? $row['username'] : $row['sender'],
				'S_USER_SELECTED'   		=> true,
			));

			$sql = 'SELECT *
					FROM ' . $this->bbmembership_table . '
					WHERE ' . (($user_id > 1) ? 'user_id = ' . $user_id : 'payer_email = "' . $payer_email . '"') . '
					ORDER BY payment_date DESC';
			$result = $this->db->sql_query($sql);
			$eurototal = $bbpointstotal = 0;
			$amounts = array_keys($this->bbmembership_groups);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$mc_gross = $this->bbmembership_helper->find_membership($this->bbmembership_package, 'id', (int) $row['membership']);	
				$membership = (!$this->bbmembership_groups[$mc_gross]['expire'] || 
							  ($this->bbmembership_groups[$mc_gross]['expire'] * 86400) + $row['payment_date'] > time()) ? true: false;
				$this->template->assign_block_vars('transactions', array(
					'PP_TRANSACTION'	=> $row['txn_id'],
					'AMOUNT'        	=> number_format($row['mc_gross'], 2),
					'STATUS'			=> $row['payment_status'],
					'CURRENCY'			=> ($row['mc_currency'] == 'BBPOINTS') ? 'BBpoints' : $this->bbmembership_helper->currency(0, $row['mc_currency']),
					'PACKAGE'			=> array_search($mc_gross, $amounts) + 1,
					'EXPIRED'			=> ($membership) ? '-' : '&radic;',
					'TIME'           	=> $this->user->format_date($row['payment_date']),
				));
				$eurototal += ($row['payment_status'] != 'Not verified' && $row['mc_currency'] != 'BBPOINTS') ? $row['mc_gross'] : 0;
				$bbpointstotal += ($row['payment_status'] != 'Not verified' && $row['mc_currency'] == 'BBPOINTS') ? $row['mc_gross'] : 0;
			}
			$this->db->sql_freeresult($result);
			$this->template->assign_vars(array(
				'TOTAL_EURO'		=> number_format($eurototal, 2),
				'TOTAL_BBPOINTS'	=> number_format($bbpointstotal, 2),
			));

		} else
		{
			$sql = 'SELECT COUNT(id) AS total FROM ' . $this->bbmembership_table;
			$result = $this->db->sql_query($sql);
			$total = $this->db->sql_fetchfield('total');
			$config['topics_per_page'] = 10;
			
			$start = $this->request->variable('start', 0);
			$start = $this->pagination->validate_start($start, $this->config['topics_per_page'], $total);

			$sql = 'SELECT d.id, d.txn_id, d.user_id, d.sender, d.payer_email, d.mc_gross, d.mc_currency, d.payment_status, d.payment_date, u.username, u.user_email, membership 
					FROM ' . $this->bbmembership_table . ' d	
					LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = d.user_id
					ORDER BY d.payment_date DESC, u.username ASC'; 
			$result = $this->db->sql_query_limit($sql, $config['topics_per_page'], $start);
			$amounts = array_keys($this->bbmembership_groups);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$mc_gross = $this->bbmembership_helper->find_membership($this->bbmembership_package, 'id', (int) $row['membership']);	
				$this->template->assign_block_vars('transactions', array(
					'ID'				=> $row['id'],
					'USERNAME'			=> ($row['user_id'] > 1) ? $row['username'] : $row['sender'],
					'EMAIL'				=> ($row['user_id'] > 1) ? $row['user_email'] : $row['payer_email'],
					'DONATIONURL'		=> $this->u_action . '&amp;txn_id=' . $row['id'],
					'PP_TRANSACTION'	=> $row['txn_id'],
					'CURRENCY'			=> ($row['mc_currency'] == 'BBPOINTS') ? 'BBpoints' : $this->bbmembership_helper->currency(0, $row['mc_currency']),
					'AMOUNT'        	=> number_format($row['mc_gross'], 2),
					'STATUS'			=> $row['payment_status'],
					'PACKAGE'			=> array_search($mc_gross, $amounts) + 1,
					'U_PAYMENT_STATUS'	=> '../../' . $this->u_action . '&action=orderdetail&amp;txn_id=' . $row['id'] . '&amp;status=change',
					'TIME'           	=> $this->user->format_date($row['payment_date']),
				));
			}
			
			$base_url = $this->u_action;
			$this->pagination->generate_template_pagination($base_url, 'pagination', 'start', $total, $config['topics_per_page'], $start);
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function search_user()
	{
		$term = strtolower($this->request->variable('term', '', true));
		$sql = 'SELECT user_id, username FROM ' . USERS_TABLE . ' WHERE user_id <> ' . 0 . ' AND user_type <> ' . USER_IGNORE . ' AND username_clean like "' . $term . '%"';
		$result = $this->db->sql_query($sql);
		$user_ary = array();
		while($row = $this->db->sql_fetchrow($result)) 
		{
			$user_ary[] = array('value' => $row['user_id'], 'label' => $row['username']);
		}
		$json_response = new json_response();
		$json_response->send($user_ary);
	}

	/**
	 * {@inheritdoc}
	 */
	public function sync_membership()
	{
		$this->get_max_id();
		$this->batch_size = 50;

		$starttime = explode(' ', microtime());
		$starttime = $starttime[1] + $starttime[0];
		$post_counter = $this->request->variable('skiprows', 0);
		
		while (still_on_time(20) && $post_counter < $this->total_ids)
		{
			$sql = 'SELECT id, membership, mc_gross, mc_currency, payment_status, payment_date, user_id FROM ' . $this->bbmembership_table . ' ORDER BY id ASC';
			$result = $this->db->sql_query_limit($sql, $this->batch_size, $post_counter);

			while ($row = $this->db->sql_fetchrow($result))
			{
				$mc_gross = $this->bbmembership_helper->find_membership($this->bbmembership_package, 'id', (int) $row['membership']);	
			//	$mc_gross = ($row['mc_currency'] == 'BBPOINTS') ? (int) $rowmc_gross / 100 : (int) $rowmc_gross;
				$membership = (isset($this->bbmembership_groups[$mc_gross]) && 
							  (($this->bbmembership_groups[$mc_gross]['expire'] == -1) ? 300 : 
							  ($this->bbmembership_groups[$mc_gross]['expire'] * 86400)) + $row['payment_date'] > time() ||
							  $this->bbmembership_groups[$mc_gross]['expire'] == 0) ? true: false;

				if ($membership)
				{
					if ($row['payment_status'] == 'Completed')
					{
						$this->bbmembership_helper->add_group($row['user_id'], $mc_gross, $row['id']);	
					}
					
				} else
				{
					if ($row['payment_status'] != 'Expired')
					{
						$this->bbmembership_helper->dell_group($row['user_id'], $mc_gross);	
						$sql1 = 'UPDATE ' . $this->bbmembership_table  . ' SET payment_status =  "Expired" WHERE id = ' . $row['id'];
						$this->db->sql_query($sql1);
					}
				}
				$post_counter++;
			}
		}

		if ($post_counter <= $this->total_ids)
		{
			$return = array(
				'postcounter'	=> $post_counter,
				'url'			=> ($post_counter < $this->total_ids) ? 
									html_entity_decode($this->u_action . '&action=progressbar&skiprows=' . $post_counter . '&time=' . time()) : 0,
				'percent'		=> round((($post_counter > $this->total_ids) ? $this->total_ids : $post_counter) / $this->total_ids, 3) * 100
			);
		} else
		{
			$return = array(
				'url'		=> 0,
				'percent'	=> 100
			);
		}
		
		$this->config->set('bbmembership_last_gc', time());
		echo json_encode($return);
		exit();
	}

	/**
	 * {@inheritdoc}
	 */
	function get_max_id()
	{
		$sql = 'SELECT MIN(id) AS min_id, MAX(id) AS max_id, COUNT(id) AS total FROM '. $this->bbmembership_table;
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->min_id = (int) $row['min_id'];
		$this->max_id = (int) $row['max_id'];
		$this->total_ids = (int) $row['total'];
		$this->db->sql_freeresult($result);
	}


	/**
	 * {@inheritdoc}
	 */
	public function show_result($message)
	{
		if ($this->request->is_ajax())
		{
			$json_response = new \phpbb\json_response;
			$json_response->send(array(
				'MESSAGE_TITLE'	=> $this->user->lang['INFORMATION'],
				'MESSAGE_TEXT'	=> $message,
				'REFRESH_DATA'	=> array(
					'time'	=> 3,
					'url'	=> $this->u_action
				)
			));
		} else
		{
			trigger_error($message . adm_back_link($this->u_action), E_USER_NOTICE);
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}
