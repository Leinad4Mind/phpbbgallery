<?php
/**
*
* @package BBajaxnews
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbajaxnews\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'	=> 'load_language_on_setup',
			'core.page_header'	=> 'common_template',

			'core.auth_login_session_create_before'	=> 'friend_logged_in',
			'core.posting_modify_submit_post_after'	=> 'new_announcement_sticky',
			'core.submit_post_end'					=> 'new_topic',
			'core.user_add_modify_data'				=> 'pre_user_joined_board',
			'core.user_add_after'					=> 'user_joined_board',
			'core.group_add_user_after'				=> 'user_joined_group',

			// BBdonation
			'core.submit_donation_end'	=> 'bbdonation',

			// BBmembership
			'sitesplat.bbmembership.payment_completed'	=> 'bbmembership',

			// BBvote
			'sitesplat.bbvote.best_answer_after'	=> 'bbvote',
		);
	}

	protected $ajaxnews_manager;
	protected $user;
	protected $template;
	protected $db;
	protected $helper;
	protected $config;
	protected $groups_table;

	private $user_joined_board = false;
	public function __construct(\sitesplat\bbajaxnews\ajaxnews\manager $ajaxnews_manager, \phpbb\user $user, \phpbb\template\template $template, \phpbb\db\driver\driver_interface $db, \phpbb\controller\helper $helper, \phpbb\config\config $config, $groups_table)
	{
		$this->ajaxnews_manager = $ajaxnews_manager;
		$this->user = $user;
		$this->template = $template;
		$this->db = $db;
		$this->helper = $helper;
		$this->config = $config;
		$this->groups_table = $groups_table;
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'sitesplat/bbajaxnews',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function common_template()
	{
		if (!$this->user->data['is_registered'])
		{
			return;
		}

		$this->template->assign_vars([
			'BBAJAXNEWS_DRIVER'				=> $this->config['sitesplat_bbajaxnews_driver'],
			'BBAJAXNEWS_USER_CHANNEL'		=> $this->user->data['session_id'],
			'BBAJAXNEWS_CASUAL_ROUTE'		=> $this->helper->route('sitesplat_bbajaxnews_casual'),
			'BBAJAXNEWS_CASUAL_INTERVAL'	=> $this->config['sitesplat_bbajaxnews_interval'] * 60000, // from minutes to milliseconds
			'BBAJAXNEWS_VISIBILITY_CONTROL'	=> $this->config['sitesplat_bbajaxnews_noty_visibility_control'],
			'BBAJAXNEWS_TIMEOUT'			=> $this->config['sitesplat_bbajaxnews_noty_timeout'],
			'BBAJAXNEWS_PROGRESS_BAR'		=> $this->config['sitesplat_bbajaxnews_noty_progress_bar'],
			'BBAJAXNEWS_LAYOUT'				=> $this->config['sitesplat_bbajaxnews_noty_layout'],
			'BBAJAXNEWS_MO'					=> $this->config['sitesplat_bbajaxnews_noty_mo'],
		]);
		$this->ajaxnews_manager->assign_driver_vars();
	}

	public function friend_logged_in($event)
	{
		if ($event['admin'] || $event['login']['status'] != LOGIN_SUCCESS)
		{
			return;
		}

		$this->ajaxnews_manager->add_ajaxnews('sitesplat.bbajaxnews.ajaxnews.type.friend_logged_in', [
			'user_id'		=> $event['login']['user_row']['user_id'],
			'username'		=> $event['login']['user_row']['username'],
			'user_colour'	=> $event['login']['user_row']['user_colour'],
		]);
	}

	public function new_announcement_sticky($event)
	{
		if ($event['mode'] == 'delete' || $event['mode'] == 'reply')
		{
			return;
		}

		$ajaxnews_type = false;
		if ($event['post_data']['topic_type'] == POST_ANNOUNCE || $event['post_data']['topic_type'] == POST_GLOBAL)
		{
			$ajaxnews_type = 'new_announcement';
		}
		else if ($event['post_data']['topic_type'] == POST_STICKY)
		{
			$ajaxnews_type = 'new_sticky';
		}

		if ($ajaxnews_type)
		{
			$this->ajaxnews_manager->add_ajaxnews('sitesplat.bbajaxnews.ajaxnews.type.' . $ajaxnews_type, [
				'poster_id'		=> $event['post_data']['poster_id'],
				'topic_id'		=> $event['post_data']['topic_id'],
				'post_subject'	=> $event['post_data']['post_subject'],
				'forum_id'		=> $event['post_data']['forum_id'],
				'forum_desc'	=> $event['post_data']['forum_desc'],
				'forum_name'	=> $event['post_data']['forum_name'],
			]);
		}
	}

	public function new_topic($event)
	{
		if ($event['mode'] == 'post' && $event['post_visibility'] == ITEM_APPROVED)
		{
			$this->ajaxnews_manager->add_ajaxnews('sitesplat.bbajaxnews.ajaxnews.type.new_topic', [
				'poster_id'		=> $event['data']['poster_id'],
				'topic_id'		=> $event['data']['topic_id'],
				'post_subject'	=> $event['data']['topic_title'],
				'forum_id'		=> $event['data']['forum_id'],
				'forum_name'	=> $event['data']['forum_name'],
			]);
		}
	}

	public function pre_user_joined_board()
	{
		$this->user_joined_board = true;
	}

	public function user_joined_board($event)
	{
		$this->ajaxnews_manager->add_ajaxnews('sitesplat.bbajaxnews.ajaxnews.type.user_joined_board', [
			'user_id'	=> $event['user_id'],
			'username'	=> $event['user_row']['username'],
		]);
	}

	public function user_joined_group($event)
	{
		// Don't display notification when user just joined board or when we don't have proper data
		if ($this->user_joined_board || empty($event['user_id_ary']))
		{
			return;
		}

		$sql = 'SELECT group_name, group_type
				FROM ' . $this->groups_table . '
				WHERE group_id = ' . (int) $event['group_id'];
		$result = $this->db->sql_query($sql);
		$group = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if ($group['group_type'] == GROUP_SPECIAL)
		{
			$users = [];
			foreach ($event['user_id_ary'] as $index => $user_id)
			{
				$users[$user_id] = $event['username_ary'][$index];
			}

			$this->ajaxnews_manager->add_ajaxnews('sitesplat.bbajaxnews.ajaxnews.type.user_joined_group', [
				'users'			=> $users,
				'group_id'		=> $event['group_id'],
				'group_name'	=> $group['group_name'],
			]);
		}
	}

	public function bbdonation($event)
	{
		// user_id is set only when donation is complete
		if (!empty($event['user_id']))
		{
			$this->ajaxnews_manager->add_ajaxnews('sitesplat.bbajaxnews.ajaxnews.type.bbdonation', [
				'user_id'	=> $event['user_id'],
			]);
		}
	}

	public function bbmembership($event)
	{
		$this->ajaxnews_manager->add_ajaxnews('sitesplat.bbajaxnews.ajaxnews.type.bbmembership', [
			'user_id'	=> $event['row']['user_id'],
			'level'		=> $event['lvl'],
		]);
	}

	public function bbvote($event)
	{
		if ($event['event'] == 'mark')
		{
			$this->ajaxnews_manager->add_ajaxnews('sitesplat.bbajaxnews.ajaxnews.type.bbvote', [
				'topic_id'	=> $event['post_data']['topic_id'],
			]);
		}
	}
}
