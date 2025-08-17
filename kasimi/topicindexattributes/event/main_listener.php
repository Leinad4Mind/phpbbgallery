<?php

/**
 *
 * Recent Topics - Attributes. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018 kasimi - https://kasimi.net
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace kasimi\topicindexattributes\event;

use ernadoo\qte\qte;
use phpbb\event\data;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{
	/** @var qte */
	protected $qte;

	/**
	 * @param qte $qte
	 */
	public function __construct(
		qte $qte = null
	)
	{
		$this->qte = $qte;
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
		if ($this->qte)
		{
			$sql_array = $event['sql_array'];
			$sql_array['SELECT'] .= ', topic_attr_id, topic_attr_user, topic_attr_time';
			$event['sql_array'] = $sql_array;
		}
	}

	/**
	 * @param data $event
	 */
	public function topicindex_sql_fetch_topics_after(data $event)
	{
		if ($this->qte)
		{
			$array = $event['array'];
			$array['topic_attr_id'] = $event['row']['topic_attr_id'];
			$array['topic_attr_user'] = $event['row']['topic_attr_user'];
			$array['topic_attr_time'] = $event['row']['topic_attr_time'];
			$event['array'] = $array;
		}
	}

	/**
	 * @param data $event
	 */
	public function topicindex_modify_block_topic_index_ary(data $event)
	{
		if ($this->qte)
		{
			$template_vars = $event['template_vars'];
			$template_vars['TOPIC_ATTRIBUTE'] = $this->qte->attr_display($event['indexdata']['topic_attr_id'], $event['indexdata']['topic_attr_user'], $event['indexdata']['topic_attr_time']);
			$event['template_vars'] = $template_vars;
		}
	}
}
