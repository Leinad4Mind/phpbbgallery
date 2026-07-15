<?php

/**
 *
 * Topic Index - Attributes. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018 kasimi - https://kasimi.net
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace kasimi\topicindexattributes\event;

use phpbb\textformatter\s9e\renderer;
use phpbb\event\data;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{
	/** @var renderer */
	protected $renderer;

	/**
	 * @param renderer	$renderer
	 */
	public function __construct(
		renderer $renderer
	)
	{
		global $phpbb_container;

		$this->renderer = $renderer;
		$this->container = $phpbb_container;
		$this->manager = $this->container->get('bbprefix.manager');
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

		// Ensure FROM clause contains all tables in comma-separated format
		$sql_array['FROM'] += [BBPREFIX_INSTANCES_TABLE => 'pri', BBPREFIX_TABLE => 'pr'];

		// Combine join conditions into WHERE clause
		if (empty($sql_array['WHERE'])) {
			$sql_array['WHERE'] = 'pri.topic = t.topic_id AND pr.id = pri.prefix';
		} else {
			$sql_array['WHERE'] .= ' AND pri.topic = t.topic_id AND pr.id = pri.prefix';
		}

		// Ensure GROUP BY is set correctly
		$sql_array['GROUP_BY'] = 't.topic_id';

		// Add additional SELECT fields and GROUP_CONCAT
		$sql_array['SELECT'] .= ', pr.id, GROUP_CONCAT(pr.prefix) as prefix';

		// Set ORDER BY clause
		$sql_array['ORDER_BY'] = 't.topic_title ASC';

		$event['sql_array'] = $sql_array;
	}

	/**
	 * @param data $event
	 */
	public function topicindex_sql_fetch_topics_after(data $event)
	{
		$event['array'] = array_merge($event['array'], [
			'prefix'		=> $event['row']['prefix'],
		]);
	}

	/**
	 * @param data $event
	 */
	public function topicindex_modify_block_topic_index_ary(data $event)
	{
		$bbemoji_listener = $this->container->get('sitesplat.bbemoji.listener');
		$topic_title = $bbemoji_listener->render($bbemoji_listener->parse($event['template_vars']['ITOPIC_TITLE']));
		$result = '';
		if(!empty($event['indexdata']['prefix'])) {
			$result = preg_replace('/[ ,]+/', ' ', $this->renderer->render($event['indexdata']['prefix']));
		}
		
		$event['template_vars'] = array_merge($event['template_vars'], [
			'TOPIC_PREFIX'		=> $result
		]);

		$event->update_subarray('template_vars', 'ITOPIC_TITLE', $topic_title);
	}

}
