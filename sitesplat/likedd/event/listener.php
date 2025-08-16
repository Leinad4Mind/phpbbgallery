<?php
/**
*
* phpBB Ajax likeBB.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\likedd\event;

use phpbb\auth\auth;
use phpbb\config\config;
use phpbb\db\driver\driver_interface;
use phpbb\user;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\controller\helper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.permissions'					=> 'add_permissions',
			'core.user_setup'					=> 'add_page_header_link',
			'core.viewtopic_modify_page_title'	=> 'assign_buttons',
			'core.viewtopic_modify_post_row'	=> 'viewtopic_handle_posts',
			'core.delete_posts_after'			=> 'delete_like_dislike',
			'core.memberlist_view_profile'		=> 'modify_profile',
			'core.bbfront_before_display'		=> 'viewtopic_handle_posts',
		);
	}

	/* @var \phpbb\config\config*/
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\request */
	protected $request;

	/* @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\controller\helper */
	protected $helper;

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var string The database table the likes are stored in */
	protected $likes_table;

	public function __construct(auth $auth, config $config, driver_interface $db, user $user, request $request, template $template, helper $helper, $likes_table)
	{
		$this->auth = $auth;
		$this->config = $config;
		$this->db = $db;
		$this->user = $user;
		$this->request = $request;
		$this->template = $template;
		$this->helper = $helper;
		$this->likes_table = $likes_table;
	}

	public function add_permissions($event)
	{
		$permissions = $event['permissions'];
		$permissions['u_likebb_like'] = array('lang' => 'ACL_U_LIKEBB_LIKE', 'cat' => 'post');
		$permissions['u_likebb_dislike'] = array('lang' => 'ACL_U_LIKEBB_DISLIKE', 'cat' => 'post');
		$event['permissions'] = $permissions;
	}

	public function add_page_header_link($event)
	{
		$this->user->add_lang_ext('sitesplat/likedd', 'likedd');
		
		$this->template->assign_vars(array(
			'U_LIKE_PAGE'		=> $this->helper->route('sitesplat_likedd_controller', array('route' => 'toplist.html'))
		));
	}
	
	public function assign_buttons()
	{
		$this->template->assign_vars(array(
			'LIKE_CLASS'		=> (isset($this->config['like_style'])) ? $this->config['like_style'] : 'btn-default',
			'DISLIKE_CLASS'		=> (isset($this->config['dislike_style'])) ? $this->config['dislike_style'] : 'btn-default',
			'LIKE_ICON'			=> (isset($this->config['like_icon'])) ? $this->config['like_icon'] : 'fa-thumbs-up',
			'DISLIKE_ICON'		=> (isset($this->config['dislike_icon'])) ? $this->config['dislike_icon'] : 'fa-thumbs-down',
		));
	}
	
	public function viewtopic_handle_posts($event)
	{
		if (($this->config['like_locked'] || $event['topic_data']['topic_status'] != ITEM_LOCKED) &&
			($this->config['like_global'] || $event['topic_data']['topic_type'] != POST_GLOBAL))
		{
				$this->user->add_lang_ext('sitesplat/likedd', 'likedd');
				$post_row = $event['post_row'];
				$post_row['U_LIKE'] = ($this->auth->acl_get('u_likebb_like')) ? append_sid($this->helper->route('sitesplat_likedd_controller', array('route' => 'index.html')) . '?l=' . $post_row['POST_ID']) : false;
				$post_row['U_DISLIKE'] = (!$this->config['dislike_off'] && $this->auth->acl_get('u_likebb_dislike')) ? append_sid($this->helper->route('sitesplat_likedd_controller', array('route' => 'index.html')) . '?d=' . $post_row['POST_ID']) : '';
		
				$sql = 'SELECT post_id, 
						GROUP_CONCAT(case when l.ld = 0 then CONCAT("<a href=\"memberlist.php?mode=viewprofile&u=", l.user_id, "\">", u.username, "</a>") else NULL end, ", ") AS names_likes,
						COUNT(case when l.ld = 0 then 1 else null end) AS num_likes, COUNT(case when l.ld = 1 then 1 else null end) AS num_dislikes, 
						(SELECT u.username FROM ' . $this->likes_table . ' l 
						LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = l.user_id
						WHERE l.post_id = ' . $post_row['POST_ID'] . ' AND l.ld = 0 ORDER BY l.like_time DESC LIMIT 1) AS lastliker
						FROM ' . $this->likes_table . ' l
						LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = l.user_id
						WHERE l.post_id = ' . $post_row['POST_ID'];
				$result = $this->db->sql_query($sql);
				$row = $this->db->sql_fetchrow($result);
			
				$post_row['LIKES'] = $row['num_likes'];
				$post_row['DISLIKES'] = $row['num_dislikes'];
				$post_row['LAST_LIKER']	= $row['lastliker'];
				$post_row['NAMES_LIKES'] = ($this->config['like_list']) ? $this->truncateByOccurence(rtrim(str_replace(', ,', ', ', $row['names_likes']),', '), ', ', 3) : '';
				$post_row['NUMNAMES_LIKES'] = $row['num_likes'] - sizeof(explode(', ', $this->truncateByOccurence(rtrim(str_replace(', ,', ', ', $row['names_likes']),', '), ', ', 3)));
				$post_row['MESSAGE'] = ($this->config['max_dislikes'] && $row['num_dislikes'] > $this->config['max_dislikes']) ? 
										'<div class="disliked-post-msg">' . sprintf($this->user->lang['TO_MANY_DISLIKES'], $row['post_id']) . '</div>
										<div class="dkd-wrapper-' . $row['post_id'] . ' collapse">' . $post_row['MESSAGE'] . '</div>' : $post_row['MESSAGE'];
						
				$event['post_row'] = $post_row;
		}
	}

	public function delete_like_dislike($event)
	{
		$post_ids = $event['post_ids'];
		$sql = 'DELETE FROM ' . $this->likes_table . ' WHERE post_id IN (' . implode(',', $post_ids) . ')';
		$this->db->sql_query($sql);
	}

	public function modify_profile($event)
	{
		$userid = $event['member']['user_id'];
		$sql = 'SELECT
				COUNT(CASE WHEN l.user_id = ' . $userid . ' AND l.ld = 0 THEN l.user_id END) AS lgiv,
				COUNT(CASE WHEN p.poster_id = ' . $userid . ' AND l.ld = 0 THEN p.poster_id END) AS lrec, 
				COUNT(CASE WHEN l.user_id = ' . $userid . ' AND l.ld = 1 THEN l.user_id END) AS dgiv,
				COUNT(CASE WHEN p.poster_id = ' . $userid . ' AND l.ld = 1 THEN p.poster_id END) AS drec,
				COUNT(CASE WHEN l.ld = 0 THEN l.user_id END) AS lgivtot,
				COUNT(CASE WHEN l.ld = 1 THEN l.user_id END) AS lrectot
				FROM ' . $this->likes_table . ' l
				LEFT JOIN ' . POSTS_TABLE . ' p ON p.post_id = l.post_id'; 
		$result = $this->db->sql_query($sql);
		$likes = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		$i = 0;
		foreach($likes as $key => $value)
		{
			if (++$i <= (($this->config['dislike_off']) ? 2 : 4))
			{
				$percentvalue = (substr($key, 0, 1) == 'l') ? $likes['lgivtot'] : $likes['lrectot'];
				$this->template->assign_block_vars('likes', array(
					'ICON'				=> (substr($key, 0, 1) == 'l') ? $this->config['like_icon'] : $this->config['dislike_icon'],
					'GIVEN_RECIEVED'	=> ((substr($key, 0, 1) == 'l') ? ((substr($key, 1) == 'rec') ? $this->user->lang['LIKES_RECEIVED'] : $this->user->lang['LIKES_GIVEN']) :
											((substr($key, 1) == 'rec') ? $this->user->lang['DISLIKES_RECEIVED'] : $this->user->lang['DISLIKES_GIVEN'])),
					'GIVE_RECIEVE'		=> $value . ' (' . (($percentvalue) ? number_format(($value / $percentvalue) * 100, 2) :  0) .
											((substr($key, 0, 1) == 'l') ? '% ' . $this->user->lang['LIKES_ALL_LIKES'] . ')' :  '% ' . $this->user->lang['LIKES_ALL_DISLIKES'] . ')')
				));
			}
		}
	}

	protected function truncateByOccurence ($haystack, $needle, $limit)
	{
		$haystack = explode($needle, $haystack, $limit + 1);
		$haystack = array_slice($haystack, 0, $limit);
		return implode($needle, $haystack);
	}
}
