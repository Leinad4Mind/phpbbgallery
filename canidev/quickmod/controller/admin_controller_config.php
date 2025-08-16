<?php
/*
* @package cBB QuickMod
* @version v1.1.3 16/04/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\quickmod\controller;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class admin_controller_config extends \canidev\core\acp
{
	protected $cache;
	protected $config;
	protected $quickmod;
	protected $dispatcher;
	protected $lang;
	protected $log;
	protected $request;
	protected $template;
	protected $user;

	/**
	* Constructor
	*
	* @param \phpbb\cache\driver\driver_interface 		$cache 				Cache instance
	* @param \phpbb\config\config 						$config				Config Object
	* @param ContainerInterface 						$container			Service container interface
	* @param \phpbb\event\dispatcher_interface			$dispatcher			Event dispatcher
	* @param \phpbb\language\language 					$language			Language object
	* @param \phpbb\log\log                       		$log				Log Object
	* @param \canidev\quickmod\libraries\quickmod 		$quickmod			QuickMod Main Class
	* @param \phpbb\request\request 					$request			Request object
	* @param \phpbb\user								$user				User object
	*
	* @access public
	*/
	public function __construct(
		\phpbb\cache\driver\driver_interface $cache,
		\phpbb\config\config $config,
		\Symfony\Component\DependencyInjection\ContainerInterface $container,
		\phpbb\event\dispatcher_interface $dispatcher,
		\phpbb\language\language $language,
		\phpbb\log\log $log,
		\canidev\quickmod\libraries\quickmod $quickmod,
		\phpbb\request\request $request,
		\phpbb\user $user)
	{
		$this->cache		= $cache;
		$this->config		= $config;
		$this->quickmod		= $quickmod;
		$this->dispatcher	= $dispatcher;
		$this->lang			= $language;
		$this->log			= $log;
		$this->request		= $request;
		$this->template 	= \canidev\core\template::get_instance($container);
		$this->user 		= $user;
	}

	public function display($mode)
	{
		$this->page_header('cbb-quickmod', $this->config['qm_version']);

		$this->lang->add_lang('main', 'canidev/quickmod');

		$action = $this->request->variable('action', '');
		$submit = $this->request->is_set_post('submit');
	
		$all_actions		= $this->quickmod->actions;
		$selected_actions	= explode(',', $this->config->offsetGet('qm_buttons'));
		$cfg_array			= ($submit) ? $this->request->variable('config', array('' => '')) : $this->config;
		$error				= array();
		
		$type_ary = array(
			'icon'		=> 'QM_TYPE_ICON',
			'menu'		=> 'QM_TYPE_MENU',
		);

		$display_vars = array(
			'legend1'			=> 'QM_MAIN_CONFIG',
			'qm_confirm'		=> array('lang' => 'QM_CONFIRM',	'validate' => 'bool',	'type' => 'radio:yes_no'),
			'qm_type'			=> array('lang' => 'QM_TYPE',		'validate' => 'string',	'type' => 'custom',			'function' => array($this, 'make_select'),	'params' => array($type_ary, '{KEY}', '{CONFIG_VALUE}')),
		);
		
		/**
		* @event quickmod.acp_config_vars
		* @var	array	display_vars	Array of config values to display and process
		* @var	boolean	submit			Do we display the form or process the submission
		* @var	array	all_actions		Array with all allowed actions
		* @since 1.1.0
		*/
		$vars = array('display_vars', 'submit', 'all_actions');
		extract($this->dispatcher->trigger_event('quickmod.acp_config_vars', compact($vars)));

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
				$this->config->set($config_name, $config_value);
			}
		}

		if($submit)
		{
			$new_buttons = $this->request->variable('selected_buttons', array(0 => ''));
			
			$this->config->set('qm_buttons', implode(',', $new_buttons));

			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_QUICKMOD_CONFIG');
			trigger_error($this->lang->lang('CONFIG_UPDATED') . adm_back_link($this->u_action));
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
				$this->template->assign_block_vars($block_name . '_button', array(
					'S_TITLE'		=> $this->lang->lang($row['lang'] . '_TOPIC'),
					'S_ACTION'		=> $action,
					'S_ICON'		=> $row['icon'],
	
					'S_HIDDEN_FIELDS'	=> '<input type="hidden" name="' . $block_name . '_buttons[]" value="' . $action . '" />',
				));
			}
		}

		$this->tpl_name 	= 'acp_quickmod';
		$this->page_title	= 'ACP_QUICKMOD_CONFIG';

		$this->template->assign_vars(array(
			'QUICKMOD_IN_ADMIN'	=> true,
			'S_ERROR'			=> (sizeof($error)) ? true : false,
			'ERROR_MSG'			=> implode('<br />', $error),

			'U_ACTION'			=> $this->u_action,
		));

		$this->display_vars($display_vars);
		
		// Assets
		$this->template->append_asset('css', '@canidev_quickmod/../theme/quickmod.css');
		$this->template->append_asset('js', '@canidev_core/js/jquery-ui.min.js');
		$this->template->append_asset('js', '@canidev_quickmod/jquickmod-acp.js', false, 'admin');
	}
}
