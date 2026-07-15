<?php

/**
* @package   BBemoji
* @copyright (c) 2018 SiteSplat All rights reserved
*/
namespace sitesplat\bbemoji\event;

class bbsidebar_linstener extends listener
{
	public static function getSubscribedEvents()
	{
		return array(
			'sitesplat.bbsidebar.type.top_topics_tpl_before'			=> 'emojify_top_topics',
			'sitesplat.bbsidebar.type.last_bbreaction_assign_before'	=> 'emojify_last_bbreaction',
			'sitesplat.bbsidebar.type.hot_topics_tpl_before'			=> 'emojify_hot_topics',
		);
	}

	public function emojify_top_topics($event)
	{
		$event['topic_title'] = $this->render($this->parse($event['topic_title']));
	}

	public function emojify_last_bbreaction($event)
	{
		if ($event['row']['emoji'])
		{
			$tpl_ary = $event['tpl_ary'];
			$tpl_ary['EMOJI'] = $this->render($tpl_ary['EMOJI']);
			$event['tpl_ary'] = $tpl_ary;
		}
	}

	public function emojify_hot_topics($event)
	{
		$tpl_ary = $event['tpl_ary'];
		$tpl_ary['TOPIC_TITLE'] = $this->render($this->parse($tpl_ary['TOPIC_TITLE']));
		$event['tpl_ary'] = $tpl_ary;
	}
}
