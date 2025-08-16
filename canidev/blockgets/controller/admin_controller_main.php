<?php
/*
* @name admin_controller_main.php
* @package cBB Blockgets
* @version v2.0.0 30/05/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\controller;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class admin_controller_main extends admin_controller_base
{
	protected function _display($mode)
	{
		$this->tpl_name = 'acp_blockgets';

		$action = $this->request->variable('action', '');
		$action = ($this->request->is_set_post('counter_reset')) ? 'counter_reset' : $action;
		$submit = $this->request->is_set_post('submit');

		switch($action)
		{
			case 'counter_reset':
				if($this->helper->confirm_box(true))
				{
					$this->config->set('blg_counter_visit_count', 0);
					$this->config->set('blg_counter_start_date', time());
					
					$this->helper->trigger_error(array('message' => 'BLG_CONFIG_UPDATED'));
				}
				else
				{
					$this->helper->confirm_box(false, $this->lang->get('CONFIRM_OPERATION'), array(
						'action'	=> $action,
					));
				}
			break;
		}

		switch($mode)
		{
			case 'main':
				$display_vars = array(
					'title'	=> 'BLG_CONFIG',
					'vars'	=> array(
						'legend1'					=> 'BLG_CONFIG_TITLE',
						'blg_on_board'				=> array('lang' => 'BLG_ON_BOARD',			'validate' => 'bool',	'type' => 'radio:yes_no'),
						'blg_home_type'				=> array('lang' => 'HOME_TYPE_DISPLAY',		'validate' => 'int',	'type' => 'select',		'function' => array($this, 'home_type_select'),	'params' => array('{CONFIG_VALUE}')),
						'blg_collapse_blocks'		=> array('lang' => 'BLG_COLLAPSE',			'validate' => 'bool',	'type' => 'radio:yes_no'),
						'blg_block_autofit'			=> array('lang' => 'BLG_BLOCK_AUTOFIT',		'validate' => 'bool',	'type' => 'radio:yes_no'),
						'blg_admin_bar'				=> array('lang' => 'BLG_ADMIN_BAR',			'validate' => 'bool',	'type' => 'radio:yes_no'),
					
						'legend2'				=> 'COUNTER',
						'blg_counter_reset'		=> array('lang' => 'COUNTER_RESET',			'validate' => 'bool',	'type' => 'custom', 'method' => 'helper',	'params' => array('counter_rst')),
					)
				);
				
				// If home page is disabled, don't display the home_type option
				$sql = 'SELECT page_enabled
					FROM ' . BLG_PAGES_TABLE . '
					WHERE page_type = ' . PAGE_HOME;
				$result = $this->db->sql_query($sql);
				$home_enabled = (int)$this->db->sql_fetchfield('page_enabled');
				$this->db->sql_freeresult($result);
				
				if(!$home_enabled)
				{
					unset($display_vars['vars']['blg_home_type']);
				}
			break;
			
			case 'optional':
				$calendar_options = 'Sunday, Monday, Tuesday, Wednesday, Thursday, Friday, Saturday';
				$calendar_options = strtr($calendar_options, array_filter($this->lang->get_raw('datetime'), 'is_string'));
				$calendar_options = explode(', ', $calendar_options);
	
				$display_vars = array(
					'title'	=> 'BLG_OPTIONAL',
					'vars'	=> array(
						'legend1'		=> 'IMAGE_RESIZE',
						'blg_resize_enabled'	=> array('lang' => 'IMAGE_RESIZE_ENABLED',	'validate' => 'bool',	'type' => 'radio:yes_no'),
						'blg_resize_on_post'	=> array('lang' => 'IMAGE_RESIZE_POST',		'validate' => 'bool',	'type' => 'radio:yes_no'),
						'blg_image_max_width'	=> array('lang' => 'IMAGE_RESIZE_WIDTH',	'validate' => 'int',	'type' => 'text:3:4'),
						'blg_avatar_max_width'	=> array('lang' => 'AVATAR_RESIZE_WIDTH',	'validate' => 'int',	'type' => 'text:3:4'),
					
						'legend2'		=> 'CALENDAR',
						'blg_calendar_enabled'		=> array('lang' => 'CALENDAR_ENABLED',		'validate' => 'bool',	'type' => 'radio:yes_no'),
						'blg_calendar_first_day'	=> array('lang' => 'CALENDAR_FIRST_DAY',	'validate' => 'int',	'type' => 'select',	'method' => 'helper',	'params' => array('make_select', $calendar_options, '{CONFIG_VALUE}', false),	'default' => 0),
						'blg_calendar_link'			=> array('lang' => 'CALENDAR_LINK',			'type' => 'select',		'method' => 'helper',	'params' => array('pagelinks_select', '{CONFIG_VALUE}')),
					
						'legend3'		=> 'BLG_REDIRECTIONS',
						'blg_redirect_login'	=> array('lang' => 'BLG_REDIRECT_LOGIN',	'type' => 'select',	'function' => array($this, 'redirect_select')),
						'blg_redirect_logout'	=> array('lang' => 'BLG_REDIRECT_LOGOUT',	'type' => 'select',	'function' => array($this, 'redirect_select')),
						'blg_redirect_404'		=> array('lang' => 'BLG_REDIRECT_404',		'type' => 'select',	'function' => array($this, 'redirect_select')),
					)
				);
			break;
		}

		/**
		* @event blockgets.acp_config_vars
		* @var array	display_vars		Variables to show
		* @var string	mode				Current mode
		* @since 2.0.0
		*/
		$vars = array('display_vars', 'mode');
		extract($this->dispatcher->trigger_event('blockgets.acp_config_vars', compact($vars)));
		
		$this->page_title = $display_vars['title'] . '_TITLE';

		$cfg_array 	= (isset($_REQUEST['config'])) ? $this->request->variable('config', array('' => '')) : $this->config;
		$error 				= array();
		$purge_cache		= false;

		// We validate the complete config if whished
		validate_config_vars($display_vars['vars'], $cfg_array, $error);

		/**
		* @event blockgets.acp_config_check_vars
		* @var array	cfg_array		Submitted data
		* @var array	error			Array with error messages
		* @since 2.0.0
		*/
		$vars = array('cfg_array', 'error');
		extract($this->dispatcher->trigger_event('blockgets.acp_config_check_vars', compact($vars)));
		
		$this->new_config = $cfg_array;

		// Do not write values if there is an error
		if(sizeof($error))
		{
			$submit = false;
		}

		// We go through the display_vars to make sure no one is trying to set variables he/she is not allowed to...
		foreach($display_vars['vars'] as $config_name => $null)
		{
			if(!isset($this->new_config[$config_name]) || strpos($config_name, 'legend') !== false)
			{
				continue;
			}
			
			if($submit && in_array($config_name, array('blg_enabled', 'blg_home_type')) && $this->config[$config_name] != $this->new_config[$config_name])
			{
				$purge_cache = true;
				
				if($config_name == 'blg_home_type')
				{
					// If the domain root is the forum root, the domain_home option is not valid
					if($this->user->page['root_script_path'] == '/' && $this->new_config[$config_name] == TYPE_DOMAIN_HOME)
					{
						$this->new_config[$config_name] = TYPE_FORUM_HOME;
					}
					
					if(!$this->manage_index_file())
					{
						$error[] = $this->lang->get('INDEX_FILE_ERROR');
						$this->new_config[$config_name] = $this->config[$config_name];
					}
				}
			}

			if($submit)
			{
				$this->config->set($config_name, $this->new_config[$config_name]);
			}
			
			$this->config[$config_name] = $this->new_config[$config_name];
		}

		if($submit)
		{
			if($purge_cache)
			{
				$this->cache->purge();
			}

			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_BLG_CONFIG');
		
			if(!sizeof($error))
			{
				$this->helper->trigger_error(array('message' => 'BLG_CONFIG_UPDATED'));
			}
		}
		
		$this->template->assign_vars(array(
			'L_TITLE'			=> $this->lang->get($this->page_title),
			'L_TITLE_EXPLAIN'	=> $this->lang->get($display_vars['title'] . '_EXPLAIN'),
		));

		if(sizeof($error))
		{
			$this->helper->trigger_error(array(
				'message'	=> implode('<br />', $error),
				'status'	=> BLG_JSON_ERROR
			));
		}
		
		$this->display_vars($display_vars['vars']);
	}
	
	function display_vars($display_vars)
	{
		global $template, $user;

		foreach($display_vars as $config_key => $vars)
		{
			if(!is_array($vars) && strpos($config_key, 'legend') === false)
			{
				continue;
			}

			if(strpos($config_key, 'legend') !== false)
			{
				$this->template->assign_block_vars('options', array(
					'S_LEGEND'		=> true,
					'LEGEND'		=> $this->lang->get($vars)
				));
				continue;
			}
			
			if(!isset($this->new_config[$config_key]) && isset($vars['default']))
			{
				$this->new_config[$config_key] = $vars['default'];
			}

			$type = explode(':', $vars['type']);

			$content = build_cfg_template($type, $config_key, $this->new_config, $config_key, $vars);
			if(empty($content))
			{
				continue;
			}

			$this->template->assign_block_vars('options', array(
				'KEY'			=> $config_key,
				'TITLE'			=> $this->lang->get($vars['lang']),
				'S_EXPLAIN'		=> ($this->lang->is_set($vars['lang'] . '_EXPLAIN') ? $this->lang->get($vars['lang'] . '_EXPLAIN') : ''),
				'CONTENT'		=> $content,
			));

			unset($display_vars[$config_key]);
		}
	}
	
	public function home_type_select($value)
	{
		$options = array(
			TYPE_DOMAIN_HOME		=> 'TYPE_DOMAIN_HOME',
			TYPE_FORUM_HOME			=> 'TYPE_FORUM_HOME',
			TYPE_FORUM_SECONDARY	=> 'TYPE_FORUM_SECONDARY',
		);
		
		// If the domain root is the forum root or rewrite is not available, the domain_home option is not valid
		if($this->user->page['root_script_path'] == '/' || !$this->config['blg_rewrite'])
		{
			unset($options[TYPE_DOMAIN_HOME]);
		}
		
		return $this->helper_acp->make_select($options, $value);
	}
	
	public function redirect_select($value)
	{
		static $redirect_options;
		
		if(empty($redirect_options))
		{
			$redirect_options = array(
				''		=> 'DEFAULT',
				'/'		=> 'INDEX',
			);
			
			$sql = 'SELECT page_id, page_type, page_title
				FROM ' . BLG_PAGES_TABLE . '
				WHERE ' . $this->db->sql_in_set('page_type', array(PAGE_HOME, PAGE_CUSTOM)) . '
				AND page_enabled = 1
				ORDER BY page_type, page_title';
			$result = $this->db->sql_query($sql);
			while($row = $this->db->sql_fetchrow($result))
			{
				$key	= ($row['page_type'] == PAGE_HOME) ? 'home' : $row['page_id'];
				$title	= $row['page_title']; 

				$redirect_options[$key] = $this->lang->get($title);
			}
			$this->db->sql_freeresult($result);
		}
		
		return $this->helper_acp->make_select($redirect_options, $value);
	}
	
	private function manage_index_file()
	{
		$domain_root 		= $this->phpbb_root_path . preg_replace(array('#/([\w\d\_\-]+)/#', '#^/#'), array('/../', ''), $this->user->page['root_script_path']);
		$protocol			= ($this->request->is_secure()) ? 'https://' : 'http://';
		$domain_filename 	= $domain_root . 'blockgets.' . $this->php_ext;
		$htaccess_filename	= $domain_root . '.htaccess';
		$allowed 			= true;
		$create_file		= false;
		
		if((file_exists($domain_filename) && !phpbb_is_writable($domain_filename)) ||
			(file_exists($htaccess_filename) && !phpbb_is_writable($htaccess_filename)))
		{
			$allowed = false;
		}
		
		if($allowed && !phpbb_is_writable($domain_root) && ((!file_exists($domain_filename) && $this->new_config['blg_home_type'] == TYPE_DOMAIN_HOME) || !file_exists($htaccess_filename)))
		{
			$allowed = false;
		}
		
		if($allowed)
		{
			if(file_exists($domain_filename))
			{
				$result = @file_get_contents($protocol . $this->user->host . '/blockgets.' . $this->php_ext . '?install=1');
				
				if($result == 'ok')
				{
					// It's a blockgets file, we delete it if neccessary
					if($this->new_config['blg_home_type'] != TYPE_DOMAIN_HOME)
					{
						@unlink($domain_filename);
						
						$htaccess_content = @file_get_contents($htaccess_filename);
						
						if($htaccess_content)
						{
							file_put_contents($htaccess_filename, preg_replace('/## BEGIN CBB BLOCKGETS.*?END CBB BLOCKGETS ##\n?/s', '', $htaccess_content));
						}
					}
				}
				else if($this->new_config['blg_home_type'] == TYPE_DOMAIN_HOME)
				{
					// It's not a blockgets file, we create it
					$create_file = true;
				}
			}
			else if($this->new_config['blg_home_type'] == TYPE_DOMAIN_HOME)
			{
				$create_file = true;
			}
		
			// Create the new index
			if($create_file)
			{
				$file_content = file_get_contents($this->helper->get_ext_path() . 'index.bak');
				$file_content = str_replace('{ROOT_PATH}', '.' . $this->user->page['root_script_path'], $file_content);
				
				if(!@file_put_contents($domain_filename, $file_content))
				{
					return false;
				}
			}
			
			if($this->new_config['blg_home_type'] == TYPE_DOMAIN_HOME)
			{
				$htaccess_change	= file_get_contents($this->helper->get_ext_path() . 'htaccess.bak');
				$htaccess_content	= @file_get_contents($htaccess_filename);
				
				file_put_contents($htaccess_filename, $htaccess_change . "\n" . $htaccess_content);
			}
		}
		
		return $allowed;
	}
}
