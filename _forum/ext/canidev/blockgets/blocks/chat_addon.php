<?php
/*
* @package cBB Chat Addon
* @version v2.0.4 30/08/2021
*
* @copyright (c) 2020 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\blocks;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class chat_addon extends base
{
	static $icon = 'fa-comments';

	private $status_ary = array();

	public function init()
	{
		$this->tpl_name = 'chat_addon';

		if(($data = $this->unserialize()) === false || !$this->container->has('canidev.chat.controller'))
		{
			return false;
		}

		if($this->user->data['is_bot'] || !$this->auth->acl_get('u_chat_view'))
		{
			return false;
		}
		
		$this->status_ary = array(
			CHAT_STATUS_AVAILABLE		=> 'available',
			CHAT_STATUS_AWAY			=> 'away',
			CHAT_STATUS_BUSY			=> 'busy',
			CHAT_STATUS_HIDDEN			=> 'hidden',
		);
		
		// Delete the array in the template if exists, prevent errors between blocks
		$this->template->destroy_block_vars('userrow');

		switch($data['display_mode'])
		{
			case 'chat':
			default:
				$this->template->assign_vars(array(
					'CHAT_ADDON_SHOW_CHAT'	=> true,
					'CHAT_ADDON_ACTION'		=> $this->helper->route('canidev_chat_controller', array('embed' => 1, 'notitle' => 1)),
					'CHAT_ADDON_HEIGHT'		=> (int)$this->config['chat_height'] + 160,
				));
			break;
			
			case 'users':
				$user_cache = array();

				$this->template->assign_vars(array(
					'CHAT_ADDON_SHOW_CHAT'	=> false,
				));

				$sql = 'SELECT cu.*, u.username as register_username, u.user_colour, g.group_name
					FROM ' . CHAT_USERS_TABLE . ' cu
						LEFT JOIN ' . USERS_TABLE . ' u ON(u.user_id = cu.user_id)
						LEFT JOIN ' . GROUPS_TABLE . ' g ON(g.group_id = u.group_id)
					WHERE cu.user_online = 1
					AND cu.user_trace_time > ' . (time() - ($this->config['chat_refresh'] * 3));
				$result = $this->db->sql_query($sql);
				while($row = $this->db->sql_fetchrow($result))
				{
					$rkey = 0;
					
					$row['username'] = ($row['username']) ? $row['username'] : $row['register_username'];
			
					if($this->config['chat_group_users'])
					{
						switch($row['group_name'])
						{
							case 'ADMINISTRATORS':
								$rkey = 1;
							break;
							
							case 'GLOBAL_MODERATORS':
								$rkey = 2;
							break;
							
							case 'REGISTERED':
								$rkey = 3;
							break;
							
							case 'NEWLY_REGISTERED':
								$rkey = 4;
							break;
							
							case 'GUESTS':
								$rkey = 'zzz';
							break;
							
							default:
								$rkey = strtolower($row['group_name']);
							break;
						}
					}
					
					$rkey = $rkey . '.' . strtolower($row['username']);
					
					$user_cache[$rkey] = $row;
				}
				$this->db->sql_freeresult($result);
				
				ksort($user_cache);
					
				foreach($user_cache as $row)
				{
					$this->template->assign_block_vars('userrow', array(
						'S_USER_FULL'		=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour'], $row['username']),
						'S_USER_STATUS'		=> $this->status_ary[$row['user_status']],
					));
				}
				
				$this->template->append_asset('css', '@canidev_chat/../theme/chat.css');
			break;
		}

		return true;
	}
	
	public function check()
	{
		return $this->container->has('canidev.chat.controller');
	}
	
	public function setup()
	{
		$this->container->get('language')->add_lang('chat_addon', 'canidev/blockgets');
	}
	
	public function get_config()
	{
		$display_modes = array(
			'chat'		=> 'CHAT_MODE_CHAT',
			'users'		=> 'CHAT_MODE_USERS',
		);

		$this->display_vars = array(
			'display_mode'		=> array('lang' => 'CHAT_ADDON_MODE',	'type' => 'select',		'method' => 'helper',	'params' => array('make_select', $display_modes, false, '{CONFIG_VALUE}'),	'default' => 'chat'),
		);

		return true;
	}
}
