<?php

/**
 *
 * Topic Index - Topic Image Preview. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018 kasimi - https://kasimi.net
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace kasimi\topicindextopicimagepreview\event;

use phpbb\event\data;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use vse\TopicImagePreview\event\listener as tip_listener;

class main_listener implements EventSubscriberInterface
{
	/** @var tip_listener */
	protected $tip_listener;

	/**
	 * @param tip_listener $tip_listener
	 */
	public function __construct(
		tip_listener $tip_listener = null
	)
	{
		$this->tip_listener = $tip_listener;
	}

	/**
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return [
			'dmzx.topicindex.sql_fetch_topics_after'		=> 'update_row_data',
			'dmzx.topicindex.modify_block_topic_index_ary'	=> 'update_tpl_data',
		];
	}

	/**
	 * @param data $event
	 */
	public function update_row_data(data $event)
	{
		if ($this->tip_listener)
		{
			$topic_id = $event['array']['id'];

			$tip_event = new data([
				'topic_list'	=> [$topic_id],
				'rowset'		=> [],
			]);

			$this->tip_listener->update_row_data($tip_event);

			$post_text = isset($tip_event['rowset'][$topic_id]['post_text']) ? $tip_event['rowset'][$topic_id]['post_text'] : '';

			$event->update_subarray('array', 'topic_preview', $post_text);
		}
	}

	/**
	 * @param data $event
	 */
	public function update_tpl_data(data $event)
	{
		if ($this->tip_listener && isset($event['indexdata']['topic_preview']))
		{
			$tip_event = new data([
				'row' 		=> [
					'post_text'	=> $event['indexdata']['topic_preview'],
				],
				'topic_row'	=> [],
			]);

			$this->tip_listener->update_tpl_data($tip_event);

			$topic_images = isset($tip_event['topic_row']['TOPIC_IMAGES']) ? $tip_event['topic_row']['TOPIC_IMAGES'] : '';

			$event->update_subarray('template_vars', 'TOPIC_IMAGES', $topic_images);
		}
	}
}
