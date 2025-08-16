<?php

/**
 *
 * Invite. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2010-2015, KillBill
 * @copyright (c) 2017, kasimi
 * @copyright (c) 2017-2018, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\invitation\controller;

use leinad4mind\invitation\ext;
use leinad4mind\invitation\includes\functions;
use leinad4mind\invitation\includes\config as ext_config;
use leinad4mind\invitation\includes\functions_admin;
use phpbb\auth\auth;
use phpbb\config\config as phpbb_config;
use phpbb\db\driver\driver_interface as db_interface;
use phpbb\language\language;
use phpbb\log\log_interface;
use phpbb\pagination;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;

class acp extends controller_base
{
	/** @var db_interface */
	protected $db;

	/** @var user */
	protected $user;

	/** @var language */
	protected $language;

	/** @var request_interface */
	protected $request;

	/** @var auth */
	protected $auth;

	/** @var template */
	protected $template;

	/** @var log_interface */
	protected $log;

	/** @var pagination */
	protected $pagination;

	/** @var phpbb_config */
	protected $config;

	/** @var ext_config */
	protected $ext_config;

	/** @var functions */
	protected $functions;

	/** @var functions_admin */
	protected $functions_admin;

	/** @var string */
	protected $table_invite;

	/** @var string */
	protected $root_path;

	/** @var string */
	protected $adm_relative_path;

	/** @var string */
	protected $php_ext;

	/**
	 * acp constructor.
	 *
	 * @param \phpbb\db\driver\driver_interface                $db
	 * @param \phpbb\user                                      $user
	 * @param \phpbb\language\language                         $language
	 * @param \phpbb\request\request_interface                 $request
	 * @param \phpbb\auth\auth                                 $auth
	 * @param \phpbb\template\template                         $template
	 * @param \phpbb\log\log_interface                         $log
	 * @param \phpbb\pagination                                $pagination
	 * @param \phpbb\config\config                             $config
	 * @param \leinad4mind\invitation\includes\config          $ext_config
	 * @param \leinad4mind\invitation\includes\functions       $functions
	 * @param \leinad4mind\invitation\includes\functions_admin $functions_admin
	 * @param string                                           $table_invite
	 * @param string                                           $root_path
	 * @param string                                           $adm_relative_path
	 * @param string                                           $php_ext
	 */
	public function __construct(db_interface $db, user $user, language $language, request_interface $request, auth $auth, template $template,log_interface $log, pagination $pagination, phpbb_config $config, ext_config $ext_config, functions $functions, functions_admin $functions_admin, $table_invite, $root_path, $adm_relative_path, $php_ext)
	{
		$this->db = $db;
		$this->user = $user;
		$this->language = $language;
		$this->request = $request;
		$this->auth = $auth;
		$this->template = $template;
		$this->log = $log;
		$this->pagination = $pagination;
		$this->config = $config;
		$this->ext_config = $ext_config;
		$this->functions = $functions;
		$this->functions_admin = $functions_admin;
		$this->table_invite = $table_invite;
		$this->root_path = $root_path;
		$this->adm_relative_path = $adm_relative_path;
		$this->php_ext = $php_ext;
	}

	/**
	 * @param string $id
	 * @param string $mode
	 * @param string $u_action
	 */
	public function main($id, $mode, $u_action)
	{
		$this->page_title = 'ACP_MEGHIVO';
		$this->tpl_name = 'acp_meghivo';

		$submit = $this->request->is_set_post('submit');
		$action = $this->request->variable('action', '');
		$error = array();

		switch ($mode)
		{
			case 'main':
				if ($action)
				{
					if (!$this->auth->acl_get('a_meghivo'))
					{
						trigger_error($this->language->lang('NO_AUTH_OPERATION') . adm_back_link($u_action), E_USER_WARNING);
					}

					if (!confirm_box(true))
					{
						switch ($action)
						{
							case 'sync_users':
							case 'sync_data':
								$confirm = true;
								$confirm_lang = 'ACP_MEGHIVO_' . strtoupper($action);
							break;

							default:
								$confirm = false;
								$confirm_lang = '';
							break;
						}

						if ($confirm)
						{
							confirm_box(false, $confirm_lang, build_hidden_fields(array(
								'i'			=> $id,
								'mode'		=> $mode,
								'action'	=> $action,
							)));
						}
					}
					else
					{
						switch ($action)
						{
							case 'sync_users':
							case 'sync_data':
								$this->functions_admin->synchronisation($action);
							break;

							default:
								trigger_error('NO_MODE', E_USER_ERROR);
							break;
						}

						$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_MEGHIVO_' . strtoupper($action));
						trigger_error($this->language->lang('ACP_MEGHIVO_' . strtoupper($action) . '_SUCCESS') . adm_back_link($u_action));
					}
				}

				if (!$this->ext_config['meghivo_enable'])
				{
					$error[] = $this->language->lang('ACP_MEGHIVO_DISABLED');
				}
				else if ($this->config['require_ac_invite'] == ext::ACC_INVITE_DISABLE)
				{
					$error[] = $this->language->lang('ACP_MEGHIVO_REQUIRE_AC_DISABLED');
				}

				if ($this->ext_config['meghivo_enable'] && !$this->config['email_enable'])
				{
					$error[] = $this->language->lang('ACP_MEGHIVO_EMAIL_DISABLED', '<a href="' . append_sid($this->root_path . $this->adm_relative_path . 'index.' . $this->php_ext, "i=board&amp;mode=email") . '">', '</a>');
				}

				$this->page_title = 'ACP_MEGHIVO_MAIN';

				$this->template->assign_vars(array(
					'S_MEGHIVO_MAIN'			=> true,
					'S_MEGHIVO_MANAGE'			=> $this->auth->acl_get('a_meghivo'),
					'S_USER_FOUNDER'			=> $this->user->data['user_type'] == USER_FOUNDER,
					'MEGHIVO_TOTAL_USERS_DAY'	=> $this->functions_admin->users_per_days(),
					'MEGHIVO_PEND_DB'			=> $this->ext_config['total_pend'],
					'MEGHIVO_TOTAL_USERS'		=> $this->ext_config['total_users'],
					'MEGHIVO_INSTALL'			=> $this->user->format_date($this->ext_config['meghivo_install_time']),
				));
			break;

			case 'config':
				$form_key = 'acp_meghivo';
				add_form_key($form_key);
				$this->tpl_name = 'acp_board';
				$this->language->add_lang('acp/email');

				$display_vars = array(
					'title'								=> 'ACP_MEGHIVO_CONFIG',
					'vars'								=> array(
					'legend1'							=> 'ACP_MEGHIVO_MAIN_CONFIG',
					'meghivo_enable'					=> array('lang' => 'ACP_MEGHIVO_ENABLE'							,'validate' => 'bool'		, 'type' => 'radio:yes_no'	,'explain'	=> true))
				);

				if ($this->ext_config['meghivo_enable'])
				{
					$display_vars['vars'] += array(
						'meghivo_captcha_enable'		=> array('lang' => 'ACP_MEGHIVO_CAPTCHA'						,'validate' => 'bool'		, 'type' => 'radio:yes_no'	, 'explain'	=> true),
						'email_address_change'			=> array('lang' => 'ACP_MEGHIVO_MAIL_FIX'						,'validate' => 'bool'		, 'type' => 'radio:yes_no'	, 'explain'	=> true),
						'meghivo_db'					=> array('lang' => 'ACP_MEGHIVO_ALL_USER_MEGHIVO_MAX'			,'validate' => 'bool'		, 'type' => 'radio:yes_no'	, 'explain'	=> true),
						'meghivo_email_priority'		=> array('lang' => 'ACP_MEGHIVO_EMAIL_PRIORITY'					,'validate' => 'int'		, 'type' => 'select'		, 'explain'	=> false	, 'method' => 'meghivo_email_priority_select'),
						'meghivo_ervenyessege'			=> array('lang' => 'ACP_MEGHIVO_ERVENY'							,'validate' => 'int'		, 'type' => 'select'		, 'explain'	=> true		, 'method' => 'meghivo_ervenyessege_select'),
						'meghivo_oldal_list'			=> array('lang' => 'ACP_MEGHIVO_USER_LIST'						,'validate' => 'int:5:99'	, 'type' => 'text:1:2'		, 'explain'	=> true		, 'append' => ' ' . $this->language->lang('ACP_MEGHIVO_DB')),
						'meghivo_notification_name'		=> array('lang' => 'ACP_MEGHIVO_NOTIFICATION_USERNAME'			,'validate' => 'string'		, 'type' => 'text:20:100'	, 'explain'	=> true		, 'append' => ' [ <a href="' . append_sid($this->root_path . 'memberlist.' . $this->php_ext, array('mode' => 'searchuser', 'form' => 'acp_board', 'field' => 'meghivo_notification_name', 'select_single' => 'true')) . '" onclick="find_username(this.href); return false;">' . $this->language->lang('FIND_USERNAME') . '</a> ]'),
						'meghivo_day_db'				=> array('lang' => 'ACP_MEGHIVO_KULDES_DAY_DB'					,'validate' => 'int:0:99'	, 'type' => 'text:1:2'		, 'explain'	=> true		, 'append' => ' ' . $this->language->lang('ACP_MEGHIVO_DB')),
						'meghivo_email_db'				=> array('lang' => 'ACP_MEGHIVO_MORE_EMAIL_DB'					,'validate' => 'int:1:50'	, 'type' => 'text:1:2'		, 'explain'	=> true		, 'append' => ' ' . $this->language->lang('ACP_MEGHIVO_DB')),
						'meghivo_post_limit'			=> array('lang' => 'ACP_MEGHIVO_POST_LIMIT_DB'					,'validate' => 'int:0'		, 'type' => 'text:1:2'		, 'explain'	=> true		, 'append' => ' ' . $this->language->lang('ACP_MEGHIVO_DB')),
						'meghivo_delet_time'			=> array('lang' => 'ACP_MEGHIVO_DELETE_TIME'					,'validate' => 'int:1:60'	, 'type' => 'text:1:2'		, 'explain'	=> true		, 'append' => ' ' . $this->language->lang('MINUTES')),

						'legend2'						=> 'ACP_MEGHIVO_CONFIG_GROUP',
						'invite_group_enabled'			=> array('lang' => 'ACP_MEGHIVO_GROUP_ENABLED'					,'validate' => 'bool'		, 'type' => 'radio:yes_no'	, 'explain'	=> true),
						'invite_group'					=> array('lang' => 'ACP_MEGHIVO_GROUP'							,'validate' => 'int'		, 'type' => 'custom'		, 'explain'	=> true		, 'method' => 'invite_group_select'),
						'default_group'					=> array('lang' => 'ACP_MEGHIVO_DEFAULT_GROUP'					,'validate' => 'bool'		, 'type' => 'radio:yes_no'	, 'explain'	=> true),
						'new_member_post_limit_ignored'	=> array('lang' => 'ACP_MEGHIVO_NEW_MEMBER_POST_LIMIT_IGNORED'	,'validate' => 'bool'		, 'type' => 'radio:yes_no'	, 'explain'	=> true),

						'legend3'						=> 'ACP_MEGHIVO_CONFIG_GIFT',
						'meghivo_uj_reg'				=> array('lang' => 'ACP_MEGHIVO_NEW_REG'						,'validate' => 'int:0:99'	, 'type' => 'text:1:2'		, 'explain'	=> true		, 'append' => ' ' . $this->language->lang('ACP_MEGHIVO_DB')),
						'meghivo_birthdays'				=> array('lang' => 'ACP_MEGHIVO_BIRTHDAYS'						,'validate' => 'int:0:99'	, 'type' => 'text:1:2'		, 'explain'	=> true		, 'append' => ' ' . $this->language->lang('ACP_MEGHIVO_DB')),
						'gift_invited_users'			=> array('lang' => 'ACP_MEGHIVO_GIFT_INVITED_USERS'				,'validate' => 'int:0:999'	, 'type' => 'custom'		, 'explain'	=> true		, 'method' => 'invite_gift'),
						'gift_invited_users_invitation'	=> false,

						'legend4'						=> 'ACP_MEGHIVO_CONFIG_REQUEST',

						'meghivo_req_max'				=> array('lang' => 'ACP_MEGHIVO_REQUEST_MAX'					,'validate' => 'int:0:99'	, 'type' => 'text:1:2'		, 'explain'	=> true		, 'append' => ' ' . $this->language->lang('ACP_MEGHIVO_DB')),
						'meghivo_req_cause'				=> array('lang' => 'ACP_MEGHIVO_REQUEST_CAUSE'					,'validate' => 'int:0'		, 'type' => 'text:1:2'		, 'explain'	=> true		, 'append' => ' ' . $this->language->lang('ACP_MEGHIVO_DB'))
					);
				}

				$display_vars['vars'] += array(
					'legend6'							=> 'ACP_SUBMIT_CHANGES'
				);

				if (isset($display_vars['lang']))
				{
					$this->language->add_lang($display_vars['lang']);
				}

				$cfg_array = $this->request->variable('config', array('' => ''), true);
				validate_config_vars($display_vars['vars'], $cfg_array, $error);

				if ($submit && !check_form_key($form_key))
				{
					$error[] = $this->language->lang('FORM_INVALID');
				}

				if (sizeof($error))
				{
					$submit = false;
				}

				foreach ($display_vars['vars'] as $config_name => $null)
				{
					if (!isset($cfg_array[$config_name]) || strpos($config_name, 'legend') !== false)
					{
						continue;
					}

					$config_value = $cfg_array[$config_name];

					if ($submit)
					{
						if ($config_name == 'meghivo_notification_name')
						{
							$user_adat = $this->functions->user_adat($config_value);

							if (empty($user_adat['user_id']))
							{
								$error[] = $this->language->lang('ACP_MEGHIVO_NOTIFICATION_NO_USER');
							}
						}

						if ($config_name == 'gift_invited_users_invitation')
						{
							$config_value = (int) $config_value;

							if ($config_value < 0)
							{
								$error[] = $this->language->lang('SETTING_TOO_LOW', $this->language->lang('ACP_MEGHIVO_GIFT_INVITED_USERS') . ' - ' . $this->language->lang('ACP_MEGHIVO_GIFT_NUMBER_INVITES'), 0);
							}
						}

						if (sizeof($error))
						{
							$submit = false;
						}
					}

					if ($submit)
					{
						$this->ext_config->set($config_name, $config_value);
					}
				}

				if ($submit)
				{
					$this->log->add('admin',$this->user->data['user_id'], $this->user->ip, 'LOG_MEGHIVO_' . strtoupper($mode));
					trigger_error($this->language->lang('CONFIG_UPDATED') . adm_back_link($u_action));
				}

				$this->page_title = $display_vars['title'];

				$this->template->assign_vars(array(
					'S_ERROR'			=> !empty($error),
					'ERROR_MSG'			=> implode('<br />', $error),
					'L_TITLE'			=> $this->language->lang($display_vars['title']),
					'L_TITLE_EXPLAIN'	=> $this->language->lang($display_vars['title'] . '_EXPLAIN'),
				));

				foreach ($display_vars['vars'] as $config_key => $vars)
				{
					if (!is_array($vars) && strpos($config_key, 'legend') === false)
					{
						continue;
					}

					if (strpos($config_key, 'legend') !== false)
					{
						$this->template->assign_block_vars('options', array(
							'S_LEGEND'	=> true,
							'LEGEND'	=> $this->language->is_set($vars) ? $this->language->lang($vars) : $vars,
						));

						continue;
					}

					$type = explode(':', $vars['type']);
					$l_explain = '';

					if ($vars['explain'] && isset($vars['lang_explain']))
					{
						$l_explain = $this->language->is_set($vars['lang_explain']) ? $this->language->lang($vars['lang_explain']) : $vars['lang_explain'];
					}
					else if ($vars['explain'])
					{
						$l_explain = $this->language->is_set($vars['lang'] . '_EXPLAIN') ? $this->language->lang($vars['lang'] . '_EXPLAIN') : '';
					}

					$content = build_cfg_template($type, $config_key, $this->ext_config, $config_key, $vars);

					if (empty($content))
					{
						continue;
					}

					$this->template->assign_block_vars('options', array(
						'KEY'			=> $config_key,
						'TITLE'			=> $this->language->is_set($vars['lang']) ? $this->language->lang($vars['lang']) : $vars['lang'],
						'S_EXPLAIN'		=> $vars['explain'],
						'TITLE_EXPLAIN'	=> $l_explain,
						'CONTENT'		=> $content,
					));

					unset($display_vars['vars'][$config_key]);
				}

			break;

			case 'kezeles':
				$this->page_title = 'ACP_MEGHIVO_KEZELES';
				$form_key = 'acp_meghivo_kezeles';
				add_form_key($form_key);
				$trigger = false;

				$management_title = $this->page_title;
				$management_title_explain = $this->page_title . '_EXPLAIN';

				$group_ids			= $this->request->variable('group_ids', array(0));
				$username			= $this->request->variable('username', '', true);
				$usernames			= $this->request->variable('usernames', '', true);
				$invite				= $this->request->variable('invite', 0);
				$uinvite			= $this->request->variable('uinvite', 0);
				$ginvite			= $this->request->variable('ginvite', 0);
				$msus				= $this->request->variable('meghivo_select_users', $this->auth->acl_get('a_meghivo_kuldes') ? 1 : 0);
				$msgs				= $this->request->variable('meghivo_select_groups', $this->auth->acl_get('a_meghivo_kuldes') ? 1 : 0);
				$group_all_users	= $this->request->variable('default_group', 1);

				$no_check = $action == 'management_users' && !$msus || $action == 'management_groups' && !$msgs;

				if ($submit && !check_form_key($form_key) && !$no_check)
				{
					$error[] = $this->language->lang('FORM_INVALID');
					$submit = false;
				}

				if ($submit)
				{
					if ($invite < 0 || $uinvite < 0 || $ginvite < 0)
					{
						$error[] = $this->language->lang('ACP_MEGHIVO_MINUSZ');
					}

					switch ($action)
					{
						case 'management_user_invite':
							if (!sizeof($error))
							{
								$this->functions_admin->set_meghivo('user', $invite, $trigger, $username);
							}
						break;

						case 'management_user':
							if (!$username)
							{
								$error[] = $this->language->lang('NO_USER_SPECIFIED');
							}
							else
							{
								$user_adat = $this->functions->user_adat($username);

								if (!$user_adat)
								{
									$error[] = $this->language->lang('NO_USER');
								}
								else if ($user_adat['user_id'] == ANONYMOUS)
								{
									$error[] = $this->language->lang('ACP_MEGHIVO_NO_ANONYMOUS');
								}
							}

							if (!sizeof($error) || $action == 'management_user_invite')
							{
								$invite						= isset($user_adat) ? $user_adat['user_meghivo'] : false;
								$management_title			= 'ACP_MEGHIVO_USER_MANAGEMENT';
								$management_title_explain	= 'ACP_MEGHIVO_USER_MANAGEMENT_EXPLAIN';

								$hidden_fields = build_hidden_fields(array(
									'username'	=> $username,
									'action'	=> 'management_user_invite',
								));

								$this->template->assign_vars(array(
									'S_MANAGEMENT_USER'	=> true,
									'S_HIDDEN_FIELDS'	=> $hidden_fields,
								));
							}

						break;

						case 'management_users':
							$users_size = explode("\n", $usernames);

							if (!$uinvite && $msus)
							{
								$error[] = $this->language->lang('ACP_MEGHIVO_NO_VALUE');
							}

							if (!$usernames)
							{
								$error[] = $this->language->lang('NO_USER_SPECIFIED');
							}

							if (!sizeof($error))
							{
								if (!$usernames = $this->functions_admin->users_verify($usernames))
								{
									$error[] = $this->language->lang(sizeof($users_size) == 1 ? 'NO_USER' : 'NO_USERS');
								}
							}

							if (!sizeof($error))
							{
								if (confirm_box(true) || $msus)
								{
									$this->functions_admin->set_meghivo('users', $uinvite, $trigger, $usernames, $msus);
								}
								else
								{
									$confirm = (sizeof($users_size) == 1) ? 'ACP_MEGHIVO_DELETE_USER' : 'ACP_MEGHIVO_DELETE_USERS';

									$s_hidden_fields = build_hidden_fields(array(
										'i'						=> $id,
										'mode'					=> $mode,
										'submit'				=> $submit,
										'action'				=> $action,
										'usernames'				=> $usernames,
										'meghivo_select_users'	=> $msus,
									));

									confirm_box(false, $confirm, $s_hidden_fields);

									$this->template->assign_var('S_HIDDEN_FIELDS_USERS', $s_hidden_fields);
								}
							}

							$this->template->assign_var('SELECT_USERNAMES', $usernames);

						break;

						case 'management_groups':
							if (!$ginvite && $msgs)
							{
								$error[] = $this->language->lang('ACP_MEGHIVO_NO_VALUE');
							}

							if (!sizeof($group_ids))
							{
								$error[] = $this->language->lang('ACP_MEGHIVO_NO_GROUP_SPECIFIED');
							}

							if (!sizeof($error))
							{
								if (confirm_box(true) || $msgs)
								{
									$error[] = $this->functions_admin->set_meghivo('groups', $ginvite, $trigger, $group_ids, $msgs, $group_all_users);
								}
								else
								{
									$confirm = (sizeof($group_ids) == 1) ? 'ACP_MEGHIVO_DELETE_GROUP' : 'ACP_MEGHIVO_DELETE_GROUPS';

									$s_hidden_fields = build_hidden_fields(array(
										'i'						=> $id,
										'mode'					=> $mode,
										'submit'				=> $submit,
										'action'				=> $action,
										'group_ids'				=> $group_ids,
										'meghivo_select_groups'	=> $msgs,
										'default_group'			=> $group_all_users,
									));

									confirm_box(false, $confirm, $s_hidden_fields);

									$this->template->assign_var('S_HIDDEN_FIELDS_GROUPS', $s_hidden_fields);
								}
							}

						break;
					}
				}

				if ($trigger)
				{
					trigger_error($trigger . adm_back_link($u_action));
				}

				foreach ($this->functions_admin->groups() as $group_id => $group)
				{
					$checked = (in_array($group_id, $group_ids)) ? ' checked="checked"' : '';

					$this->template->assign_block_vars('groups', array(
						'GROUPS_LIST' => '<input class="radio" type="checkbox" name="group_ids[]" value="' . (int) $group_id . '"' . $checked . ' />&nbsp;' . ($group['group_type'] == GROUP_SPECIAL ? '<strong>' . $this->language->lang('G_' . $group['group_name']) . '</strong>' : $group['group_name']) . '<br>'
					));
				}

				$this->template->assign_vars(array(
					'S_MEGHIVO_KEZELES'					=> true,
					'S_ACTION_MEGHIVO_KULDES'			=> $this->auth->acl_get('a_meghivo_kuldes'),
					'S_ACTION_MEGHIVO_TORLES'			=> $this->auth->acl_get('a_meghivo_delete'),
					'S_TASK_USERS_CECHKED'				=> $msus,
					'S_TASK_GROUPS_CECHKED'				=> $msgs,
					'S_DEFAULT_GROUP'					=> $group_all_users,
					'MANAGEMENT_USERNAME'				=> $username,
					'U_FIND_USERNAME'					=> append_sid($this->root_path . 'memberlist.' . $this->php_ext, 'mode=searchuser&amp;form=kezeles_user&amp;field=username&amp;select_single=true'),
					'U_FIND_USERNAMES'					=> append_sid($this->root_path . 'memberlist.' . $this->php_ext, 'mode=searchuser&amp;form=kezeles_select_users&amp;field=usernames&amp;select_single='),
					'MEGHIVO_MANAGEMENT_TITLE'			=> $this->language->lang($management_title),
					'MEGHIVO_MANAGEMENT_TITLE_EXPLAIN'	=> $this->language->lang($management_title_explain),
					'INVITE_USER'						=> $invite,
					'INVITE_USERS'						=> $uinvite,
					'INVITE_GROUPS'						=> $ginvite,
				));

			break;

			case 'igeny':
				$this->page_title = 'ACP_MEGHIVO_IGENY';
				$form_name = 'acp_invite_claim';
				add_form_key($form_name);

				if ($submit && !check_form_key($form_name))
				{
					trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($u_action), E_USER_WARNING);
				}

				$action		= $this->request->is_set_post('kiutalas') ? 'kiutalas' : ($this->request->is_set_post('elutasitas') ? 'elutasitas' : $action);
				$marked		= $this->request->variable('mark'	, array(0));
				$start		= $this->request->variable('start'	, 0);
				$sort_days	= $this->request->variable('st'	, 0);
				$sort_key	= $this->request->variable('sk'	,'date');
				$sort_dir	= $this->request->variable('sd'	,'d');
				$ip			= $this->request->variable('ip'	,'ip');

				if( $action == 'whois')
				{
					include($this->root_path . 'includes/functions_user.' . $this->php_ext);

					$this->language->add_lang('acp/users');
					$this->page_title = 'WHOIS';
					$this->tpl_name = 'simple_body';
					$u_ip		= $this->request->variable('u_ip', '');
					$domain		= gethostbyaddr($u_ip);
					$ipwhois	= user_ipwhois($u_ip);

					if ($ipwhois)
					{
						$ipwhois = preg_replace('#(\s)([\w\-\._\+]+@[\w\-\.]+)(\s)#', '\1<a href="mailto:\2">\2</a>\3', $ipwhois);
						$ipwhois = preg_replace('#(\s)(http:/{2}[^\s]*)(\s)#', '\1<a href="\2" target="_blank">\2</a>\3', $ipwhois);
					}

					$this->template->assign_vars(array(
						'MESSAGE_TITLE'	=> $this->language->lang('IP_WHOIS_FOR', $domain),
						'MESSAGE_TEXT'	=> nl2br($ipwhois),
					));
				}

				$list_meghivo = $this->ext_config['meghivo_oldal_list'];

				if ($action == 'kiutalas' || $action == 'elutasitas')
				{
					if (confirm_box(true))
					{
						$this->functions_admin->kezeles($action, $marked, true);
						$this->ext_config->set('total_petition', $this->ext_config['total_petition'] - sizeof($marked));
						$message = $action == 'kiutalas' ? sizeof($marked) == 1 ? $this->language->lang('ACP_MEGHIVO_PETITION_YSUCCES') : $this->language->lang('ACP_MEGHIVO_PETITION_YSUCCESS') : (sizeof($marked) == 1 ? $this->language->lang('ACP_MEGHIVO_PETITION_NSUCCES') : $this->language->lang('ACP_MEGHIVO_PETITION_NSUCCESS'));
						trigger_error($message . adm_back_link($u_action));
					}
					else
					{
						if (!sizeof($marked))
						{
							trigger_error($this->language->lang('ACP_MEGHIVO_NO_MARKED') . adm_back_link($u_action), E_USER_WARNING);
						}

						confirm_box(false, $this->language->lang('CONFIRM_OPERATION'), build_hidden_fields(array(
							'i'			=> $id,
							'mode'		=> $mode,
							'mark'		=> $marked,
							'action'	=> $action,
						)));
					}
				}

				$limit_days = array(
					0	=> $this->language->lang('ALL_ENTRIES'),
					1	=> $this->language->lang('1_DAY'),
					7	=> $this->language->lang('7_DAYS'),
					14	=> $this->language->lang('2_WEEKS'),
					30	=> $this->language->lang('1_MONTH'),
					90	=> $this->language->lang('3_MONTHS'),
					180	=> $this->language->lang('6_MONTHS'),
					365	=> $this->language->lang('1_YEAR'),
				);

				$sort_by_text = array(
					'name'	=> $this->language->lang('SORT_USERNAME'),
					'db'	=> $this->language->lang('ACP_MEGHIVO_KULDES_DB_NUM'),
					'date'	=> $this->language->lang('SORT_DATE'),
				);

				$sort_by_sql = array(
					'name'	=> 'u.username_clean',
					'db'	=> 'k.db',
					'date'	=> 'k.message_time',
				);

				$s_limit_days	= $s_sort_key = $s_sort_dir = $u_sort_param = '';
				gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sort_dir, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);

				$sql_where	= $sort_days ? time() - $sort_days * 86400 : 0;
				$sql_sort	= $sort_by_sql[$sort_key] . ' ' . ($sort_dir == 'd' ? 'DESC' : 'ASC');

				$kerelem = array();
				$kerelem_count = 0;

				$this->functions_admin->kerelmek($kerelem, $kerelem_count, $list_meghivo, $start, $sql_where, $sql_sort);

				$this->pagination->generate_template_pagination($u_action . '&amp;' . $u_sort_param, 'pagination', 'start', $kerelem_count, $list_meghivo, $start, true);

				$this->template->assign_vars(array(
					'S_MEGHIVO_KERELEM'	=> true,
					'S_ON_PAGE'			=> $this->pagination->on_page($kerelem_count, $list_meghivo, $start),
					'S_LIMIT_DAYS'		=> $s_limit_days,
					'S_SORT_KEY'		=> $s_sort_key,
					'S_SORT_DIR'		=> $s_sort_dir,
					'TOTAL_COUNT'		=> $this->language->lang('ACP_MEGHIVO_USERS_COUNT', $kerelem_count),
				));

				foreach ($kerelem as $row)
				{
					$message = preg_replace('/([^\s]{30})([^ ])/ui','$1 ', $row['message']);

					$this->template->assign_block_vars('kerelem', array(
						'K_USER_ID'			=> $row['user_id'],
						'K_USERNAME'		=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
						'K_DB'				=> $row['db'],
						'K_MESSAGE'			=> $message,
						'K_MESSAGE_TIME'	=> $this->user->format_date($row['message_time']),
						'K_USER_IP'			=> $ip == 'hostname' ? gethostbyaddr($row['ip']) : $row['ip'],
						'U_USER_IP'			=> $u_action . "&amp;ip=" . (($ip == 'ip') ? 'hostname' : 'ip'),
						'U_WHOIS'			=> $u_action . "&amp;action=whois&amp;u_ip={$row['ip']}",
						'U_USER_ADMIN'		=> append_sid($this->root_path . $this->adm_relative_path . 'index.' . $this->php_ext, "i=users&amp;mode=overview&amp;u={$row['user_id']}")
					));
				}

			break;

			case 'users':
				$this->page_title = 'ACP_MEGHIVO_USERS';
				$form_name = 'acp_invite_users';
				add_form_key($form_name);

				if ($submit && !check_form_key($form_name))
				{
					trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($u_action), E_USER_WARNING);
				}

				$start		= $this->request->variable('start'	, 0);
				$sort_days	= $this->request->variable('st'	, 0);
				$sort_key	= $this->request->variable('sk'	, 't');
				$sort_dir	= $this->request->variable('sd'	, 'd');

				$list_users = $this->ext_config['meghivo_oldal_list'];

				$limit_days = array(
					0	=> $this->language->lang('ALL_ENTRIES'),
					1	=> $this->language->lang('1_DAY'),
					7	=> $this->language->lang('7_DAYS'),
					14	=> $this->language->lang('2_WEEKS'),
					30	=> $this->language->lang('1_MONTH'),
					90	=> $this->language->lang('3_MONTHS'),
					180	=> $this->language->lang('6_MONTHS'),
					365	=> $this->language->lang('1_YEAR'),
				);

				$sort_by_text = array(
					'u' => $this->language->lang('ACP_MEGHIVO') . ' ' . $this->language->lang('ACP_MEGHIVO_USER_NAME'),
					'd' => $this->language->lang('ACP_MEGHIVO_SORT_NAME'),
					'm' => $this->language->lang('ACP_MEGHIVO_SORT_NAME') . ' ' . $this->language->lang('ACP_MEGHIVO_USER_NAME'),
					't' => $this->language->lang('JOINED'),
				);

				$sort_by_sql = array(
					'u' => 'u.username_clean',
					'd' => 'u.user_meghivo_member',
					'm' => 'm.user_name',
					't' => 'm.user_regdate',
				);

				$s_limit_days = $s_sort_key = $s_sort_dir = $u_sort_param = '';
				gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sort_dir, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);

				$sql_where = $sort_days ? time() - $sort_days * 86400 : 0;
				$sql_sort = $sort_by_sql[$sort_key] . ' ' . ($sort_dir == 'd' ? 'DESC' : 'ASC');

				$users = array();
				$users_count = 0;
				$this->functions_admin->users_fun($users, $users_count, $list_users, $start, $sql_where, $sql_sort);

				$this->pagination->generate_template_pagination($u_action . '&amp;' . $u_sort_param, 'pagination', 'start', $users_count, $list_users, $start, true);

				$this->template->assign_vars(array(
					'S_MEGHIVO_USERS'	=> true,
					'S_ON_PAGE'			=> $this->pagination->on_page($users_count, $list_users, $start),
					'S_LIMIT_DAYS'		=> $s_limit_days,
					'S_SORT_KEY'		=> $s_sort_key,
					'S_SORT_DIR'		=> $s_sort_dir,
					'TOTAL_COUNT'		=> $this->language->lang('ACP_MEGHIVOT_USERS_COUNT', $users_count),
				));

				foreach ($users as $row)
				{
					$this->template->assign_block_vars('users', array(
						'HIVO_USERNAME'		=> get_username_string('full', $row['hivo_id'], $row['username'], $row['hivo_color']),
						'HIVO_MEGHIVO'		=> $this->language->lang('ACP_MEGHIVO_MEMBER', $row['user_meghivo_member']),
						'HIVO_EMAIL'		=> $row['hivo_email'],
						'HIVOTT_USERNAME'	=> get_username_string('full', $row['user_id'], $row['user_name'], $row['user_colour']),
						'HIVOTT_EMAIL'		=> $row['user_reg_email'],
						'HIVOTT_TIME_REG'	=> $this->user->format_date($row['user_regdate']),
						'HIVO_USER_ADMIN'	=> $row['hivo_id'] ? append_sid($this->root_path . $this->adm_relative_path . 'index.' . $this->php_ext, "i=users&amp;mode=overview&amp;u={$row['hivo_id']}") : false,
						'HIVOTT_USER_ADMIN'	=> append_sid($this->root_path . $this->adm_relative_path . 'index.' . $this->php_ext, "i=users&amp;mode=overview&amp;u={$row['user_id']}"),
					));
				}
			break;

			case 'pend':
				$this->page_title = 'ACP_MEGHIVO_PENDING';
				$form_name = 'acp_invite_pending';
				add_form_key($form_name);

				if ($submit && !check_form_key($form_name))
				{
					trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($u_action), E_USER_WARNING);
				}

				$action		= $this->request->is_set_post('pend_delete_all') ? 'del_all' : ($this->request->is_set_post('pend_delete_mark') ? 'del_mark' : $action);
				$marked		= $this->request->variable('mark', array(0));
				$start		= $this->request->variable('start', 0);
				$sort_key	= $this->request->variable('sk', 't');
				$sort_dir	= $this->request->variable('sd', 'd');

				if ($action)
				{
					if (confirm_box(true))
					{
						if ($action == 'del_all')
						{
							$this->db->sql_query('DELETE FROM ' . $this->table_invite);
							$this->ext_config->set('total_pend', 0);
							$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_MEGHIVO_PEND_ALL_DELETE');
							trigger_error($this->language->lang('ACP_MEGHIVO_PEND_DELET_ALL_SUCCESS') . adm_back_link($u_action));
						}
						else
						{
							$sql = 'SELECT u.username FROM ' . $this->table_invite . ' i
									LEFT JOIN ' . USERS_TABLE . ' u ON i.user_id = u.user_id
									WHERE ' . $this->db->sql_in_set('i.id', $marked);
							$result = $this->db->sql_query($sql);
							$del_username = array();
							while ($row = $this->db->sql_fetchrow($result))
							{
								$del_username[] = $row['username'];
							}
							$this->db->sql_freeresult($result);

							$this->db->sql_query('DELETE FROM ' . $this->table_invite . ' WHERE ' . $this->db->sql_in_set('id', $marked));
							$this->ext_config->set('total_pend', ($this->ext_config['total_pend'] - sizeof($marked)));
							$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_MEGHIVO_PEND_MARKED_DELETE' . (sizeof($del_username) > 1 ? 'S' : ''), false, array(implode(', ', $del_username)));
							trigger_error((sizeof($marked) == 1 ? $this->language->lang('ACP_MEGHIVO_PEND_DELET_MARK_SUCCESS') : $this->language->lang('ACP_MEGHIVO_PEND_DELET_MARKS_SUCCESS')) . adm_back_link($u_action));
						}
					}
					else
					{
						if  (!sizeof($marked) && $action == 'del_mark')
						{
							trigger_error($this->language->lang('ACP_MEGHIVO_NO_SELECT_INVITE') . adm_back_link($u_action), E_USER_WARNING);
						}

						$confirm_lang = $action == 'del_all' ? $this->language->lang('ACP_MEGHIVO_DELETE_ALL_PEND_CONFIRM') : sizeof($marked) == 1 ? $this->language->lang('ACP_MEGHIVO_DELETE_PEND_CONFIRM') : $this->language->lang('ACP_MEGHIVO_DELETES_PEND_CONFIRM');

						confirm_box(false, $confirm_lang, build_hidden_fields(array(
							'i'			=> $id,
							'mode'		=> $mode,
							'mark'		=> $marked,
							'action'	=> $action,
						)));
					}
				}

				$list_invite = $this->ext_config['meghivo_oldal_list'];

				$sort_by_text = array(
					'u' => $this->language->lang('ACP_MEGHIVO') . ' ' . $this->language->lang('ACP_MEGHIVO_USER_NAME'),
					't' => $this->language->lang('ACP_MEGHIVO_PEND_DATE'),
				);

				$sort_by_sql = array(
					'u' => 'u.username_clean',
					't' => 'i.meghivo_time',
				);

				$sort_days = 0;
				$limit_days = array();
				$s_sort_key = $s_sort_dir = $u_sort_param = $s_limit_days = '';

				gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sort_dir, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);

				$invites_count = $sql_where = 0;
				$sql_sort = $sort_by_sql[$sort_key] . ' ' . ($sort_dir == 'd' ? 'DESC' : 'ASC');

				$invites = array();
				$this->functions_admin->pend($invites, $invites_count, $list_invite, $start, $sql_where, $sql_sort);

				$this->pagination->generate_template_pagination($u_action . '&amp;' . $u_sort_param, 'pagination', 'start', $invites_count, $list_invite, $start, true);

				$this->template->assign_vars(array(
					'S_MEGHIVO_PEND'	=> true,
					'S_ON_PAGE'			=> $this->pagination->on_page($invites_count, $list_invite, $start),
					'S_SORT_KEY'		=> $s_sort_key,
					'S_SORT_DIR'		=> $s_sort_dir,
					'TOTAL_COUNT'		=> $this->language->lang('ACP_MEGHIVOT_PEND_COUNT', $invites_count),
				));

				foreach ($invites as $row)
				{
					$this->template->assign_block_vars('invite', array(
						'ID'			=> $row['id'],
						'USERNAME'		=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
						'TIME'			=> $this->user->format_date($row['meghivo_time']),
						'END_TIME'		=> $this->user->format_date($row['meghivo_time_end']),
						'EMAIL'			=> $row['meghivo_email'],
						'USER_ADMIN'	=> append_sid($this->root_path . $this->adm_relative_path . 'index.' . $this->php_ext, "i=users&amp;mode=overview&amp;u={$row['user_id']}")
					));
				}
			break;

			default:
				trigger_error('NO_MODE', E_USER_ERROR);
			break;
		}

		$this->template->assign_vars(array(
			'S_USER_ADMIN'		=> $this->auth->acl_get('a_user'),
			'U_ACTION'			=> $u_action,
			'ERROR_MESSAGE'		=> implode('<br />', $error)
		));
	}

	public function invite_group_select($value, $key)
	{
		$sql = 'SELECT group_id
				FROM ' . GROUPS_TABLE . '
				WHERE ' . $this->db->sql_in_set('group_name', $this->functions->disabled_groups());
		$result = $this->db->sql_query($sql);

		$exclude = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$exclude[] = (int) $row['group_id'];
		}
		$this->db->sql_freeresult($result);

		if ($s_groups_options = group_select_options($value, $exclude))
		{
			$s_groups_options = '<select name="config[' . $key . ']" id="' . $key . '">' . $s_groups_options . '</select>';
		}
		else
		{
			$s_groups_options = $this->language->lang('ACP_MEGHIVO_NO_GROUP', '<a href="' . append_sid($this->root_path . $this->adm_relative_path . 'index.' . $this->php_ext, "i=groups&amp;mode=manage") . '">', '</a>') . '<input name="config[' . $key . ']" id="' . $key . '" type="hidden" value="0" />';
		}

		return $s_groups_options;
	}

	public function invite_gift($value, $key)
	{
		$return  = '<input type="text" id="' . $key . '" name="config[' . $key . ']" maxlength="3" size="3" value="' . $value . '" /> - ' . $this->language->lang('ACP_MEGHIVO_NUMBER_INVITED_USERS') . '<br />';
		$return .= '<input type="text" id="gift_invited_users_invitation" name="config[gift_invited_users_invitation]" maxlength="2" size="3" value="' . $this->ext_config['gift_invited_users_invitation'] . '" /> - ' . $this->language->lang('ACP_MEGHIVO_GIFT_NUMBER_INVITES');

		return $return;
	}

	public function meghivo_email_priority_select($value, $key)
	{
		$s_priority_options  = '<option ' . (($value == MAIL_LOW_PRIORITY)		? ' selected="selected"' : '') . ' value="' . MAIL_LOW_PRIORITY		. '">' . $this->language->lang('MAIL_LOW_PRIORITY') . '</option>';
		$s_priority_options .= '<option ' . (($value == MAIL_NORMAL_PRIORITY)	? ' selected="selected"' : '') . ' value="' . MAIL_NORMAL_PRIORITY	. '">' . $this->language->lang('MAIL_NORMAL_PRIORITY') . '</option>';
		$s_priority_options .= '<option ' . (($value == MAIL_HIGH_PRIORITY)		? ' selected="selected"' : '') . ' value="' . MAIL_HIGH_PRIORITY	. '">' . $this->language->lang('MAIL_HIGH_PRIORITY') . '</option>';

		return $s_priority_options;
	}

	public function meghivo_ervenyessege_select($value, $key)
	{
		return '<option value="86400"' . (($value == 86400) ? ' selected="selected"' : '') . '>1 ' . $this->language->lang('DAY') . '</option><option value="172800"' . ($value == 172800 ? ' selected="selected"' : '') . '>2 ' . $this->language->lang('DAY') . '</option><option value="604800"' . (($value == 604800) ? ' selected="selected"' : '') . '>7 ' . $this->language->lang('DAY') . '</option><option value="1209600"' . (($value == 1209600) ? ' selected="selected"' : '') . '>14 ' . $this->language->lang('DAY') . '</option><option value="2592000"' . ($value == 2592000 ? ' selected="selected"' : '') . '>30 ' . $this->language->lang('DAY') . '</option>';
	}
}
