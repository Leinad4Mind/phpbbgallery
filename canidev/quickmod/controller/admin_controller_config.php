<?php
/**
 * @package cBB QuickMod
 * @version 1.1.5 20/10/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\quickmod\controller;

class admin_controller_config extends \canidev\core\controller\acp
{
	protected $quickmod;
	protected $dispatcher;
	protected $log;
	protected $request;
	protected $user;

	/**
	 * Constructor
	 *
	 * @param \phpbb\event\dispatcher_interface			$dispatcher			Event dispatcher
	 * @param \phpbb\log\log                       		$log				Log Object
	 * @param \canidev\quickmod\libraries\quickmod 		$quickmod			QuickMod Main Class
	 * @param \phpbb\request\request 					$request			Request object
	 * @param \phpbb\user								$user				User object
	 *
	 * @access public
	 */
	public function __construct(
		\phpbb\event\dispatcher_interface $dispatcher,
		\phpbb\log\log $log,
		\canidev\quickmod\libraries\quickmod $quickmod,
		\phpbb\request\request $request,
		\phpbb\user $user)
	{
		$this->dispatcher	= $dispatcher;
		$this->log			= $log;
		$this->quickmod		= $quickmod;
		$this->request		= $request;
		$this->user 		= $user;
	}

	/**
	 * Display controller
	 * 
	 * @param string 	$mode
	 */
	public function display($mode)
	{
		$this->page_header('cbb-quickmod', $this->config['qm_version']);

		$this->language->add_lang('main', 'canidev/quickmod');

		$action = $this->request->variable('action', '');
		$submit = $this->request->is_set_post('submit');
	
		$all_actions		= $this->quickmod->get_available_tasks(true);
		$selected_actions	= explode(',', $this->config['qm_buttons']);
		$cfg_array			= ($submit) ? $this->request->variable('config', ['' => '']) : $this->config;
		$error				= [];
		
		$type_ary = [
			'icon'		=> 'QM_TYPE_ICON',
			'menu'		=> 'QM_TYPE_MENU',
		];

		$display_vars = [
			'legend1'			=> 'QM_MAIN_CONFIG',
			'qm_confirm'		=> ['lang' => 'QM_CONFIRM',		'validate' => 'bool',	'type' => 'radio:yes_no'],
			'qm_type'			=> ['lang' => 'QM_TYPE',		'validate' => 'string',	'type' => 'custom',			'function' => [$this->tools, 'make_select'],	'params' => [$type_ary, '{KEY}', '{CONFIG_VALUE}']],
		];
		
		/**
		 * @event quickmod.acp_config_vars
		 * @var	array		display_vars	Array of config values to display and process
		 * @var	boolean		submit			Do we display the form or process the submission
		 * @var	array		all_actions		Array with all allowed actions
		 * @since 1.1.0
		 */
		$vars = ['display_vars', 'submit', 'all_actions'];
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
			$new_buttons = $this->request->variable('selected_buttons', [0 => '']);
			
			$this->config->set('qm_buttons', implode(',', $new_buttons));

			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_QUICKMOD_CONFIG');
			trigger_error($this->language->lang('CONFIG_UPDATED') . adm_back_link($this->get_form_action()));
		}
	
		$button_row = [
			'selected'	=> [],
			'available'	=> [],
		];
		
		foreach($all_actions as $action => $task)
		{
			$key = in_array($action, $selected_actions) ? 'selected' : 'available';
			$button_row[$key][] = $action;
		}
		
		foreach($button_row as $block_name => $actions)
		{
			foreach($actions as $action)
			{
				$task = $all_actions[$action];

				// Put block into general template to display
				$this->template->assign_block_vars($block_name . '_button', [
					'S_TITLE'		=> $this->language->lang($task->title),
					'S_ACTION'		=> $action,
					'S_ICON'		=> $task->icon,
	
					'S_HIDDEN_FIELDS'	=> '<input type="hidden" name="' . $block_name . '_buttons[]" value="' . $action . '" />',
				]);
			}
		}

		$this->tpl_name 	= 'acp_quickmod';
		$this->page_title	= 'ACP_QUICKMOD_CONFIG';

		$this->template->assign_vars([
			'QUICKMOD_IN_ADMIN'	=> true,
			'S_ERROR'			=> (sizeof($error)) ? true : false,
			'ERROR_MSG'			=> implode('<br />', $error),
		]);

		$this->display_vars($display_vars);
		
		// Assets
		$this->template->append_asset('css', '@canidev_quickmod/quickmod.css');
		$this->template->append_asset('js', '@canidev_core/js/jquery-ui.min.js');
		$this->template->append_asset('js', '@canidev_quickmod/js/jquickmod.min.js', false, 'admin');
	}
}
