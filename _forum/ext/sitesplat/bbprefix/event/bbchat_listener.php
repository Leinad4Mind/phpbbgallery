<?php
/**
 *
* @package BBprefix
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
 *
 */

namespace sitesplat\bbprefix\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\DependencyInjection\Container;

class bbchat_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return [
			'sitesplat.bbchatpusher.topic_alert_before'	=> 'apply_on_topic_alert',
		];
	}

	protected $manager;
	public function __construct(\sitesplat\bbprefix\core\manager $manager)
	{
		$this->manager = $manager;
	}

	public function apply_on_topic_alert($event)
	{
		$this->manager->load_prefix_instances(true);

		$topic_id = (int) $event['data']['topic_id'];
		$topic_title = $this->manager->load_prefixes_topic($topic_id, '', true) . $event['topic_title'];
		$event['topic_title'] = $topic_title;
	}
}
