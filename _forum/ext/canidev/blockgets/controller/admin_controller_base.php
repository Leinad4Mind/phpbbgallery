<?php
/*
* @name main_controller.php
* @package cBB Blockgets
* @version v2.0.0 30/05/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\controller;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

use Symfony\Component\DependencyInjection\ContainerInterface;

class admin_controller_base
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
	* @param \canidev\blockgets\libraries\language		$language			Blockgets language Object
	* @param \phpbb\log\log                       		$log				Log Object
	* @param \phpbb\request\request 					$request			Request object
	* @param \canidev\blockgets\libraries\template		$template     		Template object
	* @param \phpbb\user								$user				User object
	* @param string										$root_path			phpBB root path
	* @param string										$php_ext			phpEx
	*
	* @access public
	*/
	public function __construct(\phpbb\cache\driver\driver_interface $cache, \phpbb\config\config $config, ContainerInterface $container, \phpbb\db\driver\driver_interface $db, $phpbb_dispatcher, \canidev\blockgets\libraries\helper $helper, \canidev\blockgets\libraries\helper_acp $helper_acp, \canidev\blockgets\libraries\language $language, \phpbb\log\log $log, \phpbb\request\request $request, \canidev\blockgets\libraries\template $template, \phpbb\user $user, $root_path, $php_ext)
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
		$this->template 	= $template;
		$this->user			= $user;
		
		$this->phpbb_root_path	= $root_path;
		$this->php_ext			= $php_ext;
	}
	
	public function display($mode)
	{
		$this->lang->add('acp', true);
		
		$this->template->assign_vars(array(
			'BLG_IN_ADMIN'		=> true,
			'U_ACTION'			=> $this->u_action,
			'U_HELP'			=> 'https://www.canidev.com/docs.php?i=cbb-blockgets-v' . $this->config['blg_version'],
		));
		
		// Delete the cache in the first call after the installation (prevent error to load extension template events without clear the cache manually)
		if($this->config['blg_asset_check'] != $this->config['assets_version'])
		{
			$this->config->set('blg_asset_check', $this->config['assets_version']);
			$this->cache->purge();
		}
		
		return $this->_display($mode);
	}
	
	public function get_template()
	{
		return $this->tpl_name;
	}
	
	public function get_title()
	{
		return $this->page_title;
	}
}
