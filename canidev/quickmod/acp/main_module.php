<?php
/*
* @name main_module.php
* @package cBB QuickMod
* @version 1.1.0 17/01/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\quickmod\acp;

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
	var $new_config 	= array();
	
	protected $cache;
	protected $config;
	protected $db;
	protected $request;
	protected $template;
	protected $user;
	
	protected $phpbb_root_path;
	protected $php_ext;

	function main($id, $mode)
	{
		global $db, $user, $template, $config, $request, $phpbb_container, $phpbb_dispatcher;
		
		$user->add_lang_ext('canidev/quickmod', array('main'));

		$quickmod 		= $phpbb_container->get('canidev.quickmod.quickmod');
		$compatibility	= $phpbb_container->get('canidev.quickmod.compatibility.manager');
		
		$quickmod->set_stylesheet();

		if(($sources = $compatibility->get_sources()) !== false)
		{
			$template->assign_block_vars_array('qm_additional_source', $sources);
		}

		$action = request_var('action', '');
		$submit = (isset($_POST['submit'])) ? true : false;
	
		$all_actions		= $quickmod->actions;
		$selected_actions	= explode(',', (isset($config['qm_buttons']) ? $config['qm_buttons'] : ''));
		$cfg_array			= (isset($_REQUEST['config'])) ? request_var('config', array('' => '')) : $config;
		$error				= array();

		$display_vars = array(
			'legend1'			=> 'QM_MAIN_CONFIG',
			'qm_confirm'		=> array('lang' => 'QM_CONFIRM',	'validate' => 'bool',	'type' => 'radio:yes_no'),
			'qm_type'			=> array('lang' => 'QM_TYPE',		'validate' => 'string',	'type' => 'select',	'method' => 'make_type_select',	'params' => array('{CONFIG_VALUE}')),
		);
		
		/**
		* Event to add and/or modify configurations
		*
		* @event quickmod.acp_config_vars
		* @var	array	display_vars	Array of config values to display and process
		* @var	boolean	submit			Do we display the form or process the submission
		* @var	array	all_actions		Array with all allowed actions
		* @since 1.1.0
		*/
		$vars = array('display_vars', 'submit', 'all_actions');
		extract($phpbb_dispatcher->trigger_event('quickmod.acp_config_vars', compact($vars)));

		// We validate the complete config if whished
		validate_config_vars($display_vars, $cfg_array, $error);
		
		// Do not write values if there is an error
		if(sizeof($error))
		{
			$submit = false;
		}
		
		// We go through the display_vars to make sure no one is trying to set variables he/she is not allowed to...
		foreach($display_vars as $config_name => $null)
		{
			if (!isset($cfg_array[$config_name]) || strpos($config_name, 'legend') !== false)
			{
				continue;
			}

			$this->new_config[$config_name] = $config_value = $cfg_array[$config_name];

			if($submit)
			{
				$config->set($config_name, $config_value);
			}
		}

		if($submit)
		{
			$new_buttons = request_var('selected_buttons', array(0 => ''));
			
			$config->set('qm_buttons', implode(',', $new_buttons));

			add_log('admin', 'LOG_QUICKMOD_CONFIG');
			trigger_error($user->lang['CONFIG_UPDATED'] . adm_back_link($this->u_action));
		}
		
		// Output relevant page
		foreach($display_vars as $config_key => $vars)
		{
			if(!is_array($vars) && strpos($config_key, 'legend') === false)
			{
				continue;
			}

			if(strpos($config_key, 'legend') !== false)
			{
				$template->assign_block_vars('options', array(
					'S_LEGEND'		=> true,
					'LEGEND'		=> (isset($user->lang[$vars])) ? $user->lang[$vars] : $vars)
				);

				continue;
			}

			$type 		= explode(':', $vars['type']);
			$content 	= build_cfg_template($type, $config_key, $this->new_config, $config_key, $vars);

			if(empty($content))
			{
				continue;
			}

			$template->assign_block_vars('options', array(
				'KEY'			=> $config_key,
				'TITLE'			=> (isset($user->lang[$vars['lang']])) ? $user->lang[$vars['lang']] : $vars['lang'],
				'S_EXPLAIN'		=> (isset($user->lang[$vars['lang'] . '_EXPLAIN'])) ? $user->lang[$vars['lang'] . '_EXPLAIN'] : '',
				'CONTENT'		=> $content,
			));

			unset($display_vars[$config_key]);
		}
	
		$button_row = array(
			'selected'	=> array(),
			'available'	=> array(),
		);
		
		foreach($selected_actions as $action)
		{
			if(!isset($all_actions[$action]))
			{
				continue;
			}
			
			$button_row['selected'][] = $action;
		}
		
		foreach($all_actions as $action => $row)
		{
			if(strpos($action, 'legend') !== false || (isset($row['in_button']) && !$row['in_button']) || in_array($action, $selected_actions))
			{
				continue;
			}
			
			$button_row['available'][] = $action;
		}
		
		foreach($button_row as $block_name => $actions)
		{
			foreach($actions as $action)
			{
				$row = $all_actions[$action];

				// Put block into general template to display
				$template->assign_block_vars($block_name . '_button', array(
					'S_TITLE'		=> $user->lang[$row['lang'] . '_TOPIC'],
					'S_ACTION'		=> $action,
	
					'S_HIDDEN_FIELDS'	=> '<input type="hidden" name="' . $block_name . '_buttons[]" value="' . $action . '" />',
				));
			}
		}

		$this->tpl_name 	= 'acp_quickmod';
		$this->page_title	= 'QM_' . strtoupper($mode) . '_TITLE';

		$template->assign_vars(array(
			'L_TITLE'			=> $user->lang[$this->page_title],
			'L_TITLE_EXPLAIN'	=> $user->lang['QM_' . strtoupper($mode) . '_EXPLAIN'],

			'S_ERROR'			=> (sizeof($error)) ? true : false,
			'ERROR_MSG'			=> implode('<br />', $error),

			'U_ACTION'			=> $this->u_action,
			'U_HELP'			=> 'http://www.canidev.com/docs.php?i=cbb-quickmod-v' . $config['qm_version'],
		));
	}
	
	function make_type_select($select_id)
	{
		global $user;
		
		$options = '';

		$ary = array(
			'icon'		=> 'QM_TYPE_ICON',
			'menu'		=> 'QM_TYPE_MENU',
		);
		
		foreach($ary as $value => $lang)
		{
			$selected = ($value == $select_id) ? ' selected="selected"' : '';
			$options .= '<option value="' . $value . '"' . $selected . '>' . $user->lang[$lang] . '</option>';
		}
		
		return $options;
	}
}
