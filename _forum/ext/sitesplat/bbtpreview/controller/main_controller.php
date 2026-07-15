<?php
/**
*
* BBtpreview
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbtpreview\controller;

/**
* Main controller
*/
class main_controller
{
	protected $config;
	protected $user;
	protected $request;
	protected $auth;
	protected $db;
	protected $dispatcher;
	protected $php_ext;

	public function __construct(\phpbb\config\config $config, \phpbb\user $user, \phpbb\request\request $request, \phpbb\auth\auth $auth, \phpbb\db\driver\driver_interface $db, \phpbb\event\dispatcher_interface $dispatcher, $php_ext)
	{
		$this->config = $config;
		$this->user = $user;
		$this->request = $request;
		$this->auth = $auth;
		$this->db = $db;
		$this->dispatcher = $dispatcher;
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
		
		switch($route)
		{
			case 'topic':
				if (!$this->request->is_ajax())
				{
					exit();
				}
				
				$topic_id = $this->request->variable('t', 0);

				// Update topic view and if necessary attachment view counters ... but only for humans and if this is the first 'page view'
				if (isset($this->user->data['session_page']) && !$this->user->data['is_bot'] && (strpos($this->user->data['session_page'], '&t=' . $topic_id) === false || isset($this->user->data['session_created'])))
				{
					$sql = 'UPDATE ' . TOPICS_TABLE . ' SET topic_views = topic_views + 1, topic_last_view_time = ' . time() . ' WHERE topic_id = ' . $topic_id;
					$this->db->sql_query($sql);
				}

				$sql_ary = array(
					'SELECT'	=> 't.topic_poster, t.topic_first_poster_name, t.topic_first_poster_colour, t.topic_first_post_id, t.topic_time, t.topic_last_post_time,
									t.topic_views, t.topic_posts_approved, t.forum_id, p.post_subject, p.post_text, p.bbcode_bitfield, p.bbcode_uid, COUNT(a.attach_id) AS attachments,
									u.user_avatar, u.user_avatar_type, u.user_id, u.username, u.user_avatar_width, u.user_avatar_height, r.rank_title',
					'FROM'		=> array(
						TOPICS_TABLE	=> 't',
					),
					'LEFT_JOIN'		=> array(
						array(
							'FROM'	=> array(POSTS_TABLE => 'p'),
							'ON'	=> 'p.post_id = t.topic_first_post_id',
						),
						array(
							'FROM'	=> array(ATTACHMENTS_TABLE => 'a'),
							'ON'	=> 'a.topic_id = t.topic_id',
						),
						array(
							'FROM'	=> array(USERS_TABLE => 'u'),
							'ON'	=> 'u.user_id = t.topic_poster',
						),
						array(
							'FROM'	=> array(RANKS_TABLE => 'r'),
							'ON'	=> 'r.rank_id = u.user_rank',
						),
					),
					'WHERE'		=> 't.topic_id = ' . $topic_id,
				);

				/**
				* Event to modify UCP settings data before they are updated
				*
				* @event sitesplat.bbtpreview.controller_sql
				* @var array	sql_ary	Array with SQL query
				* @since 1.0.8
				*/
				$vars = array(
					'sql_ary',
				);
				extract($this->dispatcher->trigger_event('sitesplat.bbtpreview.controller_sql', compact($vars)));

				$sql = $this->db->sql_build_query('SELECT', $sql_ary);
				$result = $this->db->sql_query($sql);
				$row = $this->db->sql_fetchrow($result);
		
				if (!empty($row['topic_poster']) && $this->auth->acl_get('f_read', $row['forum_id']))
				{
					$in_bbtags = $this->request->variable('b', 0);
					$parse_flags = ($row['bbcode_bitfield'] ? OPTION_FLAG_BBCODE : 0) | OPTION_FLAG_SMILIES;

					/**
					* Event to modify UCP settings data before they are updated
					*
					* @event sitesplat.bbtpreview.controller_response_before
					* @var array	row	Array with SQL result
					* @since 1.0.8
					*/
					$vars = array(
						'row',
					);
					extract($this->dispatcher->trigger_event('sitesplat.bbtpreview.controller_response_before', compact($vars)));

					$match = array();
					$board_url = generate_board_url();
					$avatar = (($row['user_avatar']) ? preg_match( '@src="([^"]+)"@',
								  phpbb_get_user_avatar(
									  array('avatar'			=> $row['user_avatar'], 
									        'user_id'           => $row['user_id'],
											'avatar_type'		=> $row['user_avatar_type'], 
											'avatar_width'		=> $row['user_avatar_width'], 
											'avatar_height'		=> $row['user_avatar_height'])), $match) :
											$board_url . '/styles/' . $this->user->style['style_path'] . '/theme/images/no-avatar.png');
					
					$json_response = new \phpbb\json_response();
					$json_response->send(array(
						'url'			=> append_sid($board_url . '/viewtopic.php', 'f=' . $row['forum_id'] . '&amp;t=' . $topic_id),
						'subject'		=> censor_text($row['post_subject']),
						'message'		=> generate_text_for_display($row['post_text'], $row['bbcode_uid'], $row['bbcode_bitfield'], $parse_flags, true),
						'author'		=> '<a href="' . append_sid($board_url . '/memberlist.php', 'mode=viewprofile&amp;u=' . $row['topic_poster']) . '"><img class="bbtpreview_img" alt="' . $this->user->lang['USER_AVATAR'] . '" src="' .
											((sizeof($match) > 1) ? str_replace('./' . ((!$in_bbtags) ? '../../': ''), './', array_pop($match)) : $avatar) . '" /></a>',
						'author_rank'	=>  '<a style="font-weight:bold;color:#' . $row['topic_first_poster_colour'] . '" href="' . append_sid($board_url . '/memberlist.php', 'mode=viewprofile&amp;u=' . $row['topic_poster']) . '">' . $row['topic_first_poster_name'] . '</a><br />' . $row['rank_title'],
						'starttime'		=> $this->user->format_date($row['topic_time']),
						'messages'		=> $row['topic_posts_approved'],
						'views'			=> $row['topic_views'],
						'attachments'	=> $row['attachments'],
						'topictime'		=> $this->secondsToTime($row['topic_last_post_time'] - $row['topic_time'])
					));
				}
				exit();
			break;

			default:
				exit();
			break;
		}
	}

	function secondsToTime($inputSeconds)
	{
		$secondsInAMinute = 60;
		$secondsInAnHour  = 60 * $secondsInAMinute;
		$secondsInADay    = 24 * $secondsInAnHour;
	
		$days = floor($inputSeconds / $secondsInADay);
		$hourSeconds = $inputSeconds % $secondsInADay;
		$hours = floor($hourSeconds / $secondsInAnHour);
		$minuteSeconds = $hourSeconds % $secondsInAnHour;
		$minutes = floor($minuteSeconds / $secondsInAMinute);
	
		$days = ($days) ? $days . ' '. $this->user->lang['DAYS'] : '';
		$hours = ($hours) ? $hours . ' '. $this->user->lang['HOURS'] : '';
		$minutes = ($minutes) ? $minutes . ' '. $this->user->lang['MINUTES'] : '';
		return (($days) ? $days : '') . (($hours) ? ', ' . $hours : '') . (($minutes) ? ', ' . $minutes : '');
	}
}
