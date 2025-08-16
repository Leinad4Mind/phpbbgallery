<?php
/**
 *
 * No DEA Emails. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2020, Picaron, https://github.com/picaronin/
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace pikaron\nodeaemails\acp;

/**
* @package acp
*/
class acp_nodeaemails_module
{
	/** @var string */
	public $tpl_name;

	/** @var string */
	public $page_title;

	/** @var string */
	public $u_action;

	/**
	 * ACP module constructor.
	 *
	 * @return void
	 */
	public function __construct()
	{
		global $phpbb_container;

		$this->config				 = $phpbb_container->get('config');
		$this->request				 = $phpbb_container->get('request');
		$this->language				 = $phpbb_container->get('language');
		$this->user					 = $phpbb_container->get('user');
		$this->auth					 = $phpbb_container->get('auth');
		$this->template				 = $phpbb_container->get('template');
		$this->phpbb_log			 = $phpbb_container->get('log');
		$this->db					 = $phpbb_container->get('dbal.conn');
		$this->phpbb_root_path		 = $phpbb_container->getParameter('core.root_path');
		$this->php_ext				 = $phpbb_container->getParameter('core.php_ext');
		$this->functions_nodeaemails = $phpbb_container->get('pikaron.nodeaemails.core.functions.nodeaemails');
		$this->pagination			 = $phpbb_container->get('pagination');
	}

	public function main($id, $mode)
	{
		switch ($mode)
		{
			case 'configuration':
				$this->display_configuration($mode);
			break;

			case 'locals':
				$this->display_locals($mode);
			break;

			case 'users':
				$this->display_users($mode);
			break;
		}
	}

	// Configuration
	public function display_configuration($mode)
	{
		$submit = $this->request->is_set_post('submit');

		$display_vars = array(
			'vars'	=> array(
				'legend'					=> 'GENERAL_OPTIONS',
				'nodeaemails_cron_gc'		=> array('lang' => 'L_NO_DEA_EMAILS_DELAY', 'validate' => 'int:15:86400', 'type' => 'number:300:86400', 'explain' => true, 'append' => ' ' . $this->language->lang('L_DEA_DELAY')),
			)
		);

		$this->tpl_name		= 'acp_dea_config';
		$this->page_title	= $this->language->lang('ACP_NO_DEA_EMAILS') . ' - ' . $this->language->lang('ACP_NO_DEA_EMAILS_SETTINGS');

		$form_key = 'acp_dea_config';
		add_form_key($form_key);

		$cfg_array = $this->request->is_set('config') ? $this->request->variable('config', array('' => ''), true) : $this->config;
		$error = array();

		// We validate the complete config if whished
		validate_config_vars($display_vars['vars'], $cfg_array, $error);

		if ($submit && !check_form_key($form_key))
		{
			$error[] = $this->language->lang('FORM_INVALID');
		}

		// Do not write values if there is an error
		if (sizeof($error))
		{
			$submit = false;
		}

		// Save the config vars if submit
		foreach ($display_vars['vars'] as $config_name => $null)
		{
			if (!isset($cfg_array[$config_name]))
			{
				continue;
			}

			if ($submit)
			{
				$this->config->set($config_name, $cfg_array[$config_name]);
			}
		}

		if ($submit)
		{
			// Save log
			$this->phpbb_log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_CONFIG_' . strtoupper($mode));
			trigger_error($this->language->lang('CONFIG_UPDATED') . adm_back_link($this->u_action));
		}

		$this->template->assign_vars(array(
			'S_NO_DEA_EMAILS_CONF'		 => $cfg_array['nodeaemails_cron_gc'],
			'S_NO_DEA_EMAILS_MINUTES'	 => (int) ($cfg_array['nodeaemails_cron_gc'] / 60),
			'S_NO_DEA_EMAILS_VERSION'	 => str_replace('-', '--', $this->config['nodeaemails_version']),
			'S_ERROR'					 => sizeof($error) ? true : false,
			'ERROR_MSG'					 => implode('<br />', $error),
			'U_ACTION'					 => $this->u_action
		));

		// Show Emails take with CRON
		$MiArray = $this->functions_nodeaemails->load_external_deas();
		$count = count($MiArray);
		$minus = ($count % 5);
		$counter = ($minus != 0) ? $count - $minus + 5 : $count;

		$this->template->assign_vars(array(
			'S_NO_DEA_EMAILS_CANT'		 => $count,
			'S_NO_DEA_EMAILS_TIMES'		 => $this->config['nodeaemails_counter'],
			'S_NO_DEA_EMAILS_DATE'		 => $this->user->format_date($this->config['nodeaemails_cron_last_gc'], $this->config['default_dateformat']),
		));

		// Add Emails DEA to Template
		for ($i = 0; $i < $counter; $i += 5)
		{
			$this->template->assign_block_vars('emailsex', array(
				'S_NO_DEA_EMAILS_EMA0' => isset($MiArray[$i]) ? $MiArray[$i] : '',
				'S_NO_DEA_EMAILS_EMA1' => isset($MiArray[$i+1]) ? $MiArray[$i+1] : '',
				'S_NO_DEA_EMAILS_EMA2' => isset($MiArray[$i+2]) ? $MiArray[$i+2] : '',
				'S_NO_DEA_EMAILS_EMA3' => isset($MiArray[$i+3]) ? $MiArray[$i+3] : '',
				'S_NO_DEA_EMAILS_EMA4' => isset($MiArray[$i+4]) ? $MiArray[$i+4] : '',
			));
		}
	}

	// Locals
	public function display_locals($mode)
	{
		$this->tpl_name		= 'acp_dea_locals';
		$this->page_title	= $this->language->lang('ACP_NO_DEA_EMAILS') . ' - ' . $this->language->lang('ACP_NO_DEA_EMAILS_LOCALS');

		$form_key = 'acp_dea_locals';
		add_form_key($form_key);

		// Show Emails take with CRON
		$MiArray = $this->functions_nodeaemails->load_local_deas();
		$count = count($MiArray);
		$minus = ($count % 5);
		$counter = ($minus != 0) ? $count - $minus + 5 : $count;

		$this->template->assign_vars(array(
			'S_NO_DEA_EMAILS_CANT'		 => $count,
			'S_NO_DEA_EMAILS_VERSION'	 => str_replace('-', '--', $this->config['nodeaemails_version']),
			'U_ACTION'					 => $this->u_action,
		));

		// Add local Emails DEA to Template
		for ($i = 0; $i < $counter; $i += 5)
		{
			$this->template->assign_block_vars('emailsex', array(
				'S_NO_DEA_EMAILS_EMA0' => isset($MiArray[$i]) ? $MiArray[$i] : '',
				'S_NO_DEA_EMAILS_EMA1' => isset($MiArray[$i+1]) ? $MiArray[$i+1] : '',
				'S_NO_DEA_EMAILS_EMA2' => isset($MiArray[$i+2]) ? $MiArray[$i+2] : '',
				'S_NO_DEA_EMAILS_EMA3' => isset($MiArray[$i+3]) ? $MiArray[$i+3] : '',
				'S_NO_DEA_EMAILS_EMA4' => isset($MiArray[$i+4]) ? $MiArray[$i+4] : '',
			));
		}

		/// Save Domain
		$deadomain = $this->request->variable('deadomain', '');
		$deaaction = $this->request->variable('deaaction', '');
		$submit = $this->request->is_set_post('submit');

		if ($submit && $deadomain)
		{
			$deadomain = strtolower(trim($deadomain));

			if (!check_form_key($form_key))
			{
				trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			if ($deaaction == '1')
			{
				if (strpos($deadomain, '.') === false)
				{
					trigger_error($this->language->lang('L_NO_DEA_EMAILS_DOM_VALID', $deadomain) . adm_back_link($this->u_action), E_USER_WARNING);
				}

				$resp = $this->functions_nodeaemails->save_deas($deadomain);

				if ($resp > 1)
				{
					trigger_error($this->language->lang('L_NO_DEA_EMAILS_DOM_SAVE', $deadomain) . adm_back_link($this->u_action));
				}
				else
				{
					trigger_error($this->language->lang('L_NO_DEA_EMAILS_DOM_VALID', $deadomain) . adm_back_link($this->u_action), E_USER_WARNING);
				}
			}

			if ($deaaction == '2')
			{
				$resp = $this->functions_nodeaemails->delete_deas($deadomain);

				if ($resp == 0)
				{
					trigger_error($this->language->lang('L_NO_DEA_EMAILS_DOM_LOCATE', $deadomain) . adm_back_link($this->u_action), E_USER_WARNING);
				}
				else
				{
					trigger_error($this->language->lang('L_NO_DEA_EMAILS_DOM_DEL', $deadomain) . adm_back_link($this->u_action));
				}
			}
		}
	}

	// Users
	public function display_users($mode)
	{
		$this->language->add_lang('memberlist');
		$this->tpl_name		= 'acp_dea_users';
		$this->page_title	= $this->language->lang('ACP_NO_DEA_EMAILS') . ' - ' . $this->language->lang('ACP_NO_DEA_EMAILS_USERS');

		/* @var $pagination \phpbb\pagination */
		$pagination		= $this->pagination;

		$number			= $this->config['topics_per_page'];
		$start			= $this->request->variable('start', 0);
		$sort_key		= $this->request->variable('sk', 'c');
		$sort_dir		= $this->request->variable('sd', 'a');

		// Sorting
		$sort_by_text	= array('a' => $this->language->lang('SORT_USERNAME'), 'e' => $this->language->lang('SORT_EMAIL'), 'c' => $this->language->lang('SORT_JOINED'), 'l' => $this->language->lang('SORT_LAST_ACTIVE'), 'd' => $this->language->lang('SORT_POST_COUNT'));
		$sort_by_sql	= array('a' => 'username', 'e' => 'user_email', 'c' => 'user_regdate', 'l' => 'user_lastvisit', 'd' => 'user_posts');

		$limit_days		= array();
		$sort_days = $s_limit_days = $s_sort_key = $s_sort_dir = $u_sort_param = '';
		gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sort_dir, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);
		$sql_sort_order = $sort_by_sql[$sort_key] . ' ' . (($sort_dir == 'd') ? 'DESC' : 'ASC');

		// Get users with DEA email
		$ids_dea_users = $this->functions_nodeaemails->get_users_dea();
		$dea_users = count($ids_dea_users);
		$sql_dea_users = ($dea_users != 0) ? implode(', ', $ids_dea_users) : '99999999';

		// Make sure $start is set to the last page if it exceeds the users
		$start = $this->pagination->validate_start($start, $number, $dea_users);

		// Seek Email DEA in ALL Users
		$sql = "SELECT user_id, username, user_email, user_regdate, user_lastvisit, user_posts, user_colour, user_chg_email_force
				FROM " . USERS_TABLE ." WHERE user_id IN (" . $sql_dea_users . ") ORDER BY " . $sql_sort_order;
		$result = $this->db->sql_query_limit($sql, $number, $start);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->template->assign_block_vars('usersex', array(
				'S_NO_DEA_EMAILS_ATTACH_ID' => $row['user_id'],
				'S_NO_DEA_EMAILS_USER'		=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
				'S_NO_DEA_EMAILS_EMAIL'		=> $row['user_email'],
				'S_NO_DEA_EMAILS_REGISTER'	=> $this->user->format_date($row['user_regdate'], $this->config['default_dateformat']),
				'S_NO_DEA_EMAILS_LAST'		=> $this->user->format_date($row['user_lastvisit'], $this->config['default_dateformat']),
				'S_NO_DEA_EMAILS_POST'		=> $row['user_posts'],
				'S_NO_DEA_EMAILS_COLOR'		=> $row['user_chg_email_force'] ? ' style="background-color: #f0db10;" ' : null,
				'S_NO_DEA_EMAILS_TITLE'		=> $row['user_chg_email_force'] ? ' title="' . $this->language->lang('LOG_FORCE_USER_CHG_EMAIL') . '" ' : null,
			));
		}
		$this->db->sql_freeresult($result);

		$base_url = $this->u_action . "&amp;$u_sort_param";
		$this->pagination->generate_template_pagination($base_url, 'pagination', 'start', $dea_users, $number, $start);

		$total_users = $this->functions_nodeaemails->count_total_users();
		$percentage = number_format(($dea_users * 100) / $total_users, 6, ',', '.');

		$this->template->assign_vars(array(
			'S_NO_DEA_EMAILS_TOT_USERS'	 => $total_users,
			'S_NO_DEA_EMAILS_DEA_USERS'	 => $dea_users . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $this->language->lang('L_NO_DEA_EMAILS_PERCENTAGE', $percentage),
			'S_NO_DEA_EMAILS_VERSION'	 => str_replace('-', '--', $this->config['nodeaemails_version']),
			'U_ACTION'					 => $this->u_action . "&amp;$u_sort_param&amp;start=$start",
			'S_SORT_KEY'				 => $s_sort_key,
			'S_SORT_DIR'				 => $s_sort_dir,
		));

		/// Manage Users
		$continue = $this->request->is_set_post('continue');
		$submit = $this->request->is_set_post('submit');
		$delete_type = $this->request->variable('delete_type', '');
		$delete_users = (isset($_REQUEST['delete'])) ? $this->request->variable('delete', array(0)) : array();

		$form_key = 'acp_dea_users';
		add_form_key($form_key);

		if ($submit)
		{
			if (!$continue && !check_form_key($form_key))
			{
				trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			// No useres select
			if (!count($delete_users))
			{
				trigger_error($this->language->lang('L_NO_DEA_EMAILS_NO_USERS') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			// Need select one option
			if ($delete_type == '')
			{
				trigger_error($this->language->lang('L_NO_DEA_EMAILS_NEED_ACTION') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			$sql = 'SELECT *
				FROM ' . USERS_TABLE . '
				WHERE ' . $this->db->sql_in_set('user_id', $delete_users);
			$result = $this->db->sql_query($sql);

			$user_affected = array();
			$users = null;
			while ($row = $this->db->sql_fetchrow($result))
			{
				// Founders can not be deleted.
				if ($row['user_type'] == USER_FOUNDER)
				{
					trigger_error($this->language->lang('L_NO_DEA_EMAILS_CANNOT_FOUNDER', $row['username']) . adm_back_link($this->u_action), E_USER_WARNING);
				}

				// Check if the user wants to remove himself
				if ($row['user_id'] == $this->user->data['user_id'])
				{
					trigger_error($this->language->lang('L_NO_DEA_EMAILS_CANNOT_YOURSELF') . adm_back_link($this->u_action), E_USER_WARNING);
				}

				$user_affected[$row['user_id']] = $row['username'];

				//Add user to send PM
				$users .= $row['user_id'] . '_';
			}
			$this->db->sql_freeresult($result);

			if (confirm_box(true))
			{
				if ($delete_type == 'sendpm')
				{
					redirect(append_sid($this->phpbb_root_path . "ucp." . $this->php_ext, 'i=ucp_pm&amp;mode=compose&amp;users_nodeaemail=' . substr($users, 0, -1)));
				}
				elseif ($delete_type == 'chgema')
				{
					$sql = "UPDATE " . USERS_TABLE . " SET user_chg_email_force = 1
							WHERE " . $this->db->sql_in_set('user_id', $delete_users);
					$result = $this->db->sql_query($sql);
					$this->db->sql_freeresult($result);

					$this->phpbb_log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_FORCE_CHG_EMAIL', false, array('<strong>' . $this->language->lang('LOG_FORCE_USERS_CHG_EMAIL') . '</strong><br>» ' . implode($this->language->lang('COMMA_SEPARATOR'), $user_affected)));
					trigger_error($this->language->lang('LOG_FORCE_USERS_CHG_EMAIL') . '<br><br>' . implode($this->language->lang('COMMA_SEPARATOR'), $user_affected) . ' ' . adm_back_link($this->u_action . "&amp;$u_sort_param&amp;start=$start"));
				}
				elseif ($delete_type == 'chgemn')
				{
					$sql = "UPDATE " . USERS_TABLE . " SET user_chg_email_force = 0
							WHERE " . $this->db->sql_in_set('user_id', $delete_users);
					$result = $this->db->sql_query($sql);
					$this->db->sql_freeresult($result);

					$this->phpbb_log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_FORCE_CHG_EMAIL', false, array('<strong>' . $this->language->lang('LOG_FORCE_USERS_NO_CHG_EMAIL') . '</strong><br>» ' . implode($this->language->lang('COMMA_SEPARATOR'), $user_affected)));
					trigger_error($this->language->lang('LOG_FORCE_USERS_NO_CHG_EMAIL') . '<br><br>' . implode($this->language->lang('COMMA_SEPARATOR'), $user_affected) . ' ' . adm_back_link($this->u_action . "&amp;$u_sort_param&amp;start=$start"));
				}
				elseif ($delete_type == 'retain' || $delete_type == 'remove')
				{
					if (!$this->auth->acl_get('a_userdel'))
					{
						send_status_line(403, 'Forbidden');
						trigger_error($this->language->lang('NO_AUTH_OPERATION') . adm_back_link($this->u_action . "&amp;$u_sort_param&amp;start=$start"), E_USER_WARNING);
					}

					if (!function_exists('user_active_flip'))
					{
						include($this->phpbb_root_path . 'includes/functions_user.' . $this->php_ext);
					}

					user_delete($delete_type, $delete_users, false);

					$this->phpbb_log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_INACTIVE_DELETE', false, array('<strong>' . $this->language->lang('LOG_CONFIG_USERS') . '</strong><br>» ' . implode($this->language->lang('COMMA_SEPARATOR'), $user_affected)));
					trigger_error($this->language->lang('LOG_CONFIG_USERS') . '<br><br>' . implode($this->language->lang('COMMA_SEPARATOR'), $user_affected) . ' ' . adm_back_link($this->u_action));
				}
			}
			else
			{
				$s_hidden_fields = array(
					'continue'		=> 1,
					'mode'			=> $mode,
					'delete'		=> $delete_users,
					'delete_type'	=> $delete_type,
					'submit'		=> 1,
				);
				confirm_box(false, $this->language->lang('CONFIRM_OPERATION'), build_hidden_fields($s_hidden_fields));
			}
		}
	}
}
