<?php
/*
* @name bbsidebar.php
* @package cBB Chat Compatibility
* @version v1.0.0 10/03/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\chat\compatibility;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class bbsidebar extends base
{
	public $name = 'sitesplat/sidebar';

	public function is_runnable()
	{
		return $this->ext_manager->is_enabled($this->name);
	}
	
	public function get_core_events()
	{
		$events = array(
			'chat.before_load_js'	=> 'before_load_js',
		);
		
		if(!defined('ADMIN_START'))
		{
			$events['core.page_footer'] = array('overwrite_footer', -1);
		}
		
		return $events;
	}
	
	public function before_load_js($event)
	{
		global $request;
		
		if($request->variable('sidebar', false))
		{
			$event['js_filename'] = 'jchat-sidebar.js';
		}
	}
	
	public function overwrite_footer($event)
	{
		global $config, $user, $template, $phpEx, $chat;
		
		if(in_array($user->style['style_name'], array('BBOOTS', 'FLATBOOTS')))
		{
			$sidebar_config = json_decode($config['sidebar_settings'], true);

			$page = str_replace('.' . $phpEx, '', $user->page['page_name']);
			$sidebar = (!$sidebar_config['all_pages']) ? (($sidebar_config['panel_pages']) ? !in_array($page, array('ucp', 'mcp')): true) : $page == 'index';

			if($sidebar)
			{
				$template->assign_var('U_CHAT_JSCRIPT', str_replace('&amp;', '&', append_sid($chat->web_path . $chat->path . 'jchat_scripts.' . $phpEx, array(
					'v'					=> $config['chat_version'],
					'id'				=> $user->style['style_id'],
					'assets_version'	=> $config['assets_version'],
					'sidebar'			=> 1,
				))));
			}
		}
	}

	public function get_js_events()
	{
		global $config, $request;
	
		$sidebar_config = json_decode($config['sidebar_settings'], true);

		if($request->variable('sidebar', false) && !$sidebar_config['height'])
		{
			return array(
				'chat.onInit' => "function() {
					if($('#page-sidebar').length)
					{
						var x = $('#contentje').height();
						$('#page-sidebar').css('height', x -10);
					}
				}"
			);
		}
		
		return array();
	}
}