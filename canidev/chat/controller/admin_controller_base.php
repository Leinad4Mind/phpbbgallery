<?php
/**
 * @package cBB Chat
 * @version 1.2.5 20/09/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\chat\controller;

abstract class admin_controller_base extends \canidev\core\controller\acp
{
	const FORM_KEY = 'acp_chat';

	protected $db;
	protected $dispatcher;
	protected $json;
	protected $log;
	protected $request;
	protected $user;

	protected $phpbb_root_path;
	protected $php_ext;
	protected $tables;
	
	protected $action;
	protected $page_title;
	protected $submit;
	protected $tpl_name;
	
	/**
	 * Constructor
	 *
	 * @param \phpbb\db\driver\driver_interface			$db					DB Object
	 * @param \phpbb\event\dispatcher_interface			$dispatcher			Event dispatcher
	 * @param \phpbb\log\log                       		$log				Log Object
	 * @param \phpbb\user								$user				User object
	 * @param string									$root_path			phpBB root path
	 * @param string									$php_ext			phpEx
	 * @param array 									$tables 			Chat DB Tables
	 *
	 * @access public
	 */
	public function __construct(
		\phpbb\db\driver\driver_interface $db,
		\phpbb\event\dispatcher_interface $dispatcher,
		\phpbb\log\log $log,
		\phpbb\user $user,
		$root_path,
		$php_ext,
		$tables)
	{
		$this->db			= $db;
		$this->dispatcher	= $dispatcher;
		$this->json			= \canidev\core\JsonResponse::getInstance();
		$this->log			= $log;
		$this->user			= $user;
		
		$this->phpbb_root_path	= $root_path;
		$this->php_ext			= $php_ext;
		$this->tables 			= $tables;
	}
	
	/**
	 * Display the page
	 * 
	 * @param string 	$mode 		Current mode
	 */
	public function display($mode)
	{
		$this->language->add_lang(['acp', 'main'], 'canidev/chat');
		
		$this->page_header('cbb-chat', $this->config['chat_version']);
		
		$this->template->assign_vars([
			'IN_CHAT_ADMIN'		=> true,
		]);

		// Load assets
		$this->template->append_asset('css', '@canidev_chat/acp.css', false, 'admin');

		$this->template->append_asset(
			'js',
			[
				'@canidev_core/js/jquery-ui.min.js',
				'@canidev_chat/js/jchat.min.js',
				'@canidev_chat/js/jchat-acp.js',
			],
			false,
			'admin'
		);

		// Init controller
		$this->action = $this->request->variable('action', '');
		$this->submit = $this->request->is_set_post('submit');

		return $this->_display($mode);
	}

	/**
	 * Function to execute custom code on display
	 * 
	 * @param string 	$mode 		Current mode
	 */
	abstract protected function _display($mode);
}
