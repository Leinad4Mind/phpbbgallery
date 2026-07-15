<?php
/**
*
* common [English]
*
* @package BBsvg
* @copyright (c) 2017 SiteSplat All rights reserved
* @license Proprietary
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'FORUM_ICONS'	                            => 'Forum icons',
	'BBSVG_NOTICE'						        => '<div style="width:80%;margin:20px auto;"><p>The setting for this extension are in <strong>%1$s &#187; %2$s &#187; %3$s</strong>.<br />You can also add SVG for group ranks. <strong>ACP &#187; Users and Groups &#187; Users &#187; Manage ranks</strong>.</p></div>',
	'SS_HELPER_NOTY'	                        => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
    'ACP_BBSVG_FORUMS'	                        => 'Forum administration. Select forum and edit to find the custom Forum icons settings',
	'ACP_BBSVG_FORUMS_EXPLAIN'	                => 'If you need to remove the default gray circle in the forum/topic list you can add the following code to your custom.css:',
	
	'VIEWFORUM_ICON_FOLDER_UNREAD'			    => 'Viewforum unread icon',
	'VIEWFORUM_ICON_FOLDER_UNREAD_EXPLAIN'	    => 'Location, relative to the phpBB root directory, of a normal viewforum unread icon to associate with this forum.',
	'VIEWFORUM_ICON_FOLDER_READ'			    => 'Viewforum read icon',
	'VIEWFORUM_ICON_FOLDER_READ_EXPLAIN'	    => 'Location, relative to the phpBB root directory, of a normal viewforum read icon to associate with this forum.',
	'VIEWFORUM_ICON_LOCK'					    => 'Viewforum locked icon',
	'VIEWFORUM_ICON_LOCK_EXPLAIN'			    => 'Location, relative to the phpBB root directory, of a lock viewforum icon to associate with this forum.',
	'VIEWFORUM_ICON_LINK'					    => 'Viewforum link icon',
	'VIEWFORUM_ICON_LINK_EXPLAIN'			    => 'Location, relative to the phpBB root directory, of a link viewforum icon to associate with this forum.',

	'VIEWTOPIC_ICON_LOCK'						=> 'Viewtopic lock icon',
	'VIEWTOPIC_ICON_LOCK_EXPLAIN'				=> 'Location, relative to the phpBB root directory, of a lock viewtopic icon to associate with this forum.',
	'VIEWTOPIC_ICON_GLOBAL_UNREAD'				=> 'Viewtopic global announcement unread icon',
	'VIEWTOPIC_ICON_GLOBAL_UNREAD_EXPLAIN'		=> 'Location, relative to the phpBB root directory, of a global announcement unread viewtopic icon to associate with this forum.',
	'VIEWTOPIC_ICON_GLOBAL_READ'				=> 'Viewtopic global announcement read icon',
	'VIEWTOPIC_ICON_GLOBAL_READ_EXPLAIN'		=> 'Location, relative to the phpBB root directory, of a global announcement read viewtopic icon to associate with this forum.',
	'VIEWTOPIC_ICON_ANNOUNCE_UNREAD'			=> 'Viewtopic announcement unread icon',
	'VIEWTOPIC_ICON_ANNOUNCE_UNREAD_EXPLAIN'	=> 'Location, relative to the phpBB root directory, of an announcement unread viewtopic icon to associate with this forum.',
	'VIEWTOPIC_ICON_ANNOUNCE_READ'				=> 'Viewtopic announcement read icon',
	'VIEWTOPIC_ICON_ANNOUNCE_READ_EXPLAIN'		=> 'Location, relative to the phpBB root directory, of an announcement read viewtopic icon to associate with this forum.',
	'VIEWTOPIC_ICON_STICKY_UNREAD'				=> 'Viewtopic sticky unread icon',
	'VIEWTOPIC_ICON_STICKY_UNREAD_EXPLAIN'		=> 'Location, relative to the phpBB root directory, of a sticky unread viewtopic icon to associate with this forum.',
	'VIEWTOPIC_ICON_STICKY_READ'				=> 'Viewtopic sticky read icon',
	'VIEWTOPIC_ICON_STICKY_READ_EXPLAIN'		=> 'Location, relative to the phpBB root directory, of a sticky read viewtopic icon to associate with this forum.',
	'VIEWTOPIC_ICON_POLL_UNREAD'				=> 'Viewtopic poll unread icon',
	'VIEWTOPIC_ICON_POLL_UNREAD_EXPLAIN'		=> 'Location, relative to the phpBB root directory, of a poll unread viewtopic icon to associate with this forum.',
	'VIEWTOPIC_ICON_POLL_READ'					=> 'Viewtopic poll read icon',
	'VIEWTOPIC_ICON_POLL_READ_EXPLAIN'			=> 'Location, relative to the phpBB root directory, of a poll read viewtopic icon to associate with this forum.',
	'VIEWTOPIC_ICON_MOVED_UNREAD'				=> 'Viewtopic moved unread icon',
	'VIEWTOPIC_ICON_MOVED_UNREAD_EXPLAIN'		=> 'Location, relative to the phpBB root directory, of a moved unread viewtopic icon to associate with this forum.',
	'VIEWTOPIC_ICON_MOVED_READ'					=> 'Viewtopic moved read icon',
	'VIEWTOPIC_ICON_MOVED_READ_EXPLAIN'			=> 'Location, relative to the phpBB root directory, of a moved read viewtopic icon to associate with this forum.',
	'VIEWTOPIC_ICON_NORMAL_UNREAD'				=> 'Viewtopic unread icon',
	'VIEWTOPIC_ICON_NORMAL_UNREAD_EXPLAIN'		=> 'Location, relative to the phpBB root directory, of a normal unread viewtopic icon to associate with this forum.',
	'VIEWTOPIC_ICON_NORMAL_READ'				=> 'Viewtopic read icon',
	'VIEWTOPIC_ICON_NORMAL_READ_EXPLAIN'		=> 'Location, relative to the phpBB root directory, of a normal read viewtopic icon to associate with this forum.',
));
