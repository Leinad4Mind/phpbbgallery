<?php
/**
 * @package cBB Debugger
 * @version 1.0.1 20/09/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\debugger\controller;

use Symfony\Component\DependencyInjection\ContainerInterface;

class admin_controller extends \canidev\core\controller\acp
{
	protected $container;
	protected $log;
	protected $request;
	protected $user;

	/**
	 * Constructor
	 *
	 * @param ContainerInterface 				$container			Service container interface
	 * @param \phpbb\log\log 					$log				Log Object
	 * @param \phpbb\request\request 			$request			Request object
	 * @param \phpbb\user						$user				User object
	 *
	 * @access public
	 */
	public function __construct(
		ContainerInterface $container,
		\phpbb\log\log $log,
		\phpbb\request\request $request,
		\phpbb\user $user
	)
	{
		$this->container	= $container;
		$this->log			= $log;
		$this->request		= $request;
		$this->user 		= $user;
	}
	
	/**
	 * Display controller
	 */
	public function display()
	{
		$this->page_header('cbb-debugger', $this->config['debugger_version']);

		$this->tpl_name		= 'acp_debugger';
		$this->page_title	= 'ACP_DEBUGGER';
		
		$config 	= \canidev\debugger\libraries\config::instance();
		$submit 	= $this->request->is_set_post('submit');
		$error 		= [];
		$form_key 	= 'acp_debugger';
		
		$this->new_config = $config->get_source();

		$display_vars = [
			'legend1' 		=> 'OPTIONS',
			'debug_enable' 	=> ['lang' => 'DEBUG_ENABLE',		'validate' => 'bool',	'type' => 'radio:yes_no'],
			'show_stats' 	=> ['lang' => 'DEBUG_SHOW_STATS',	'validate' => 'bool',	'type' => 'radio:yes_no'],
			'allowed_ips'	=> ['lang' => 'DEBUG_ALLOWED_IPS',	'validate' => 'string',	'type' => 'textarea:10:20'],
		];

		add_form_key($form_key);

		if($submit)
		{
			$this->new_config = $this->request->variable('config', ['' => '']);

			// We validate the complete config if whished
			validate_config_vars($display_vars, $this->new_config, $error);
			
			if(!check_form_key($form_key))
			{
				$error[] = $this->language->lang('FORM_INVALID');
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
				if($config_name == 'allowed_ips')
				{
					$this->new_config[$config_name] = trim($this->new_config[$config_name]);

					if($this->new_config[$config_name])
					{
						// Normalize
						$this->new_config[$config_name] = str_replace(
							[' ', ','],
							['', "\n"],
							$this->new_config[$config_name]
						);

						$this->new_config[$config_name] = implode("\n", array_filter(explode("\n", $this->new_config[$config_name]), function($value) {
							return !empty($value);
						}));
					}
				}

				$config->set($config_name, $this->new_config[$config_name]);
			}
		}

		if($submit)
		{
			$config->save();

			$this->cache->purge();

			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_DEBUGGER_CONFIG');
			trigger_error($this->language->lang('CONFIG_UPDATED') . adm_back_link($this->form_action));
		}
		
		$this->template->assign_vars([
			'DEBUGGER_IN_ADMIN'		=> true,
			'S_ERROR'				=> !empty($error),
			'ERROR_MSG'				=> implode('<br />', $error),
		]);

		$this->display_vars($display_vars);
	}
}
