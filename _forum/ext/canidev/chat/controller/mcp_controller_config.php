<?php
/**
 * @package cBB Chat
 * @version 1.2.7 07/03/2025
 *
 * @copyright (c) 2025 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\chat\controller;

use canidev\chat\libraries\constants;

class mcp_controller_config extends \canidev\core\controller\acp
{
	protected $db;
	protected $log;
	protected $pagination;
	protected $user;
	
	protected $phpbb_root_path;
	protected $php_ext;
	protected $tables;

	/**
	 * Constructor
	 *
	 * @param \phpbb\db\driver\driver_interface		$db					DB Object
	 * @param \phpbb\log\log						$log				Log object
	 * @param \phpbb\pagination						$pagination			Pagination object
	 * @param \phpbb\user							$user				User object
	 * @param string								$phpbb_root_path	phpBB root path
	 * @param string								$php_ext			phpEx
	 * @param array 								$tables 			Chat DB Tables
	 *
	 * @access public
	 */
	public function __construct(
		\phpbb\db\driver\driver_interface $db,
		\phpbb\log\log $log,
		\phpbb\pagination $pagination,
		\phpbb\user $user,
		$phpbb_root_path,
		$php_ext,
		$tables)
	{
		$this->db			= $db;
		$this->log			= $log;
		$this->pagination	= $pagination;
		$this->user			= $user;
	
		$this->phpbb_root_path	= $phpbb_root_path;
		$this->php_ext			= $php_ext;
		$this->tables 			= $tables;
	}
	
	/**
	 * Display the panel
	 * 
	 * @param string 	$mode 		Current mode
	 */
	public function display($mode)
	{
		// Set up general vars
		$action 	= $this->request->variable('action', '');
		$action		= ($this->request->is_set_post('bansubmit')) ? 'banusers' : $action;
		$start		= $this->request->variable('start', 0);
		$marked		= ($this->request->is_set_post('submit')) ? $this->request->variable('mark', [0]) : [$this->request->variable('id', 0)];
		
		// Sort keys
		$sort_days	= $this->request->variable('st', 0);
		$sort_key	= $this->request->variable('sk', 'u');
		$sort_dir	= $this->request->variable('sd', 'a');

		$this->page_title 	= 'MCP_CHAT_BAN';
		$this->tpl_name 	= 'mcp_chat_ban';
		
		// Sorting
		$limit_days		= [0 => $this->language->lang('ALL_ENTRIES'), 1 => $this->language->lang('1_DAY'), 7 => $this->language->lang('7_DAYS'), 14 => $this->language->lang('2_WEEKS'), 30 => $this->language->lang('1_MONTH'), 90 => $this->language->lang('3_MONTHS'), 180 => $this->language->lang('6_MONTHS'), 365 => $this->language->lang('1_YEAR')];
		$sort_by_text	= ['u' => $this->language->lang('SORT_USERNAME'), 't' => $this->language->lang('SORT_DATE'), 'i' => $this->language->lang('SORT_IP')];
		$sort_by_sql	= ['u' => 'LOWER(cu.username)', 't' => 'cu.exclude_time', 'i' => 'cu.user_ip'];

		$s_limit_days = $s_sort_key = $s_sort_dir = $u_sort_param = '';
		gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sort_dir, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);

		// Define where and sort sql for use in displaying logs
		$sql_where = ($sort_days) ? (time() - ($sort_days * 86400)) : 0;
		$sql_sort = $sort_by_sql[$sort_key] . ' ' . (($sort_dir == 'd') ? 'DESC' : 'ASC');
		
		$keywords = $this->request->variable('keywords', '', true);
		$keywords_param = !empty($keywords) ? '&amp;keywords=' . urlencode(htmlspecialchars_decode($keywords)) : '';
		
		$complete_u_action = $this->form_action . "&amp;$u_sort_param$keywords_param&amp;start=$start";
		
		// Do actions
		if($action == 'banusers')
		{
			$userlist = $this->request->variable('ban', '', true);
			$userlist = array_unique(array_map('trim', explode("\n", $userlist)));
			
			$user_keys = $usernames = [];
			
			// Get user_keys for guests
			$sql = 'SELECT user_key, username
				FROM ' . $this->tables['users'] . '
				WHERE ' . $this->db->sql_in_set('username', $userlist) . '
				AND user_id = ' . ANONYMOUS;
			$result = $this->db->sql_query($sql);
			while($row = $this->db->sql_fetchrow($result))
			{
				$user_keys[] = (int)$row['user_key'];
				$usernames[] = $row['username'];
			}
			$this->db->sql_freeresult($result);
			
			// Get user_keys for registered members
			$sql = 'SELECT user_id, username
				FROM ' . USERS_TABLE . '
				WHERE ' . $this->db->sql_in_set('username', $userlist) . '
				AND user_type <> ' . USER_IGNORE . '
				AND user_id <> ' . $this->user->data['user_id'];
			$result = $this->db->sql_query($sql);
			while($row = $this->db->sql_fetchrow($result))
			{
				$user_keys[] = (int)$row['user_id'];
				$usernames[] = $row['username'];
			}
			$this->db->sql_freeresult($result);
			
			// Do exclusion
			$this->exclude($user_keys, $usernames, $complete_u_action);
		}
		else if($action && !empty($marked) && $marked[0] != 0)
		{
			if(confirm_box(true))
			{
				switch($action)
				{
					case 'unban':
						$update_ary = [
							'cu.exclude_time'	=> 0,
							'cu.user_online'	=> 0,
						];
						
						$marked		= array_map('intval', $marked);
						$usernames	= [];
						
						$sql_where = 'cu.exclude_time > 0
							AND ' . $this->db->sql_in_set('cu.user_key', $marked);
						
						// Get usernames for log
						$sql = 'SELECT cu.username, u.username AS member_name
							FROM ' . $this->tables['users'] . ' cu
								LEFT JOIN ' . USERS_TABLE . " u ON(u.user_id = cu.user_id)
							WHERE $sql_where";
						$result = $this->db->sql_query($sql);
						while($row = $this->db->sql_fetchrow($result))
						{
							$usernames[] = ($row['username']) ? $row['username'] : $row['member_name'];
						}
						$this->db->sql_freeresult($result);
						
						// Do work
						if(sizeof($usernames))
						{
							$sql = 'UPDATE ' . $this->tables['users'] . ' cu
								SET ' . $this->db->sql_build_array('UPDATE', $update_ary) . "
								WHERE $sql_where";
							$this->db->sql_query($sql);
						
							$this->log->add('mod',
								$this->user->data['user_id'],
								$this->user->ip,
								'LOG_CHAT_EXCLUSION_REMOVED',
								time(),
								[implode(', ', $usernames)]
							);
						}
						
						trigger_error($this->language->lang('CHAT_EXCLUSIONS_DELETED') . '<br /><br /><a href="' . $complete_u_action . '">&laquo; ' . $this->language->lang('BACK_TO_PREV') . '</a>');
					break;
					
					case 'edit':
						// Get usernames for log
						$usernames = [];

						$sql = 'SELECT cu.username, u.username AS member_name
							FROM ' . $this->tables['users'] . ' cu
								LEFT JOIN ' . USERS_TABLE . ' u ON(u.user_id = cu.user_id)
							WHERE ' . $this->db->sql_in_set('cu.user_key', $marked);
						$result = $this->db->sql_query($sql);
						while($row = $this->db->sql_fetchrow($result))
						{
							$usernames[] = ($row['username']) ? $row['username'] : $row['member_name'];
						}
						$this->db->sql_freeresult($result);
	
						$this->exclude($marked, $usernames, $complete_u_action);
					break;
				}
			}
			else
			{
				if($action == 'edit')
				{
					$this->build_period_options();
					
					$this->template->assign_vars([
						'S_EDIT'			=> true,
						'IN_CHAT_MCP'		=> true,
					]);
				}
				
				confirm_box(false, $this->language->lang('CONFIRM_OPERATION'), build_hidden_fields([
					'start'		=> $start,
					'mark'		=> $marked,
					'sk'		=> $sort_key,
					'sd'		=> $sort_dir,
					'submit'	=> true,
				]), 'mcp_chat_ban.html');
				
				redirect($complete_u_action);
			}
		}
		
		// Build the main query
		$sql_ary = [
			'SELECT'	=> 'cu.*, u.username AS member_name',
			'FROM'		=> [$this->tables['users'] => 'cu'],
			'LEFT_JOIN'	=> [
				['FROM' => [USERS_TABLE => 'u'], 'ON' => 'u.user_id = cu.user_id']
			],
			'ORDER_BY'	=> $sql_sort,
		];
		
		if($sql_where)
		{
			$sql_ary['WHERE'] = 'cu.exclude_time > 1
				AND cu.exclude_time > ' . $sql_where;
		}
		else
		{
			$sql_ary['WHERE'] = '(cu.exclude_time = 1
				OR cu.exclude_time > ' . $this->user->time_now . ')';
		}
		
		if($keywords)
		{
			$sql_ary['WHERE'] .= ' AND LOWER(cu.username) ' . $this->db->sql_like_expression($this->db->get_any_char() . strtolower($keywords) . $this->db->get_any_char());
		}
		
		// Get total count
		$sql_total = [
			'SELECT'	=> 'COUNT(*) AS total',
			'FROM'		=> $sql_ary['FROM'],
			'WHERE'		=> $sql_ary['WHERE'],
		];
		$sql = $this->db->sql_build_query('SELECT', $sql_total);
		$result = $this->db->sql_query($sql);
		$total_count = (int)$this->db->sql_fetchfield('total');
		$this->db->sql_freeresult($result);
		
		// Get user list
		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query($sql);
		while($row = $this->db->sql_fetchrow($result))
		{
			$username = ($row['username']) ? $row['username'] : $row['member_name'];
	
			$this->template->assign_block_vars('user', [
				'EXCLUSION'		=> ($row['exclude_time'] == 1) ? $this->language->lang('PERMANENT') : $this->user->format_date($row['exclude_time']),
				'ID'			=> $row['user_key'],
				'IP'			=> $row['user_ip'],
				'USERNAME'		=> $username,
				
				'U_EDIT'		=> $this->form_action . "&amp;$u_sort_param$keywords_param&amp;start=$start&amp;action=edit&amp;id=" . $row['user_key'],
				'U_UNBAN'		=> $this->form_action . "&amp;$u_sort_param$keywords_param&amp;start=$start&amp;action=unban&amp;id=" . $row['user_key'],
			]);
		}
		$this->db->sql_freeresult($result);
		
		$base_url = $this->form_action . "&amp;$u_sort_param$keywords_param";
		$this->pagination->generate_template_pagination($base_url, 'pagination', 'start', $total_count, $this->config['topics_per_page'], $start);
		
		$this->template->assign_vars([
			'IN_CHAT_MCP'			=> true,
			'L_TITLE'				=> '',
			'S_SELECT_SORT_DIR'		=> $s_sort_dir,
			'S_SELECT_SORT_KEY'		=> $s_sort_key,
			'S_KEYWORDS'			=> $keywords,
			
			'U_FIND_USERNAME'	=> append_sid($this->phpbb_root_path . 'memberlist.' . $this->php_ext, 'mode=searchuser&amp;form=mcp&amp;field=ban'),
			'U_POST_ACTION'		=> $complete_u_action,
		]);

		$this->template->append_asset('css', '@canidev_chat/chat.css');

		$this->build_period_options();
	}
	
	/**
	 * Exclude user
	 * 
	 * @param array 	$user_list
	 * @param array 	$usernames
	 * @param string 	$u_action
	 * 
	 * @access private
	 */
	protected function exclude($user_list, $usernames = [], $u_action = '')
	{
		$period_time	= $this->request->variable('period', 0);
		$period_date	= $this->request->variable('date', '');
		$exclude_time	= 0;

		switch($period_time)
		{
			case 0:
				if(preg_match('#^(\w{2})\/(\w{2})\/(\d{4}) (\w{2})\:(\w{2})\:(\w{2})#', $period_date, $match))
				{
					$exclude_time = $this->user->create_datetime()
						->setDate((int)$match[3], (int)$match[2], (int)$match[1])
						->setTime((int)$match[4], (int)$match[5], (int)$match[6])
						->getTimestamp();
					
					if($exclude_time <= time())
					{
						$exclude_time = 0;
					}
				}
			break;

			case 1:
				$exclude_time = 1;
			break;

			default:
				$exclude_time = time() + $period_time;
			break;
		}
		
		$u_action	= ($u_action) ? $u_action : $this->form_action;
		$back_link	= '<br /><br /><a href="' . $u_action . '">&laquo; ' . $this->language->lang('BACK_TO_PREV') . '</a>';
		
		if(sizeof($user_list) && $exclude_time)
		{
			$sql = 'UPDATE ' . $this->tables['users'] . "
				SET exclude_time = $exclude_time
				WHERE " . $this->db->sql_in_set('user_key', array_map('intval', $user_list));
			$result = $this->db->sql_query($sql);
			
			// Insert banned users if sessions no exist in the chat
			if($this->db->sql_affectedrows($result) < sizeof($user_list))
			{
				$real_user_list = [];
				
				$sql = 'SELECT user_key
					FROM ' . $this->tables['users'] . '
					WHERE exclude_time > 0
					AND ' . $this->db->sql_in_set('user_key', array_map('intval', $user_list));
				$result = $this->db->sql_query($sql);
				while($row = $this->db->sql_fetchrow($result))
				{
					$real_user_list[] = (int) $row['user_key'];
				}
				$this->db->sql_freeresult($result);
				
				$user_list = array_diff($user_list, $real_user_list);
				
				if(sizeof($user_list))
				{
					$sql_ary = [];
					
					foreach($user_list as $user_key)
					{
						// This only occurs with registered members so, no need username
						$sql_ary[] = [
							'user_key'			=> $user_key,
							'user_id'			=> $user_key,
							'user_ip'			=> '',
							'username'			=> '',
							'session_start'		=> time(),
							'user_lastjoin'		=> time(),
							'user_online'		=> 0,
							'user_status'		=> constants::STATUS_AVAILABLE,
							'exclude_time'		=> $exclude_time,
							'user_trace_time'	=> time(),
						];
					}
					
					$this->db->sql_multi_insert($this->tables['users'] , $sql_ary);
				}
			}

			if(sizeof($user_list))
			{
				$this->log->add(
					'mod',
					$this->user->data['user_id'],
					$this->user->ip,
					'LOG_CHAT_EXCLUSION_ADDED',
					time(),
					[implode(', ', $usernames)]
				);

				trigger_error($this->language->lang('CHAT_EXCLUSIONS_ADDED') . $back_link);
			}
		}
		
		trigger_error($this->language->lang('CHAT_EXCLUSIONS_ERROR') . $back_link);
	}
	
	/**
	 * Options for period selector
	 * @access private
	 */
	protected function build_period_options()
	{
		$option_ary = [
			1			=> 'PERMANENT',
			1800		=> 'HALF_AN_HOUR',
			3600		=> 'ONE_HOUR',
			86400		=> 'ONE_DAY',
			604800		=> 'ONE_WEEK',
			2592000		=> 'ONE_MONTH',
			31104000	=> 'ONE_YEAR',
			0			=> 'CUSTOM_DATE',
		];
		
		$this->template->assign_var('S_PERIOD_OPTIONS', $this->tools->make_select($option_ary, false, null));
	}
}
