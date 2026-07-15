<?php

/**
* @package BBemoji
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*/
namespace sitesplat\bbemoji\event;

class bbtitle_listener extends listener
{
	public static function getSubscribedEvents()
	{
		return array(
			'sitesplat.bbtitle.viewtopic'	=> 'emojify_bbtitle',
			'sitesplat.bbtitle.viewprofile'	=> 'emojify_bbtitle',
			'sitesplat.bbtitle.pm'			=> 'emojify_bbtitle',
		);
	}

	public function emojify_bbtitle($event)
	{
		$event['user_title'] = $this->render($this->parse($event['user_title']));
	}
}
