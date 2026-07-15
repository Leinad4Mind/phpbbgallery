<?php

/**
* @package   BBemoji
* @copyright (c) 2018 SiteSplat All rights reserved
*/
namespace sitesplat\bbemoji\event;

class bbchat_listener extends listener
{
	public static function getSubscribedEvents()
	{
		return array(
			'sitesplat.bbchatpusher.bbstatus_listener_save_status_before'	=> 'render_status',
			'sitesplat.bbchatpusher.topic_alert_before'						=> 'render_topic_alert',
		);
	}

	public function render_status($event)
	{
		$event['status'] = $this->render($this->parse($event['status']));
	}

	public function render_topic_alert($event)
	{
		$data = $event['data'];
		$data['topic_title'] = $this->render($this->parse($data['topic_title']));
		$event['data'] = $data;
	}
}
