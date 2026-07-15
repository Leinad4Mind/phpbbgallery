<?php

/**
 * @package BBEmoji
 * @copyright (c) 2016-2022 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbemoji\event;

class bbtags_listener extends listener
{
	public static function getSubscribedEvents()
	{
		return array(
			'sitesplat.bbtags.btpreview'	=> 'emojify_bbtags',
		);
	}

	public function emojify_bbtags($event)
	{
		$topic_row = $event['topic_row'];
		$topic_row['LAST_POST_SUBJECT'] = $this->render($this->parse($topic_row['LAST_POST_SUBJECT']));
		$topic_row['TOPIC_TITLE'] = $this->render($this->parse($topic_row['TOPIC_TITLE']));
		$event['topic_row'] = $topic_row;
	}
}
