<?php
/**
*
* @package BBsvg
* @copyright (c) 2017 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\svg\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class bbprenext_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return [
			'sitesplat.bbprenext.generate_prev_next_sql_before'	=> 'modify_sql_query',
			'sitesplat.bbprenext.listener_template_before'		=> 'assign_template'
		];
	}

	protected $template;
	protected $root_path;

	private $done = false;
	public function __construct(\phpbb\template\template $template, $root_path)
	{
		$this->template = $template;
		$this->root_path = $root_path;
	}

	public function modify_sql_query($event)
	{
		$sql_ary = $event['sql_ary'];
		$sql_ary['SELECT'] .= ', f.forum_wt_icon_lock, f.forum_wt_icon_global_unread, f.forum_wt_icon_global_read, f.forum_wt_icon_announce_unread, f.forum_wt_icon_announce_read, f.forum_wt_icon_sticky_unread, f.forum_wt_icon_sticky_read, f.forum_wt_icon_poll_unread, f.forum_wt_icon_poll_read, f.forum_wt_icon_moved_unread, f.forum_wt_icon_moved_read, f.forum_wt_icon_normal_unread, f.forum_wt_icon_normal_read';
		$sql_ary['LEFT_JOIN'][] = [
			'FROM'	=> [FORUMS_TABLE => 'f'],
			'ON'	=> 'f.forum_id = t.forum_id',
		];
		$event['sql_ary'] = $sql_ary;
	}

	public function assign_template($event)
	{
		if ($this->done)
		{
			return;
		}

		$this->template->assign_vars(array(
			'VIEWTOPIC_ICON_LOCK_SRC'				=> ($event['row']['forum_wt_icon_lock']) ? $this->root_path . $event['row']['forum_wt_icon_lock'] : '',
			'VIEWTOPIC_ICON_GLOBAL_UNREAD_SRC'		=> ($event['row']['forum_wt_icon_global_unread']) ? $this->root_path . $event['row']['forum_wt_icon_global_unread'] : '',
			'VIEWTOPIC_ICON_GLOBAL_READ_SRC'		=> ($event['row']['forum_wt_icon_global_read']) ? $this->root_path . $event['row']['forum_wt_icon_global_read'] : '',
			'VIEWTOPIC_ICON_ANNOUNCE_UNREAD_SRC'	=> ($event['row']['forum_wt_icon_announce_unread']) ? $this->root_path . $event['row']['forum_wt_icon_announce_unread'] : '',
			'VIEWTOPIC_ICON_ANNOUNCE_READ_SRC'		=> ($event['row']['forum_wt_icon_announce_read']) ? $this->root_path . $event['row']['forum_wt_icon_announce_read'] : '',
			'VIEWTOPIC_ICON_STICKY_UNREAD_SRC'		=> ($event['row']['forum_wt_icon_sticky_unread']) ? $this->root_path . $event['row']['forum_wt_icon_sticky_unread'] : '',
			'VIEWTOPIC_ICON_STICKY_READ_SRC'		=> ($event['row']['forum_wt_icon_sticky_read']) ? $this->root_path . $event['row']['forum_wt_icon_sticky_read'] : '',
			'VIEWTOPIC_ICON_POLL_UNREAD_SRC'		=> ($event['row']['forum_wt_icon_poll_unread']) ? $this->root_path . $event['row']['forum_wt_icon_poll_unread'] : '',
			'VIEWTOPIC_ICON_POLL_READ_SRC'			=> ($event['row']['forum_wt_icon_poll_read']) ? $this->root_path . $event['row']['forum_wt_icon_poll_read'] : '',
			'VIEWTOPIC_ICON_MOVED_UNREAD_SRC'		=> ($event['row']['forum_wt_icon_moved_unread']) ? $this->root_path . $event['row']['forum_wt_icon_moved_unread'] : '',
			'VIEWTOPIC_ICON_MOVED_READ_SRC'			=> ($event['row']['forum_wt_icon_moved_read']) ? $this->root_path . $event['row']['forum_wt_icon_moved_read'] : '',
			'VIEWTOPIC_ICON_NORMAL_UNREAD_SRC'		=> ($event['row']['forum_wt_icon_normal_unread']) ? $this->root_path . $event['row']['forum_wt_icon_normal_unread'] : '',
			'VIEWTOPIC_ICON_NORMAL_READ_SRC'		=> ($event['row']['forum_wt_icon_normal_read']) ? $this->root_path . $event['row']['forum_wt_icon_normal_read'] : '',
		));
	}
}
