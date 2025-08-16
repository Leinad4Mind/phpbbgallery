<?php
/*
* @name admin_controller_config.php
* @package cBB QuickQuote
* @version 1.0.0 01/03/2018
*
* @copyright (c) 2018 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\quickquote\controller;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

use Symfony\Component\DependencyInjection\ContainerInterface;

class admin_controller_config extends \canidev\core\acp
{
	/**
	* Constructor
	*
	* @param \phpbb\cache\driver\driver_interface 		$cache 				Cache instance
	* @param \phpbb\config\config 						$config				Config Object
	* @param ContainerInterface 						$container			Service container interface
	* @param \phpbb\db\driver\driver_interface			$db					DB Object
	* @param \phpbb\event\dispatcher_interface			$phpbb_dispatcher	Event dispatcher
	* @param \phpbb\request\request 					$request			Request object
	* @param \phpbb\template\template					$template     		Template object
	* @param \phpbb\user								$user				User object
	*
	* @access public
	*/
	public function __construct(\phpbb\cache\driver\driver_interface $cache, \phpbb\config\config $config, ContainerInterface $container, \phpbb\db\driver\driver_interface $db, $phpbb_dispatcher, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user)
	{
		$this->cache		= $cache;
		$this->config		= $config;
		$this->db			= $db;
		$this->dispatcher	= $phpbb_dispatcher;
		$this->lang			= \canidev\core\language::get_instance($container, $user);
		$this->request		= $request;
		$this->template 	= $template;
	}

	public function display($mode)
	{
		$this->page_header('cbb-quickquote', $this->config['quickquote_version']);

		$this->tpl_name		= 'acp_quickquote_config';
		$this->page_title	= $this->lang->get('ACP_CAT_QUICKQUOTE') . ' &bull; ' . $this->lang->get('ACP_QUICKQUOTE_CONFIG');

		$submit 	= $this->request->is_set_post('submit');
		$form_key 	= 'acp_quickquote';
		$error		= array();
		
		add_form_key($form_key);
		
		$display_vars = array(
			'legend1'			=> 'MAIN_OPTIONS',
			'quickquote_floatbtn'		=> array('lang' => 'QUICKQUOTE_FLOATBTN',	'validate' => 'bool',	'type' => 'radio:yes_no'),
			'quickquote_groups'			=> array('lang' => 'QUICKQUOTE_GROUPS',		'type' => 'custom',		'method' => 'helper',	'params' => array('groups_select', '{KEY}', '{CONFIG_VALUE}', 1, 'groups-selector')),
		);

		/**
		* @event quickquote.acp_config_vars
		* @var array	display_vars		Variables to show
		* @var string	mode				Current mode
		* @since 1.0.0
		*/
		$vars = array('display_vars', 'mode');
		extract($this->dispatcher->trigger_event('quickquote.acp_config_vars', compact($vars)));

		$cfg_array 	= $this->config;
		
		if($submit)
		{
			$cfg_array = $this->request->variable('config', array('' => ''));
			$cfg_array['quickquote_groups'] = ($this->request->is_set_post('all_groups_quickquote_groups')) ? 'all' : $this->request->variable('quickquote_groups', array(0));

			// We validate the complete config if whished
			validate_config_vars($display_vars, $cfg_array, $error);
			
			if(!check_form_key($form_key))
			{
				$error[] = $this->lang->get('FORM_INVALID');
			}
		}

		/**
		* @event quickquote.acp_config_check_vars
		* @var array	cfg_array		Submitted data
		* @var boll		submit			Submit status
		* @var array	error			Array with error messages
		* @since 1.0.0
		*/
		$vars = array('cfg_array', 'submit', 'error');
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
			trigger_error($this->lang->get('CONFIG_UPDATED') . adm_back_link($this->u_action));
		}
		
		$this->template->assign_vars(array(
			'QUICKQUOTE_IN_ADMIN'	=> true,
			'L_TITLE'				=> $this->lang->get('ACP_QUICKQUOTE_CONFIG'),
			'L_TITLE_EXPLAIN'		=> $this->lang->get('ACP_QUICKQUOTE_CONFIG_EXPLAIN'),
			
			'S_ERROR'			=> (sizeof($error)) ? true : false,
			'ERROR_MSG'			=> implode('<br />', $error),
		));

		$this->display_vars($display_vars);
	}
}
