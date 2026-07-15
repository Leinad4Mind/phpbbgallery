<?php
/**
 * @package cBB QuickMod
 * @version 1.1.6 01/11/2024
 *
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\quickmod\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	protected $quickmod;
	
	/**
	 * Constructor
	 *
	 * @param \canidev\quickmod\libraries\quickmod 		$quickmod		QuickMod Main Class
	 *
	 * @access public
	 */
	public function __construct(
		\canidev\quickmod\libraries\quickmod $quickmod)
	{
		$this->quickmod	= $quickmod;
	}

	/**
	 * {@inheritDoc}
	 */
	static public function getSubscribedEvents()
	{
		return [
			'core.user_setup'					=> 'load_language',
			'core.user_setup_after'				=> 'on_setup_after',
			'core.page_footer'					=> 'on_footer',
			'core.viewforum_modify_topics_data'	=> 'obtain_real_topic_ids',
			'core.viewforum_modify_topicrow'	=> 'modify_topic_row',
			'core.search_modify_tpl_ary'		=> 'modify_search_row',
		];
	}

	/**
	 * core.user_setup
	 * Load extension language
	 * 
	 * @param \phpbb\event\data 	$event
	 */
	public function load_language($event)
	{
		if(!defined('ADMIN_START'))
		{
			$lang_set_ext = $event['lang_set_ext'];
			$lang_set_ext[] = [
				'ext_name' => 'canidev/quickmod',
				'lang_set' => 'main',
			];
			$event['lang_set_ext'] = $lang_set_ext;
		}
	}
	
	/**
	 * core.user_setup_after
	 * Initialize extension
	 */
	public function on_setup_after()
	{
		if(!defined('ADMIN_START'))
		{
			$this->quickmod->setup();
		}
	}
	
	/**
	 * core.page_footer
	 * Display extension
	 */
	public function on_footer()
	{
		$this->quickmod->display();
	}
	
	/**
	 * core.viewforum_modify_topics_data
	 * Obtain topic IDs
	 * 
	 * @param \phpbb\event\data 	$event
	 */
	public function obtain_real_topic_ids($event)
	{
		$topic_list = $event['topic_list'];
		$rowset		= $event['rowset'];
		
		foreach($topic_list as $topic_id)
		{
			$rowset[$topic_id]['orig_topic_id'] = $topic_id;
		}
		
		$event['rowset'] = $rowset;
	}
	
	/**
	 * core.viewforum_modify_topicrow
	 * Modify topic row on viewtopic
	 * 
	 * @param \phpbb\event\data 	$event
	 */
	public function modify_topic_row($event)
	{
		$topic_row	= $event['topic_row'];
		$row		= $event['row'];
		
		$topic_forum_id	= ($row['forum_id']) ? (int) $row['forum_id'] : $this->quickmod->forum_id;
		
		$topic_row['QM_CONTENT'] = $this->quickmod->get_row_content($topic_forum_id, $row['orig_topic_id'], $row['topic_type'], $row['topic_status'], $row['topic_visibility']);
		
		$event['topic_row'] = $topic_row;
	}
	
	/**
	 * core.search_modify_tpl_ary
	 * Modify topic row on search
	 * 
	 * @param \phpbb\event\data 	$event
	 */
	public function modify_search_row($event)
	{
		if($event['show_results'] == 'topics')
		{
			$topic_row	= $event['tpl_ary'];
			$row		= $event['row'];

			$topic_forum_id	= ($row['forum_id']) ? (int) $row['forum_id'] : $this->quickmod->forum_id;

			$topic_row['QM_CONTENT'] = $this->quickmod->get_row_content($topic_forum_id, $row['topic_id'], $row['topic_type'], $row['topic_status'], $row['topic_visibility']);
			
			$event['tpl_ary'] = $topic_row;
		}
	}
}
