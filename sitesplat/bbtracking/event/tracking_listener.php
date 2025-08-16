<?php
/**
*
* BBtracking
*
* @copyright (c) 2017, Sitesplat
* @license private
*/

namespace sitesplat\bbtracking\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use sitesplat\bbtracking\tracking_types;

class tracking_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.ucp_profile_reg_details_sql_ary'		=> 'track_account_settings',
			'core.viewforum_modify_topics_data'			=> 'track_viewforum',
			'core.viewtopic_modify_page_title'			=> 'track_viewtopic',
			'core.memberlist_view_profile'				=> 'track_memberlist_viewprofile',
			'core.posting_modify_submit_post_before'	=> 'track_edit_post',
			'core.auth_login_session_create_before'		=> 'track_login',
			'core.session_kill_after'					=> 'track_logout',
			'core.submit_pm_after'						=> 'track_send_pm',
		);
	}

	private $user;
	private $db;
	private $request;
	private $tracking_table;
	private $users_table;
	private $groups_table;
	private $root_path;
	private $php_ext;
	public function __construct(\phpbb\user $user, \phpbb\db\driver\driver_interface $db, \phpbb\request\request $request, $tracking_table, $users_table, $groups_table, $root_path, $php_ext)
	{
		$this->user = $user;
		$this->db = $db;
		$this->request = $request;
		$this->tracking_table = $tracking_table;
		$this->users_table = $users_table;
		$this->groups_table = $groups_table;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	public function track_account_settings($event)
	{
		$sql_ary = array(
			'tracking_type'	=> tracking_types::TYPE['TRACKING_TYPE_ACCOUNT_SETTINGS'],
			'tracking_data'	=> json_encode(array(
				'username'			=> $event['sql_ary']['username'],
				'email'				=> $event['sql_ary']['user_email'],
				'changed_username'	=> $this->user->data['username'] != $event['sql_ary']['username'],
				'changed_email'		=> $this->user->data['user_email'] != $event['sql_ary']['user_email'],
				'changed_password'	=> (bool) $event['sql_ary']['user_passchg'],
			)),
		);
		$this->add_tracking_log($sql_ary);
	}

	public function track_viewforum($event)
	{
		$sql_ary = array(
			'tracking_type'	=> tracking_types::TYPE['TRACKING_TYPE_VIEWFORUM'],
			'tracking_data'	=> json_encode(array(
				'forum_id'	=> $event['forum_id'],
				'start'		=> $this->request->variable('start', 0),
			)),
		);
		$this->add_tracking_log($sql_ary);
	}

	public function track_viewtopic($event)
	{
		$sql_ary = array(
			'tracking_type'	=> tracking_types::TYPE['TRACKING_TYPE_VIEWTOPIC'],
			'tracking_data'	=> json_encode(array(
				'forum_id'	=> $event['forum_id'],
				'topic_id'	=> $event['topic_data']['topic_id'],
				'start'		=> $event['start'],
			)),
		);
		$this->add_tracking_log($sql_ary);
	}

	public function track_memberlist_viewprofile($event)
	{
		$sql_ary = array(
			'tracking_type'	=> tracking_types::TYPE['TRACKING_TYPE_MEMBERLIST_VIEWPROFILE'],
			'tracking_data'	=> json_encode(array(
				'member_id'	=> $event['member']['user_id'],
			)),
		);
		$this->add_tracking_log($sql_ary);
	}

	public function track_edit_post($event)
	{
		if ($event['mode'] == 'edit')
		{
			$sql_ary = array(
				'tracking_type'	=> tracking_types::TYPE['TRACKING_TYPE_EDIT_POST'],
				'tracking_data'	=> json_encode(array(
					'post_id'	=> $event['post_id'],
				)),
			);
			$this->add_tracking_log($sql_ary);
		}
	}

	public function track_login($event)
	{
		if ($event['login']['status'] == LOGIN_SUCCESS && !$event['admin'])
		{
			$sql_ary = array(
				'tracking_type'	=> tracking_types::TYPE['TRACKING_TYPE_LOGIN'],
				'tracking_user'	=> $event['login']['user_row']['user_id'],
				'tracking_data'	=> '',
			);
			$this->add_tracking_log($sql_ary);
		}
	}

	public function track_logout($event)
	{
		$sql_ary = array(
			'tracking_type'	=> tracking_types::TYPE['TRACKING_TYPE_LOGOUT'],
			'tracking_data'	=> '',
		);
		$this->add_tracking_log($sql_ary);
	}

	public function track_send_pm($event)
	{
		$sql_ary = array(
			'tracking_type'	=> tracking_types::TYPE['TRACKING_TYPE_SEND_PM'],
			'tracking_data'	=> json_encode(array(
				'recipients'	=> $event['pm_data']['recipients'],
			)),
		);
		$this->add_tracking_log($sql_ary);
	}

	private function add_tracking_log($sql_ary)
	{
		// by default, user is NOT tracked
		$user_tracked = false;

		// if tracking_user isn't set, we default it to current user
		if (!isset($sql_ary['tracking_user']))
		{
			$sql_ary['tracking_user'] = $this->user->data['user_id'];

			// we can directly decide if user is tracked from his data
			if ($this->user->data['user_tracked'])
			{
				$user_tracked = true;
			}
		}
		$sql_ary['tracking_time'] = time();

		// firstly try in users table
		if (!$user_tracked)
		{
			$sql = 'SELECT user_tracked
					FROM ' . $this->users_table . '
					WHERE user_id = ' . (int) $sql_ary['tracking_user'];
			$result = $this->db->sql_query($sql);
			$user_tracked = (int) $this->db->sql_fetchfield('user_tracked');
			$this->db->sql_freeresult($result);
		}

		// then try groups table
		if (!$user_tracked)
		{
			if (!function_exists('group_memberships'))
			{
				include($this->root_path . 'includes/functions_user.' . $this->php_ext);
			}
			$groups = group_memberships(false, $sql_ary['tracking_user']);
			$group_ids = array();
			foreach ($groups as $group_data)
			{
				$group_ids[] = $group_data['group_id'];
			}

			if (sizeof($group_ids))
			{
				$sql = 'SELECT SUM(group_tracked) as user_groups_tracked
						FROM ' . $this->groups_table . '
						WHERE ' . $this->db->sql_in_set('group_id', $group_ids);
				$result = $this->db->sql_query($sql);
				$user_groups_tracked = (int) $this->db->sql_fetchfield('user_groups_tracked');
				if ($user_groups_tracked)
				{
					$user_tracked = true;
				}
				$this->db->sql_freeresult($result);
			}
		}

		if ($user_tracked)
		{
			$sql = 'INSERT INTO ' . $this->tracking_table . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
			$this->db->sql_query($sql);
		}
	}
}
