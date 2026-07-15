<?php
/*
* @name chat_addon.php
* @package cBB Blockgets
* @version v2.0.0 30/07/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\blocks;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class chat_addon extends base
{
	static $icon = 'blg-icon-comments';

	public function init()
	{
		$this->tpl_name = 'chat_addon';
		
		if(!$this->container->has('canidev.chat.controller') || !$this->config['chat_enabled'])
		{
			return false;
		}

		$this->template->assign_vars(array(
			'CHAT_ADDON_ACTION'		=> $this->helper->route('canidev_chat_controller', array('embed' => 1, 'notitle' => 1)),
			'CHAT_ADDON_HEIGHT'		=> (int)$this->config['chat_height'] + 160,
		));

		return true;
	}
	
	public function check()
	{
		return $this->container->has('canidev.chat.controller');
	}
	
	public function setup()
	{
		$this->lang->add('chat_addon', true);
	}
}
