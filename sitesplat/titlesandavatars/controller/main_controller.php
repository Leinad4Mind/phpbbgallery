<?php
/**
*
* BBAvatars
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\titlesandavatars\controller;

/**
* Main controller
*/
class main_controller
{
	/* @var \phpbb\config\config*/
	protected $config;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\pagination */
	protected $pagination;

	/** @var \phpbb\path_helper	*/
	protected $path_helper;

	/** @var string */
	protected $phpbb_root_path;
	protected $php_ext;

	public function __construct(\phpbb\config\config $config, \phpbb\user $user, \phpbb\request\request $request, \phpbb\db\driver\driver_interface $db, \phpbb\pagination $pagination, \phpbb\path_helper $path_helper, $phpbb_root_path, $php_ext)
	{
		$this->config = $config;
		$this->user = $user;
		$this->request = $request;
		$this->db = $db;
		$this->pagination = $pagination;
		$this->path_helper = $path_helper;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
	}

	/**
	* Display the page
	*
	* @param string $route The route name for a page
	* @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	* @access public
	*/
	public function display($route)
	{
		$route = preg_replace('/\\.[^.\\s]{3,4}$/', '', $route);
		$this->root_path = $this->path_helper->get_web_root_path();
		
		switch($route)
		{
			case 'avatars':
				if (!$this->config['titles_avatar_participants'])
				{
					exit();
				}
				if (!$this->request->is_ajax())
				{
					exit();
				}
				include($this->phpbb_root_path . 'includes/functions_user.' . $this->php_ext);
				$sql = 'SELECT COUNT(DISTINCT poster_id) AS total FROM ' . POSTS_TABLE . '	WHERE topic_id = ' . $this->request->variable('t', 0);
				$result = $this->db->sql_query($sql);
				$total_posters = $this->db->sql_fetchfield('total');
				
				$per_page = 12;
				$start = $this->request->variable('start', 0);
				$start = $this->pagination->validate_start($start, $per_page, $total_posters);
				$base_url = append_sid('app.' . $this->php_ext . '/titlesandavatars/avatars.html?t=' . $this->request->variable('t', 0));

				$sql = 'SELECT l.poster_id, COUNT(l.poster_id) AS posts, u.username, u.user_colour, u.user_avatar, user_avatar_type, user_id, user_avatar_width, user_avatar_height 
						FROM ' . POSTS_TABLE . ' l 
						LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = l.poster_id
						WHERE l.topic_id = ' . $this->request->variable('t', 0) . ' 
						GROUP BY l.poster_id';		
				$result = $this->db->sql_query_limit($sql, $per_page, $start);
				while($row = $this->db->sql_fetchrow($result))
				{
				  $match = array();
				  $avatar = (($row['user_avatar']) ? preg_match( '@src="([^"]+)"@',
							  phpbb_get_user_avatar(
								  array('avatar'			=> $row['user_avatar'], 
								        'user_id'           => $row['user_id'],
										'avatar_type'		=> $row['user_avatar_type'], 
										'avatar_width'		=> $row['user_avatar_width'], 
										'avatar_height'		=> $row['user_avatar_height'])), $match) :
										generate_board_url() . '/styles/' . $this->user->style['style_path'] . '/theme/images/no-avatar.png');



					echo '<div class="avatar-partecipants col-md-2 col-sm-3 col-xs-4">' .
						  (($row['posts'] > 1) ? '<span class="badge badge-danger tabadge">' . $row['posts'] . '</span>' : '') . '
						  <img alt="' . $this->user->lang['USER_AVATAR'] . '" src="' . ((sizeof($match) > 1) ? str_replace('./../../', './', array_pop($match)) : $avatar) . ' " style="float:left;width:70px;">
						  <div class="partecipants-time-stamp" style="text-align:center;padding-left:5px;">
						  <a href="'. generate_board_url() . '/memberlist.php?mode=viewprofile&amp;u=' . $row['poster_id'] . '"' . (($row['user_colour']) ?  ' style="font-weight:bold;color:#'.$row['user_colour'] . ';"' : '') .'>' . $row['username'] . '</a></div></div>';
				}
				echo '<br style="clear:both;"><div class="pagination-partecipants pull-right"><ul class="pagination pagination-sm">';
				echo $this->generate_pagination($base_url, $total_posters, $per_page, $start, true);
				echo '</ul></div>
				<script>
				$( document ).ready(function() {
					$( "#profileBBavatar .pull-right .pagination-sm > li a" ).addClass( "AvatarsPagination" );
				});
				</script>'; 
				exit();
			break;

			default:
				exit();
			break;
		}
	}

	/*
	* Pagination routine, generates page number sequence
	* tpl_prefix is for using different pagination blocks at one page
	*/
	public function generate_pagination($base_url, $num_items, $per_page, $start_item, $add_prevnext_text = false, $tpl_prefix = '')
	{
		// Make sure $per_page is a valid value
		$per_page = ($per_page <= 0) ? 1 : $per_page;
	
		$seperator = ''; //'<span class="page-sep">' . $this->user->lang['COMMA_SEPARATOR'] . '</span>';
		$total_pages = ceil($num_items / $per_page);
	
		if ($total_pages == 1 || !$num_items)
		{
			return false;
		}
	
		$on_page = floor($start_item / $per_page) + 1;
		$url_delim = (strpos($base_url, '?') === false) ? '?' : ((strpos($base_url, '?') === strlen($base_url) - 1) ? '' : '&amp;');
	
		$page_string = ($on_page == 1) ? '<li class="active"><span>1</span></li>' : '<li><a href="' . $base_url . '">1</a></li>';
	
		if ($total_pages > 5)
		{
			$start_cnt = min(max(1, $on_page - 4), $total_pages - 5);
			$end_cnt = max(min($total_pages, $on_page + 4), 6);
	
			$page_string .= ($start_cnt > 1) ? '<li class="page-dots"><a>...</a></li>' : $seperator;
	
			for ($i = $start_cnt + 1; $i < $end_cnt; $i++)
			{
				$page_string .= ($i == $on_page) ? '<li><a>' . $i . '</a></li>' : '<li><a href="' . $base_url . "{$url_delim}start=" . (($i - 1) * $per_page) . '">' . $i . '</a></li>';
				if ($i < $end_cnt - 1)
				{
					$page_string .= $seperator;
				}
			}
	
			$page_string .= ($end_cnt < $total_pages) ? '<li class="page-dots"><a>...</a></li>' : $seperator;
		}
		else
		{
			$page_string .= $seperator;
	
			for ($i = 2; $i < $total_pages; $i++)
			{
				$page_string .= ($i == $on_page) ? '<li class="active"><span>' . $i . '</span></li>' : '<li><a href="' . $base_url . "{$url_delim}start=" . (($i - 1) * $per_page) . '" role="button">' . $i . '</a></li>';
				
				if ($i < $total_pages)
				{
					$page_string .= $seperator;
				}
			}
		}
	
		$page_string .= ($on_page == $total_pages) ? '<li class="active"><span>' . $total_pages . '</span></li>' : '<li><a href="' . $base_url . "{$url_delim}start=" . (($total_pages - 1) * $per_page) . '">' . $total_pages . '</a></li>';
	
		if ($add_prevnext_text)
		{
			if ($on_page != 1)
			{
				$page_string = '<li class="previous"><a href="' . $base_url . "{$url_delim}start=" . (($on_page - 2) * $per_page) . '" rel="prev" role="button">' . $this->user->lang['PREVIOUS'] . '</a></li>&nbsp;&nbsp;' . $page_string;
			}
	
			if ($on_page != $total_pages)
			{
				$page_string .= '&nbsp;&nbsp;<li class="next"><a href="' . $base_url . "{$url_delim}start=" . ($on_page * $per_page) . '" rel="next" role="button">' . $this->user->lang['NEXT'] . '</a></li>';
			}
		}
			
		return $page_string;
	}
}
