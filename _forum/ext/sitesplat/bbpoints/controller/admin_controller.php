<?php
/**
*
* BBPoints extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbpoints\controller;

/**
* Main controller
*/
class admin_controller
{
	protected $db;
	protected $request;
	protected $template;
	protected $user;
	protected $config;
	protected $root_path;
	protected $php_ext;
	protected $bbpoints_table;
	protected $bbpoints_helper;

	/**
	* Constructor
	*
	* @access public
	*/
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user, \phpbb\config\config $config, $root_path, $php_ext, $bbpoints_table, $bbpoints_helper)
	{
		$this->db = $db;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->config = $config;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		$this->bbpoints_table = $bbpoints_table;
		$this->bbpoints_helper = $bbpoints_helper;
		$this->bbpoints_config = json_decode($this->config['bbpoints_settings'], true);
	}

	/**
	* Display the page
	*
	* @access public
	*/
	public function display()
	{
		foreach($this->bbpoints_config as $key => $value)
		{
			$this->template->assign_vars(array(
				strtoupper($key)	=> $value
			));
		}
		
		$this->template->assign_vars(array(
			'U_ACTION'			=> $this->u_action,
			'U_SMILIES'			=> append_sid($this->root_path . 'posting.' . $this->php_ext, 'mode=smilies'),				
			'GROUP_OPTIONS'		=> group_select_options(false, array(6)),
			'CURRENCY'			=> $this->bbpoints_helper->currency($this->bbpoints_config['currency']),
			'EXT_SYMBOL'		=> $this->bbpoints_helper->ext_icon($this->bbpoints_config['ext_symbol']),
			'UA_PROGRESS_BAR'	=> html_entity_decode($this->u_action . '&amp;action=progressbar&time=' . time()),
			'BOARD_URL'			=> generate_board_url() . '/'
		));
	}

	/**
	 * {@inheritdoc}
	 */
	public function submit_config_options()
	{
		$this->config->set('bbpoints_settings', json_encode(array(
			'ext_symbol'			=> $this->request->variable('ext_symbol', ''),
			'symbol_pos' 			=> $this->request->variable('symbol_pos', 0),
			'currency' 				=> $this->request->variable('currency', ''),
			'per_topic'				=> $this->request->variable('per_topic', 0),
			'per_post'				=> $this->request->variable('per_post', 0),
			'per_word'				=> $this->request->variable('per_word', 0),
			'transfer_notify'		=> $this->request->variable('transfer_notify', 0),
			'comments_enable'		=> $this->request->variable('comments_enable', 0),
			'bar_stats'				=> $this->request->variable('bar_stats', 0),
			'bbpoints_stats'		=> $this->request->variable('bbpoints_stats', 0),
			'goal'					=> abs($this->request->variable('goal', 0)),
			'per_login'				=> $this->request->variable('per_login', 0),
			'per_register'			=> $this->request->variable('per_register', 0),
			'per_birthday'			=> $this->request->variable('per_birthday', 0),
		)));
		$this->show_result('Settings saved');
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function sync_points()
	{
/*		$sql = 'UPDATE ' . TOPICS_TABLE . ' SET bbpoints = 0';
		$this->db->sql_query($sql);
		$sql = 'UPDATE ' . POSTS_TABLE . ' SET bbpoints = 0';
		$this->db->sql_query($sql);

*/		$sql = 'SELECT forum_id, bbpoints_per_topic, bbpoints_per_post, bbpoints_per_word FROM ' . FORUMS_TABLE . ' WHERE bbpoints_enabled = 1';
		$result = $this->db->sql_query($sql);
		$forum_ary = $points_ary = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$forum_ary[$row['forum_id']] = array(
				 'bbpoints_per_topic'	=> ($row['bbpoints_per_topic']) ? $row['bbpoints_per_topic'] : $this->bbpoints_config['per_topic'],
				 'bbpoints_per_post'	=> ($row['bbpoints_per_post']) ? $row['bbpoints_per_post'] : $this->bbpoints_config['per_post'],
				 'bbpoints_per_word'	=> ($row['bbpoints_per_word']) ? $row['bbpoints_per_word'] : $this->bbpoints_config['per_word']
			);
		}
		foreach($forum_ary as $forumid => $topicpoints)
		{
			$points_ary[$topicpoints['bbpoints_per_topic']][] = $forumid;	
		}

		foreach($points_ary as $points => $forumid)
		{
			$sql = 'UPDATE ' . TOPICS_TABLE . ' SET bbpoints =  ' . $points	. ' WHERE forum_id IN (' . implode(',', $forumid) . ')';
			$this->db->sql_query($sql);
		}
		unset($points_ary);

		foreach($forum_ary as $forumid => $postpoints)
		{
			$points_ary[$postpoints['bbpoints_per_post']][] = $forumid;	
		}

		foreach($points_ary as $points => $forumid)
		{
			$sql = 'UPDATE ' . POSTS_TABLE . ' SET bbpoints =  ' . $points	. ' WHERE forum_id IN (' . implode(',', $forumid) . ')';
			$this->db->sql_query($sql);
		}
		unset($points_ary);
	}

	public function sync_post()
	{
		$sql = 'SELECT forum_id, bbpoints_per_topic, bbpoints_per_post, bbpoints_per_word FROM ' . FORUMS_TABLE . ' WHERE bbpoints_enabled = 1';
		$result = $this->db->sql_query($sql);
		$forum_ary = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$forum_ary[$row['forum_id']] = array(
				 'bbpoints_per_topic'	=> ($row['bbpoints_per_topic']) ? $row['bbpoints_per_topic'] : $this->bbpoints_config['per_topic'],
				 'bbpoints_per_post'	=> ($row['bbpoints_per_post']) ? $row['bbpoints_per_post'] : $this->bbpoints_config['per_post'],
				 'bbpoints_per_word'	=> ($row['bbpoints_per_word']) ? $row['bbpoints_per_word'] : $this->bbpoints_config['per_word']
			);
		}

		$this->get_max_post_id();
		$this->batch_size = 50;

		$starttime = explode(' ', microtime());
		$starttime = $starttime[1] + $starttime[0];
		$post_counter = $this->request->variable('skiprows', 0);
		
		while (still_on_time(20) && $post_counter <= $this->total_post_ids)
		{
			$sql = 'SELECT forum_id, post_id, post_text, bbcode_uid FROM ' . POSTS_TABLE . ' ORDER BY post_id ASC';
			$result = $this->db->sql_query_limit($sql, $this->batch_size, $post_counter);

			while ($row = $this->db->sql_fetchrow($result))
			{
				strip_bbcode($row['post_text'], $row['bbcode_uid']);
				$row['post_text'] = preg_replace("#\[\/?[a-z0-9\*\+\-]+(?:=(?:&quot;.*&quot;|[^\]]*))?(?::[a-z])?\]#", ' ', $row['post_text']);
				$bbpoints = str_word_count($row['post_text']) * $forum_ary[$row['forum_id']]['bbpoints_per_word'];
				$sql1 = 'UPDATE ' . POSTS_TABLE . ' SET bbpoints =  bbpoints + ' . $bbpoints	. ' WHERE post_id = ' . $row['post_id'];
				$this->db->sql_query($sql1);
				$post_counter++;
			}
		}

		if ($post_counter <= $this->total_post_ids)
		{
			$return = array(
				'postcounter'	=> $post_counter,
				'url'			=> ($post_counter < $this->total_post_ids) ? 
									html_entity_decode($this->u_action . '&action=progressbar&skiprows=' . $post_counter . '&time=' . time()) : 0,
				'percent'		=> round((($post_counter > $this->total_post_ids) ? $this->total_post_ids : $post_counter) / $this->total_post_ids, 3) * 100
			);
		} else
		{
			$return = array(
				'url'		=> 0,
				'percent'	=> 100
			);
		}
		echo json_encode($return);
		exit();
	}

	function get_max_post_id()
	{
		$sql = 'SELECT MIN(post_id) AS min_post_id, MAX(post_id) AS max_post_id, COUNT(post_id) AS total FROM '. POSTS_TABLE;
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->min_post_id = (int) $row['min_post_id'];
		$this->max_post_id = (int) $row['max_post_id'];
		$this->total_post_ids = (int) $row['total'];
		$this->db->sql_freeresult($result);
	}

	function save_state($state = false)
	{
		if ($state)
		{
			$this->state = $state;
		}

		ksort($this->state);

		set_config('search_indexing_state', implode(',', $this->state), true);
	}

	/**
	 * {@inheritdoc}
	 */
	public function reset_points()
	{
		$sql = 'UPDATE ' . TOPICS_TABLE . ' SET bbpoints = 0';
		$this->db->sql_query($sql);
		$sql = 'UPDATE ' . POSTS_TABLE . ' SET bbpoints = 0';
		$this->db->sql_query($sql);
		$sql = 'TRUNCATE ' . $this->bbpoints_table;
		$this->db->sql_query($sql);

		$this->show_result('reset points');
	}
	/**
	 * {@inheritdoc}
	 */
	public function transfer_amount()
	{
		$amount		= $this->request->variable('transfer_amount',	0);				
		$user_id	= $this->request->variable('transfer_to', 0);
		$group_id	= $this->request->variable('group_id', 0);
		$pm_subject	= $this->request->variable('pm_subject', '', true);
		$pm_text	= $this->request->variable('pm_text', '', true);

		if (!$amount)
		{
			trigger_error($this->user->lang('POINTS_GROUP_TRANSFER_NO_AMOUNT') . adm_back_link($this->u_action), E_USER_WARNING);  
		}

		$sql_array = array(
			'SELECT'	=> 'g.user_id',
			'FROM'		=> array(
				USER_GROUP_TABLE => 'g',
			),
			'LEFT_JOIN'	=> array(
				array(
					'FROM'	=> array(USERS_TABLE => 'u'),
					'ON'	=> 'u.user_id = g.user_id',
				)
			),     
			'WHERE'	=> 'g.user_pending = 0 AND u.user_type <> 2 AND g.group_id = ' . $group_id,
		);
		$sql = $this->db->sql_build_query('SELECT', $sql_array);
		$result = $this->db->sql_query($sql);

		$user_ids = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$user_ids[] = $row['user_id'];
		}
		$this->db->sql_freeresult($result);

		if ($user_id) 
		{
			$user_ids[] = $user_id;
		}
		
		if (sizeof($user_ids))
		{
			// Load the insert buffer class to perform a buffered multi insert
			$buffer = new \phpbb\db\sql_insert_buffer($this->db, $this->bbpoints_table);
			
			// Insert data
			foreach ($user_ids as $user_id)
			{
				$buffer->insert(array(
					'id'		=> null,
					'from_id'	=> 0,
					'to_id'		=> $user_id,
					'bbpoints'	=> $amount,
					'reason'	=> $pm_subject,
					'timestamp'	=> time(),
				));
			}

			// Flush the buffer
			$buffer->flush();
			
			$currency_symbol = $this->bbpoints_helper->currency(0, $this->bbpoints_config['currency']);
			$transfer_amount = ($this->bbpoints_config['symbol_pos']) ? $currency_symbol[2] . ' ' . number_format($amount, 2) :
							   number_format($amount, 2) . ' ' . $currency_symbol[2];
			if ($this->bbpoints_config['transfer_notify'])
			{
				$noti_ary = array(
					'user_ids'		=> $user_ids,
					'parent_id'		=> 0,
					'post_id'		=> substr(time(), -5) ,
					'poster_id'		=> $this->user->data['user_id'],
					'amount'		=> $amount,
					'like_txt'		=> sprintf($this->user->lang('TRANSFER_NOTI'), $transfer_amount, $this->config['sitename'] . '<br />', $pm_subject),
					'currency'		=> $currency_symbol
				);
				$this->bbpoints_helper->add_noti($noti_ary);
			}
			
			// Send PM, if pm subject and pm comment is entered
			if ($pm_subject && $pm_text)
			{
				include($this->root_path . 'includes/functions_privmsgs.' . $this->php_ext);
				include($this->root_path . 'includes/message_parser.' . $this->php_ext);

				$message_parser = new \parse_message();
				$message_parser->message = sprintf($this->user->lang('TRANSFER_NOTI'), str_replace($currency_symbol[2], $currency_symbol[1], $transfer_amount), $this->config['sitename'], '') . "\n" . $pm_text;
				$message_parser->parse(true, true, true, false, false, true, true);

				$pm_data = array(
					'from_user_id'			=> $this->user->data['user_id'],
					'from_user_ip'			=> $this->user->ip,
					'from_username'			=> $this->user->data['username'],
					'icon_id'				=> 0,
					'enable_sig'			=> true,
					'enable_bbcode'			=> true,
					'enable_smilies'		=> true,
					'enable_urls'			=> true,
					'bbcode_bitfield'		=> $message_parser->bbcode_bitfield,
					'bbcode_uid'			=> $message_parser->bbcode_uid,
					'message'				=> $message_parser->message,
				);

				foreach($user_ids as $user_id)
				{
					$pm_data['address_list'] = array('u' => array($user_id => 'to'));
					submit_pm('post', $pm_subject, $pm_data, false); 
				}
				$this->db->sql_freeresult($result);
			}

			$this->show_result($this->user->lang['POINTS_GROUP_TRANSFER_SUCCESS']);
		}
		else
		{
			trigger_error($this->user->lang('POINTS_GROUP_TRANSFER_NO_USERS') . adm_back_link($this->u_action), E_USER_WARNING);
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function show_result($message)
	{
		if ($this->request->is_ajax())
		{
			$json_response = new \phpbb\json_response;
			$json_response->send(array(
				'MESSAGE_TITLE'	=> $this->user->lang['INFORMATION'],
				'MESSAGE_TEXT'	=> $message,
				'REFRESH_DATA'	=> array(
					'time'	=> 3,
					'url'	=> $this->u_action
				)
			));
		} else
		{
			trigger_error($message . adm_back_link($this->u_action), E_USER_NOTICE);
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}
