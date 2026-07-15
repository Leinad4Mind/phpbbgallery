<?php

/**
 *
 * Topic Index - Forum Info. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018 kasimi - https://kasimi.net
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace kasimi\topicindexforuminfo\event;

use phpbb\cache\service;
use phpbb\event\data;
use phpbb\path_helper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{
	/** @var service */
	protected $cache;

	/** @var path_helper */
	protected $path_helper;

	/**
	 * @param service	$cache
	 * @param path_helper		$path_helper
	 */
	public function __construct(
		service $cache,
		path_helper $path_helper
	)
	{
		$this->cache		= $cache;
		$this->path_helper	= $path_helper;
	}

	/**
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return [
			'dmzx.topicindex.sql_fetch_topics_before'		=> 'topicindex_sql_fetch_topics_before',
			'dmzx.topicindex.sql_fetch_topics_after'		=> 'topicindex_sql_fetch_topics_after',
			'dmzx.topicindex.modify_block_topic_index_ary'	=> 'topicindex_modify_block_topic_index_ary',
		];
	}

	/**
	 * @param data $event
	 */
	public function topicindex_sql_fetch_topics_before(data $event)
	{
		$sql_array = $event['sql_array'];

		$sql_array['SELECT'] .= ', f.forum_name, f.forum_image';

		if (empty($sql_array['LEFT_JOIN']))
		{
			$sql_array['LEFT_JOIN'] = [];
		}

		$sql_array['LEFT_JOIN'][] = [
			'FROM'	=> [FORUMS_TABLE => 'f'],
			'ON'	=> 'f.forum_id = t.forum_id',
		];

		$sql_array['SELECT'] .= ', f.forum_name, f.forum_image, t.icon_id';
		$event['sql_array'] = $sql_array;
	}

	/**
	 * @param data $event
	 */
	public function topicindex_sql_fetch_topics_after(data $event)
	{
		$event['array'] = array_merge($event['array'], [
			'forum_name'	=> $event['row']['forum_name'],
			'forum_image'	=> $event['row']['forum_image'],
			'icon_id'		=> $event['row']['icon_id'],
		]);

	}

	/**
	 * @param data $event
	 */
	public function topicindex_modify_block_topic_index_ary(data $event)
	{
		$icons = $this->cache->obtain_icons();
		$icon = !empty($icons[$event['indexdata']['icon_id']]) ? $icons[$event['indexdata']['icon_id']] : '';

		$event['template_vars'] = array_merge($event['template_vars'], [
			'U_FORUM'			=> append_sid($this->path_helper->get_phpbb_root_path() . 'viewforum.' . $this->path_helper->get_php_ext(), 'f=' . $event['indexdata']['forum_id']),
			'FORUM_NAME'		=> $event['indexdata']['forum_name'],
			'FORUM_IMAGE'		=> $this->fix_relative_root_path($event['indexdata']['forum_image']),
			'TOPIC_ICON_IMG'	=> is_array($icon) ? $icon['img'] : '',
			'TOPIC_ICON_ALT'	=> is_array($icon) ? $icon['alt'] : '',
			'TOPIC_ICON_WIDTH'	=> is_array($icon) ? $icon['width'] : '',
			'TOPIC_ICON_HEIGHT'	=> is_array($icon) ? $icon['height'] : '',
		]);
	}

	/**
	 * @param string $url
	 * @return string
	 */
	protected function fix_relative_root_path($url)
	{
		if (substr( $url, 0, 4 ) !== 'http')
		{
			$url = $this->path_helper->update_web_root_path($this->path_helper->get_phpbb_root_path() . $url);
		}

		return $url;
	}
}
