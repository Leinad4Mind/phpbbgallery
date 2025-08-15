<?php
/**
*
* BBAwards premium rule PAK.
*
* @copyright (c) 2015 SiteSplat <http://www.sitesplat.com>
* @license SiteSplat 2015 all rights reserved
*
*/

namespace sitesplat\badgepremium\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{

	protected $user;

	public function __construct(\phpbb\user $user)
	{
		$this->user = $user;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'					=> 'add_language',
		);
	}

	public function add_language($event)
	{
		$this->user->add_lang_ext('sitesplat/badgepremium', 'badgepremium');
	}
}
