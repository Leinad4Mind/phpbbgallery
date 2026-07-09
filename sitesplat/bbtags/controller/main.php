<?php
/**
*
* BBtags
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbtags\controller;

use phpbb\db\driver\driver_interface;
use phpbb\config\config;
use phpbb\config\db_text;
use phpbb\template\template;
use phpbb\controller\helper;
use phpbb\request\request;
use phpbb\user;
use phpbb\auth\auth;
use phpbb\cache\service;
use phpbb\pagination;
use phpbb\event\dispatcher;
use phpbb\content_visibility;
use sitesplat\bbtags\tags\manager;

/**
 * @ignore
 */
use phpbb\json_response;

class main
{
	protected $db;
	protected $config;
	protected $config_text;
	protected $template;
	protected $helper;
	protected $request;
	protected $user;
	protected $auth;
	protected $cache;
	protected $pagination;
	protected $phpbb_dispatcher;
	protected $content_visibility;
	protected $php_ext;
	protected $phpbb_root_path;
	protected $manager;
	protected $table_bbtags;
	protected $table_bbtags_topic;

	/**
	 * Constructor
	 */
	public function __construct(driver_interface $db, config $config, db_text $config_text, template $template, helper $helper, request $request, user $user, auth $auth, service $cache, pagination $pagination, dispatcher $phpbb_dispatcher, content_visibility $content_visibility, $php_ext, $phpbb_root_path, manager $manager, $table_bbtags, $table_bbtags_topic)
	{
		$this->db				= $db;
		$this->config			= $config;
		$this->config_text		= $config_text;
		$this->template			= $template;
		$this->helper			= $helper;
		$this->request			= $request;
		$this->user				= $user;
		$this->auth				= $auth;
		$this->cache			= $cache;
		$this->pagination		= $pagination;
		$this->phpbb_dispatcher	= $phpbb_dispatcher;
		$this->content_visibility = $content_visibility;
		$this->php_ext			= $php_ext;
		$this->phpbb_root_path	= $phpbb_root_path;
		$this->manager			= $manager;
		$this->table_bbtags			= $table_bbtags;
		$this->table_bbtags_topic	= $table_bbtags_topic;
	}

	public function suggest_tags()
	{
		if ($this->request->is_ajax())
		{
			$tags = ($this->request->variable('message', '', true));
			
			$tags = $this->stripBBCode($tags);
			$tags = array_count_values(explode(' ', $tags));
			arsort($tags);
			$tag = array();
			foreach($tags as $key => $value)
			{
				if (strlen($this->manager->clean_tag($key)) <= $this->config['bbtags_min_length'])
				{
					continue;
				}
				$tag[$this->manager->clean_tag($key)] = $value;
			}
			$tag = array_slice($tag, 0, $this->config['bbtags_max_tags'], true);	
			$tag = implode(', ', array_keys($tag));			
			$json_response = new json_response();
			$json_response->send($tag);
		}
	}

	public function auto_complete()
	{
		if ($this->request->is_ajax())
		{
			$tags = json_decode($this->config_text->get('bbtags_pre_tags'), true);
			$term = $this->manager->Slug(strtolower($this->request->variable('term', '', true)));
			
			$tags = preg_grep("/^" . $term . ".*/", $tags);
			$json_response = new json_response();
			$json_response->send($tags);
		}
	}
	
	public function show_topic($tags)
	{
		if (!$this->auth->acl_get('u_bbtags_read'))
		{
			return $this->helper->error('NOT_AUTHORISED', 403);
		}

		$this->user->add_lang('search');
		
		include($this->phpbb_root_path . 'includes/functions_display.' . $this->php_ext);
		$icons = $this->cache->obtain_icons();
		
		$ex_fid_ary = array_unique(array_merge(array_keys($this->auth->acl_getf('!f_read', true)), array_keys($this->auth->acl_getf('!f_search', true))));
		$not_in_fid = (sizeof($ex_fid_ary)) ? ' AND ' . $this->db->sql_in_set('topics.forum_id', $ex_fid_ary, true) : '';
	
		$tags = $this->manager->clean_tag($tags);
		$sql = 'SELECT t.id, COUNT(tt.id) AS total FROM ' .  $this->table_bbtags_topic . ' tt
				LEFT JOIN ' . $this->table_bbtags . ' t ON t.id = tt.tag_id
				LEFT JOIN ' . TOPICS_TABLE . ' topics ON topics.topic_id = tt.topic_id
				WHERE t.route = "' . $this->db->sql_escape($tags) . '"' . $not_in_fid . '
                GROUP BY t.id';
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$topics_count = $row['total'];
		$tag_id = $row['id'];

		$start = max($this->request->variable('start', 0), 0);
		$start = $this->pagination->validate_start($start, $this->config['topics_per_page'], $topics_count);
		$u_search = $this->helper->route('sitesplat_bbtags_controller', array('tags' => $this->manager->Slug($tags)));
		$this->pagination->generate_template_pagination($u_search, 'pagination', 'start', $topics_count, $this->config['topics_per_page'], $start);

		if ($topics_count > 0)
		{
			$folder_img = $folder_alt = $topic_type = '';

			$sql_array = array(
				'SELECT'	=> 't.*, topics.*, ttt.mark_time',
				'FROM'		=> array(
					$this->table_bbtags_topic	=> 'tt'
				),
				
				'LEFT_JOIN' => array(
					array(
						'FROM'	=> array(TOPICS_TABLE => 't'),
						'ON'	=> 't.topic_id = tt.topic_id',
					),
					array(
						'FROM'	=> array(FORUMS_TABLE => 'topics'),
						'ON'	=> 'topics.forum_id = t.forum_id',
					),
					array(
						'FROM'	=> array(TOPICS_TRACK_TABLE => 'ttt'),
						'ON'	=> 'ttt.topic_id = t.topic_id AND ttt.user_id = ' . $this->user->data['user_id'],
					),
				),				
				'WHERE'			=> 'tt.tag_id = ' . $tag_id . $not_in_fid,
				'ORDER_BY'		=> 't.topic_last_post_time DESC'
			);
			$sql = $this->db->sql_build_query('SELECT_DISTINCT', $sql_array);
			$result = $this->db->sql_query_limit($sql, $this->config['topics_per_page'], $start);
			while($row = $this->db->sql_fetchrow($result))
			{
				$replies = $this->content_visibility->get_count('topic_posts', $row, $row['forum_id']) - 1;
				topic_status($row, $replies, (isset($topic_tracking_info[$row['forum_id']][$row['topic_id']]) && $row['topic_last_post_time'] > $topic_tracking_info[$forum_id][$row['topic_id']]) ? true : false, $folder_img, $folder_alt, $topic_type);
				
				$unread_topic = (isset($topic_tracking_info[$row['forum_id']][$row['topic_id']]) && $row['topic_last_post_time'] > $topic_tracking_info[$row['forum_id']][$row['topic_id']]) ? true : false;
				$topic_unapproved = (($row['topic_visibility'] == ITEM_UNAPPROVED || $row['topic_visibility'] == ITEM_REAPPROVE) && $this->auth->acl_get('m_approve', $row['forum_id'])) ? true : false;
				$posts_unapproved = ($row['topic_visibility'] == ITEM_APPROVED && $row['topic_posts_unapproved'] && $auth->acl_get('m_approve', $forum_id)) ? true : false;
				$topic_deleted = $row['topic_visibility'] == ITEM_DELETED;
				$u_mcp_queue = ($topic_unapproved || $posts_unapproved) ? append_sid("{$this->phpbb_root_path}mcp.$this->php_ext", 'i=queue&amp;mode=' . (($topic_unapproved) ? 'approve_details' : 'unapproved_posts') .  '&amp;t=' . $row['topic_id'], true, $this->user->session_id) : '';
				$u_mcp_queue = (!$u_mcp_queue && $topic_deleted) ? append_sid("{$this->phpbb_root_path}mcp.$this->php_ext", "i=queue&amp;mode=deleted_topics&amp;t=". $row['topic_id'], true, $user->session_id) : $u_mcp_queue;
				
				$view_topic_url_params = 'f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id'];
				$view_topic_url = append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", $view_topic_url_params);

				$topic_row = array(
					'TOPIC_AUTHOR'				=> get_username_string('username', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
					'TOPIC_AUTHOR_COLOUR'		=> get_username_string('colour', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
					'TOPIC_AUTHOR_FULL'			=> get_username_string('full', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
					'FIRST_POST_TIME'			=> $this->user->format_date($row['topic_time']),
					'LAST_POST_SUBJECT'			=> $row['topic_last_post_subject'],
					'LAST_POST_TIME'			=> $this->user->format_date($row['topic_last_post_time']),
					'LAST_VIEW_TIME'			=> $this->user->format_date($row['topic_last_view_time']),
					'LAST_POST_AUTHOR'			=> get_username_string('username', $row['topic_last_poster_id'], $row['topic_last_poster_name'], $row['topic_last_poster_colour']),
					'LAST_POST_AUTHOR_COLOUR'	=> get_username_string('colour', $row['topic_last_poster_id'], $row['topic_last_poster_name'], $row['topic_last_poster_colour']),
					'LAST_POST_AUTHOR_FULL'		=> get_username_string('full', $row['topic_last_poster_id'], $row['topic_last_poster_name'], $row['topic_last_poster_colour']),

					'TOPIC_TYPE'		=> $topic_type,

					'TOPIC_IMG_STYLE'		=> $folder_img,
					'TOPIC_FOLDER_IMG'		=> $this->user->img($folder_img, $folder_alt),
					'TOPIC_FOLDER_IMG_ALT'	=> $this->user->lang[$folder_alt],

					'TOPIC_ICON_IMG'		=> (!empty($icons[$row['icon_id']])) ? $icons[$row['icon_id']]['img'] : '',
					'TOPIC_ICON_IMG_WIDTH'	=> (!empty($icons[$row['icon_id']])) ? $icons[$row['icon_id']]['width'] : '',
					'TOPIC_ICON_IMG_HEIGHT'	=> (!empty($icons[$row['icon_id']])) ? $icons[$row['icon_id']]['height'] : '',
					'ATTACH_ICON_IMG'		=> ($this->auth->acl_get('u_download') && $this->auth->acl_get('f_download', $row['forum_id']) && $row['topic_attachment']) ? $this->user->img('icon_topic_attach', $this->user->lang['TOTAL_ATTACHMENTS']) : '',
					'UNAPPROVED_IMG'		=> ($topic_unapproved || $posts_unapproved) ? $this->user->img('icon_topic_unapproved', ($topic_unapproved) ? 'TOPIC_UNAPPROVED' : 'POSTS_UNAPPROVED') : '',

					'S_TOPIC_TYPE'			=> $row['topic_type'],
					'S_USER_POSTED'			=> (!empty($row['topic_posted'])) ? true : false,
					'S_UNREAD_TOPIC'		=> $unread_topic,

					'S_TOPIC_REPORTED'		=> (!empty($row['topic_reported']) && $this->auth->acl_get('m_report', $forum_id)) ? true : false,
					'S_TOPIC_UNAPPROVED'	=> $topic_unapproved,
					'S_POSTS_UNAPPROVED'	=> $posts_unapproved,
					'S_TOPIC_DELETED'		=> $topic_deleted,
					'S_HAS_POLL'			=> ($row['poll_start']) ? true : false,

					'U_LAST_POST'			=> append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", $view_topic_url_params . '&amp;p=' . $row['topic_last_post_id']) . '#p' . $row['topic_last_post_id'],
					'U_LAST_POST_AUTHOR'	=> get_username_string('profile', $row['topic_last_poster_id'], $row['topic_last_poster_name'], $row['topic_last_poster_colour']),
					'U_TOPIC_AUTHOR'		=> get_username_string('profile', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
					'U_NEWEST_POST'			=> append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", $view_topic_url_params . '&amp;view=unread') . '#unread',
					'U_MCP_REPORT'			=> append_sid("{$this->phpbb_root_path}mcp.$this->php_ext", 'i=reports&amp;mode=reports&amp;t=' . $row['topic_id'], true, $this->user->session_id),
					'U_MCP_QUEUE'			=> $u_mcp_queue,
					'TOPIC_TITLE'		=> censor_text($row['topic_title']),
					'FORUM_ID'			=> $row['forum_id'],
					'TOPIC_ID'			=> $row['topic_id'],
					'POST_ID'			=> false,
	
					'FORUM_TITLE'		=> $row['forum_name'],
					'TOPIC_REPLIES'		=> $replies,
					'TOPIC_VIEWS'		=> $row['topic_views'],
	
					'U_VIEW_TOPIC'		=> append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", 'f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id']),
					'U_VIEW_FORUM'		=> append_sid("{$this->phpbb_root_path}viewforum.$this->php_ext", 'f=' . $row['forum_id']),
					'U_VIEW_POST'		=> (!empty($row['post_id'])) ? append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", 'f=' . $row['forum_id'] . '&amp;t=' . $row['topic_id'] . '&amp;p=' . $row['post_id']) . '#p' . $row['post_id'] : '',
				);

			$vars = array('topic_row');
			extract($this->phpbb_dispatcher->trigger_event('sitesplat.bbtags.btpreview', compact($vars)));

			$this->template->assign_block_vars('topicrow', $topic_row);
			}
		}
		
		$this->template->assign_vars(array('SEARCH_MATCHES' => $this->user->lang('FOUND_SEARCH_MATCHES', $topics_count)));
		return $this->helper->render('show_topics.html', 'Tag-' . $this->user->lang('SEARCH'));
	}

	public function stripBBCode($text_to_search)
	{
		$pattern = '|[[\\/\\!]*?[^\\[\\]]*?]|si';
		$replace = '';
		$text_to_search = preg_replace($pattern, $replace, $text_to_search);
		return preg_replace('/[^a-zA-Z0-9]+/', ' ', html_entity_decode($text_to_search, ENT_QUOTES));
	}
}
