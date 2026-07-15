<?php

/**
 * @package BBEmoji
 * @copyright (c) 2016-2022 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbemoji\event;

class bblinks_listener extends listener
{
	public static function getSubscribedEvents()
	{
		return array(
			'sitesplat.bblinks.display'	=> 'emojify_bblinks',
		);
	}

	public function emojify_bblinks($event)
	{
		$event['topic_title'] = $this->render($this->parse($event['topic_title']));
	}
}
