<?php
/**
 * @package cBB Blockgets
 * @version 2.0.6 20/09/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\controller;

use \Symfony\Component\DependencyInjection\ContainerInterface;

abstract class admin_controller_base extends \canidev\core\controller\acp
{
	public $helper_acp;

	protected $container;
	protected $db;
	protected $dispatcher;
	protected $filesystem;
	protected $helper;
	protected $log;
	protected $user;

	protected $phpbb_root_path;
	protected $php_ext;
	protected $tables;
	
	/**
	 * Constructor
	 *
	 * @param ContainerInterface 						$container			Service container interface
	 * @param \phpbb\db\driver\driver_interface			$db					DB Object
	 * @param \phpbb\event\dispatcher_interface			$phpbb_dispatcher	Event dispatcher
	 * @param \phpbb\filesystem\filesystem 				$filesystem 		Filesystem Object
	 * @param \canidev\blockgets\libraries\helper		$helper				Blockgets helper Object
	 * @param \canidev\blockgets\libraries\helper_acp	$helper_acp			Blockgets ACP helper Object
	 * @param \phpbb\log\log                       		$log				Log Object
	 * @param \phpbb\user								$user				User object
	 * @param string									$root_path			phpBB root path
	 * @param string									$php_ext			phpEx
	 * @param array 									$tables 			Blockgets DB Tables
	 *
	 * @access public
	 */
	public function __construct(
		ContainerInterface $container,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\event\dispatcher_interface $phpbb_dispatcher,
		\phpbb\filesystem\filesystem $filesystem,
		\canidev\blockgets\libraries\helper $helper,
		\canidev\blockgets\libraries\helper_acp $helper_acp,
		\phpbb\log\log $log,
		\phpbb\user $user,
		$root_path,
		$php_ext,
		$tables)
	{
		$this->container	= $container;
		$this->db			= $db;
		$this->dispatcher	= $phpbb_dispatcher;
		$this->filesystem 	= $filesystem;
		$this->helper		= $helper;
		$this->helper_acp	= $helper_acp;
		$this->log			= $log;
		$this->user			= $user;
		
		$this->phpbb_root_path	= $root_path;
		$this->php_ext			= $php_ext;
		$this->tables 			= $tables;
	}
	
	/**
	 * Display the controller page
	 * 
	 * @param string $mode
	 */
	public function display($mode)
	{
		$this->language->add_lang('acp', 'canidev/blockgets');
		
		$this->page_header('cbb-blockgets', $this->config['blg_version']);
		
		$this->template->assign_vars([
			'BLG_IN_ADMIN'		=> true,
		]);

		$this->container->get('canidev.blockgets.core')->load_assets();
		
		return $this->_display($mode);
	}

	/**
	 * Do specific work for each controller
	 * 
	 * @param string $mode
	 */
	abstract protected function _display($mode);
}
