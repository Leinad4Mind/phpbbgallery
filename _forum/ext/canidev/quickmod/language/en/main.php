<?php
/**
* [English [En]]
* @package cBB QuickMod
* @version 1.1.4 01/06/2022
*
* @copyright (c) 2022 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
*/

// DO NOT CHANGE
if(!defined('IN_PHPBB'))
{
	exit;
}

if(empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'APPROVE_TOPIC'			=> 'Approve',
	'CHANGE_ICON'			=> 'Change icon',
	'CHANGE_ICON_TOPIC'		=> 'Change icon',
	'CHANGE_POSTER_TOPIC'	=> 'Change author',
	'CHANGE_TIME_TOPIC'		=> 'Change publish date',
	'DISAPPROVE_TOPIC'		=> 'Disapprove',
	
	'CONFIRM_CHANGE_TOPIC'		=> 'Are you sure you wish to modify the selected topic?',
	'CONFIRM_CHANGE_TOPICS'		=> 'Are you sure you wish to modify the selected topics?',
	'CONFIRM_DELETE_TOPIC'		=> 'Are you sure you wish to delete the selected topic?',
	'CONFIRM_DELETE_TOPICS'		=> 'Are you sure you wish to delete the selected topics?',
	'CONFIRM_LOCK_TOPIC'		=> 'Are you sure you wish to lock the selected topic?',
	'CONFIRM_LOCK_TOPICS'		=> 'Are you sure you wish to lock the selected topics?',
	'CONFIRM_RENAME_TOPIC'		=> 'Are you sure you wish to rename the selected topic?',
	'CONFIRM_RENAME_TOPICS'		=> 'Are you sure you wish to rename the selected topics?',
	'CONFIRM_RESTORE_TOPIC'		=> 'Are you sure you wish to restore the selected topic?',
	'CONFIRM_RESTORE_TOPICS'	=> 'Are you sure you wish to restore the selected topics?',
	'CONFIRM_UNLOCK_TOPIC'		=> 'Are you sure you wish to unlock the selected topic?',
	'CONFIRM_UNLOCK_TOPICS'		=> 'Are you sure you wish to unlock the selected topics?',
	
	'DELETE_TOPIC'				=> 'Delete',
	'DELETE_PERMANENTLY_TOPIC'	=> 'Delete permanently',
	'LOCK_TOPIC'				=> 'Lock',
	'MAKE_ANNOUNCE_TOPIC'		=> 'Change to Announcement',
	'MAKE_GLOBAL_TOPIC'			=> 'Change to Global',
	'MAKE_NORMAL_TOPIC'			=> 'Change to Normal',
	'MAKE_STICKY_TOPIC'			=> 'Change to Sticky',
	
	'MARK_ANNOUNCE'			=> 'Mark Announcements',
	'MARK_BY_STATUS'		=> 'Mark by state',
	'MARK_BY_TYPE'			=> 'Mark by type',
	'MARK_GENERAL'			=> 'General',
	'MARK_GLOBAL'			=> 'Mark global topics',
	'MARK_LOCKED'			=> 'Mark locked topics',
	'MARK_MOVED'			=> 'Mark moved topics',
	'MARK_NORMAL'			=> 'Mark normal topics',
	'MARK_STICKY'			=> 'Mark sticky topics',
	'MARK_TOPICS'			=> 'Mark topics',
	'MARK_UNLOCKED'			=> 'Mark unlocked topics',
	
	'MOVE_TOPIC'			=> 'Move',
	'NO_TOPIC_SELECTED'		=> 'No topic selected',
	'OPTIONS_BASIC'			=> 'Basic Options',
	'OPTIONS_ADVANCED'		=> 'Advanced Options',
	'RENAME_TOPIC'			=> 'Rename',
	'RESTORE_TOPIC'			=> 'Restore',
	'TOPIC_TYPE'			=> 'Topic type',
	'UNLOCK_TOPIC'			=> 'Unlock',

	'ICON'					=> 'Icon',
	'NOTHING'				=> 'There has been no changes',
	'SELECT_ACTION'			=> 'Select action',
	'WITH_SELECTED'			=> 'With selected',

	'AUTHOR_CHANGE_SUCCESS'	=> 'The author of topics has been changed correctly.',
	'TOPIC_RENAMED_SUCCESS'	=> 'The topic has been renamed correctly.',
	
	'CORE_INSTALL_ERROR'	=> 'You have not uploaded all the files from the installation package or you are trying to install an old package.<br />
		Please make sure to upload all the files (including the <em>core</em> folder) and use a package downloaded from the official website.',
));
