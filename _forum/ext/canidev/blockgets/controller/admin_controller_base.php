<?php
/*
* @package cBB Blockgets
* @version v2.0.2 12/01/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\controller;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class admin_controller_base extends \canidev\core\acp
{
	public $u_action = '';
	public $helper_acp;

	protected $cache;
	protected $config;
	protected $container;
	protected $db;
	protected $dispatcher;
	protected $helper;
	protected $lang;
	protected $log;
	protected $request;
	protected $template;
	protected $user;

	protected $phpbb_root_path;
	protected $php_ext;
	
	protected $page_title;
	protected $tpl_name;
	
	/**
	* Constructor
	*
	* @param \phpbb\cache\driver\driver_interface 		$cache 				Cache instance
	* @param \phpbb\config\config 						$config				Config Object
	* @param ContainerInterface 						$container			Service container interface
	* @param \phpbb\db\driver\driver_interface			$db					DB Object
	* @param \phpbb\event\dispatcher_interface			$phpbb_dispatcher	Event dispatcher
	* @param \canidev\blockgets\libraries\helper		$helper				Blockgets helper Object
	* @param \canidev\blockgets\libraries\helper_acp	$helper_acp			Blockgets ACP helper Object
	* @param \phpbb\language\language					$language			Blockgets language Object
	* @param \phpbb\log\log                       		$log				Log Object
	* @param \phpbb\request\request 					$request			Request object
	* @param \phpbb\user								$user				User object
	* @param string										$root_path			phpBB root path
	* @param string										$php_ext			phpEx
	*
	* @access public
	*/
	public function __construct(
		\phpbb\cache\driver\driver_interface $cache,
		\phpbb\config\config $config,
		\Symfony\Component\DependencyInjection\ContainerInterface $container,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\event\dispatcher_interface $phpbb_dispatcher,
		\canidev\blockgets\libraries\helper $helper,
		\canidev\blockgets\libraries\helper_acp $helper_acp,
		\phpbb\language\language $language,
		\phpbb\log\log $log,
		\phpbb\request\request $request,
		\phpbb\user $user,
		$root_path,
		$php_ext)
	{
		$this->cache		= $cache;
		$this->config		= $config;
		$this->container	= $container;
		$this->db			= $db;
		$this->dispatcher	= $phpbb_dispatcher;
		$this->helper		= $helper;
		$this->helper_acp	= $helper_acp;
		$this->lang			= $language;
		$this->log			= $log;
		$this->request		= $request;
		$this->template 	= \canidev\core\template::get_instance($container);
		$this->user			= $user;
		
		$this->phpbb_root_path	= $root_path;
		$this->php_ext			= $php_ext;
	}
	
	public function display($mode)
	{
		$this->lang->add_lang('acp', 'canidev/blockgets');
		
		$this->page_header('cbb-blockgets', $this->config['blg_version']);
		
		$this->template->assign_vars(array(
			'BLG_IN_ADMIN'		=> true,
		));

		$this->container->get('canidev.blockgets.core')->load_assets();
		
		return $this->_display($mode);
	}
}
