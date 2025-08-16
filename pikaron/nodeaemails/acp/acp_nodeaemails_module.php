<?php
/**
 *
 * No DEA Emails. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Picaron, https://github.com/picaronin/
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


	public function display_users($mode)
	{
		$this->tpl_name		= 'acp_dea_users';
		$this->page_title	= $this->language->lang('ACP_NO_DEA_EMAILS') . ' - ' . $this->language->lang('ACP_NO_DEA_EMAILS_USERS');

		// Seek Email DEA in ALL Users
		$sql = "SELECT user_id, username, user_email, user_regdate, user_lastvisit, user_posts, user_colour
				FROM " . USERS_TABLE ." WHERE user_email <> ''";
		$result = $this->db->sql_query($sql);

		$dea_users = 0;
		$MiArray = $this->functions_nodeaemails->load_total_deas();

		while ($row = $this->db->sql_fetchrow($result))
		{
			// split on @ and return last value of array in $domain[1]
			$domain = explode('@', $row['user_email']);

			if (array_search($domain[1], $MiArray) !== false)
			{
				$this->template->assign_block_vars('usersex', array(
					'S_NO_DEA_EMAILS_ATTACH_ID' => $row['user_id'],
					'S_NO_DEA_EMAILS_USER'		=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
					'S_NO_DEA_EMAILS_EMAIL'		=> $row['user_email'],
					'S_NO_DEA_EMAILS_REGISTER'	=> $this->user->format_date($row['user_regdate'], $this->config['default_dateformat']),
					'S_NO_DEA_EMAILS_LAST'		=> $this->user->format_date($row['user_lastvisit'], $this->config['default_dateformat']),
					'S_NO_DEA_EMAILS_POST'		=> $row['user_posts'],
				));
				$dea_users++;
			}
		}
		$this->db->sql_freeresult($result);

		$this->template->assign_vars(array(
			'S_NO_DEA_EMAILS_TOT_USERS'	 => $this->functions_nodeaemails->count_users(),
			'S_NO_DEA_EMAILS_DEA_USERS'	 => $dea_users,
			'S_NO_DEA_EMAILS_VERSION'	 => str_replace('-', '--', $this->config['nodeaemails_version']),
			'U_ACTION'					 => $this->u_action,
		));


		/// Delete Users
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
				else
				{
					if (!$this->auth->acl_get('a_userdel'))
					{
						send_status_line(403, 'Forbidden');
						trigger_error($this->language->lang('NO_AUTH_OPERATION') . adm_back_link($this->u_action), E_USER_WARNING);
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
