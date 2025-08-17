<?php
/**
 *
 * BBsort. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, Sitesplat
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace sitesplat\bbsort\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.viewforum_get_topic_data'	=> 'viewforum_get_topic_data',
		);
	}

	protected $template;
	protected $language;
	protected $root_path;
	protected $php_ext;
	public function __construct(\phpbb\template\template $template, \phpbb\language\language $language, $root_path, $php_ext)
	{
		$this->template = $template;
		$this->language = $language;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	public function viewforum_get_topic_data($event)
	{
		$default_url = "{$this->root_path}viewforum.{$this->php_ext}?f={$event['forum_id']}";
		$this->template->assign_vars(array(
			'L_TITLE'	=> '<a href="' . append_sid($default_url . '&amp;sk=t&amp;sd=' . (($event['sort_dir'] == 'a') ? 'd' : 'a')) . '">' . $this->language->lang('TITLE') . '</a>',
			'L_TOPICS_POSTS_STATISTICS'	=> '<a href="' . append_sid($default_url . '&amp;sk=v&amp;sd=' . (($event['sort_dir'] == 'a') ? 'd' : 'a')) . '">' . $this->language->lang('TOPICS_POSTS_STATISTICS') . '</a>',
			'L_LAST_POST'	=> '<a href="' . append_sid($default_url . '&amp;sk=r&amp;sd=' . (($event['sort_dir'] == 'a') ? 'd' : 'a')) . '">' . $this->language->lang('LAST_POST') . '</a>',
		));
	}
}
