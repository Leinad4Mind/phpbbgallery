<?php
/*
* @name main_module.php
* @package cBB Chat
* @version v1.1.3 10/03/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\chat\mcp;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

/**
* @package acp
*/
class main_module
{
	var $u_action;

	function main($id, $mode)
	{
		global $db, $user, $template, $config, $request, $phpbb_container, $phpbb_log, $phpbb_root_path, $phpEx;

		// Set up general vars
		$error		= array();
		$action 	= $request->variable('action', '');
		$action		= ($request->is_set_post('bansubmit')) ? 'banusers' : $action;
		$start		= $request->variable('start', 0);
		$marked		= ($request->is_set_post('submit')) ? $request->variable('mark', array(0)) : array($request->variable('id', 0));
		$pagination = $phpbb_container->get('pagination');
		
		// Sort keys
		$sort_days	= $request->variable('st', 0);
		$sort_key	= $request->variable('sk', 'u');
		$sort_dir	= $request->variable('sd', 'a');

		$this->page_title 	= '';
		$this->tpl_name 	= 'mcp_chat_ban';
		
		// Sorting
		$limit_days		= array(0 => $user->lang['ALL_ENTRIES'], 1 => $user->lang['1_DAY'], 7 => $user->lang['7_DAYS'], 14 => $user->lang['2_WEEKS'], 30 => $user->lang['1_MONTH'], 90 => $user->lang['3_MONTHS'], 180 => $user->lang['6_MONTHS'], 365 => $user->lang['1_YEAR']);
		$sort_by_text	= array('u' => $user->lang['SORT_USERNAME'], 't' => $user->lang['SORT_DATE'], 'i' => $user->lang['SORT_IP']);
		$sort_by_sql	= array('u' => 'LOWER(cu.username)', 't' => 'cu.exclude_time', 'i' => 'cu.user_ip');

		$s_limit_days = $s_sort_key = $s_sort_dir = $u_sort_param = '';
		gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sort_dir, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);

		// Define where and sort sql for use in displaying logs
		$sql_where = ($sort_days) ? (time() - ($sort_days * 86400)) : 0;
		$sql_sort = $sort_by_sql[$sort_key] . ' ' . (($sort_dir == 'd') ? 'DESC' : 'ASC');
		
		$keywords = utf8_normalize_nfc($request->variable('keywords', '', true));
		$keywords_param = !empty($keywords) ? '&amp;keywords=' . urlencode(htmlspecialchars_decode($keywords)) : '';
		
		$complete_u_action = $this->u_action . "&amp;$u_sort_param$keywords_param&amp;start=$start";
		
		// Do actions
		if($action == 'banusers')
		{
			$userlist = utf8_normalize_nfc($request->variable('ban', '', true));
			$userlist = array_unique(array_map('trim', explode("\n", $userlist)));
			
			$user_keys = $usernames = array();
			
			// Get user_keys for guests
			$sql = 'SELECT user_key, username
				FROM ' . CHAT_USERS_TABLE . '
				WHERE ' . $db->sql_in_set('username', $userlist) . '
				AND user_id = ' . ANONYMOUS;
			$result = $db->sql_query($sql);
			while($row = $db->sql_fetchrow($result))
			{
				$user_keys[] = (int)$row['user_key'];
				$usernames[] = $row['username'];
			}
			$db->sql_freeresult($result);
			
			// Get user_keys for registered members
			$sql = 'SELECT user_id, username
				FROM ' . USERS_TABLE . '
				WHERE ' . $db->sql_in_set('username', $userlist) . '
				AND user_type <> ' . USER_IGNORE . '
				AND user_id <> ' . $user->data['user_id'];
			$result = $db->sql_query($sql);
			while($row = $db->sql_fetchrow($result))
			{
				$user_keys[] = (int)$row['user_id'];
				$usernames[] = $row['username'];
			}
			$db->sql_freeresult($result);
			
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
						$update_ary = array(
							'cu.exclude_time'	=> 0,
							'cu.user_online'	=> 0,
						);
						
						$marked		= array_map('intval', $marked);
						$usernames	= array();
						
						$sql_where = 'cu.exclude_time > 0
							AND ' . $db->sql_in_set('cu.user_key', $marked);
						
						// Get usernames for log
						$sql = 'SELECT cu.username, u.username AS member_name
							FROM ' . CHAT_USERS_TABLE . ' cu
								LEFT JOIN ' . USERS_TABLE . " u ON(u.user_id = cu.user_id)
							WHERE $sql_where";
						$result = $db->sql_query($sql);
						while($row = $db->sql_fetchrow($result))
						{
							$usernames[] = ($row['username']) ? $row['username'] : $row['member_name'];
						}
						$db->sql_freeresult($result);
						
						// Do work
						if(sizeof($usernames))
						{
							$sql = 'UPDATE ' . CHAT_USERS_TABLE . ' cu
								SET ' . $db->sql_build_array('UPDATE', $update_ary) . "
								WHERE $sql_where";
							$db->sql_query($sql);
						
							$phpbb_log->add('mod',
								$user->data['user_id'],
								$user->ip,
								'LOG_CHAT_EXCLUSION_REMOVED',
								time(),
								array(implode(', ', $usernames))
							);
						}
						
						trigger_error($user->lang['CHAT_EXCLUSIONS_DELETED'] . '<br /><br /><a href="' . $complete_u_action . '">&laquo; ' . $user->lang['BACK_TO_PREV'] . '</a>');
					break;
					
					case 'edit':
						// Get usernames for log
						$usernames = array();

						$sql = 'SELECT cu.username, u.username AS member_name
							FROM ' . CHAT_USERS_TABLE . ' cu
								LEFT JOIN ' . USERS_TABLE . ' u ON(u.user_id = cu.user_id)
							WHERE ' . $db->sql_in_set('cu.user_key', $marked);
						$result = $db->sql_query($sql);
						while($row = $db->sql_fetchrow($result))
						{
							$usernames[] = ($row['username']) ? $row['username'] : $row['member_name'];
						}
						$db->sql_freeresult($result);
	
						$this->exclude($marked, $usernames, $complete_u_action);
					break;
				}
			}
			else
			{
				if($action == 'edit')
				{
					$this->build_period_options();
					
					$template->assign_vars(array(
						'S_EDIT'			=> true,
						'IN_CHAT_MCP'		=> true,
					));
				}
				
				confirm_box(false, $user->lang['CONFIRM_OPERATION'], build_hidden_fields(array(
					'start'		=> $start,
					'mark'		=> $marked,
					'sk'		=> $sort_key,
					'sd'		=> $sort_dir,
					'i'			=> $id,
					'mode'		=> $mode,
					'action'	=> $action,
					'submit'	=> true,
				)), 'mcp_chat_ban.html');
				
				redirect($complete_u_action);
			}
		}
		
		// Build the main query
		$sql_ary = array(
			'SELECT'	=> 'cu.*, u.username AS member_name',
			'FROM'		=> array(CHAT_USERS_TABLE => 'cu'),
			'LEFT_JOIN'	=> array(
				array('FROM' => array(USERS_TABLE => 'u'), 'ON' => 'u.user_id = cu.user_id')
			),
			'ORDER_BY'	=> $sql_sort,
		);
		
		if($sql_where)
		{
			$sql_ary['WHERE'] = 'cu.exclude_time > 1
				AND cu.exclude_time > ' . $sql_where;
		}
		else
		{
			$sql_ary['WHERE'] = '(cu.exclude_time = 1
				OR cu.exclude_time > ' . $user->time_now . ')';
		}
		
		if($keywords)
		{
			$sql_ary['WHERE'] .= ' AND LOWER(cu.username) ' . $db->sql_like_expression($db->get_any_char() . strtolower($keywords) . $db->get_any_char());
		}
		
		// Get total count
		$sql_total = array(
			'SELECT'	=> 'COUNT(*) AS total',
			'FROM'		=> $sql_ary['FROM'],
			'WHERE'		=> $sql_ary['WHERE'],
		);
		$sql = $db->sql_build_query('SELECT', $sql_total);
		$result = $db->sql_query($sql);
		$total_count = (int)$db->sql_fetchfield('total');
		$db->sql_freeresult($result);
		
		// Get user list
		$sql = $db->sql_build_query('SELECT', $sql_ary);
		$result = $db->sql_query($sql);
		while($row = $db->sql_fetchrow($result))
		{
			$username = ($row['username']) ? $row['username'] : $row['member_name'];
	
			$template->assign_block_vars('user', array(
				'EXCLUSION'		=> ($row['exclude_time'] == 1) ? $user->lang['PERMANENT'] : $user->format_date($row['exclude_time']),
				'ID'			=> $row['user_key'],
				'IP'			=> $row['user_ip'],
				'USERNAME'		=> $username,
				
				'U_EDIT'		=> $this->u_action . "&amp;$u_sort_param$keywords_param&amp;start=$start&amp;action=edit&amp;id=" . $row['user_key'],
				'U_UNBAN'		=> $this->u_action . "&amp;$u_sort_param$keywords_param&amp;start=$start&amp;action=unban&amp;id=" . $row['user_key'],
			));
		}
		$db->sql_freeresult($result);
		
		$base_url = $this->u_action . "&amp;$u_sort_param$keywords_param";
		$pagination->generate_template_pagination($base_url, 'pagination', 'start', $total_count, $config['topics_per_page'], $start);
		
		$template->assign_vars(array(
			'IN_CHAT_MCP'			=> true,
			'L_TITLE'				=> '',
			'S_SELECT_SORT_DIR'		=> $s_sort_dir,
			'S_SELECT_SORT_KEY'		=> $s_sort_key,
			'S_KEYWORDS'			=> $keywords,
			
			'U_FIND_USERNAME'	=> append_sid("{$phpbb_root_path}memberlist.$phpEx", 'mode=searchuser&amp;form=mcp&amp;field=ban'),
			'U_POST_ACTION'		=> $complete_u_action,
		));
		
		$this->build_period_options();
	}
	
	function exclude($user_list, $usernames = array(), $u_action = '')
	{
		global $db, $request, $user, $phpbb_log;
		
		$period_time	= $request->variable('period', 0);
		$period_date	= $request->variable('date', '');
		$exclude_time	= 0;

		switch($period_time)
		{
			case 0:
				if(preg_match('#^(\w{2})\/(\w{2})\/(\d{4}) (\w{2})\:(\w{2})\:(\w{2})#', $period_date, $match))
				{
					$exclude_time = $user->create_datetime()
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
		
		$u_action	= ($u_action) ? $u_action : $this->u_action;
		$back_link	= '<br /><br /><a href="' . $u_action . '">&laquo; ' . $user->lang['BACK_TO_PREV'] . '</a>';
		
		if(sizeof($user_list) && $exclude_time)
		{
			$sql = 'UPDATE ' . CHAT_USERS_TABLE . "
				SET exclude_time = $exclude_time
				WHERE " . $db->sql_in_set('user_key', array_map('intval', $user_list));
			$result = $db->sql_query($sql);
			
			// Insert banned users if sessions no exist in the chat
			if($db->sql_affectedrows($result) < sizeof($user_list))
			{
				$real_user_list = array();
				
				$sql = 'SELECT user_key
					FROM ' . CHAT_USERS_TABLE . '
					WHERE exclude_time > 0
					AND ' . $db->sql_in_set('user_key', array_map('intval', $user_list));
				$result = $db->sql_query($sql);
				while($row = $db->sql_fetchrow($result))
				{
					$real_user_list[] = (int) $row['user_key'];
				}
				$db->sql_freeresult($result);
				
				$user_list = array_diff($user_list, $real_user_list);
				
				if(sizeof($user_list))
				{
					$sql_ary = array();
					
					foreach($user_list as $user_key)
					{
						// This only occurs with registered members so, no need username
						$sql_ary[] = array(
							'user_key'			=> $user_key,
							'user_id'			=> $user_key,
							'user_ip'			=> '',
							'username'			=> '',
							'session_start'		=> time(),
							'user_lastjoin'		=> time(),
							'user_online'		=> 0,
							'user_status'		=> CHAT_STATUS_AVAILABLE,
							'exclude_time'		=> $exclude_time,
							'user_trace_time'	=> time(),
						);
					}
					
					$db->sql_multi_insert(CHAT_USERS_TABLE , $sql_ary);
				}
			}

			if(sizeof($user_list))
			{
				$phpbb_log->add(
					'mod',
					$user->data['user_id'],
					$user->ip,
					'LOG_CHAT_EXCLUSION_ADDED',
					time(),
					array(implode(', ', $usernames))
				);

				trigger_error($user->lang['CHAT_EXCLUSIONS_ADDED'] . $back_link);
			}
		}
		
		trigger_error($user->lang['CHAT_EXCLUSIONS_ERROR'] . $back_link);
	}
	
	function build_period_options()
	{
		global $template, $user;

		$option_ary = array(
			1			=> 'PERMANENT',
			1800		=> 'HALF_AN_HOUR',
			3600		=> 'ONE_HOUR',
			86400		=> 'ONE_DAY',
			604800		=> 'ONE_WEEK',
			2592000		=> 'ONE_MONTH',
			31104000	=> 'ONE_YEAR',
			0			=> 'CUSTOM_DATE',
		);

		$option_str = '';

		foreach($option_ary as $value => $title)
		{
			$option_str .= '<option value="' . $value . '">' . $user->lang($title) . '</option>';
		}
		
		$template->assign_var('S_PERIOD_OPTIONS', $option_str);
	}
}
