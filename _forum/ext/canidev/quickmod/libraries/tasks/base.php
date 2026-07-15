<?php
/**
 * @package cBB QuickMod
 * @version 1.1.5 20/10/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\quickmod\libraries\tasks;

use \Symfony\Component\DependencyInjection\ContainerInterface;

abstract class base
{
	protected $auth;
	protected $config;
	protected $core;
	protected $db;
	protected $dispatcher;
	protected $language;
	protected $log;
	protected $request;
	protected $response;
	protected $template;
	protected $user;

	protected $phpbb_root_path;
	protected $php_ext;

	public $title = '';

	/**
	 * Constructor
	 * 
	 * @param ContainerInterface 	$container
	 */
	public function __construct(ContainerInterface $container)
	{
		$this->auth 		= $container->get('auth');
		$this->config 		= $container->get('config');
		$this->db 			= $container->get('dbal.conn');
		$this->dispatcher 	= $container->get('dispatcher');
		$this->language 	= $container->get('language');
		$this->request 		= $container->get('request');
		$this->template 	= $container->get('canidev.core.template');
		$this->user 		= $container->get('user');

		$this->phpbb_root_path 	= $container->getParameter('core.root_path');
		$this->php_ext 			= $container->getParameter('core.php_ext');
	}

	/**
	 * Define if the task must be available for single item
	 * @return bool
	 */
	public function available_on_row($topic_type, $topic_status, $topic_visibility)
	{
		return true;
	}

	/**
	 * Execute task
	 * 
	 * @param array 	$topic_ids
	 * @param int 		$forum_id
	 *
	 * @return bool|null|void
	 */
	public abstract function run(array $topic_ids, $forum_id);

	/**
	 * Services loaded only on task run
	 * 
	 * @param ContainerInterface 	$container
	 */
	public function set_run_services($container)
	{
		$this->core 		= $container->get('canidev.core.lib');
		$this->log 			= $container->get('log');
		$this->response 	= \canidev\core\JsonResponse::getInstance();
	}

	/**
	 * Show confirm dialog
	 * 
	 * @param int 		$count 		Item's count
	 * @param string 	$lang_key 	Language key, if not set, task titlle will be used
	 * @return bool
	 */
	public function confirm($count = 1, $lang_key = '')
	{
		$message = 'CONFIRM_' . (($lang_key) ? $lang_key : $this->title) . (($count > 1) ? 'S' : '');

		if(!$this->config['qm_confirm'] || $this->core->modal_dialog(true))
		{
			return true;
		}

		$this->core->modal_dialog(
			false,
			$this->language->lang($message)
		);
		
		return false;
	}
}