<?php
/**
*
* BBreaction
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbreaction\controller;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
* Main controller
*/
class main_controller
{
	/* @var \phpbb\config\config*/
	protected $config;

	/** @var \phpbb\controller\helper */
	protected $helper;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @param \phpbb\auth\auth */
	protected  $auth;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\pagination */
	protected $pagination;

	/** @var \phpbb\path_helper	*/
	protected $path_helper;

	protected $phpbb_dispatcher;
	
	/** @var \phpbb\notification\manager */
	protected $notification_manager;

	protected $container;
	/** @var string */
	protected $phpbb_root_path;
	protected $php_ext;
	protected $reward_table;
	protected $reward_type_table;

	public function __construct(\phpbb\config\config $config, \phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\user $user, \phpbb\auth\auth $auth, \phpbb\request\request $request, \phpbb\db\driver\driver_interface $db, \phpbb\pagination $pagination, \phpbb\path_helper $path_helper, ContainerInterface $container, \phpbb\event\dispatcher $phpbb_dispatcher, \phpbb\notification\manager $notification_manager, \phpbb\extension\manager $ext_manager, $phpbb_root_path, $php_ext, $reward_table, $reward_type_table)
	{
		$this->config = $config;
		$this->helper = $helper;
		$this->template = $template;
		$this->user = $user;
		$this->auth = $auth;
		$this->request = $request;
		$this->db = $db;
		$this->pagination = $pagination;
		$this->path_helper = $path_helper;
		$this->container = $container;
		$this->phpbb_dispatcher = $phpbb_dispatcher;
		$this->notification_manager = $notification_manager;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
		$this->reward_table = $reward_table;
		$this->reward_type_table = $reward_type_table;
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
			case 'likers':
				if (!$this->request->is_ajax())
				{
					exit();
				}
				include($this->phpbb_root_path . 'includes/functions_user.' . $this->php_ext);
				$sql = 'SELECT COUNT(like_id) AS total FROM ' . $this->reward_table . '	WHERE post_id = ' . $this->request->variable('p', 0);
				$result = $this->db->sql_query($sql);
				$total_likes = $this->db->sql_fetchfield('total');
				
				$per_page = 12;
				$start = $this->request->variable('start', 0);
				$start = $this->pagination->validate_start($start, $per_page, $total_likes);
				$base_url = append_sid('app.' . $this->php_ext . '/bbreaction/likers.html?p=' . $this->request->variable('p', 0));

				$sql = 'SELECT l.user_id, u.username, u.user_colour, u.user_avatar, user_avatar_type, user_avatar_width, user_avatar_height, t.symbol, t.*, l.like_time FROM ' . $this->reward_table . ' l 
						LEFT JOIN ' . $this->reward_type_table . ' t ON t.type_id = l.like_type
						LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = l.user_id
						WHERE l.post_id = ' . $this->request->variable('p', 0) . ' ORDER BY l.like_time DESC';	
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


					$classlist = 'fa ' . $row['symbol'];
					$contents = '';
					/**
					* Event to modify class list and contents of reward
					*
					* @event sitesplat.bbreaction.main_controller_display
					* @var	array	row			Row data
					* @var	string	classlist	Reward class list
					* @var	string	contents	Reward contents
					* @since 1.3.0
					*/
					$vars = array(
						'row',
						'classlist',
						'contents',
					);
					extract($this->phpbb_dispatcher->trigger_event('sitesplat.bbreaction.main_controller_display', compact($vars)));


					echo '<div class="avatar-likers" style="float:left;width:33.333%;">
						  <img alt="' . $this->user->lang['USER_AVATAR'] . '" src="' . 
		/*				  ((!phpbb_validate_email($row['user_avatar']) ? '//secure.gravatar.com/avatar/' . md5(strtolower(trim($row['user_avatar']))) . '?d=identicon&amp;s=70':
						  (($row['user_avatar']) ? ((strpos($row['user_avatar'], 'http') === false) ? generate_board_url() . '/download/file.php?avatar=' . $row['user_avatar'] : $row['user_avatar']) : generate_board_url() . '/styles/prosilver/theme/images/no_avatar.gif'))) */
						  
						  ((sizeof($match) > 1) ? str_replace('./../../', './', array_pop($match)) : $avatar)
						  
						  . ' " style="float:left;width:70px;">
						  <div class="likers-time-stamp" style="text-align:center;padding-left:5px;">
						  <a href="'. generate_board_url() . '/memberlist.php?mode=viewprofile&amp;u=' . $row['user_id'] . '"' . (($row['user_colour']) ?  ' style="font-weight:bold;color:#'.$row['user_colour'] . ';"' : '') .'>' . $row['username'] . '</a>
						  <br /><i class="' . $classlist . '" style="font-size:18px;color:' . (($row['positive']) ? 'green': 'red') . ';" title="' . $row['title'] . '">' . $contents . '</i><br />' . $this->user->format_date($row['like_time'], 'Y-m-d') . '</div></div>';
				}
				echo '<br style="clear:both;"><div class="pagination-likes pull-right"><ul class="pagination pagination-sm">';
				echo $this->generate_pagination($base_url, $total_likes, $per_page, $start, true);
				echo '</ul></div>
				<script>
				$( document ).ready(function() {
					$( "#bbreaction-profile-data .pull-right .pagination-sm > li a" ).addClass( "ReactionPagination" );
				});
				</script>'; 
				exit();
			break;
			
			case 'toplist':
				if (!$this->auth->acl_get('u_bbreaction_module'))
				{
					trigger_error($this->user->lang['NOT_AUTHORISED'], E_USER_NOTICE);
				}
				$type = $this->request->variable('t', 0);
				
				$visibility = $this->container->get('content.visibility');
				$forum_ary = array();
				$forum_read_ary = $this->auth->acl_getf('f_read');
		
				foreach ($forum_read_ary as $forum_id => $allowed)
				{
					if ($allowed['f_read'])
					{
						$forum_ary[] = (int) $forum_id;
					}
				}
				$forum_ary = array_unique($forum_ary);

				$sql = 'SELECT COUNT(case when t.positive = 1 then 0 else null end) AS num_likes, COUNT(case when t.positive = 0 then 0 else null end) AS num_dislikes,				
						' . (($type == 1) ? 'p.topic_id,  p.forum_id, o.topic_title' : 
						(($type == 2) ? 'p.topic_id, p.post_id, p.forum_id, p.post_subject' : 
						(($type == 3) ? 'l.user_id, p.username': 'p.forum_id, f.forum_name'))) . ' AS catname
						FROM ' . $this->reward_table . ' l 
						LEFT JOIN '. $this->reward_type_table . ' t ON t.type_id = l.like_type
						LEFT JOIN ' . (($type == 3) ? USERS_TABLE . ' p ON p.user_id = l.user_id' : POSTS_TABLE . ' p ON p.post_id = l.post_id') . '
						
						' . (($type == 1) ? 'LEFT JOIN ' . TOPICS_TABLE . ' o ON o.topic_id = p.topic_id' : 
						(($type == 2) ? '' : 
						(($type == 3) ? '' : 'LEFT JOIN ' . FORUMS_TABLE . ' f ON f.forum_id = p.forum_id'))) .
						(($type == 3) ? '' : ' WHERE ' . str_replace('forum_id', 'p.forum_id', $visibility->get_forums_visibility_sql('post', $forum_ary))) . '
						GROUP BY ' . (($type == 1) ? 'o.topic_id' : 
						(($type == 2) ? 'p.post_id' : 
						(($type == 3) ? 'l.user_id' : 'p.forum_id'))) . '
						ORDER BY num_likes DESC';
				
				$result = $this->db->sql_query_limit($sql, $this->request->variable('numresults', 10), 0);
				$likes['name'] = $this->user->lang['REACTIONS_POSITIVE'];
				$dislikes['name'] = $this->user->lang['REACTIONS_NEGATIVE'];
				$categories['data'] = $likes['data'] = $dislikes['data'] = array();
				while($row = $this->db->sql_fetchrow($result)) 
				{
					$url = (($type == 1) ? $this->root_path . 'viewtopic.' . $this->php_ext . '?f=' . $row['forum_id'] . '&t=' . $row['topic_id'] : 
							(($type == 2) ? $this->root_path . 'viewtopic.' . $this->php_ext . '?f=' . $row['forum_id'] . '&t=' . $row['topic_id'] . '&p='. $row['post_id'] : 
							(($type == 3) ? $this->root_path . 'memberlist.' . $this->php_ext . '?mode=viewprofile&u=' . $row['user_id'] : $this->root_path . 'viewforum.php?f=' . $row['forum_id'])));
					
					$likes['data'][] = array('y' => $row['num_likes'], 'url' => $url);
					$dislikes['data'][] = array('y' => $row['num_dislikes'], 'url' => $url);
					
					$categories['data'][] = htmlspecialchars_decode($row['catname']);
				}
				
				$likes_dislikes = '[' . str_replace(array('"name"', '"data"', '"y"', '"url"'), array('name', 'data', 'y', 'url'), json_encode($likes, JSON_NUMERIC_CHECK)) . 
								  ', ' . str_replace(array('"name"', '"data"', '"y"', '"url"'), array('name', 'data', 'y', 'url'), json_encode($dislikes, JSON_NUMERIC_CHECK)) . ']';

				$title_type = array(
					$this->user->lang['REACTIONS_FORUM_OVERVIEW'],
					$this->user->lang['REACTIONS_TOPIC_OVERVIEW'],
					$this->user->lang['REACTIONS_POSTS_OVERVIEW'],
					$this->user->lang['REACTIONS_USER_OVERVIEW']
				);
				$title['title'][] = $title_type[$type];
				$title['descr'][] = $this->user->lang['BBREACTION_TOP_LIST'] . ': ';

				if ($this->request->variable('table', false))
				{
					$series = array();
					array_push($series, $likes, $dislikes);
					$graph_data = substr(str_replace("data", "categories", json_encode($categories, JSON_NUMERIC_CHECK)), 0, -1) . 
								  ',"series":[' . json_encode($series, JSON_NUMERIC_CHECK) . ']' .
								  ',"title":[' . json_encode($title, JSON_NUMERIC_CHECK). ']}';
					echo $graph_data;
					exit();
				} else
				{
					$this->template->assign_vars(array(
						'STATS'			=>  $likes_dislikes,
						'DATES' 		=> '["' . implode('","', $categories['data']) . '"]',
						'HITSTITLE'		=> '\'' . $this->user->lang['POSTS'] . '\'',
						'LABELENABLE'	=> 'true',
						'BTNEN'			=> 'true',
					));
				}

				return $this->helper->render('toplist_body.html', $this->user->lang['BBREACTION']);
			break;

			case 'index':
				$this->user->add_lang_ext('sitesplat/bbreaction', 'bbreaction');

				$sql_ary = array(
					'post_id'	=> ($this->request->is_set_post('p')) ? $this->request->variable('p', 0) : 0,
					'user_id'	=> $this->user->data['user_id'],
					'like_type'	=> ($this->request->is_set_post('e')) ? $this->request->variable('e', 0) : 0,
					'like_time'	=> time()
				);
				
				$sql = 'SELECT l.like_id, l.like_type, p.poster_id, l.like_time, p.forum_id FROM ' . POSTS_TABLE . ' p 
						LEFT JOIN ' . $this->reward_table . ' l ON l.post_id = p.post_id AND l.user_id = ' . $this->user->data['user_id'] . 
						(($this->config['rewards_multivote']) ? ' AND like_type = ' . $sql_ary['like_type'] : '') . '
						WHERE p.post_id  = ' . $sql_ary['post_id'];
				$result = $this->db->sql_query($sql);
				$row = $this->db->sql_fetchrow($result);

				$error = array();
				if ($row)
				{
					if ($row['poster_id'] == $this->user->data['user_id']) $error[] = $this->user->lang['BBREACTION_OWN_POST_ERROR'];
					if (!$this->auth->acl_getf_global('m_') && !$this->auth->acl_getf_global('a_') && $row['like_time'] + $this->config['flood_interval'] > time()) 
					{
						$error[] = $this->user->lang['BBREACTION_TIME_ERROR'];
					}
				}

				if (!$this->user->data['is_registered'] || !$this->auth->acl_get('u_bbreaction')) 
				{
					$error[] = $this->user->lang['BBREACTION_POST_NO_AUTH'];
				}

				if (!$this->request->is_ajax())
				{
					$error[] = $this->user->lang['BBREACTION_MODE_ERROR'];
				}
					
				if (!$sql_ary['post_id']) 
				{
					$error[] = $this->user->lang['BBREACTION_POST_ERROR'];
				}

				if (!sizeof($error))
				{
					if ($row['like_id'])
					{
						$sql = 'DELETE FROM ' . $this->reward_table . ' WHERE like_id = ' . $row['like_id'];
						$this->db->sql_query($sql);

						if (!$this->config['reward_multivote'] && $sql_ary['like_type'] != $row['like_type'])
						{
							$sql = 'INSERT INTO ' . $this->reward_table . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
							$this->db->sql_query($sql);
						}

					} else
					{
						$sql = 'INSERT INTO ' . $this->reward_table . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
						$this->db->sql_query($sql);
					}

					$total_ary = array();
					$sql = 'SELECT COUNT(r.like_id) AS total FROM ' . $this->reward_table . ' r
							INNER JOIN ' . $this->reward_type_table . ' t ON t.type_id = like_type and t.active = 1
							WHERE r.post_id = ' . $sql_ary['post_id'];
					$result = $this->db->sql_query($sql);
					$total = $this->db->sql_fetchfield('total');

					$sql = 'SELECT type_id, (SELECT count(1) FROM ' . $this->reward_table . ' 
							WHERE post_id = ' . $sql_ary['post_id'] . ' AND like_type = type_id) AS num_likes 
							FROM ' . $this->reward_type_table . '
							WHERE active = 1';
					$result = $this->db->sql_query($sql);
					while ($row1 = $this->db->sql_fetchrow($result))
					{
						$total_ary['p'. $sql_ary['post_id'] . $row1['type_id']] = ($this->config['rewards_percent']) ? 
								round(($row1['num_likes'] / (($total) ? $total : 1)) * 100, 1) . ' %' :
								'# ' . (($row1['num_likes']) ? $row1['num_likes'] : 0);
					}
					
					$sql = 'SELECT notify FROM ' . $this->reward_type_table . ' WHERE type_id = ' . $sql_ary['like_type'];
					$result = $this->db->sql_query($sql);
					$notify = $this->db->sql_fetchfield('notify');
					if ($notify)
					{
						$this->notification_manager->add_notifications('sitesplat.bbreaction.notification.type.reward_added', array(
							'user_ids'		=> $row['poster_id'],
							'parent_id'		=> $sql_ary['post_id'],
							'post_id'		=> substr(time(), -5) ,
							'poster_id'		=> $sql_ary['user_id'],
							'like_txt'		=> ($row['like_id'] && !$this->config['reward_multivote'] && $sql_ary['like_type'] == $row['like_type']) ? 
												$this->user->lang('BBREACTION_REMOVED') : $this->user->lang('BBREACTION_ADDED'),
						));
					}

					$return = array(
						'info'		=> $this->user->lang('INFOMSG'),
						'txt'		=> ($row['like_id'] && !$this->config['reward_multivote'] && $sql_ary['like_type'] == $row['like_type']) ? 
										$this->user->lang('BBREACTION_REMOVED') : $this->user->lang('BBREACTION_ADDED'),
						'likes'		=> json_encode($total_ary)
					);
				} else
				{
					$return = array(
						'info'		=> $this->user->lang('INFOMSG'),
						'txt'		=> implode('<br />', $error)
					);
				}

				echo json_encode($return);
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
	
			$page_string .= ($end_cnt < $total_pages) ? '<span class="page-dots"> ... </span>' : $seperator;
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
