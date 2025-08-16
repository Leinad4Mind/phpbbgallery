<?php
/**
 * @package cBB Quickquote
 * @version 1.0.3 15/01/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\quickquote\controller;

class admin_controller_config extends \canidev\core\controller\acp
{
	protected $db;
	protected $dispatcher;

	/**
	 * Constructor
	 *
	 * @param \phpbb\db\driver\driver_interface			$db					DB Object
	 * @param \phpbb\event\dispatcher_interface			$dispatcher			Event dispatcher
	 *
	 * @access public
	 */
	public function __construct(
		\phpbb\db\driver\driver_interface $db,
		\phpbb\event\dispatcher_interface $dispatcher)
	{
		$this->db			= $db;
		$this->dispatcher	= $dispatcher;
	}

	/**
	 * Display controller
	 * @param string 	$mode
	 */
	public function display($mode)
	{
		$this->page_header('cbb-quickquote', $this->config['quickquote_version']);

		$this->tpl_name		= 'acp_quickquote_config';
		$this->page_title	= 'ACP_QUICKQUOTE_CONFIG';

		$submit 	= $this->request->is_set_post('submit');
		$form_key 	= 'acp_quickquote';
		$error		= [];
		
		add_form_key($form_key);
		
		$display_vars = [
			'legend1'			=> 'MAIN_OPTIONS',
			'quickquote_floatbtn'			=> ['lang' => 'QUICKQUOTE_FLOATBTN',			'validate' => 'bool',	'type' => 'radio:yes_no'],
			'quickquote_groups'				=> ['lang' => 'QUICKQUOTE_GROUPS',				'type' => 'custom',		'function' => [$this->tools, 'groups_select'],	'params' => ['{KEY}', '{CONFIG_VALUE}', 1]],
			'quickquote_reply_overwrite'	=> ['lang' => 'QUICKQUOTE_REPLY_OVERWRITE',		'validate' => 'bool',	'type' => 'radio:yes_no'],
		];

		/**
		 * @event quickquote.acp_config_vars
		 * @var array	display_vars		Variables to show
		 * @var string	mode				Current mode
		 * @since 1.0.0
		 */
		$vars = ['display_vars', 'mode'];
		extract($this->dispatcher->trigger_event('quickquote.acp_config_vars', compact($vars)));

		$cfg_array 	= $this->config;
		
		if($submit)
		{
			$cfg_array = $this->request->variable('config', ['' => '']);
			$cfg_array['quickquote_groups'] = ($this->request->is_set_post('all_groups_quickquote_groups')) ? 'all' : $this->request->variable('quickquote_groups', [0]);

			// We validate the complete config if whished
			validate_config_vars($display_vars, $cfg_array, $error);
			
			if(!check_form_key($form_key))
			{
				$error[] = $this->language->lang('FORM_INVALID');
			}
		}

		/**
		 * @event quickquote.acp_config_check_vars
		 * @var array	cfg_array		Submitted data
		 * @var bool	submit			Submit status
		 * @var array	error			Array with error messages
		 * @since 1.0.0
		 */
		$vars = ['cfg_array', 'submit', 'error'];
		extract($this->dispatcher->trigger_event('quickquote.acp_config_check_vars', compact($vars)));
		
		$this->new_config = $cfg_array;

		// Do not write values if there is an error
		if(sizeof($error))
		{
			$submit = false;
		}

		// We go through the display_vars to make sure no one is trying to set variables he/she is not allowed to...
		foreach($display_vars as $config_name => $null)
		{
			if(!isset($this->new_config[$config_name]) || strpos($config_name, 'legend') !== false)
			{
				continue;
			}

			if($submit)
			{
				$value = (is_array($this->new_config[$config_name]) ? implode(',', $this->new_config[$config_name]) : $this->new_config[$config_name]);
				$this->config->set($config_name, $value);
			}
		}

		if($submit)
		{
			trigger_error($this->language->lang('CONFIG_UPDATED') . adm_back_link($this->get_form_action()));
		}
		
		$this->template->assign_vars([
			'QUICKQUOTE_IN_ADMIN'	=> true,
			'S_ERROR'				=> (sizeof($error)) ? true : false,
			'ERROR_MSG'				=> implode('<br />', $error),
		]);

		$this->display_vars($display_vars);
	}
}
