<?php

/**
 * @package BBEmoji
 * @copyright (c) 2016-2022 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbemoji\event;

class bbpreview_listener extends listener
{
	public static function getSubscribedEvents()
	{
		return array(
			'sitesplat.bbtpreview.controller_response_before'	=> 'emojify_bbpreview',
		);
	}

	public function emojify_bbpreview($event)
	{
		$row = $event['row'];
		$row['post_subject'] = $this->render($this->parse($row['post_subject']));
		$row['post_text'] = $this->render($row['post_text']);
		$event['row'] = $row;
	}
}
