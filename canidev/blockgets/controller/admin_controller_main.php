<?php
/**
 * @package cBB Blockgets
 * @version 2.0.5 15/01/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\controller;

use canidev\blockgets\libraries\constants;

class admin_controller_main extends admin_controller_base
{
	/**
	 * {@inheritDoc}
	 */
	protected function _display($mode)
	{
		$this->tpl_name = 'acp_blockgets';

		$action = $this->request->variable('action', '');
		$action = ($this->request->is_set_post('counter_reset')) ? 'counter_reset' : $action;
		$submit = $this->request->is_set_post('submit');

		switch($action)
		{
			case 'counter_reset':
				if(confirm_box(true))
				{
					$this->config->set('blg_counter_visit_count', 0);
					$this->config->set('blg_counter_start_date', time());
					
					$this->helper->json->send(['message' => $this->language->lang('BLG_CONFIG_UPDATED')]);
				}
				else
				{
					confirm_box(
						false,
						$this->language->lang('CONFIRM_OPERATION'),
						build_hidden_fields([
							'action'	=> $action,
						]),
						'@canidev_core/confirmbox.html'
					);
				}
			break;
		}

		switch($mode)
		{
			case 'main':
				$home_type_options = [
					constants::TYPE_DOMAIN_HOME		=> 'TYPE_DOMAIN_HOME',
					constants::TYPE_FORUM_HOME		=> 'TYPE_FORUM_HOME',
					constants::TYPE_FORUM_SECONDARY	=> 'TYPE_FORUM_SECONDARY',
				];

				$board_block_options = [
					constants::BOARD_BLOCK_NONE			=> 'BOARD_BLOCK_NONE',
					constants::BOARD_BLOCK_INDIVIDUAL	=> 'BOARD_BLOCK_INDIVIDUAL',
					constants::BOARD_BLOCK_SAME			=> 'BOARD_BLOCK_SAME',
				];
				
				// If the domain root is the forum root or rewrite is not available, the domain_home option is not valid
				if($this->user->page['root_script_path'] == '/' || !$this->config['blg_rewrite'])
				{
					unset($home_type_options[constants::TYPE_DOMAIN_HOME]);
				}
			
				$display_vars = [
					'title'	=> 'BLG_CONFIG',
					'vars'	=> [
						'legend1'					=> 'BLG_CONFIG_TITLE',
						'blg_on_board'				=> ['lang' => 'BLG_ON_BOARD',			'validate' => 'int',	'type' => 'select',		'function' => [$this->tools, 'make_select'],	'params' => [$board_block_options, false, '{CONFIG_VALUE}']],
						'blg_home_type'				=> ['lang' => 'HOME_TYPE_DISPLAY',		'validate' => 'int',	'type' => 'select',		'function' => [$this->tools, 'make_select'],	'params' => [$home_type_options, false, '{CONFIG_VALUE}']],
						'blg_collapse_blocks'		=> ['lang' => 'BLG_COLLAPSE',			'validate' => 'bool',	'type' => 'radio:yes_no'],
						'blg_block_autofit'			=> ['lang' => 'BLG_BLOCK_AUTOFIT',		'validate' => 'bool',	'type' => 'radio:yes_no'],
						'blg_admin_bar'				=> ['lang' => 'BLG_ADMIN_BAR',			'validate' => 'bool',	'type' => 'radio:yes_no'],
					
						'legend2'				=> 'COUNTER',
						'blg_counter_reset'		=> ['lang' => 'COUNTER_RESET',				'validate' => 'bool',	'type' => 'custom', 	'function' => [$this->helper_acp, 'counter_rst']],
					]
				];
				
				// If home page is disabled, don't display the home_type option
				$sql = 'SELECT page_enabled
					FROM ' . $this->tables['pages'] . '
					WHERE page_type = ' . constants::PAGE_HOME;
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
				$calendar_options = strtr($calendar_options, array_filter($this->language->lang_raw('datetime'), 'is_string'));
				$calendar_options = explode(', ', $calendar_options);
	
				$display_vars = [
					'title'	=> 'BLG_OPTIONAL',
					'vars'	=> [
						'legend1'		=> 'IMAGE_RESIZE',
						'blg_image_max_width'	=> ['lang' => 'IMAGE_RESIZE_WIDTH',	'validate' => 'int',	'type' => 'number'],
						'blg_avatar_max_width'	=> ['lang' => 'AVATAR_RESIZE_WIDTH',	'validate' => 'int',	'type' => 'number'],
						'blg_resize_on_post'	=> ['lang' => 'IMAGE_RESIZE_POST',		'validate' => 'bool',	'type' => 'radio:yes_no'],
					
						'legend2'		=> 'CALENDAR',
						'blg_calendar_enabled'		=> ['lang' => 'CALENDAR_ENABLED',		'validate' => 'bool',	'type' => 'radio:yes_no'],
						'blg_calendar_birthdays'	=> ['lang' => 'CALENDAR_BIRTHDAYS',	'validate' => 'bool',	'type' => 'radio:yes_no',	'default' => 1],
						'blg_calendar_first_day'	=> ['lang' => 'CALENDAR_FIRST_DAY',	'validate' => 'int',	'type' => 'custom',			'function' => [$this->tools, 'make_select'],	'params' => [$calendar_options, '{KEY}', '{CONFIG_VALUE}'],	'default' => 0],
						'blg_calendar_link'			=> ['lang' => 'CALENDAR_LINK',			'type' => 'custom',		'function' => [$this->helper_acp, 'pagelinks_select']],
					
						'legend3'		=> 'BLG_REDIRECTIONS',
						'blg_redirect_login'	=> ['lang' => 'BLG_REDIRECT_LOGIN',	'type' => 'custom',	'function' => [$this, 'redirect_select']],
						'blg_redirect_logout'	=> ['lang' => 'BLG_REDIRECT_LOGOUT',	'type' => 'custom',	'function' => [$this, 'redirect_select']],
						'blg_redirect_404'		=> ['lang' => 'BLG_REDIRECT_404',		'type' => 'custom',	'function' => [$this, 'redirect_select']],
					]
				];
			break;
		}

		/**
		 * @event blockgets.acp_config_vars
		 * @var array	display_vars		Variables to show
		 * @var string	mode				Current mode
		 * @since 2.0.0
		 */
		$vars = ['display_vars', 'mode'];
		extract($this->dispatcher->trigger_event('blockgets.acp_config_vars', compact($vars)));
		
		$this->page_title = $display_vars['title'] . '_TITLE';

		$cfg_array 			= (isset($_REQUEST['config'])) ? $this->request->variable('config', ['' => '']) : $this->config;
		$error 				= [];
		$purge_cache		= false;

		// We validate the complete config if whished
		validate_config_vars($display_vars['vars'], $cfg_array, $error);

		/**
		 * @event blockgets.acp_config_check_vars
		 * @var array	cfg_array		Submitted data
		 * @var array	error			Array with error messages
		 * @since 2.0.0
		 */
		$vars = ['cfg_array', 'error'];
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
			
			if($submit && in_array($config_name, ['blg_enabled', 'blg_home_type']) && $this->config[$config_name] != $this->new_config[$config_name])
			{
				$purge_cache = true;
				
				if($config_name == 'blg_home_type')
				{
					// If the domain root is the forum root, the domain_home option is not valid
					if($this->user->page['root_script_path'] == '/' && $this->new_config[$config_name] == constants::TYPE_DOMAIN_HOME)
					{
						$this->new_config[$config_name] = constants::TYPE_FORUM_HOME;
					}
					
					if(!$this->manage_index_file())
					{
						$error[] = $this->language->lang('INDEX_FILE_ERROR');
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
				$this->helper->json->send(['message' => $this->language->lang('BLG_CONFIG_UPDATED')]);
			}
		}
		
		$this->template->assign_vars([
			'S_TITLE'			=> $this->language->lang($this->page_title),
			'S_TITLE_EXPLAIN'	=> $this->language->lang($display_vars['title'] . '_EXPLAIN'),
		]);

		if(sizeof($error))
		{
			$this->helper->json->send([
				'message'	=> implode('<br />', $error),
				'status'	=> \canidev\core\json_response::JSON_STATUS_ERROR
			]);
		}
		
		$this->display_vars($display_vars['vars']);
	}

	/**
	 * Build redirect selector
	 * 
	 * @param strin 	$value
	 * @param string 	$key
	 * 
	 * @return string
	 */
	public function redirect_select($value, $key)
	{
		static $redirect_options;
		
		if(empty($redirect_options))
		{
			$redirect_options = [
				''		=> 'DEFAULT',
				'/'		=> 'INDEX',
			];
			
			$sql = 'SELECT page_id, page_type, page_title
				FROM ' . $this->tables['pages'] . '
				WHERE ' . $this->db->sql_in_set('page_type', [constants::PAGE_HOME, constants::PAGE_CUSTOM]) . '
				AND page_enabled = 1
				ORDER BY page_type, page_title';
			$result = $this->db->sql_query($sql);
			while($row = $this->db->sql_fetchrow($result))
			{
				$option_key = ($row['page_type'] == constants::PAGE_HOME) ? 'home' : $row['page_id'];

				$redirect_options[$option_key] = $this->language->lang($row['page_title']);
			}
			$this->db->sql_freeresult($result);
		}

		return $this->tools->make_select($redirect_options, $key, $value);
	}
	
	/**
	 * Manage root index
	 * 
	 * @return bool
	 * @access private
	 */
	private function manage_index_file()
	{
		$domain_root 		= $this->phpbb_root_path . preg_replace(['#/([\w\d\_\-]+)/#', '#^/#'], ['/../', ''], $this->user->page['root_script_path']);
		$protocol			= ($this->request->is_secure()) ? 'https://' : 'http://';
		$domain_filename 	= $domain_root . 'blockgets.' . $this->php_ext;
		$htaccess_filename	= $domain_root . '.htaccess';
		$allowed 			= true;
		$create_file		= false;
		
		if((file_exists($domain_filename) && !$this->filesystem->is_writable($domain_filename)) ||
			(file_exists($htaccess_filename) && !$this->filesystem->is_writable($htaccess_filename)))
		{
			$allowed = false;
		}
		
		if($allowed && !$this->filesystem->is_writable($domain_root) && ((!file_exists($domain_filename) && $this->new_config['blg_home_type'] == constants::TYPE_DOMAIN_HOME) || !file_exists($htaccess_filename)))
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
					if($this->new_config['blg_home_type'] != constants::TYPE_DOMAIN_HOME)
					{
						@unlink($domain_filename);
						
						$htaccess_content = @file_get_contents($htaccess_filename);
						
						if($htaccess_content)
						{
							file_put_contents($htaccess_filename, preg_replace('/## BEGIN CBB BLOCKGETS.*?END CBB BLOCKGETS ##\n?/s', '', $htaccess_content));
						}
					}
				}
				else if($this->new_config['blg_home_type'] == constants::TYPE_DOMAIN_HOME)
				{
					// It's not a blockgets file, we create it
					$create_file = true;
				}
			}
			else if($this->new_config['blg_home_type'] == constants::TYPE_DOMAIN_HOME)
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
			
			if($this->new_config['blg_home_type'] == constants::TYPE_DOMAIN_HOME)
			{
				$htaccess_change	= file_get_contents($this->helper->get_ext_path() . 'htaccess.bak');
				$htaccess_content	= @file_get_contents($htaccess_filename);
				
				file_put_contents($htaccess_filename, $htaccess_change . "\n" . $htaccess_content);
			}
		}
		
		return $allowed;
	}
}
