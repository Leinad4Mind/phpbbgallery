<?php
/*
* @package cBB QuickMod
* @version v1.1.3 16/04/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\quickmod\event;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	protected $quickmod;
	
	/**
	* Constructor
	*
	* @param ContainerInterface 						$container		Service container interface
	* @param \canidev\quickmod\libraries\quickmod 		$quickmod		QuickMod Main Class
	*
	* @access public
	*/
	public function __construct(
		\Symfony\Component\DependencyInjection\ContainerInterface $container,
		\canidev\quickmod\libraries\quickmod $quickmod)
	{
		$this->quickmod	= $quickmod;
		
		\canidev\core\lib::get_instance($container);
	}

	static public function getSubscribedEvents()
	{
		if(!defined('IN_INSTALL'))
		{
			return array(
				'core.user_setup'					=> 'load_language',
				'core.user_setup_after'				=> 'on_setup_after',
				'core.page_footer'					=> 'on_footer',
				'core.viewforum_modify_topics_data'	=> 'obtain_real_topic_ids',
				'core.viewforum_modify_topicrow'	=> 'modify_topic_row',
				'core.search_modify_tpl_ary'		=> 'modify_search_row',
			);
		}

		return array();
	}

	public function load_language($event)
	{
		if(!defined('ADMIN_START'))
		{
			$lang_set_ext = $event['lang_set_ext'];
			$lang_set_ext[] = array(
				'ext_name' => 'canidev/quickmod',
				'lang_set' => 'main',
			);
			$event['lang_set_ext'] = $lang_set_ext;
		}
	}
	
	public function on_setup_after()
	{
		$this->quickmod->setup();
	}
	
	public function on_footer()
	{
		$this->quickmod->display();
	}
	
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
	
	public function modify_topic_row($event)
	{
		$topic_row	= $event['topic_row'];
		$row		= $event['row'];
		
		$topic_forum_id	= ($row['forum_id']) ? (int) $row['forum_id'] : $this->quickmod->forum_id;
		
		$topic_row['QM_CONTENT'] = $this->quickmod->get_row_content($topic_forum_id, $row['orig_topic_id'], $row['topic_type'], $row['topic_status'], $row['topic_visibility']);
		
		$event['topic_row'] = $topic_row;
	}
	
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
