<?php
/**
*
* @package BBSidebar
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\sidebar\controller;

/**
* Main controller
*/
class main_controller
{
	protected $config;
	protected $helper;
	protected $template;
	protected $user;
	protected $auth;
	protected $request;
	protected $db;
	protected $pagination;
	protected $path_helper;
	protected $phpbb_dispatcher;
	protected $notification_manager;
	protected $phpbb_root_path;
	protected $php_ext;

	public function __construct(\phpbb\config\config $config, \phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\user $user, \phpbb\auth\auth $auth, \phpbb\request\request $request, \phpbb\db\driver\driver_interface $db, \phpbb\pagination $pagination, \phpbb\path_helper $path_helper, \phpbb\event\dispatcher $phpbb_dispatcher, \phpbb\notification\manager $notification_manager, $phpbb_root_path, $php_ext)
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
		$this->phpbb_dispatcher = $phpbb_dispatcher;
		$this->notification_manager = $notification_manager;
		$this->root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
	}

	/**
	* Display the page
	*
	* @param string $route The route name for a page
	* @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	* @access public
	*/
	public function handle($route)
	{
		$route = preg_replace('/\\.[^.\\s]{3,4}$/', '', $route);
//		$this->root_path = $this->path_helper->get_web_root_path();
		$this->user->add_lang_ext('sitesplat/sidebar', 'sidebar');

		switch($route)
		{
			case 'poll':
				$forum_id = $this->request->variable('f', 0);
				$topic_id = $this->request->variable('t', 0);
				$vote_id = $this->request->variable('v', 0);
				
				$sql = 'SELECT t.forum_id, topic_id, poll_start, poll_length, poll_max_options, poll_last_vote, poll_vote_change, f.forum_status, topic_status 
						FROM ' . TOPICS_TABLE . ' t
						LEFT JOIN ' . FORUMS_TABLE . ' f ON f.forum_id = t.forum_id
						WHERE t.topic_id = ' . $topic_id;
				$result = $this->db->sql_query($sql);
				$pol_info = $this->db->sql_fetchrow($result);
				if ($pol_info)
				{
					$cur_voted = array();
					if ($this->user->data['is_registered'])
					{
						$sql = 'SELECT poll_option_id FROM ' . POLL_VOTES_TABLE . ' WHERE topic_id = ' . $topic_id . ' AND vote_user_id = ' . $this->user->data['user_id'];
						$result = $this->db->sql_query($sql);
				
						while ($row = $this->db->sql_fetchrow($result))
						{
							$cur_voted[] = $row['poll_option_id'];
						}
						$this->db->sql_freeresult($result);
					} else
					{// Cookie based guest tracking ... I don't like this
						if ($this->request->is_set($this->config['cookie_name'] . '_poll_' . $topic_id, \phpbb\request\request_interface::COOKIE))
						{
							$cur_voted = explode(',', $this->request->variable($this->config['cookie_name'] . '_poll_' . $topic_id, '', true, 
										 \phpbb\request\request_interface::COOKIE));
							$cur_voted = array_map('intval', $cur_voted);
						}
					}
	
					$s_can_vote = ($this->auth->acl_get('f_vote', $forum_id) &&
						(($pol_info['poll_length'] != 0 && $pol_info['poll_start'] + $pol_info['poll_length'] > time()) || $pol_info['poll_length'] == 0) &&
						$pol_info['topic_status'] != ITEM_LOCKED &&
						$pol_info['forum_status'] != ITEM_LOCKED &&
						(!sizeof($cur_voted) ||
						($this->auth->acl_get('f_votechg', $forum_id) && $pol_info['poll_vote_change']))) ? true : false;

					// Update vote
					if ($s_can_vote && !in_array($vote_id, $cur_voted) && sizeof($cur_voted) < $pol_info['poll_max_options'])
					{
						$sql = 'UPDATE ' . POLL_OPTIONS_TABLE . ' SET poll_option_total = poll_option_total + 1
								WHERE poll_option_id = ' . (int) $vote_id . ' AND topic_id = ' . (int) $topic_id;
						$this->db->sql_query($sql);

						if ($this->user->data['is_registered'])
						{
							$sql_ary = array(
								'topic_id'			=> (int) $topic_id,
								'poll_option_id'	=> (int) $vote_id,
								'vote_user_id'		=> (int) $this->user->data['user_id'],
								'vote_user_ip'		=> (string) $this->user->ip,
							);
			
							$sql = 'INSERT INTO ' . POLL_VOTES_TABLE . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
							$this->db->sql_query($sql);

							$sql = 'UPDATE ' . TOPICS_TABLE . ' SET poll_last_vote = ' . time() . ' WHERE topic_id = ' . (int) $topic_id;
							$this->db->sql_query($sql);
							$error[] = $this->user->lang('VOTE_SAVED');
						}
					} else if($s_can_vote && $this->auth->acl_get('f_votechg', $forum_id) && $pol_info['poll_vote_change'] && sizeof($cur_voted))
					{
						$sql = 'UPDATE ' . POLL_OPTIONS_TABLE . ' SET poll_option_total = poll_option_total + 1
								WHERE poll_option_id = ' . (int) $vote_id . ' AND topic_id = ' . (int) $topic_id;
						$this->db->sql_query($sql);
						
						$sql = 'UPDATE ' . POLL_OPTIONS_TABLE . ' SET poll_option_total = CASE WHEN poll_option_total > 0 THEN poll_option_total - 1 ELSE 0 END
								WHERE poll_option_id = ' . (int) $cur_voted[0] . ' AND topic_id = ' . (int) $topic_id;
						$this->db->sql_query($sql);
						
						$sql = 'UPDATE ' . POLL_VOTES_TABLE . ' SET poll_option_id = ' . $vote_id . '
								WHERE poll_option_id = ' . (int) $cur_voted[0] . ' AND topic_id = ' . (int) $topic_id . ' AND vote_user_id = ' . $this->user->data['user_id'];
						$this->db->sql_query($sql);

						$sql = 'UPDATE ' . TOPICS_TABLE . ' SET poll_last_vote = '. time() . ' WHERE topic_id = ' . (int) $topic_id;
						$this->db->sql_query($sql);
						$error[] = $this->user->lang('VOTE_CHANGED');
					} else
					{
						$error[] =  $this->user->lang('VOTE_NOT_POSIIBLE');
					}

					$data = array(
						'info'		=> $this->user->lang('INFOMSG'),
						'txt'		=> implode('<br />', $error)
					);

					// Voted
					$poll_sql = 'SELECT poll_option_id, poll_option_text, poll_option_total FROM ' . POLL_OPTIONS_TABLE . '
								WHERE topic_id = ' . $pol_info['topic_id'] . ' ORDER BY poll_option_id';
					$poll_result = $this->db->sql_query($poll_sql);
					$poll_total_votes = 0;
					$poll_data = array();
					while($polls_data = $this->db->sql_fetchrow($poll_result))
					{
						$poll_data[] = $polls_data;
						$poll_total_votes += ($polls_data['poll_option_total'] > 0) ? $polls_data['poll_option_total'] : 1;
					}
					$this->db->sql_freeresult($poll_result);
		
					foreach($poll_data as $pd)
					{
						$option_pct = (($pd['poll_option_total'] > 0) ? $pd['poll_option_total'] : 1) / $poll_total_votes;
						$data['data'][] = array('name'	=> $pd['poll_option_text'], 'y' => round($option_pct * 100), 'f' => $pol_info['forum_id'], 't' => $pol_info['topic_id'],
									'v'	=> $pd['poll_option_id']);	
					}
					$json_response = new \phpbb\json_response();
					$json_response->send($data);
				} else
				{
					$error[] = $this->user->lang('NOT_FOUND');
					$data = array(
						'info'		=> $this->user->lang('INFOMSG'),
						'txt'		=> implode('<br />', $error)
					);
					$json_response = new \phpbb\json_response();
					$json_response->send($data);
				}
				exit();
			break;
			
			default:
				exit();
			break;
		}
	}
}
