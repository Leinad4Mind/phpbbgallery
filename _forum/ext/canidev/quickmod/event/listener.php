<?php
/*
* @name listener.php
* @package cBB QuickMod
* @version 1.1.0 17/01/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\quickmod\event;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class listener implements EventSubscriberInterface
{
	protected $config;
	protected $container;
	protected $user;
	
	protected $phpbb_root_path;
	protected $php_ext;
	
	protected $quickmod = null;
	
	/**
	* Constructor
	*
	* @param \phpbb\config\config 				$config			Config Object
	* @param ContainerInterface 				$container		Service container interface
	* @param \phpbb\template\template			$template     	Template object
	* @param \phpbb\user						$user			User object
	*
	* @access public
	*/
	public function __construct(\phpbb\config\config $config, ContainerInterface $container, \phpbb\user $user, $root_path, $php_ext)
	{
		$this->config		= $config;
		$this->container	= $container;
		$this->user			= $user;
		
		$this->phpbb_root_path	= $root_path;
		$this->php_ext			= $php_ext;
	}

	static public function getSubscribedEvents()
	{
		if(!defined('IN_INSTALL'))
		{
			global $phpbb_container;

			$events = array(
				'core.user_setup'					=> 'on_setup',
				'core.page_footer'					=> 'on_footer',
				'core.viewforum_modify_topics_data'	=> 'obtain_real_topic_ids',
				'core.viewforum_modify_topicrow'	=> 'modify_topic_row',
				'core.search_modify_tpl_ary'		=> 'modify_search_row',
			);
			
			$compatibility = $phpbb_container->get('canidev.quickmod.compatibility.manager');
			$compatibility->get_core_events();
			
			return $events;
		}

		return array();
	}

	public function on_setup($event)
	{
		$mod_pages = array('viewforum.' . $this->php_ext, 'search.' . $this->php_ext);

		if($this->phpbb_root_path == './' && in_array($this->user->page['page_name'], $mod_pages))
		{
			$this->quickmod = $this->container->get('canidev.quickmod.quickmod');
			$this->quickmod->forum_id = request_var('f', 0);
			$this->quickmod->setup();
		}
		
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
	
	public function on_footer()
	{
		if($this->quickmod !== null)
		{
			$this->quickmod->display();
		}
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
		if($this->quickmod !== null)
		{
			$topic_row	= $event['topic_row'];
			$row		= $event['row'];
			
			$topic_forum_id	= ($row['forum_id']) ? (int) $row['forum_id'] : $this->forum_id;
			
			$topic_row['QM_CONTENT'] = $this->quickmod->get_row_content($topic_forum_id, $row['orig_topic_id'], $row['topic_type'], $row['topic_status'], $row['topic_visibility']);
			
			$event['topic_row'] = $topic_row;
		}
	}
	
	public function modify_search_row($event)
	{
		if($this->quickmod !== null && $event['show_results'] == 'topics')
		{
			$topic_row	= $event['tpl_ary'];
			$row		= $event['row'];
			
			$topic_forum_id	= ($row['forum_id']) ? (int) $row['forum_id'] : $this->forum_id;

			$topic_row['QM_CONTENT'] = $this->quickmod->get_row_content($topic_forum_id, $row['topic_id'], $row['topic_type'], $row['topic_status'], $row['topic_visibility']);
			
			$event['tpl_ary'] = $topic_row;
		}
	}
}