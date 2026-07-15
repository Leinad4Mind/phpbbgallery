<?php
/**
*
* BBPoints extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbpoints\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
	protected $db;
	protected $request;
	protected $template;
	protected $user;
	protected $auth;
	protected $config;
	protected $helper;
	protected $phpbb_root_path;
	protected $php_ext;
	protected $bbpoints_table;
	protected $bbpoints_helper;

	/**
	 * Constructor
	 *
	 * @access	public
	 */
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user, \phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\controller\helper $helper, $phpbb_root_path, $php_ext, $bbpoints_table, $bbpoints_helper)
	{
		$this->db = $db;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->auth = $auth;
		$this->config = $config;
		$this->helper = $helper;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
		$this->bbpoints_table = $bbpoints_table;
		$this->bbpoints_helper = $bbpoints_helper;
		$this->bbpoints_config = json_decode($this->config['bbpoints_settings'], true);
		$this->bbpoints_config['currency'] = $this->bbpoints_helper->currency(0, $this->bbpoints_config['currency']);
	}

	/**
	 * Assign functions defined in this class to event listeners in the core
	 *
	 * @return array
	 * @static
	 * @access public
	 */
	static public function getSubscribedEvents()
	{
		return array(
			// frontend
			'core.user_setup'						=> 'add_common_language',
			'core.permissions'						=> 'add_permission',
			'core.page_header_after'				=> 'page_header_after',
			'core.index_modify_page_title'			=> 'bbpoints_stats',

			'core.viewtopic_post_rowset_data'		=> 'viewtopic_post_rowset_data',
			'core.viewtopic_modify_post_row'		=> 'viewtopic_modify_post_row',
			'core.viewtopic_before_f_read_check'	=> 'payed_topic',

			'core.viewforum_get_topic_data'			=> 'viewforum_get_topic_data',
			'core.viewforum_modify_topicrow'		=> 'viewforum_modify_topicrow',
			'core.memberlist_view_profile'			=> 'memberlist_view_profile',

			'core.posting_modify_template_vars'		=> 'get_bbpoints_hiding',
			'core.posting_modify_submit_post_after'	=> 'add_points_after_posting',

			'core.login_box_redirect'				=> 'transfer_login',
			'core.user_add_after'					=> 'transfer_register',
		);
	}

	public function payed_topic($event)
	{
		if($event['topic_data']['bbpoints_payed'])
		{
			$this->user->add_lang_ext('sitesplat/bbpoints', 'bbpoints');
			$sql = 'SELECT * FROM ' . $this->bbpoints_table . ' WHERE from_id = ' . $this->user->data['user_id'] . ' AND topic_id = ' . $event['topic_id'] . ' ORDER BY timestamp DESC';
			$result = $this->db->sql_query_limit($sql, 1);
			$row = $this->db->sql_fetchrow($result);
			if ($row['bbpoints'] != $event['topic_data']['bbpoints_payed'] && $event['topic_data']['topic_poster'] != $this->user->data['user_id'] &&
				!$this->auth->acl_gets('m_', $this->request->variable('f', 0)))
			{
				if (!confirm_box(true))
				{
					$this->template->assign_vars(array('COMMENT_ENABLED' => $this->bbpoints_config['comments_enable'], 'TOPIC_POINTS' => $event['topic_data']['bbpoints_payed']));
					$amount = ($this->bbpoints_config['symbol_pos']) ? 
							'<i class="fa ' . $this->bbpoints_config['currency'][0] . '"></i> ' . number_format($event['topic_data']['bbpoints_payed'], 0) :
							number_format($event['topic_data']['bbpoints_payed'], 0) . ' <i class="fa ' . $this->bbpoints_config['currency'][0] . '"></i>';
					confirm_box(false, $this->user->lang('TRANSFER_TO_HIDDEN_TOPIC', $amount), build_hidden_fields(array(
						'userid'		=> $this->user->data['user_id'],
						'amount'		=> $event['topic_data']['bbpoints_payed'],
						'transfer_to'	=> $event['topic_data']['topic_poster'],
						'topic_id'		=> $event['topic_id'],
						'action'		=> 'transfer',
					)), '@sitesplat_bbpoints/confirm_transfer_hidden_topic.html', '');
				} else
				{
					if ($this->request->variable('transfer_to', 0) && $this->request->variable('amount', 0) > 4 && $this->request->variable('transfer_to', 0) != $this->user->data['user_id'])
					{
						$user_id = $this->user->data['user_id'];
						$sql = 'SELECT user_id, SUM(points) as total FROM (
								SELECT poster_id AS user_id, SUM(bbpoints) AS points FROM ' . POSTS_TABLE . ' WHERE post_visibility = 1 AND poster_id = ' . $user_id . ' GROUP BY poster_id
								UNION ALL
								SELECT topic_poster AS user_id, SUM(bbpoints) AS points FROM ' . TOPICS_TABLE . ' WHERE topic_poster = ' . $user_id . ' GROUP BY topic_poster
								UNION ALL
								SELECT to_id AS user_id, SUM(bbpoints) AS points FROM ' . $this->bbpoints_table . ' WHERE to_id = ' . $user_id . ' GROUP BY to_id
								UNION ALL
								SELECT from_id AS user_id, SUM(- bbpoints) AS points FROM ' . $this->bbpoints_table . ' WHERE from_id = ' . $user_id . ' GROUP BY from_id
								) t1 GROUP BY user_id';		
						$result = $this->db->sql_query($sql);
						$user_points  = $this->db->sql_fetchfield('total');
					
						if ($this->request->variable('amount', 0) <= $user_points)
						{
							$sql = 'INSERT INTO ' . $this->bbpoints_table . ' (topic_id, from_id, to_id, bbpoints, reason, timestamp) 
								VALUES(' . $this->request->variable('topic_id', 0) . ', ' . $user_id . ', ' . $this->request->variable('transfer_to', 0) . ', ' . $this->request->variable('amount', 0) . ', "' . $this->request->variable('comment', '') . '", ' . time() . ')';
		
							$this->db->sql_query($sql);
							$item_id = $this->db->sql_nextid();
		
							if ($this->bbpoints_config['transfer_notify'] && 1 == 0)
							{
								$amount = ($this->bbpoints_config['symbol_pos']) ? '<i class="fa ' . $this->bbpoints_config['currency'][0] . '"></i> ' . $this->request->variable('amount', 0) :
										   $this->request->variable('amount', 0) . ' <i class="fa ' . $this->bbpoints_config['currency'][0] . '"></i>';
								$noti_ary = array(
									'user_ids'		=> $this->request->variable('transfer_to', 0),
									'parent_id'		=> 0,
									'post_id'		=> $item_id,
									'poster_id'		=> $user_id,
									'amount'		=> $this->request->variable('amount', 0),
									'like_txt'		=> sprintf($this->user->lang('TRANSFER_NOTI'), $amount, $this->user->data['username'], $this->request->variable('comment', '')),
								);
								$this->bbpoints_helper->add_noti($noti_ary);
							}
							meta_refresh(2, append_sid($this->phpbb_root_path . 'viewtopic.' . $this->php_ext, 'f=' . $this->request->variable('f', 0) . '&amp;t=' . $this->request->variable('topic_id', 0)));
							trigger_error($this->user->lang['TRANSFER_SUCCESS'] /*. adm_back_link($this->u_action)*/, E_USER_WARNING);	
						} else
						{
							meta_refresh(2, append_sid($this->phpbb_root_path . 'viewforum.' . $this->php_ext, 'f=' . $this->request->variable('f', 0)));
							trigger_error($this->user->lang['TRANSFER_NOT_ENOUGH_POINTS']);	
						}
					} else
					{
						meta_refresh(2, append_sid($this->phpbb_root_path . 'viewforum.' . $this->php_ext, 'f=' . $this->request->variable('f', 0)));
						trigger_error($this->user->lang[(!$this->request->variable('transfer_to', 0) ? 'NO_USER_SELECTED' : 'NO_AMOUNT_SELECTED')]);	
					}
		
				}
			redirect(append_sid($this->phpbb_root_path . 'viewforum.' . $this->php_ext, 'f=' . $this->request->variable('f', 0)));
			}
		}
	}

	public function add_common_language($event)
	{
		$this->user->add_lang_ext('sitesplat/bbpoints', 'bbpoints_common');	
	}
	
	/**
	 * Add common template variables
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function page_header_after($event)
	{
		$this->user->add_lang_ext('sitesplat/bbpoints', 'bbpoints');

		$this->template->assign_vars(array(
			'U_POINTS'			=> ($this->bbpoints_config['transfer_notify']) ? $this->helper->route('sitesplat_bbpoints_main_controller') : '',
			'U_BBPOINTS'		=> append_sid($this->phpbb_root_path . 'ucp.php?i=-sitesplat-bbpoints-ucp-bbpoints_module&mode=bbpoints'),
			'BBPOINTS_SYMBOL'	=> $this->bbpoints_config['currency'][0],
			'SYMBOL_POS'		=> $this->bbpoints_config['symbol_pos'],
			'EXT_SYMBOL'		=> $this->bbpoints_helper->ext_icon(0, $this->bbpoints_config['ext_symbol']),
			'USER_POINTS'		=> $this->load_user_points($this->user->data['user_id']),
		));
	}

	/**
	 * Add rules variables
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function viewforum_get_topic_data($event)
	{
		$bbpoints = $event['forum_data'];
		if ($bbpoints['bbpoints_enabled'])
		{
			$this->template->assign_block_vars('points', array(
				'RULE'	=> sprintf($this->user->lang['EARN_PER_TOPIC'], (($bbpoints['bbpoints_per_topic']) ? $bbpoints['bbpoints_per_topic'] : 
							$this->bbpoints_config['per_topic']) . ' ' . $this->user->lang['BBPOINTS_SHORT']),
			));
			$this->template->assign_block_vars('points', array(
				'RULE'	=> sprintf($this->user->lang['EARN_PER_POST'], (($bbpoints['bbpoints_per_post']) ? $bbpoints['bbpoints_per_post'] : 
							$this->bbpoints_config['per_post']) . ' ' . $this->user->lang['BBPOINTS_SHORT']),
			));
			$this->template->assign_block_vars('points', array(
				'RULE'	=> sprintf($this->user->lang['EARN_PER_WORD'], (($bbpoints['bbpoints_per_word']) ? $bbpoints['bbpoints_per_word'] : 
							$this->bbpoints_config['per_word']) . ' ' . $this->user->lang['BBPOINTS_SHORT']),
			));
		}
	}

	public function viewforum_modify_topicrow($event)
	{
		$sql = 'SELECT bbpoints FROM ' . $this->bbpoints_table . ' 
				WHERE topic_id = ' . $event['row']['topic_id'] . ' AND from_id = '. $this->user->data['user_id'] . ' ORDER BY timestamp DESC';
		$result = $this->db->sql_query_limit($sql, 1);
		$bbpoints = $this->db->sql_fetchfield('bbpoints');
		
		$topic_row = $event['topic_row'];
		$topic_row['TOPIC_HIDDEN'] = $event['row']['bbpoints_payed'];
		$topic_row['TOPIC_PAYED'] = ($bbpoints == $event['row']['bbpoints_payed'] || $this->user->data['user_id'] == $event['row']['topic_poster']) ? false : true;
		$topic_row['TOPIC_PERSONAL'] = $this->user->data['user_id'] == $event['row']['topic_poster'] ? false : true;
		$topic_row['TOPIC_POINTS'] = $event['row']['bbpoints_payed'];
		$event['topic_row'] = $topic_row;
	}

	/**
	 * Add bbpoints variables
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function viewtopic_post_rowset_data($event)
	{
		$rowset_data = $event['rowset_data'];
		$rowset_data['bbpoints'] = number_format($event['row']['bbpoints'], 0);
		$event['rowset_data'] = $rowset_data;
	}

	/**
	* Modify the viewtopic post row
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function viewtopic_modify_post_row($event)
	{
		$topic_points = ($event['topic_data']['topic_first_post_id'] == $event['row']['post_id']) ? $event['topic_data']['bbpoints'] : 0;
		$event['post_row'] = array_merge($event['post_row'], array(
		// points value per post
		//	'BBPOINTS' => ($event['row']['post_visibility'] == 1) ? number_format($event['row']['bbpoints'] + $topic_points, 2) : 0,
        // total points		
		'USER_TOTAL_POINTS' => number_format($this->load_user_points($event['row']['user_id']), 0),
		));
	}

	/**
	 * Set template variables for the richest users
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function bbpoints_stats($event)
	{
		if ($this->bbpoints_config['bbpoints_stats'])
		{
			$sql = 'SELECT t1.user_id, SUM(points) as total, u.username, u.user_colour FROM ( 
					SELECT to_id AS user_id, SUM(bbpoints) AS points FROM ' . $this->bbpoints_table . ' GROUP BY to_id
					UNION
					SELECT from_id AS user_id, SUM(-bbpoints) AS points FROM ' . $this->bbpoints_table . ' GROUP BY from_id
					UNION
					SELECT topic_poster AS user_id, SUM(bbpoints) AS points FROM ' . TOPICS_TABLE . ' GROUP BY topic_poster
					UNION 
					SELECT poster_id AS user_id, SUM(bbpoints) AS points FROM ' . POSTS_TABLE . ' WHERE post_visibility = 1 GROUP BY poster_id) t1 
					LEFT JOIN ' . USERS_TABLE . ' u ON u.user_id = t1.user_id
					GROUP BY user_id
					ORDER BY total DESC';
			$result = $this->db->sql_query_limit($sql, 10, 0, 300);
			while ($row = $this->db->sql_fetchrow($result))
			{
				if ($row['user_id'])
				{
					$this->template->assign_block_vars('richest_users', array(
						'USERNAME'	=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
						'POINTS'	=> number_format($row['total'], 0),
					));
				}
			}
			$this->db->sql_freeresult($result);
		}
		
		if ($this->bbpoints_config['bar_stats'])
		{
			$sql = 'SELECT SUM(points) as total FROM ( 
					SELECT SUM(bbpoints) AS points FROM ' . $this->bbpoints_table . ' WHERE from_id = 0
					UNION
					SELECT SUM(bbpoints) AS points FROM ' . TOPICS_TABLE . '
					UNION 
					SELECT SUM(bbpoints) AS points FROM ' . POSTS_TABLE . ' WHERE post_visibility = 1) t1';
			$result = $this->db->sql_query($sql, 300);
			$total = $this->db->sql_fetchfield('total');

			$this->template->assign_vars(array(
				'TOTAL_POINTS' => ($total < $this->bbpoints_config['goal']) ? round($total / $this->bbpoints_config['goal'], 3) * 100 : 100,
				'BBPOINTS_GOAL'	=> ($total < $this->bbpoints_config['goal']) ? 100 - (round($total / $this->bbpoints_config['goal'], 3) * 100): 0
			));
		}
	}

	/**
	* Display points on viewing user profile
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function memberlist_view_profile($event)
	{
		$this->template->assign_vars(array(
			'USER_PROFILE_POINTS' => number_format($this->load_user_points($event['member']['user_id']), 0),
		));
	}

	public function get_bbpoints_hiding($event)
	{
		$sql = 'SELECT bbpoints_payed FROM ' . TOPICS_TABLE . ' WHERE topic_id = ' . $event['topic_id'];
		$result = $this->db->sql_query($sql);
		$bbpoints_payed = $this->db->sql_fetchfield('bbpoints_payed');
		$page_data = $event['page_data'];
		$page_data['BBPOINTS_PAYED'] = $bbpoints_payed;
		$page_data['BBPOINTS_ENABLED_HIDE'] = ($this->auth->acl_gets('f_hide_topic', $this->request->variable('f', 0)) && ($event['mode'] == 'post' || ($event['mode'] == 'edit' && $event['post_data']['topic_first_post_id'] == $event['post_id']))) ? true : false;
		$event['page_data'] = $page_data;
	}
	
	/**
	 * Add points to user after creating post
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function add_points_after_posting($event)
	{
		$sql = 'SELECT bbpoints_enabled, bbpoints_per_topic, bbpoints_per_post, bbpoints_per_word
				FROM ' . FORUMS_TABLE . '
				WHERE forum_id = ' . $event['forum_id'];
		$result = $this->db->sql_query($sql);
		$forum_data = $this->db->sql_fetchrow($result);
		
		if ($forum_data['bbpoints_enabled'])
		{
			if ($event['mode'] == 'post')
			{
				$add_points =  ($forum_data['bbpoints_per_topic']) ? $forum_data['bbpoints_per_topic'] : $this->bbpoints_config['per_topic'];
				$sql = 'UPDATE ' . TOPICS_TABLE . ' SET bbpoints = ' . $add_points . ' WHERE topic_id = ' . $event['data']['topic_id'];
				$this->db->sql_query($sql);
			}
			elseif ($event['mode'] == 'reply' || 'quote')
			{
				$add_points = ($forum_data['bbpoints_per_post']) ? $forum_data['bbpoints_per_post'] : $this->bbpoints_config['per_post'];
			}

			if ($forum_data['bbpoints_per_word'] || $this->bbpoints_config['per_word'])
			{
				$add_points = ($event['mode'] == 'post') ? ($forum_data['bbpoints_per_post']) ? $forum_data['bbpoints_per_post'] : $this->bbpoints_config['per_post'] : $add_points;
				$text = $event['data']['message'];
				$uid = $event['data']['bbcode_uid'];
				strip_bbcode($text, $uid);
				$text = preg_replace("#\[\/?[a-z0-9\*\+\-]+(?:=(?:&quot;.*&quot;|[^\]]*))?(?::[a-z])?\]#", ' ', $text);

				$words_count = str_word_count($text);
				$add_points += (($forum_data['bbpoints_per_word']) ? $forum_data['bbpoints_per_word'] : $this->bbpoints_config['per_word']) * $words_count;
			}
			$sql = 'UPDATE ' . POSTS_TABLE . ' SET bbpoints = ' . $add_points . ' WHERE post_id = ' . $event['data']['post_id'];
			$this->db->sql_query($sql);

			if ($event['mode'] == 'post' || ($event['mode'] == 'edit' && $event['post_data']['topic_first_post_id'] == $event['post_id'])) {
				if (is_numeric($this->request->variable('bbpoints_hide', 0)) && $this->request->variable('bbpoints_hide', 0) >= 0)
				{
					$sql = 'UPDATE ' . TOPICS_TABLE . ' SET bbpoints_payed = ' . $this->request->variable('bbpoints_hide', 0) . ' WHERE topic_id = ' . $event['data']['topic_id'];
					$this->db->sql_query($sql);
				}
			}
		}
	}
	
	/**
	 * Add points to user when login
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function transfer_login($event)
	{
		if ($this->bbpoints_config['per_login'])
		{
			$sql = 'INSERT INTO ' . $this->bbpoints_table . ' (from_id, to_id, bbpoints, reason, timestamp) 
					VALUES(0, ' . $this->user->data['user_id'] . ', ' . $this->bbpoints_config['per_login'] . ', "Login in our board", ' . time() . ')';
			$this->db->sql_query($sql);
		}
	}
	
	/**
	 * Pay points for download
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function pay_points($event)
	{
		$sql = 'INSERT INTO ' . $this->bbpoints_table . ' (from_id, to_id, bbpoints, reason, timestamp) 
				VALUES(' . $this->user->data['user_id'] . ', 0, ' . $event['bbpoints'] . ', "' . $event['reason'] . '", ' . time() . ')';
		$this->db->sql_query($sql);
	}

	/**
	 * Add points to user when register
	 *
	 * @param object $event The event object
	 * @return null
	 * @access public
	 */
	public function transfer_register($event)
	{
		if ($this->bbpoints_config['per_register'])
		{
			$userid = $event['user_id'];
			$sql = 'INSERT INTO ' . $this->bbpoints_table . ' (from_id, to_id, bbpoints, reason, timestamp) 
					VALUES(0, ' . $userid . ', ' . $this->bbpoints_config['per_register'] . ', "You registered at our board", ' . time() . ')';
			$this->db->sql_query($sql);
		}
	}

	/*
	 * Load user points
	 *
	 * @param	int			$user_id	The user ID
	 * @return	int			Number of user points
	 * @access	protected
	 */
	public function load_user_points($user_id)
	{
		$sql = 'SELECT user_id, SUM(points) as total FROM (
				SELECT poster_id AS user_id, SUM(bbpoints) AS points FROM ' . POSTS_TABLE . ' WHERE post_visibility = 1 AND poster_id = ' . $user_id . ' GROUP BY poster_id
				UNION ALL
				SELECT topic_poster AS user_id, SUM(bbpoints) AS points FROM ' . TOPICS_TABLE . ' WHERE topic_poster = ' . $user_id . ' GROUP BY topic_poster
				UNION ALL
				SELECT to_id AS user_id, SUM(bbpoints) AS points FROM ' . $this->bbpoints_table . ' WHERE to_id = ' . $user_id . ' GROUP BY to_id
				UNION ALL
				SELECT from_id AS user_id, SUM(- bbpoints) AS points FROM ' . $this->bbpoints_table . ' WHERE from_id = ' . $user_id . ' GROUP BY from_id
				) t1 GROUP BY user_id';
		$result = $this->db->sql_query($sql);
		$user_points  = $this->db->sql_fetchfield('total');
		$this->db->sql_freeresult($result);

		return $user_points;
	}

	/**
	* Add permissions to page
	* @access public
	*/
	public function add_permission($event)
	{
		$permissions = $event['permissions'];
		$permissions['f_hide_topic'] = array('lang' => 'ACL_F_HIDE_TOPIC', 'cat' => 'post');
		$permissions['u_bbpoints_override'] = array('lang' => 'ACL_U_BBPOINTS_OVERRIDE', 'cat' => 'misc');
		$event['permissions'] = $permissions;
	}
}
