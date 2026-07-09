<?php
/**
*
* @package BBsvg
* @copyright (c) 2017 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\svg\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * SVG support Event listener.
 */
class main_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.acp_ranks_edit_modify_tpl_ary'	=> 'load_svg_ranks',
			'core.acp_ranks_save_modify_sql_ary'	=> 'save_svg_ranks',

			'core.acp_manage_forums_request_data'		=> 'acp_request_svg_forum_icons',
			'core.acp_manage_forums_initialise_data'	=> 'acp_init_svg_forum_icons',
			'core.acp_manage_forums_display_form'		=> 'acp_display_svg_forum_icons',

			'core.ucp_main_front_modify_template_vars'				=> 'ucp_main_front_modify_template_vars',
			'core.ucp_main_subscribed_forum_modify_template_vars'	=> 'ucp_subscribed_display_svg_forum_icons',
			'core.display_forums_modify_template_vars'				=> 'forumlist_display_svg_forum_icons',

			'core.viewforum_get_topic_data'							=> 'viewforum_display_svg_topic_icons',
			'core.mcp_forum_view_before'							=> 'mcp_display_svg_topic_icons',
			'core.ucp_main_topiclist_topic_modify_template_vars'	=> 'ucp_subscribed_bookmarked_display_svg_topic_icons',
			'core.search_modify_tpl_ary'							=> 'search_display_svg_topic_icons',

			'core.mcp_view_forum_modify_topicrow'	=> 'mcp_load_svg_topic_icons',
			'core.ucp_main_topiclist_modify_query'	=> 'ucp_subscribed_bookmarked_load_svg_topic_icons',
			'core.search_get_topic_data'			=> 'search_load_svg_topic_icons',
			'core.ucp_main_front_modify_sql'		=> 'ucp_load_svg_topic_icons',
		);
	}

	protected $config;
	protected $user;
	protected $db;
	protected $request;
	protected $template;
	protected $root_path;
	protected $ranks_table;
	public function __construct(\phpbb\config\config $config, \phpbb\user $user, \phpbb\db\driver\driver_interface $db, \phpbb\request\request $request, \phpbb\template\template $template, $root_path, $ranks_table)
	{
		$this->config = $config;
		$this->user = $user;
		$this->db = $db;
		$this->request = $request;
		$this->template = $template;
		$this->root_path = $root_path;
		$this->ranks_table = $ranks_table;
	}

	public function load_svg_ranks($event)
	{
		$tpl_ary = $event['tpl_ary'];

		$existing_imgs = array();
		$sql = 'SELECT *
				FROM ' . $this->ranks_table . '
				ORDER BY rank_min ASC, rank_special ASC';
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$existing_imgs[] = $row['rank_image'];
		}
		$this->db->sql_freeresult($result);

		foreach (filelist($this->root_path . $this->config['ranks_path'], '', 'svg') as $path => $img_ary)
		{
			sort($img_ary);

			foreach ($img_ary as $img)
			{
				$img = $path . $img;

				if ($event['ranks'] && $img == $event['ranks']['rank_image'])
				{
					$selected = ' selected="selected"';
					$edit_img = $img;
				}
				else
				{
					$selected = '';
				}

				if (strlen($img) > 255)
				{
					continue;
				}

				$tpl_ary['S_FILENAME_LIST'] .= '<option value="' . htmlspecialchars($img) . '"' . $selected . '>' . $img . ((in_array($img, $existing_imgs)) ? ' ' . $this->user->lang('RANK_IMAGE_IN_USE') : '') . '</option>';
			}
		}

		$event['tpl_ary'] = $tpl_ary;
	}

	public function save_svg_ranks($event)
	{
		$sql_ary = $event['sql_ary'];

		$rank_image = $this->request->variable('rank_image', '');
		if ($rank_image != '' && preg_match('#(\.gif|\.png|\.jpg|\.jpeg|\.svg)$#i', $rank_image))
		{
			$sql_ary['rank_image'] = htmlspecialchars_decode($rank_image);
		}

		$event['sql_ary'] = $sql_ary;
	}

	public function acp_request_svg_forum_icons($event)
	{
		$forum_data = $event['forum_data'];

		$forum_data['forum_wf_icon_folder_unread'] = $this->request->variable('viewforum_icon_folder_unread', '');
		$forum_data['forum_wf_icon_folder_read'] = $this->request->variable('viewforum_icon_folder_read', '');
		$forum_data['forum_wf_icon_lock'] = $this->request->variable('viewforum_icon_lock', '');
		$forum_data['forum_wf_icon_link'] = $this->request->variable('viewforum_icon_link', '');
		$forum_data['forum_wt_icon_lock'] = $this->request->variable('viewtopic_icon_lock', '');
		$forum_data['forum_wt_icon_global_unread'] = $this->request->variable('viewtopic_icon_global_unread', '');
		$forum_data['forum_wt_icon_global_read'] = $this->request->variable('viewtopic_icon_global_read', '');
		$forum_data['forum_wt_icon_announce_unread'] = $this->request->variable('viewtopic_icon_announce_unread', '');
		$forum_data['forum_wt_icon_announce_read'] = $this->request->variable('viewtopic_icon_announce_read', '');
		$forum_data['forum_wt_icon_sticky_unread'] = $this->request->variable('viewtopic_icon_sticky_unread', '');
		$forum_data['forum_wt_icon_sticky_read'] = $this->request->variable('viewtopic_icon_sticky_read', '');
		$forum_data['forum_wt_icon_poll_unread'] = $this->request->variable('viewtopic_icon_poll_unread', '');
		$forum_data['forum_wt_icon_poll_read'] = $this->request->variable('viewtopic_icon_poll_read', '');
		$forum_data['forum_wt_icon_moved_unread'] = $this->request->variable('viewtopic_icon_moved_unread', '');
		$forum_data['forum_wt_icon_moved_read'] = $this->request->variable('viewtopic_icon_moved_read', '');
		$forum_data['forum_wt_icon_normal_unread'] = $this->request->variable('viewtopic_icon_normal_unread', '');
		$forum_data['forum_wt_icon_normal_read'] = $this->request->variable('viewtopic_icon_normal_read', '');

		$event['forum_data'] = $forum_data;
	}

	public function acp_init_svg_forum_icons($event)
	{
		if ($event['action'] != 'edit' && !$event['update'])
		{
			$forum_data = $event['forum_data'];

			$forum_data['forum_wf_icon_folder_unread'] = '';
			$forum_data['forum_wf_icon_folder_read'] = '';
			$forum_data['forum_wf_icon_lock'] = '';
			$forum_data['forum_wf_icon_link'] = '';
			$forum_data['forum_wt_icon_lock'] = '';
			$forum_data['forum_wt_icon_global_unread'] = '';
			$forum_data['forum_wt_icon_global_read'] = '';
			$forum_data['forum_wt_icon_announce_unread'] = '';
			$forum_data['forum_wt_icon_announce_read'] = '';
			$forum_data['forum_wt_icon_sticky_unread'] = '';
			$forum_data['forum_wt_icon_sticky_read'] = '';
			$forum_data['forum_wt_icon_poll_unread'] = '';
			$forum_data['forum_wt_icon_poll_read'] = '';
			$forum_data['forum_wt_icon_moved_unread'] = '';
			$forum_data['forum_wt_icon_moved_read'] = '';
			$forum_data['forum_wt_icon_normal_unread'] = '';
			$forum_data['forum_wt_icon_normal_read'] = '';

			$event['forum_data'] = $forum_data;
		}
	}

	public function acp_display_svg_forum_icons($event)
	{
		$template_data = $event['template_data'];

		$template_data['VIEWFORUM_ICON_FOLDER_UNREAD']		= $event['forum_data']['forum_wf_icon_folder_unread'];
		$template_data['VIEWFORUM_ICON_FOLDER_READ']		= $event['forum_data']['forum_wf_icon_folder_read'];
		$template_data['VIEWFORUM_ICON_LOCK']				= $event['forum_data']['forum_wf_icon_lock'];
		$template_data['VIEWFORUM_ICON_LINK']				= $event['forum_data']['forum_wf_icon_link'];
		$template_data['VIEWTOPIC_ICON_LOCK']				= $event['forum_data']['forum_wt_icon_lock'];
		$template_data['VIEWTOPIC_ICON_GLOBAL_UNREAD']		= $event['forum_data']['forum_wt_icon_global_unread'];
		$template_data['VIEWTOPIC_ICON_GLOBAL_READ']		= $event['forum_data']['forum_wt_icon_global_read'];
		$template_data['VIEWTOPIC_ICON_ANNOUNCE_UNREAD']	= $event['forum_data']['forum_wt_icon_announce_unread'];
		$template_data['VIEWTOPIC_ICON_ANNOUNCE_READ']		= $event['forum_data']['forum_wt_icon_announce_read'];
		$template_data['VIEWTOPIC_ICON_STICKY_UNREAD']		= $event['forum_data']['forum_wt_icon_sticky_unread'];
		$template_data['VIEWTOPIC_ICON_STICKY_READ']		= $event['forum_data']['forum_wt_icon_sticky_read'];
		$template_data['VIEWTOPIC_ICON_POLL_UNREAD']		= $event['forum_data']['forum_wt_icon_poll_unread'];
		$template_data['VIEWTOPIC_ICON_POLL_READ']			= $event['forum_data']['forum_wt_icon_poll_read'];
		$template_data['VIEWTOPIC_ICON_MOVED_UNREAD']		= $event['forum_data']['forum_wt_icon_moved_unread'];
		$template_data['VIEWTOPIC_ICON_MOVED_READ']			= $event['forum_data']['forum_wt_icon_moved_read'];
		$template_data['VIEWTOPIC_ICON_NORMAL_UNREAD']		= $event['forum_data']['forum_wt_icon_normal_unread'];
		$template_data['VIEWTOPIC_ICON_NORMAL_READ']		= $event['forum_data']['forum_wt_icon_normal_read'];

		$template_data['VIEWFORUM_ICON_FOLDER_UNREAD_SRC']		= ($event['forum_data']['forum_wf_icon_folder_unread']) ? $this->root_path . $event['forum_data']['forum_wf_icon_folder_unread'] : '';
		$template_data['VIEWFORUM_ICON_FOLDER_READ_SRC']		= ($event['forum_data']['forum_wf_icon_folder_read']) ? $this->root_path . $event['forum_data']['forum_wf_icon_folder_read'] : '';
		$template_data['VIEWFORUM_ICON_LOCK_SRC']				= ($event['forum_data']['forum_wf_icon_lock']) ? $this->root_path . $event['forum_data']['forum_wf_icon_lock'] : '';
		$template_data['VIEWFORUM_ICON_LINK_SRC']				= ($event['forum_data']['forum_wf_icon_link']) ? $this->root_path . $event['forum_data']['forum_wf_icon_link'] : '';
		$template_data['VIEWTOPIC_ICON_LOCK_SRC']				= ($event['forum_data']['forum_wt_icon_lock']) ? $this->root_path . $event['forum_data']['forum_wt_icon_lock'] : '';
		$template_data['VIEWTOPIC_ICON_GLOBAL_UNREAD_SRC']		= ($event['forum_data']['forum_wt_icon_global_unread']) ? $this->root_path . $event['forum_data']['forum_wt_icon_global_unread'] : '';
		$template_data['VIEWTOPIC_ICON_GLOBAL_READ_SRC']		= ($event['forum_data']['forum_wt_icon_global_read']) ? $this->root_path . $event['forum_data']['forum_wt_icon_global_read'] : '';
		$template_data['VIEWTOPIC_ICON_ANNOUNCE_UNREAD_SRC']	= ($event['forum_data']['forum_wt_icon_announce_unread']) ? $this->root_path . $event['forum_data']['forum_wt_icon_announce_unread'] : '';
		$template_data['VIEWTOPIC_ICON_ANNOUNCE_READ_SRC']		= ($event['forum_data']['forum_wt_icon_announce_read']) ? $this->root_path . $event['forum_data']['forum_wt_icon_announce_read'] : '';
		$template_data['VIEWTOPIC_ICON_STICKY_UNREAD_SRC']		= ($event['forum_data']['forum_wt_icon_sticky_unread']) ? $this->root_path . $event['forum_data']['forum_wt_icon_sticky_unread'] : '';
		$template_data['VIEWTOPIC_ICON_STICKY_READ_SRC']		= ($event['forum_data']['forum_wt_icon_sticky_read']) ? $this->root_path . $event['forum_data']['forum_wt_icon_sticky_read'] : '';
		$template_data['VIEWTOPIC_ICON_POLL_UNREAD_SRC']		= ($event['forum_data']['forum_wt_icon_poll_unread']) ? $this->root_path . $event['forum_data']['forum_wt_icon_poll_unread'] : '';
		$template_data['VIEWTOPIC_ICON_POLL_READ_SRC']			= ($event['forum_data']['forum_wt_icon_poll_read']) ? $this->root_path . $event['forum_data']['forum_wt_icon_poll_read'] : '';
		$template_data['VIEWTOPIC_ICON_MOVED_UNREAD_SRC']		= ($event['forum_data']['forum_wt_icon_moved_unread']) ? $this->root_path . $event['forum_data']['forum_wt_icon_moved_unread'] : '';
		$template_data['VIEWTOPIC_ICON_MOVED_READ_SRC']			= ($event['forum_data']['forum_wt_icon_moved_read']) ? $this->root_path . $event['forum_data']['forum_wt_icon_moved_read'] : '';
		$template_data['VIEWTOPIC_ICON_NORMAL_UNREAD_SRC']		= ($event['forum_data']['forum_wt_icon_normal_unread']) ? $this->root_path . $event['forum_data']['forum_wt_icon_normal_unread'] : '';
		$template_data['VIEWTOPIC_ICON_NORMAL_READ_SRC']		= ($event['forum_data']['forum_wt_icon_normal_read']) ? $this->root_path . $event['forum_data']['forum_wt_icon_normal_read'] : '';

		$event['template_data'] = $template_data;
	}

	public function ucp_load_svg_topic_icons($event)
	{
		$event['sql_select'] .= ', f.forum_wt_icon_lock, f.forum_wt_icon_global_unread, f.forum_wt_icon_global_read, f.forum_wt_icon_announce_unread, f.forum_wt_icon_announce_read, f.forum_wt_icon_sticky_unread, f.forum_wt_icon_sticky_read, f.forum_wt_icon_poll_unread, f.forum_wt_icon_poll_read, f.forum_wt_icon_moved_unread, f.forum_wt_icon_moved_read, f.forum_wt_icon_normal_unread, f.forum_wt_icon_normal_read';
		if (version_compare(PHPBB_VERSION, '3.3.9', '<')) {
			$event['sql_from'] .= ' LEFT JOIN ' . FORUMS_TABLE . ' f ON (f.forum_id = t.forum_id)';
		}

		$this->template->assign_var('SITESPLAT_BBSVG_TOPICROW', true);
	}

	public function ucp_main_front_modify_template_vars($event)
	{
		$topicrow = $event['topicrow'];

		$topicrow['VIEWTOPIC_ICON_LOCK_SRC']			= ($event['row']['forum_wt_icon_lock']) ? $this->root_path . $event['row']['forum_wt_icon_lock'] : '';
		$topicrow['VIEWTOPIC_ICON_GLOBAL_UNREAD_SRC']	= ($event['row']['forum_wt_icon_global_unread']) ? $this->root_path . $event['row']['forum_wt_icon_global_unread'] : '';
		$topicrow['VIEWTOPIC_ICON_GLOBAL_READ_SRC']		= ($event['row']['forum_wt_icon_global_read']) ? $this->root_path . $event['row']['forum_wt_icon_global_read'] : '';
		$topicrow['VIEWTOPIC_ICON_ANNOUNCE_UNREAD_SRC']	= ($event['row']['forum_wt_icon_announce_unread']) ? $this->root_path . $event['row']['forum_wt_icon_announce_unread'] : '';
		$topicrow['VIEWTOPIC_ICON_ANNOUNCE_READ_SRC']	= ($event['row']['forum_wt_icon_announce_read']) ? $this->root_path . $event['row']['forum_wt_icon_announce_read'] : '';
		$topicrow['VIEWTOPIC_ICON_STICKY_UNREAD_SRC']	= ($event['row']['forum_wt_icon_sticky_unread']) ? $this->root_path . $event['row']['forum_wt_icon_sticky_unread'] : '';
		$topicrow['VIEWTOPIC_ICON_STICKY_READ_SRC']		= ($event['row']['forum_wt_icon_sticky_read']) ? $this->root_path . $event['row']['forum_wt_icon_sticky_read'] : '';
		$topicrow['VIEWTOPIC_ICON_POLL_UNREAD_SRC']		= ($event['row']['forum_wt_icon_poll_unread']) ? $this->root_path . $event['row']['forum_wt_icon_poll_unread'] : '';
		$topicrow['VIEWTOPIC_ICON_POLL_READ_SRC']		= ($event['row']['forum_wt_icon_poll_read']) ? $this->root_path . $event['row']['forum_wt_icon_poll_read'] : '';
		$topicrow['VIEWTOPIC_ICON_MOVED_UNREAD_SRC']	= ($event['row']['forum_wt_icon_moved_unread']) ? $this->root_path . $event['row']['forum_wt_icon_moved_unread'] : '';
		$topicrow['VIEWTOPIC_ICON_MOVED_READ_SRC']		= ($event['row']['forum_wt_icon_moved_read']) ? $this->root_path . $event['row']['forum_wt_icon_moved_read'] : '';
		$topicrow['VIEWTOPIC_ICON_NORMAL_UNREAD_SRC']	= ($event['row']['forum_wt_icon_normal_unread']) ? $this->root_path . $event['row']['forum_wt_icon_normal_unread'] : '';
		$topicrow['VIEWTOPIC_ICON_NORMAL_READ_SRC']		= ($event['row']['forum_wt_icon_normal_read']) ? $this->root_path . $event['row']['forum_wt_icon_normal_read'] : '';

		$event['topicrow'] = $topicrow;
	}

	public function ucp_subscribed_display_svg_forum_icons($event)
	{
		$this->display_svg_forum_icons($event, 'template_vars', 'row');
	}

	public function forumlist_display_svg_forum_icons($event)
	{
		$this->display_svg_forum_icons($event, 'forum_row', 'row');
	}

	public function viewforum_display_svg_topic_icons($event)
	{
		$this->display_svg_topic_icons($event, 'forum_data');
	}

	public function mcp_load_svg_topic_icons($event)
	{
		$topic_row = $event['topic_row'];
		$topic_row['S_TOPIC_TYPE'] = $event['row']['topic_type'];
		$topic_row['S_HAS_POLL'] = ($event['row']['poll_start']) ? true : false;
		$event['topic_row'] = $topic_row;
	}

	public function mcp_display_svg_topic_icons($event)
	{
		$this->display_svg_topic_icons($event, 'forum_info');
	}

	public function ucp_subscribed_bookmarked_load_svg_topic_icons($event)
	{
		$sql_array = $event['sql_array'];
		$sql_array['SELECT'] .= ', f.forum_wt_icon_lock, f.forum_wt_icon_global_unread, f.forum_wt_icon_global_read, f.forum_wt_icon_announce_unread, f.forum_wt_icon_announce_read, f.forum_wt_icon_sticky_unread, f.forum_wt_icon_sticky_read, f.forum_wt_icon_poll_unread, f.forum_wt_icon_poll_read, f.forum_wt_icon_moved_unread, f.forum_wt_icon_moved_read, f.forum_wt_icon_normal_unread, f.forum_wt_icon_normal_read';
		$event['sql_array'] = $sql_array;

		$this->template->assign_var('SITESPLAT_BBSVG_TOPICROW', true);
	}

	public function ucp_subscribed_bookmarked_display_svg_topic_icons($event)
	{
		$template_vars = $event['template_vars'];

		$template_vars['S_TOPIC_TYPE']							= $event['row']['topic_type'];
		$template_vars['S_HAS_POLL']							= ($event['row']['poll_start']) ? true : false;
		$template_vars['VIEWTOPIC_ICON_LOCK_SRC']				= ($event['row']['forum_wt_icon_lock']) ? $this->root_path . $event['row']['forum_wt_icon_lock'] : '';
		$template_vars['VIEWTOPIC_ICON_GLOBAL_UNREAD_SRC']		= ($event['row']['forum_wt_icon_global_unread']) ? $this->root_path . $event['row']['forum_wt_icon_global_unread'] : '';
		$template_vars['VIEWTOPIC_ICON_GLOBAL_READ_SRC']		= ($event['row']['forum_wt_icon_global_read']) ? $this->root_path . $event['row']['forum_wt_icon_global_read'] : '';
		$template_vars['VIEWTOPIC_ICON_ANNOUNCE_UNREAD_SRC']	= ($event['row']['forum_wt_icon_announce_unread']) ? $this->root_path . $event['row']['forum_wt_icon_announce_unread'] : '';
		$template_vars['VIEWTOPIC_ICON_ANNOUNCE_READ_SRC']		= ($event['row']['forum_wt_icon_announce_read']) ? $this->root_path . $event['row']['forum_wt_icon_announce_read'] : '';
		$template_vars['VIEWTOPIC_ICON_STICKY_UNREAD_SRC']		= ($event['row']['forum_wt_icon_sticky_unread']) ? $this->root_path . $event['row']['forum_wt_icon_sticky_unread'] : '';
		$template_vars['VIEWTOPIC_ICON_STICKY_READ_SRC']		= ($event['row']['forum_wt_icon_sticky_read']) ? $this->root_path . $event['row']['forum_wt_icon_sticky_read'] : '';
		$template_vars['VIEWTOPIC_ICON_POLL_UNREAD_SRC']		= ($event['row']['forum_wt_icon_poll_unread']) ? $this->root_path . $event['row']['forum_wt_icon_poll_unread'] : '';
		$template_vars['VIEWTOPIC_ICON_POLL_READ_SRC']			= ($event['row']['forum_wt_icon_poll_read']) ? $this->root_path . $event['row']['forum_wt_icon_poll_read'] : '';
		$template_vars['VIEWTOPIC_ICON_MOVED_UNREAD_SRC']		= ($event['row']['forum_wt_icon_moved_unread']) ? $this->root_path . $event['row']['forum_wt_icon_moved_unread'] : '';
		$template_vars['VIEWTOPIC_ICON_MOVED_READ_SRC']			= ($event['row']['forum_wt_icon_moved_read']) ? $this->root_path . $event['row']['forum_wt_icon_moved_read'] : '';
		$template_vars['VIEWTOPIC_ICON_NORMAL_UNREAD_SRC']		= ($event['row']['forum_wt_icon_normal_unread']) ? $this->root_path . $event['row']['forum_wt_icon_normal_unread'] : '';
		$template_vars['VIEWTOPIC_ICON_NORMAL_READ_SRC']		= ($event['row']['forum_wt_icon_normal_read']) ? $this->root_path . $event['row']['forum_wt_icon_normal_read'] : '';

		$event['template_vars'] = $template_vars;
	}

	public function search_display_svg_topic_icons($event)
	{
		if ($event['show_results'] !== 'topics')
		{
			return;
		}
		$this->template->assign_block_vars('topicrow', array(
			'TOPIC_ID'								=> $event['row']['topic_id'],
			'VIEWTOPIC_ICON_LOCK_SRC'				=> ($event['row']['forum_wt_icon_lock']) ? $this->root_path . $event['row']['forum_wt_icon_lock'] : '',
			'VIEWTOPIC_ICON_GLOBAL_UNREAD_SRC'		=> ($event['row']['forum_wt_icon_global_unread']) ? $this->root_path . $event['row']['forum_wt_icon_global_unread'] : '',
			'VIEWTOPIC_ICON_GLOBAL_READ_SRC'		=> ($event['row']['forum_wt_icon_global_read']) ? $this->root_path . $event['row']['forum_wt_icon_global_read'] : '',
			'VIEWTOPIC_ICON_ANNOUNCE_UNREAD_SRC'	=> ($event['row']['forum_wt_icon_announce_unread']) ? $this->root_path . $event['row']['forum_wt_icon_announce_unread'] : '',
			'VIEWTOPIC_ICON_ANNOUNCE_READ_SRC'		=> ($event['row']['forum_wt_icon_announce_read']) ? $this->root_path . $event['row']['forum_wt_icon_announce_read'] : '',
			'VIEWTOPIC_ICON_STICKY_UNREAD_SRC'		=> ($event['row']['forum_wt_icon_sticky_unread']) ? $this->root_path . $event['row']['forum_wt_icon_sticky_unread'] : '',
			'VIEWTOPIC_ICON_STICKY_READ_SRC'		=> ($event['row']['forum_wt_icon_sticky_read']) ? $this->root_path . $event['row']['forum_wt_icon_sticky_read'] : '',
			'VIEWTOPIC_ICON_POLL_UNREAD_SRC'		=> ($event['row']['forum_wt_icon_poll_unread']) ? $this->root_path . $event['row']['forum_wt_icon_poll_unread'] : '',
			'VIEWTOPIC_ICON_POLL_READ_SRC'			=> ($event['row']['forum_wt_icon_poll_read']) ? $this->root_path . $event['row']['forum_wt_icon_poll_read'] : '',
			'VIEWTOPIC_ICON_MOVED_UNREAD_SRC'		=> ($event['row']['forum_wt_icon_moved_unread']) ? $this->root_path . $event['row']['forum_wt_icon_moved_unread'] : '',
			'VIEWTOPIC_ICON_MOVED_READ_SRC'			=> ($event['row']['forum_wt_icon_moved_read']) ? $this->root_path . $event['row']['forum_wt_icon_moved_read'] : '',
			'VIEWTOPIC_ICON_NORMAL_UNREAD_SRC'		=> ($event['row']['forum_wt_icon_normal_unread']) ? $this->root_path . $event['row']['forum_wt_icon_normal_unread'] : '',
			'VIEWTOPIC_ICON_NORMAL_READ_SRC'		=> ($event['row']['forum_wt_icon_normal_read']) ? $this->root_path . $event['row']['forum_wt_icon_normal_read'] : '',
		));
	}

	public function search_load_svg_topic_icons($event)
	{
		$sql_select = $event['sql_select'];
		$sql_select .= ', f.forum_wt_icon_lock, f.forum_wt_icon_global_unread, f.forum_wt_icon_global_read, f.forum_wt_icon_announce_unread, f.forum_wt_icon_announce_read, f.forum_wt_icon_sticky_unread, f.forum_wt_icon_sticky_read, f.forum_wt_icon_poll_unread, f.forum_wt_icon_poll_read, f.forum_wt_icon_moved_unread, f.forum_wt_icon_moved_read, f.forum_wt_icon_normal_unread, f.forum_wt_icon_normal_read';
		$event['sql_select'] = $sql_select;

		$this->template->assign_var('SITESPLAT_BBSVG_TOPICROW', true);
	}

	protected function display_svg_forum_icons($event, $template_var_name, $data_var_name)
	{
		$forum_row = $event[$template_var_name];

		$forum_row['VIEWFORUM_ICON_FOLDER_UNREAD_SRC']		= ($event[$data_var_name]['forum_wf_icon_folder_unread']) ? $this->root_path . $event[$data_var_name]['forum_wf_icon_folder_unread'] : '';
		$forum_row['VIEWFORUM_ICON_FOLDER_READ_SRC']		= ($event[$data_var_name]['forum_wf_icon_folder_read']) ? $this->root_path . $event[$data_var_name]['forum_wf_icon_folder_read'] : '';
		$forum_row['VIEWFORUM_ICON_LOCK_SRC']				= ($event[$data_var_name]['forum_wf_icon_lock']) ? $this->root_path . $event[$data_var_name]['forum_wf_icon_lock'] : '';
		$forum_row['VIEWFORUM_ICON_LINK_SRC']				= ($event[$data_var_name]['forum_wf_icon_link']) ? $this->root_path . $event[$data_var_name]['forum_wf_icon_link'] : '';

		$event[$template_var_name] = $forum_row;
	}

	protected function display_svg_topic_icons($event, $var_name)
	{
		$this->template->assign_vars(array(
			'VIEWTOPIC_ICON_LOCK_SRC'				=> ($event[$var_name]['forum_wt_icon_lock']) ? $this->root_path . $event[$var_name]['forum_wt_icon_lock'] : '',
			'VIEWTOPIC_ICON_GLOBAL_UNREAD_SRC'		=> ($event[$var_name]['forum_wt_icon_global_unread']) ? $this->root_path . $event[$var_name]['forum_wt_icon_global_unread'] : '',
			'VIEWTOPIC_ICON_GLOBAL_READ_SRC'		=> ($event[$var_name]['forum_wt_icon_global_read']) ? $this->root_path . $event[$var_name]['forum_wt_icon_global_read'] : '',
			'VIEWTOPIC_ICON_ANNOUNCE_UNREAD_SRC'	=> ($event[$var_name]['forum_wt_icon_announce_unread']) ? $this->root_path . $event[$var_name]['forum_wt_icon_announce_unread'] : '',
			'VIEWTOPIC_ICON_ANNOUNCE_READ_SRC'		=> ($event[$var_name]['forum_wt_icon_announce_read']) ? $this->root_path . $event[$var_name]['forum_wt_icon_announce_read'] : '',
			'VIEWTOPIC_ICON_STICKY_UNREAD_SRC'		=> ($event[$var_name]['forum_wt_icon_sticky_unread']) ? $this->root_path . $event[$var_name]['forum_wt_icon_sticky_unread'] : '',
			'VIEWTOPIC_ICON_STICKY_READ_SRC'		=> ($event[$var_name]['forum_wt_icon_sticky_read']) ? $this->root_path . $event[$var_name]['forum_wt_icon_sticky_read'] : '',
			'VIEWTOPIC_ICON_POLL_UNREAD_SRC'		=> ($event[$var_name]['forum_wt_icon_poll_unread']) ? $this->root_path . $event[$var_name]['forum_wt_icon_poll_unread'] : '',
			'VIEWTOPIC_ICON_POLL_READ_SRC'			=> ($event[$var_name]['forum_wt_icon_poll_read']) ? $this->root_path . $event[$var_name]['forum_wt_icon_poll_read'] : '',
			'VIEWTOPIC_ICON_MOVED_UNREAD_SRC'		=> ($event[$var_name]['forum_wt_icon_moved_unread']) ? $this->root_path . $event[$var_name]['forum_wt_icon_moved_unread'] : '',
			'VIEWTOPIC_ICON_MOVED_READ_SRC'			=> ($event[$var_name]['forum_wt_icon_moved_read']) ? $this->root_path . $event[$var_name]['forum_wt_icon_moved_read'] : '',
			'VIEWTOPIC_ICON_NORMAL_UNREAD_SRC'		=> ($event[$var_name]['forum_wt_icon_normal_unread']) ? $this->root_path . $event[$var_name]['forum_wt_icon_normal_unread'] : '',
			'VIEWTOPIC_ICON_NORMAL_READ_SRC'		=> ($event[$var_name]['forum_wt_icon_normal_read']) ? $this->root_path . $event[$var_name]['forum_wt_icon_normal_read'] : '',
		));
	}
}
