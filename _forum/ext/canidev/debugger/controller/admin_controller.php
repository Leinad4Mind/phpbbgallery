<?php
/*
* @package cBB Debugger
* @version v1.0.0 21/06/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\debugger\controller;

class admin_controller extends \canidev\core\acp
{
	public $u_action = '';

	protected $cache;
	protected $config;
	protected $container;
	protected $lang;
	protected $log;
	protected $request;
	protected $template;
	protected $user;

	/*
	* Constructor
	*
	* @param \phpbb\cache\driver\driver_interface 		$cache 				Cache instance
	* @param \phpbb\config\config 						$config				Config Object
	* @param ContainerInterface 						$container			Service container interface
	* @param \phpbb\language\language					$language			Language Object
	* @param \phpbb\log\log                       		$log				Log Object
	* @param \phpbb\request\request 					$request			Request object
	* @param \phpbb\user								$user				User object
	*
	* @access public
	*/
	public function __construct(
		\phpbb\cache\driver\driver_interface $cache,
		\phpbb\config\config $config,
		\Symfony\Component\DependencyInjection\ContainerInterface $container,
		\phpbb\language\language $language,
		\phpbb\log\log $log,
		\phpbb\request\request $request,
		\phpbb\user $user
	)
	{
		$this->cache		= $cache;
		$this->config		= $config;
		$this->container	= $container;
		$this->lang			= $language;
		$this->log			= $log;
		$this->request		= $request;
		$this->template 	= \canidev\core\template::get_instance($container);
		$this->user 		= $user;
	}
	
	public function display($mode)
	{
		$this->page_header('cbb-debugger', $this->config['debugger_version']);

		$this->tpl_name		= 'acp_debugger';
		$this->page_title	= 'ACP_DEBUGGER';
		
		$config 	= \canidev\debugger\libraries\config::instance();
		$submit 	= $this->request->is_set_post('submit');
		$error 		= array();
		$form_key 	= 'acp_debugger';
		
		$this->new_config = $config->get_all();

		$display_vars = array(
			'legend1' 		=> 'OPTIONS',
			'debug_enable' 	=> array('lang' => 'DEBUG_ENABLE',		'validate' => 'bool',	'type' => 'radio:yes_no'),
			'show_stats' 	=> array('lang' => 'DEBUG_SHOW_STATS',	'validate' => 'bool',	'type' => 'radio:yes_no'),
		);

		add_form_key($form_key);

		if($submit)
		{
			$this->new_config = $this->request->variable('config', array('' => ''));

			// We validate the complete config if whished
			validate_config_vars($display_vars, $this->new_config, $error);
			
			if(!check_form_key($form_key))
			{
				$error[] = $this->lang->lang('FORM_INVALID');
			}
		}
		
		// Do not write values if there is an error
		if(sizeof($error))
		{
			$submit = false;
		}

		// We go through the display_vars to make sure no one is trying to set variables he/she is not allowed to...
		foreach($display_vars as $config_name => $config_options)
		{
			if(!isset($this->new_config[$config_name]) || strpos($config_name, 'legend') !== false)
			{
				continue;
			}

			if($submit)
			{
				$config->set($config_name, $this->new_config[$config_name]);
			}
		}

		if($submit)
		{
			$config->save();

			$this->cache->purge();

			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_DEBUGGER_CONFIG');
			trigger_error($this->lang->lang('CONFIG_UPDATED') . adm_back_link($this->u_action));
		}
		
		$this->template->assign_vars(array(
			'DEBUGGER_IN_ADMIN'		=> true,
			'S_ERROR'				=> !empty($error),
			'ERROR_MSG'				=> implode('<br />', $error),
		));

		$this->display_vars($display_vars);
	}
}
