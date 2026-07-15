<?php

/**
 * @package BBEmoji
 * @copyright (c) 2016-2022 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbemoji\event;

class bbprenext_listener extends listener
{
	public static function getSubscribedEvents()
	{
		return array(
			'sitesplat.bbprenext.listener_template_before'	=> 'emojify_bbprenext',
		);
	}

	public function emojify_bbprenext($event)
	{
		$tpl_ary = $event['tpl_ary'];
		$tpl_ary[$event['block_name'] . '_TOPIC_TITLE'] = $this->render($this->parse($tpl_ary[$event['block_name'] . '_TOPIC_TITLE']));
		$event['tpl_ary'] = $tpl_ary;
	}
}
