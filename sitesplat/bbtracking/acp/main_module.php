<?php
/**
*
* BBtracking
*
* @copyright (c) 2018 Ken F. Innes IV <https://www.absoluteanime.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
* @copyright (c) 2017, Sitesplat
* @license private
*/

namespace sitesplat\bbtracking\acp;

use sitesplat\bbtracking\tracking_types;

class main_module
{
	public $page_title;
	public $tpl_name;
	public $u_action;
	private $user;
	private $root_path;
	private $php_ext;

	public function main($id, $mode)
	{
		global $config, $request, $template, $user, $db, $phpbb_container;
		global $table_prefix, $phpbb_admin_path, $phpEx, $phpbb_root_path;
		$pagination = $phpbb_container->get('pagination');
		$group_helper = $phpbb_container->get('group_helper');
		$this->user = $phpbb_container->get('user');
		$this->root_path = $phpbb_root_path;
		$this->php_ext = $phpEx;

		$action = $request->variable('action', '');
		switch ($mode)
		{
			case 'settings':

				$this->tpl_name = 'acp_bbtracking_settings';
				$this->page_title = $user->lang('ACP_BBTRACKING_SETTINGS');

				switch ($action)
				{
					case 'delete':

						$user_id = $request->variable('u', 0);
						$sql = 'UPDATE ' . $table_prefix . 'users
								SET user_tracked = 0
								WHERE user_id = ' . (int) $user_id;
						$db->sql_query($sql);

						trigger_error($user->lang('USER_UNTRACKED') . ' ' . adm_back_link($this->u_action));

					break;

					case 'add':

						// add new user
						$username = $request->variable('username', '', true);
						$sql = 'UPDATE ' . $table_prefix . "users
								SET user_tracked = 1
								WHERE username_clean = '" . $db->sql_escape(utf8_clean_string($username)) . "'";
						$db->sql_query($sql);

						$groups = $request->variable('groups', array(0));
						// reset tracking for all groups
						$sql = 'UPDATE ' . $table_prefix . 'groups
								SET group_tracked = 0';
						$db->sql_query($sql);
						if (sizeof($groups))
						{
							// set tracking for selected groups
							$sql = 'UPDATE ' . $table_prefix . 'groups
									SET group_tracked = 1
									WHERE ' . $db->sql_in_set('group_id', $groups);
							$db->sql_query($sql);
						}

						trigger_error($user->lang('TRACKED_UPDATED') . ' ' . adm_back_link($this->u_action));
					
					break;
				}

				$sql = 'SELECT user_id, username, user_colour
						FROM ' . $table_prefix . 'users
						WHERE user_tracked = 1';
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result))
				{
					$template->assign_block_vars('tracked_users', array(
						'USERNAME_FULL'	=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour'], false, append_sid("{$phpbb_admin_path}index.$phpEx", 'i=-sitesplat-bbtracking-acp-main_module&amp;mode=logs&amp;u=' . $row['user_id'])),
						'U_DELETE'		=> append_sid("{$phpbb_admin_path}index.$phpEx", 'i=-sitesplat-bbtracking-acp-main_module&amp;mode=settings&amp;action=delete&amp;u=' . $row['user_id']),
					));
				}

				$sql = 'SELECT group_id, group_name, group_tracked
						FROM ' . $table_prefix . 'groups';
				$result = $db->sql_query($sql);
				while ($row = $db->sql_fetchrow($result))
				{
					$template->assign_block_vars('tracked_groups', array(
						'GROUP_ID'			=> $row['group_id'],
						'GROUP_NAME'		=> $group_helper->get_name($row['group_name']),
						'GROUP_SELECTED'	=> (int) $row['group_tracked'],
					));
				}

				$template->assign_vars(array(
					'U_FIND_USERNAME'	=> append_sid("{$phpbb_root_path}memberlist.$phpEx", 'mode=searchuser&amp;form=select_user&amp;field=username&amp;select_single=true'),
				));

			break;

			case 'logs':

				$this->tpl_name = 'acp_bbtracking_logs';
				$this->page_title = $user->lang('ACP_BBTRACKING_LOGS');

				$username		= $request->variable('username', '', true);
				$tracking_type	= $request->variable('t', 0);
				$start			= $request->variable('start', 0);

				// pagination query
				$sql = 'SELECT COUNT(t.tracking_id) as total_logs
						FROM ' . $table_prefix . 'tracking t,
							' . $table_prefix . 'users u
						WHERE t.tracking_user = u.user_id';
				if ($username)
				{
					$sql .= " AND u.username_clean = '" . $db->sql_escape(utf8_clean_string($username)) . "'";
				}
				if ($tracking_type)
				{
					$sql .= ' AND t.tracking_type = ' . (int) $tracking_type;
				}
				$result = $db->sql_query($sql);
				$total_logs = $db->sql_fetchfield('total_logs');
				$db->sql_freeresult($result);

				$start = $pagination->validate_start($start, $config['topics_per_page'], $total_logs);

				// data query
				$sql = 'SELECT t.*, u.username, u.user_colour
						FROM ' . $table_prefix . 'tracking t,
							' . $table_prefix . 'users u
						WHERE t.tracking_user = u.user_id';
				if ($username)
				{
					$sql .= " AND u.username_clean = '" . $db->sql_escape(utf8_clean_string($username)) . "'";
				}
				if ($tracking_type)
				{
					$sql .= ' AND t.tracking_type = ' . (int) $tracking_type;
				}
				$sql .= ' ORDER BY tracking_time DESC';

				$result = $db->sql_query_limit($sql, $config['topics_per_page'], $start);
				while ($row = $db->sql_fetchrow($result))
				{
					$template->assign_block_vars('logs', array(
						'USERNAME'	=> get_username_string('full', $row['tracking_user'], $row['username'], $row['user_colour'], false, append_sid("{$phpbb_admin_path}index.$phpEx", 'i=-sitesplat-bbtracking-acp-main_module&amp;mode=logs&amp;u=' . $row['tracking_user'])),
						'TIME'		=> $user->format_date($row['tracking_time']),
						'TEXT'		=> $this->generate_tracking_text($row['tracking_type'], json_decode($row['tracking_data'], true)),
					));
				}
				$db->sql_freeresult($result);

				// generate tracking type options
				foreach (tracking_types::TYPE as $tracking_type_name => $tracking_type_id)
				{
					$template->assign_block_vars('tracking_types', array(
						'ID'		=> $tracking_type_id,
						'LABEL'		=> $this->user->lang($tracking_type_name . '_LABEL'),
						'SELECTED'	=> $tracking_type == $tracking_type_id,
					));
				}

				$base_url = append_sid($this->u_action, 'username=' . $username . '&amp;t=' . $tracking_type);
				$pagination->generate_template_pagination($base_url, 'pagination', 'start', $total_logs, $config['topics_per_page'], $start);
				$template->assign_vars(array(
					'PAGE_NUMBER'	=> $pagination->on_page($total_logs, $config['topics_per_page'], $start),
					'S_USERNAME'	=> $username,
				));

			break;
		}

		$template->assign_vars(array(
			'U_ACTION'				=> $this->u_action,
		));
	}

	private function generate_tracking_text($tracking_type, $tracking_data)
	{
		switch ($tracking_type)
		{
			case tracking_types::TYPE['TRACKING_TYPE_ACCOUNT_SETTINGS']:
				return $this->user->lang(
					'TRACKING_TYPE_ACCOUNT_SETTINGS',
					$tracking_data['username'],
					$tracking_data['email'],
					json_encode($tracking_data['changed_username']),
					json_encode($tracking_data['changed_email']),
					json_encode($tracking_data['changed_password'])
				);
			break;

			case tracking_types::TYPE['TRACKING_TYPE_VIEWFORUM']:
				return $this->user->lang(
					'TRACKING_TYPE_VIEWFORUM',
					append_sid("{$this->root_path}viewforum.{$this->php_ext}", 'f=' . $tracking_data['forum_id'] . '&amp;start=' . $tracking_data['start']),
					$tracking_data['forum_id'],
					$tracking_data['start']
				);
			break;

			case tracking_types::TYPE['TRACKING_TYPE_VIEWTOPIC']:
				return $this->user->lang(
					'TRACKING_TYPE_VIEWTOPIC',
					append_sid("{$this->root_path}viewtopic.{$this->php_ext}", 'f=' . $tracking_data['forum_id'] . '&amp;t=' . $tracking_data['topic_id'] . '&amp;start=' . $tracking_data['start']),
					$tracking_data['topic_id'],
					$tracking_data['start'],
					append_sid("{$this->root_path}viewforum.{$this->php_ext}", 'f=' . $tracking_data['forum_id']),
					$tracking_data['forum_id']
				);
			break;

			case tracking_types::TYPE['TRACKING_TYPE_MEMBERLIST_VIEWPROFILE']:
				return $this->user->lang(
					'TRACKING_TYPE_MEMBERLIST_VIEWPROFILE',
					append_sid("{$this->root_path}memberlist.{$this->php_ext}", 'mode=viewprofile&amp;u=' . $tracking_data['member_id']),
					$tracking_data['member_id']
				);
			break;

			case tracking_types::TYPE['TRACKING_TYPE_EDIT_POST']:
				return $this->user->lang(
					'TRACKING_TYPE_EDIT_POST',
					append_sid("{$this->root_path}viewtopic.{$this->php_ext}", 'p=' . $tracking_data['post_id'] . '#p=' . $tracking_data['post_id']),
					$tracking_data['post_id']
				);
			break;

			case tracking_types::TYPE['TRACKING_TYPE_LOGIN']:
				return $this->user->lang('TRACKING_TYPE_LOGIN');
			break;

			case tracking_types::TYPE['TRACKING_TYPE_LOGOUT']:
				return $this->user->lang('TRACKING_TYPE_LOGOUT');
			break;

			case tracking_types::TYPE['TRACKING_TYPE_SEND_PM']:
				$users = array();
				foreach (array_keys($tracking_data['recipients']) as $user_id)
				{
					$users[] = '<a href="' . append_sid("{$this->root_path}memberlist.{$this->php_ext}", 'mode=viewprofile&amp;u=' . $user_id) . '">' . $user_id . '</a>';
				}
				return $this->user->lang(
					'TRACKING_TYPE_SEND_PM',
					implode(', ', $users)
				);
			break;
		}
	}
}
