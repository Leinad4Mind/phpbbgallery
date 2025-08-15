<?php
/**
*
* @package BBnewsletter
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\newsletter\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	protected $controller_helper;
	protected $template;
	protected $user;

	public function __construct(\phpbb\controller\helper $controller_helper, \phpbb\template\template $template, \phpbb\user $user)
	{
		$this->helper		= $controller_helper;
		$this->template		= $template;
		$this->user			= $user;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.page_header'		=> 'add_page_header_link',
		);
	}

	public function add_page_header_link($event)
	{
		$this->user->add_lang_ext('sitesplat/newsletter', 'newsletter');

		$this->template->assign_vars(array(
			'U_NEWSLETTER' => $this->helper->route('sitesplat_newsletter_main_controller', array('route' => 'index')),
		));
	}
}
