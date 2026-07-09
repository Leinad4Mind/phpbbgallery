<?php
/**
*
* @package BBsvg
* @copyright (c) 2017 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\svg\migrations;

class m1_forum_icons extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v320\v320');
	}

	public function update_schema()
	{
		return array(
			'add_columns'	=> array(
				$this->table_prefix . 'forums'	=> array(
                    'forum_wf_icon_folder_unread'	=> array('VCHAR', ''),
                    'forum_wf_icon_folder_read'	    => array('VCHAR', ''),
                    'forum_wf_icon_lock'	        => array('VCHAR', ''),
                    'forum_wf_icon_link'	        => array('VCHAR', ''),
                    'forum_wt_icon_lock'	        => array('VCHAR', ''),
                    'forum_wt_icon_global_unread'	=> array('VCHAR', ''),
                    'forum_wt_icon_global_read'	    => array('VCHAR', ''),
                    'forum_wt_icon_announce_unread'	=> array('VCHAR', ''),
                    'forum_wt_icon_announce_read'	=> array('VCHAR', ''),
                    'forum_wt_icon_sticky_unread'	=> array('VCHAR', ''),
                    'forum_wt_icon_sticky_read'	    => array('VCHAR', ''),
                    'forum_wt_icon_poll_unread'	    => array('VCHAR', ''),
                    'forum_wt_icon_poll_read'	    => array('VCHAR', ''),
                    'forum_wt_icon_moved_unread'	=> array('VCHAR', ''),
                    'forum_wt_icon_moved_read'	    => array('VCHAR', ''),
                    'forum_wt_icon_normal_unread'	=> array('VCHAR', ''),
                    'forum_wt_icon_normal_read'	    => array('VCHAR', ''),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns'	=> array(
				$this->table_prefix . 'forums'	=> array(
                    'forum_wf_icon_folder_unread',
                    'forum_wf_icon_folder_read',
                    'forum_wf_icon_lock',
                    'forum_wf_icon_link',
                    'forum_wt_icon_lock',
                    'forum_wt_icon_global_unread',
                    'forum_wt_icon_global_read',
                    'forum_wt_icon_announce_unread',
                    'forum_wt_icon_announce_read',
                    'forum_wt_icon_sticky_unread',
                    'forum_wt_icon_sticky_read',
                    'forum_wt_icon_poll_unread',
                    'forum_wt_icon_poll_read',
                    'forum_wt_icon_moved_unread',
                    'forum_wt_icon_moved_read',
                    'forum_wt_icon_normal_unread',
                    'forum_wt_icon_normal_read',
				),
			),
		);
	}
}