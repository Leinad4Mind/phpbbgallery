<?php
/**
*
* BBpostdated
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\futurepost\event;

class listener implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
{
	protected $auth;
	protected $helper;
	protected $template;
	protected $user;
	protected $config;
	protected $request;
	protected $db;
	protected $notifications;
	protected $topics_table;
	protected $phpbb_root_path;
	protected $php_ext;
	protected $now;
	protected $future_date;
	protected $future_time;

	public function __construct(
		\phpbb\auth\auth $auth,
		\phpbb\controller\helper $helper,
		\phpbb\template\template $template,
		\phpbb\user $user,
		\phpbb\config\config $config,
		\phpbb\request\request $request,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\notification\manager $notifications,
		$topics_table,
		$posts_table,
		$phpbb_root_path,
		$php_ext
	)
	{
		$this->auth = $auth;
		$this->helper = $helper;
		$this->template = $template;
		$this->user = $user;
		$this->config = $config;
		$this->request = $request;
		$this->db = $db;
		$this->notifications = $notifications;
		$this->topics_table = $topics_table;
		$this->posts_table = $posts_table;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
		$this->now = time();
		date_default_timezone_set($this->user->data['user_timezone']);
		$this->future_date = $this->request->variable('future_date', '');
		$this->future_time = strtotime(($this->future_date) ? $this->future_date : date('m/d/Y H:i', $this->now));
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.permissions'	=> 'add_permission',

			// posting
			'core.posting_modify_template_vars'	=> 'temp_future_time',
			'core.modify_submit_post_data'		=> 'save_future_time',
			'core.submit_post_modify_sql_data'	=> 'set_future_post',
			'core.submit_post_end'				=> 'remove_notifications',

			// viewforum
			'core.viewforum_get_topic_data'		=> 'first_post_future_status',
			'core.viewforum_modify_topicrow'	=> 'display_future_status',

			// MCP main
			'core.mcp_front_queue_unapproved_total_before'	=> 'mcp_list',
			'core.mcp_front_view_queue_postid_list_after'	=> 'mcp_list_filter',
			'core.mcp_view_forum_modify_sql'				=> 'mcp_forum',
			'core.modify_mcp_modules_display_option'		=> 'mcp_topic',

			// MCP Moderation queue
			'core.mcp_queue_get_posts_for_topics_query_before'	=> 'mcp_queue_topics',
		);
	}

	public function add_permission($event)
	{
		$permissions = $event['permissions'];
		$permissions['u_futurepost'] = array('lang' => 'ACL_U_FUTUREPOST', 'cat' => 'misc');
		$event['permissions'] = $permissions;
	}

	public function temp_future_time($event)
	{
		if (
			$this->auth->acl_get('u_futurepost') &&
			$event['topic_data']['topic_status'] != ITEM_LOCKED &&
			$event['topic_data']['topic_type'] != POST_GLOBAL && 
			$event['topic_data']['topic_first_post_id'] == $event['row']['post_id'] &&
			(
				$event['post_data']['post_visibility'] == ITEM_UNAPPROVED ||
				$event['mode'] == 'post' ||
				$event['mode'] == 'edit'
			)
		)
		{
			$this->user->add_lang_ext('sitesplat/futurepost', 'futurepost');

			$event['page_data'] += [
				'S_FUTURE_DATE'	=> $event['post_data']['post_time'] > $this->now,
				'D_FUTURE_DATE'	=> ($event['post_data']['post_time'] ?: $this->now + 7200) * 1000,
				'UU_DATEFORMAT'	=> str_replace(array('g','a','jS','|'), array('h','K','J',''), $this->user->data['user_dateformat']),
			];
		}
	}

	public function save_future_time($event)
	{
		if ($this->request->is_set_post('future_chk'))
		{
			$event['data'] += [
				'post_time'			=> $this->future_time,
				'force_visibility'	=> ITEM_UNAPPROVED,
			];
		}
	}

	public function set_future_post($event)
	{
		$sql_data = $event['sql_data'];

		$future = (int) $this->request->is_set_post('future_chk');
		$sql_data[POSTS_TABLE]['sql']['post_future'] = $future;

		if ($future) {
			if (strpos($event['post_mode'], 'edit') !== false) {
				$sql_data[POSTS_TABLE]['sql']['post_time'] = $this->future_time;
			}
			if ($event['post_mode'] == 'edit_topic' || $event['post_mode'] == 'edit_first_post') {
				$sql_data[POSTS_TABLE]['sql']['post_time'] = $this->future_time;
				$sql_data[TOPICS_TABLE]['sql']['topic_time'] = $this->future_time;
				$sql_data[TOPICS_TABLE]['sql']['topic_last_view_time'] = $this->future_time;
			}
		}

		$event['sql_data'] = $sql_data;
	}

	public function remove_notifications($event)
	{
		if ($this->request->is_set_post('future_chk'))
		{
			$this->notifications->delete_notifications('notification.type.topic_in_queue', $event['data']['topic_id']);

			$this->user->add_lang_ext('sitesplat/futurepost', 'futurepost');
			trigger_error('FUTURE_POST_ADDED');
		}
	}

	public function first_post_future_status($event)
	{
		$sql_array = $event['sql_array'];
		$sql_array['SELECT'] .= ', sfp.post_future';
		$sql_array['LEFT_JOIN'][] = [
			'FROM'	=> [POSTS_TABLE => 'sfp'],
			'ON'	=> 'sfp.post_id = t.topic_first_post_id',
		];
		$event['sql_array'] = $sql_array;
	}

	public function display_future_status($event)
	{
		if ($event['row']['post_future'] && $event['row']['topic_time'] > $this->now - 300) {
			$this->user->add_lang_ext('sitesplat/futurepost', 'futurepost');

			$event['topic_row'] += [
				'IS_FUTURE'	=> true,
			];
		}
	}

	public function mcp_list($event)
	{
		$sql_ary = $event['sql_ary'];
		$sql_ary['WHERE'] .= ' AND p.post_time <= ' . ($this->now + 300);
		$event['sql_ary'] = $sql_ary;
	}

	public function mcp_list_filter($event)
	{
		if (!$event['total'])
		{
			return;
		}

		$sql = 'SELECT post_id
			FROM ' . $this->posts_table . '
			WHERE post_time <= ' . ($this->now + 300) . '
				AND ' . $this->db->sql_in_set('post_id', $event['post_list']);
		$result = $this->db->sql_query($sql);
		$post_ids = array_column($this->db->sql_fetchrowset($result), 'post_id');

		$event['post_list'] = array_intersect($event['post_list'], $post_ids);
	}

	public function mcp_forum($event)
	{
		$event['sql'] = str_replace('WHERE', 'WHERE t.topic_time <= ' . ($this->now + 300) . ' AND', $event['sql']);
	}

	public function mcp_topic($event)
	{
		if (empty($event['topic_id']))
		{
			return;
		}

		$sql = 'SELECT topic_time
			FROM ' . $this->topics_table . '
			WHERE topic_id = ' . (int) $event['topic_id'];
		$result = $this->db->sql_query($sql);
		$topic_time = $this->db->sql_fetchfield('topic_time', $result);
		$this->db->sql_freeresult($result);

		if ($topic_time > $this->now - 300)
		{
			$event['module']->set_display('main', 'topic_view', false);
			$event['module']->set_display('logs', 'topic_logs', false);
		}
	}

	public function mcp_queue_topics($event)
	{
		$event['sql'] = str_replace('WHERE', 'WHERE t.topic_time <= ' . ($this->now + 300) . ' AND', $event['sql']);
		$this->user->add_lang_ext('sitesplat/futurepost', 'futurepost');
	}
}
