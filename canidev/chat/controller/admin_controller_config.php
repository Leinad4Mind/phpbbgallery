<?php
/*
* @package cBB Chat
* @version v1.2.3 22/04/2022
*
* @copyright (c) 2022 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
*/

namespace canidev\chat\controller;

use canidev\chat\libraries\constants;

class admin_controller_config extends admin_controller_base
{
	/**
	 * {@inheritDoc}
	*/
	public function _display($mode)
	{
		$this->tpl_name		= 'acp_chat_config';
		$this->page_title	= 'ACP_CHAT_CONFIG';
		
		$error = array();
		
		add_form_key(self::FORM_KEY);
		
		$options = array(
			'row_align'		=> array(
				'left' 		=> 'CHAT_ROW_LEFT',
				'right' 	=> 'CHAT_ROW_RIGHT',
				'zigzag' 	=> 'CHAT_ROW_ZIGZAG',
				'meother' 	=> 'CHAT_ROW_MEOTHER',
			),
			'row_format'		=> array(
				'normal'	=> 'CHAT_ROW_NORMAL',
				'bubble'	=> 'CHAT_ROW_BUBBLE',
			),
			'bbcode_format'	=> array(
				'button'	=> 'CHAT_BBCODE_INBUTTON',
				'select'	=> 'CHAT_BBCODE_INSELECT',
			),
			'direction'	=> array(
				'down'		=> 'CHAT_DIRECTION_DOWN',
				'up'		=> 'CHAT_DIRECTION_UP',
			),
			'disallowed_bbcode'	=> $this->get_bbcode_options(),
			'forum_posts'	=> array(
				constants::SHOW_NONE	=> 'CHAT_SHOW_NONE',
				constants::SHOW_TOPICS	=> 'CHAT_SHOW_TOPICS',
				constants::SHOW_POSTS	=> 'CHAT_SHOW_POSTS',
			),
		);

		$display_vars = array(
			'legend1'			=> 'CHAT_MAIN_CONFIG',
			'chat_page_enabled'			=> array('lang' => 'CHAT_PAGE_ENABLED',			'validate' => 'bool',		'type' => 'radio:yes_no'),
			'chat_forum_posts'			=> array('lang' => 'CHAT_FORUM_POSTS',			'type' => 'custom',			'function' => array($this, 'make_select'),	'params' => array($options['forum_posts'], '{KEY}', '{CONFIG_VALUE}')),
			'chat_autoconnect'			=> array('lang' => 'CHAT_AUTOCONNECT',			'validate' => 'bool',		'type' => 'radio:yes_no'),
			'chat_anonymous_allowed'	=> array('lang' => 'CHAT_ANONYMOUS_ALLOWED',	'validate' => 'bool',		'type' => 'radio:yes_no'),
			'chat_sound'				=> array('lang' => 'CHAT_SOUND_ENABLED',		'validate' => 'bool',		'type' => 'radio:yes_no'),
			'chat_flood_time'			=> array('lang' => 'CHAT_FLOOD',				'validate' => 'int:0:60',	'type' => 'number:0:60'),
			'chat_height'				=> array('lang' => 'CHAT_HEIGHT',				'validate' => 'int:50:800',	'type' => 'number:50:800'),
			'chat_refresh'				=> array('lang' => 'CHAT_REFRESH_TIME',			'validate' => 'int:5:60',	'type' => 'number:5:60'),
			'chat_hide_popup'			=> array('lang' => 'CHAT_HIDE_POPUP',			'validate' => 'bool',		'type' => 'radio:yes_no'),

			'legend2'			=> 'CHAT_USERS_CONFIG',
			'chat_timeout'				=> array('lang' => 'CHAT_TIMEOUT',			'validate' => 'int:0:60',	'type' => 'number:0:60'),
			'chat_auto_away'			=> array('lang' => 'CHAT_AUTO_AWAY',		'validate' => 'int:0:60',	'type' => 'number:0:60'),
			'chat_remember_status'		=> array('lang' => 'CHAT_REMEMBER_STATUS',	'validate' => 'bool',		'type' => 'radio:yes_no'),
			'chat_group_users'			=> array('lang' => 'CHAT_GROUP_USERS',		'validate' => 'bool',		'type' => 'radio:yes_no'),
		
			'legend3'			=> 'CHAT_MESSAGES_CONFIG',
			'chat_direction'			=> array('lang' => 'CHAT_DIRECTION',			'validate' => 'string',		'type' => 'custom',	'function' => array($this, 'make_select'),	'params' => array($options['direction'], '{KEY}', '{CONFIG_VALUE}')),
			'chat_max_rows'				=> array('lang' => 'CHAT_ROWS',					'validate' => 'int:1:100',	'type' => 'number:1:100'),
			'chat_max_chars'			=> array('lang' => 'CHAT_CHARS',				'validate' => 'int',		'type' => 'number'),
			'chat_row_align'			=> array('lang' => 'CHAT_ROW_ALIGN',			'type' => 'custom',			'function' => array($this, 'make_select'),	'params' => array($options['row_align'], '{KEY}', '{CONFIG_VALUE}')),
			'chat_row_format'			=> array('lang' => 'CHAT_ROW_FORMAT',			'type' => 'custom',			'function' => array($this, 'make_select'),	'params' => array($options['row_format'], '{KEY}', '{CONFIG_VALUE}')),
			'chat_show_avatars'			=> array('lang' => 'CHAT_AVATARS',				'validate' => 'bool',		'type' => 'radio:yes_no'),
			'chat_allow_bbcode'			=> array('lang' => 'CHAT_ALLOW_BBCODE',			'validate' => 'bool',		'type' => 'radio:yes_no'),
			'chat_disallowed_bbcode'	=> array('lang' => 'CHAT_DISALLOWED_BBCODE',	'type' => 'custom',			'function' => array($this, 'make_select'),	'params' => array($options['disallowed_bbcode'], '{KEY}', '{CONFIG_VALUE}', self::SELECT_PARSE_LANG | self::SELECT_MULTIPLE)),
			'chat_bbcode_format'		=> array('lang' => 'CHAT_BBCODE_FORMAT',		'type' => 'custom',			'function' => array($this, 'make_select'),	'params' => array($options['bbcode_format'], '{KEY}', '{CONFIG_VALUE}')),
		
			'legend4'		=> 'CHAT_PM_CONFIG',
			'chat_allow_pm'			=> array('lang' => 'CHAT_ALLOW_PM',			'validate' => 'bool',			'type' => 'radio:yes_no'),
			'chat_max_pm'			=> array('lang' => 'CHAT_PM_MAX',			'validate' => 'int:0:60',		'type' => 'number:0:60'),
			'chat_pm_maxage'		=> array('lang' => 'CHAT_PM_MAXAGE',		'validate' => 'int:1:365',		'type' => 'number:1:365'),
			'chat_pm_ignore_flood'	=> array('lang' => 'CHAT_PM_IGNORE_FLOOD',	'validate' => 'bool',			'type' => 'radio:yes_no'),
		);
		
		/*
		* @event chat.acp_config_vars
		* @var	array	display_vars	Array of config values to display and process
		* @var	boolean	submit			Do we display the form or process the submission
		* @since 1.1.1
		*/
		$submit = &$this->submit;
		$vars 	= array('display_vars', 'submit');
		extract($this->dispatcher->trigger_event('chat.acp_config_vars', compact($vars)));
		
		$cfg_array	= $this->config;
		
		if($this->submit)
		{
			$cfg_array = utf8_normalize_nfc($this->request->variable('config', array('' => ''), true));
			$cfg_array['chat_disallowed_bbcode'] = $this->request->variable('chat_disallowed_bbcode', array(0));
			
			if(!empty($cfg_array['chat_disallowed_bbcode']))
			{
				$bitfield = new \bitfield();
				
				foreach($cfg_array['chat_disallowed_bbcode'] as $bbcode_id)
				{
					$bitfield->set($bbcode_id);
				}
				
				$cfg_array['chat_disallowed_bbcode'] = $bitfield->get_base64();
			}
			else
			{
				$cfg_array['chat_disallowed_bbcode'] = '';
			}
			
			if(!check_form_key(self::FORM_KEY))
			{
				$error[] = $this->language->lang('FORM_INVALID');
			}
		}

		// We validate the complete config if whished
		validate_config_vars($display_vars, $cfg_array, $error);
		
		// Validate the timeouts
		if($cfg_array['chat_timeout'] && $cfg_array['chat_auto_away'] && $cfg_array['chat_timeout'] <= $cfg_array['chat_auto_away'])
		{
			$error[] = $this->language->lang('CHAT_AUTO_AWAY_ERROR');
		}
		
		// Do not write values if there is an error
		if(sizeof($error))
		{
			$this->submit = false;
		}
		
		// We go through the display_vars to make sure no one is trying to set variables he/she is not allowed to...
		foreach($display_vars as $config_name => $null)
		{
			if(!isset($cfg_array[$config_name]) || strpos($config_name, 'legend') !== false)
			{
				continue;
			}

			$this->new_config[$config_name] = $config_value = $cfg_array[$config_name];

			if($this->submit)
			{
				// Delete the guest sessions is neccessary here
				if($config_name == 'chat_anonymous_allowed' && $this->config['chat_anonymous_allowed'] != $config_value)
				{
					$sql = 'DELETE FROM ' . $this->tables['users'] . '
						WHERE user_id = ' . ANONYMOUS;
					$this->db->sql_query($sql);
				}
				
				$this->config->set($config_name, $config_value);
			}
		}

		if($this->submit)
		{
			$this->cache->destroy('_chat_options');
	
			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_CHAT_CONFIG');
			trigger_error($this->language->lang('CONFIG_UPDATED') . adm_back_link($this->u_action));
		}
		
		// Decode disallowed bbcode's bitfield
		$bitfield = new \bitfield($this->new_config['chat_disallowed_bbcode']);
		$this->new_config['chat_disallowed_bbcode'] = $bitfield->get_all_set();
		
		$this->template->assign_vars(array(
			'S_ERROR'		=> (sizeof($error)) ? true : false,
			'ERROR_MSG'		=> implode('<br />', $error),
		));
		
		$this->display_vars($display_vars);
	}
	
	/**
	 * Get phpBB BBcodes
	 * @return array
	 */
	protected function get_bbcode_options()
	{
		$bbcodes = array(
			'default' 	=> array(
				BBCODE_ID_B		=> 'b',
				BBCODE_ID_I		=> 'i',
				BBCODE_ID_U		=> 'u',
				BBCODE_ID_CODE	=> 'code',
				BBCODE_ID_COLOR	=> 'color',
				BBCODE_ID_IMG	=> 'img',
				BBCODE_ID_LIST	=> 'list',
				BBCODE_ID_QUOTE	=> 'quote',
				BBCODE_ID_SIZE	=> 'size',
				BBCODE_ID_URL	=> 'url'
			),
			'custom'	=> array()
		);
		
		// Custom BBcodes
		$sql = 'SELECT bbcode_id, bbcode_tag
			FROM ' . BBCODES_TABLE . '
			WHERE display_on_posting = 1
			ORDER BY bbcode_tag';
		$result = $this->db->sql_query($sql);
		while($row = $this->db->sql_fetchrow($result))
		{
			$bbcodes['custom'][$row['bbcode_id']] = $row['bbcode_tag'];
		}
		$this->db->sql_freeresult($result);
		
		$ary = array('legend1' => 'DEFAULT_BBCODES');
		
		foreach($bbcodes['default'] as $bbcode_id => $bbcode_tag)
		{
			$ary[$bbcode_id] = ucfirst($bbcode_tag);
		}
		
		if(sizeof($bbcodes['custom']))
		{
			$ary['legend2'] = 'CUSTOM_BBCODES';
			
			foreach($bbcodes['custom'] as $bbcode_id => $bbcode_tag)
			{
				$ary[$bbcode_id] = ucfirst($bbcode_tag);
			}
		}
		
		return $ary;
	}
}
