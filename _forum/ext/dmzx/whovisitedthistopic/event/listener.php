<?php
/**
*
* @package phpBB Extension - Who Visited This Topic
* @copyright (c) 2016 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\whovisitedthistopic\event;

use phpbb\auth\auth;
use phpbb\cache\service;
use phpbb\config\config;
use phpbb\content_visibility;
use phpbb\db\driver\driver_interface;
use phpbb\pagination;
use phpbb\request\request;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/** @var config */
	protected $config;

	/* @var template */
	protected $template;

	/** @var driver_interface */
	protected $db;

	/** @var user */
	protected $user;

	/** @var request */
	protected $request;

	/** @var content_visibility */
	protected $content_visibility;

	/** @var service */
	protected $cache;

	/** @var pagination */
	protected $pagination;

	/** @var string */
	protected $whovisitedthistopic_table;

	/** @var string */
	protected $root_path;

	/** @var string */
	protected $phpEx;

	/** @var auth */
	protected $auth;

	/**
	* Constructor
	*
	* @param config					$config
	* @param template				$template
	* @param driver_interface		$db
	* @param user					$user
	* @param request				$request
	* @param content_visibility		$content_visibility
	* @param service				$cache
	* @param pagination				$pagination
	* @param string					$root_path
	* @param string					$phpEx
	* @param string					$whovisitedthistopic_table
	* @param auth					$auth
	*
	*/
	public function __construct(
		config $config,
		template $template,
		driver_interface $db,
		user $user,
		request $request,
		content_visibility $content_visibility,
		service $cache,
		pagination $pagination,
		$root_path,
		$phpEx,
		$whovisitedthistopic_table,
		auth $auth
	)
	{
		$this->config 						= $config;
		$this->template 					= $template;
		$this->db 							= $db;
		$this->user 						= $user;
		$this->request 						= $request;
		$this->content_visibility 			= $content_visibility;
		$this->cache 						= $cache;
		$this->pagination 					= $pagination;
		$this->root_path 					= $root_path;
		$this->phpEx						= $phpEx;
		$this->whovisitedthistopic_table 	= $whovisitedthistopic_table;
		$this->auth 						= $auth;
	}

	static public function getSubscribedEvents()
	{
		return [
			'core.permissions'					=> 'permissions',
			'core.viewtopic_get_post_data'		=> 'viewtopic_get_post_data',
			'core.memberlist_view_profile'		=> 'memberlist_view_profile'
		];
	}

	public function permissions($event)
	{
		$permissions = $event['permissions'];
		$permissions += [
			'u_whovisitedthistopic'		=> [
				'lang'		=> 'ACL_U_WHOVISITEDTHISTOPIC',
				'cat'		=> 'whovisitedthistopic'
			],
			'u_whovisitedthistopic_count'	=> [
				'lang'		=> 'ACL_U_WHOVISITEDTHISTOPIC_COUNT',
				'cat'		=> 'whovisitedthistopic'
			],
			'u_whovisitedthistopic_profile'	=> [
				'lang'		=> 'ACL_U_WHOVISITEDTHISTOPIC_PROFILE',
				'cat'		=> 'whovisitedthistopic'
			],
			'u_whovisitedthistopic_show_avatar'	=> [
				'lang'		=> 'ACL_U_WHOVISITEDTHISTOPIC_SHOW_AVATAR',
				'cat'		=> 'whovisitedthistopic'
			],
		];
		$event['permissions'] = $permissions;
		$categories['whovisitedthistopic'] = 'WHOVISITEDTHISTOPIC_INDEX';
		$event['categories'] = array_merge($event['categories'], $categories);
	}

	public function viewtopic_get_post_data($event)
	{
		// Add lang file
		$this->user->add_lang_ext('dmzx/whovisitedthistopic', 'common');

		$topic_id = (int) $event['topic_id'];
		$user_id = (int) $this->user->data['user_id'];
		$value = (int) $this->config['whovisitedthistopic_value'];

		if ($user_id !== ANONYMOUS && !$this->user->data['is_bot'] && $this->config['whovisitedthistopic_allow_topics'])
		{
			$date = time();

			// Usa INSERT ON DUPLICATE KEY UPDATE
			$sql = 'INSERT INTO ' . $this->whovisitedthistopic_table . ' (user_id, topic_id, counter_user, date)
				VALUES (' . $user_id . ', ' . $topic_id . ', 1, ' . $date . ')
				ON DUPLICATE KEY UPDATE
					counter_user = counter_user + 1,
					date = ' . $date;
			$this->db->sql_query($sql);
		}

		if ($this->auth->acl_get('u_whovisitedthistopic') && $this->config['whovisitedthistopic_allow_topics'])
		{
			// Get the excluded members arrays
			$whovisitedthistopic_members = json_decode($this->config['whovisitedthistopic_members']);

			$query = 'SELECT w.user_id, u.username, u.user_colour, u.user_id, u.user_avatar, u.user_avatar_type, u.user_avatar_height, u.user_avatar_width, u.user_type, MAX(w.date) AS last_visit, SUM(w.counter_user) AS total
				FROM ' . $this->whovisitedthistopic_table . ' w, ' . USERS_TABLE . ' u
				WHERE w.topic_id = ' . $topic_id . '
				AND w.user_id = u.user_id';

			if (!empty($whovisitedthistopic_members))
			{
				$query .= ' AND ' . $this->db->sql_in_set('w.user_id', $whovisitedthistopic_members, true);
			}

			$query .= ' GROUP BY w.user_id
						ORDER BY last_visit DESC';

			$row_query = $this->db->sql_query_limit($query, $value);

			while ($row = $this->db->sql_fetchrow($row_query))
			{
				$avatar = phpbb_get_user_avatar($row);
				$user_colour = ($row['user_colour']) ? ' style="color:#' . $row['user_colour'] . '" class="username-coloured"' : '';
				$visits = $this->auth->acl_get('u_whovisitedthistopic_count') ? (int) $row['total'] : null;
				$date = $row['last_visit'] ? ' title="' . $this->user->format_date($row['last_visit']) . '" ' : '';
				$url = append_sid("{$this->root_path}memberlist.{$this->phpEx}?mode=viewprofile&amp;u={$row['user_id']}");

				$this->template->assign_block_vars('whovisitedthistopic', [
					'USERNAME'			=> $row['username'],
					'USERNAME_COLOUR'	=> $user_colour,
					'VISITS'			=> $visits,
					'URL'				=> $url,
					'AVATAR'			=> empty($avatar) ? '<img class="img-thumbnail avatar" src="' . $this->root_path . 'styles/FLATBOOTS/theme/images/no-avatar.png" width="60px;" height="60px;" alt="" />' : $avatar,
					'DATE'				=> $date
				]);
			}
			$this->db->sql_freeresult($row_query);

			// Total
			$sql = 'SELECT topic_id, SUM(counter_user) AS counter
				FROM ' . $this->whovisitedthistopic_table . '
				WHERE topic_id = ' . $topic_id;
			$result = $this->db->sql_query($sql);
			$counter = (int) $this->db->sql_fetchfield('counter');
			$this->db->sql_freeresult($result);

			$this->template->assign_vars([
				'WHOVISITEDTHISTOPIC_TITLE'			=> $this->user->lang('WHOVISITEDTHISTOPIC_TITLE', $value, $counter),
				'PERMISSION_COUNT'					=> $this->auth->acl_get('u_whovisitedthistopic_count') && $this->config['whovisitedthistopic_allow_count'],
				'PERMISSION_VIEW'					=> $this->auth->acl_get('u_whovisitedthistopic'),
				'PERMISSION_SHOW_AVATAR'			=> $this->auth->acl_get('u_whovisitedthistopic_show_avatar') && $this->config['whovisitedthistopic_show_avatar'],
			]);
		}
	}

	public function memberlist_view_profile($event)
	{
		// Add lang file
		$this->user->add_lang_ext('dmzx/whovisitedthistopic', 'common');

		$member = $event['member'];
		$user_id = $member['user_id'];
		$value = $this->config['whovisitedthistopic_visit_value'];

		if ($this->auth->acl_get('u_whovisitedthistopic_profile') && $this->config['whovisitedthistopic_allow_memberpage'])
		{
			$sql_list = [
				'SELECT'	=> 'ft.forum_id, ft.forum_name,
								tt.*,
								wt.date',
				'FROM' => [
					$this->whovisitedthistopic_table => 'wt',
				],
				'LEFT_JOIN' => [
					['FROM' => [TOPICS_TABLE => 'tt'], 'ON' => 'wt.topic_id = tt.topic_id'],
					['FROM' => [FORUMS_TABLE => 'ft'], 'ON' => 'ft.forum_id = tt.forum_id'],
				],
				'WHERE' => 'tt.topic_moved_id = 0
					AND tt.topic_visibility = 1
					AND wt.user_id = ' . (int) $user_id,
				'ORDER_BY'	=> 'wt.date DESC',
			];

			// Get the excluded members arrays
			$excluded_ids = json_decode($this->config['whovisitedthistopic_members_profile'], true);
			if (is_array($excluded_ids) && !empty($excluded_ids)) {
				$sql_list['WHERE'] .= ' AND ' . $this->db->sql_in_set('wt.user_id', $excluded_ids, true);
			}

			if ($this->user->data['is_registered'] && $this->config['load_db_lastread'])
			{
				$sql_list['LEFT_JOIN'][] = ['FROM' => [TOPICS_TRACK_TABLE => 'ttt'], 'ON' => 'ttt.topic_id = tt.topic_id AND ttt.user_id = ' .	(int) $this->user->data['user_id']];
				$sql_list['LEFT_JOIN'][] = ['FROM' => [FORUMS_TRACK_TABLE => 'ftt'], 'ON' => 'ftt.forum_id = ft.forum_id AND ftt.user_id = ' .	(int) $this->user->data['user_id']];
				$sql_list['SELECT'] .= ', ttt.mark_time, ftt.mark_time as f_mark_time';
			}
			else if ($this->config['load_anon_lastread'] || $this->user->data['is_registered'])
			{
				$tracking_topics = $this->request->variable($this->config['cookie_name'] . '_track', '', true, request_interface::COOKIE);
				$tracking_topics = $tracking_topics ? tracking_unserialize($tracking_topics) : [];
			}
			$sql_list_query = $this->db->sql_build_query('SELECT', $sql_list);
			$result = $this->db->sql_query_limit($sql_list_query, $value);

			$icons = $this->cache->obtain_icons();
			$rowset = [];

			while ($sql_list = $this->db->sql_fetchrow($result))
			{
				$topic_id = $sql_list['topic_id'];
				$forum_id = $sql_list['forum_id'];
				$rowset[$topic_id] = $sql_list;

				if ($this->user->data['is_registered'] && $this->config['load_db_lastread'] && !$this->config['similar_topics_cache'])
				{
					$topic_tracking_info = get_topic_tracking($forum_id, $topic_id, $rowset, [$forum_id => $sql_list['f_mark_time']]);
				}
				else if ($this->config['load_anon_lastread'] || $this->user->data['is_registered'])
				{
					$topic_tracking_info = get_complete_topic_tracking($forum_id, $topic_id);
					if (!$this->user->data['is_registered'])
					{
						$this->user->data['user_lastmark'] = isset($tracking_topics['l']) ? ((int) base_convert($tracking_topics['l'], 36, 10) + (int) $this->config['board_startdate']) : 0;
					}
				}

				$replies = $this->content_visibility->get_count('topic_posts', $sql_list, $forum_id) - 1;

				$folder_img = $folder_alt = $topic_type = '';
				$unread_topic = isset($topic_tracking_info[$topic_id]) && $sql_list['topic_last_post_time'] > $topic_tracking_info[$topic_id];
				topic_status($sql_list, $replies, $unread_topic, $folder_img, $folder_alt, $topic_type);

				$topic_unapproved = $sql_list['topic_visibility'] == ITEM_UNAPPROVED;
				$posts_unapproved = $sql_list['topic_visibility'] == ITEM_APPROVED && $sql_list['topic_posts_unapproved'];
				$u_mcp_queue = ($topic_unapproved || $posts_unapproved) ? append_sid("{$this->root_path}mcp.{$this->phpEx}", 'i=queue&amp;mode=' . ($topic_unapproved ? 'approve_details' : 'unapproved_posts') . "&amp;t=$topic_id", true, $this->user->session_id) : '';

				$base_url = append_sid("{$this->root_path}viewtopic.{$this->phpEx}", 'f=' . $forum_id . '&amp;t=' . $topic_id);

				$this->template->assign_block_vars('whovisitedthistopic', [
					'TOPIC_REPLIES'			=> $replies,
					'TOPIC_VIEWS'			=> $sql_list['topic_views'],
					'TOPIC_TITLE'			=> censor_text($sql_list['topic_title']),
					'FORUM_TITLE'			=> $sql_list['forum_name'],

					'TOPIC_AUTHOR_FULL'		=> get_username_string('full', $sql_list['topic_poster'], $sql_list['topic_first_poster_name'], $sql_list['topic_first_poster_colour']),
					'FIRST_POST_TIME'		=> $this->user->format_date($sql_list['topic_time']),
					'LAST_POST_TIME'		=> $this->user->format_date($sql_list['topic_last_post_time']),
					'LAST_POST_AUTHOR_FULL'	=> get_username_string('full', $sql_list['topic_last_poster_id'], $sql_list['topic_last_poster_name'], $sql_list['topic_last_poster_colour']),

					'S_HAS_POLL'			=> (bool) $sql_list['poll_start'],

					'S_TOPIC_REPORTED'		=> !empty($sql_list['topic_reported']) && $this->auth->acl_get('m_report', $forum_id),
					'S_TOPIC_UNAPPROVED'	=> $topic_unapproved,
					'S_POSTS_UNAPPROVED'	=> $posts_unapproved,
					'S_UNREAD_TOPIC'		=> $unread_topic,

					'TOPIC_ICON_IMG'		=> (!empty($icons[$sql_list['icon_id']])) ? $icons[$sql_list['icon_id']]['img'] : '',
					'TOPIC_ICON_IMG_WIDTH'	=> (!empty($icons[$sql_list['icon_id']])) ? $icons[$sql_list['icon_id']]['width'] : '',
					'TOPIC_ICON_IMG_HEIGHT'	=> (!empty($icons[$sql_list['icon_id']])) ? $icons[$sql_list['icon_id']]['height'] : '',
					'ATTACH_ICON_IMG'		=> ($this->auth->acl_get('u_download') && $this->auth->acl_get('f_download', $forum_id) && $sql_list['topic_attachment']) ? $this->user->img('icon_topic_attach', $this->user->lang('TOTAL_ATTACHMENTS')) : '',

					'TOPIC_IMG_STYLE'		=> $folder_img,
					'TOPIC_FOLDER_IMG'		=> $this->user->img($folder_img, $folder_alt),
					'TOPIC_FOLDER_IMG_ALT'	=> $this->user->lang($folder_alt),

					'U_NEWEST_POST'			=> append_sid("{$this->root_path}viewtopic.{$this->phpEx}", 'f=' . $forum_id . '&amp;t=' . $topic_id . '&amp;view=unread') . '#unread',
					'U_LAST_POST'			=> append_sid("{$this->root_path}viewtopic.{$this->phpEx}", 'f=' . $forum_id . '&amp;t=' . $topic_id . '&amp;p=' . $sql_list['topic_last_post_id']) . '#p' . $sql_list['topic_last_post_id'],
					'U_VIEW_TOPIC'			=> append_sid("{$this->root_path}viewtopic.{$this->phpEx}", 'f=' . $forum_id . '&amp;t=' . $topic_id),
					'U_VIEW_FORUM'			=> append_sid("{$this->root_path}viewforum.{$this->phpEx}", 'f=' . $forum_id),
					'U_MCP_REPORT'			=> append_sid("{$this->root_path}mcp.{$this->phpEx}", 'i=reports&amp;mode=reports&amp;f=' . $forum_id . '&amp;t=' . $topic_id, true, $this->user->session_id),
					'U_MCP_QUEUE'			=> $u_mcp_queue,
				]);

				$this->pagination->generate_template_pagination($base_url, 'whovisitedthistopic.pagination', 'start', $replies + 1, $this->config['posts_per_page'], 1, true, true);
			}
			$this->db->sql_freeresult($result);

			$this->template->assign_var('PERMISSION_PROFILE', true);
		}

		$this->template->assign_vars([
			'WHOVISITEDTHISTOPIC_VISIT_TITLE'	=> $this->user->lang('WHOVISITEDTHISTOPIC_VISIT_TITLE', $value),
		]);
	}
}
