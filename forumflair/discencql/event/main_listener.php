<?php

/*
* @package phpBB Extension - Discussion Encouragement With Quick Login
* @copyright (c) 2022, ForumFlair, https://forumflair.co.uk
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace forumflair\discencql\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{
	protected $language;	

	public function __construct(\phpbb\language\language $language)
	{
		$this->language		= $language;
	}

	public static function getSubscribedEvents()
	{
		return array(
			'core.user_setup'	=> 'load_lang',
		);
	}

	public function load_lang()
	{
		$this->language->add_lang('common', 'forumflair/discencql');
	}
}
