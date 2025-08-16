<?php
/** 
* acp.php [English [En]]
* @package cBB Chat
* @version v1.1.2 20/08/2016
*
* @copyright (c) 2016 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
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
	'CHAT_CONFIG_TITLE'		=> 'Configure Chat',
	'CHAT_CONFIG_EXPLAIN'	=> 'Thank you for choosing cBB Chat as a complement to your forum!<br />
		From this page you can modify the main features of the chat.',
	'CHAT_PAGES_TITLE'		=> 'Manage pages',
	'CHAT_PAGES_EXPLAIN'	=> 'From here you can manage the pages that will be load the chat and the position of it.',
	'CHAT_ROOMS_TITLE'		=> 'Manage rooms',
	'CHAT_ROOMS_EXPLAIN'	=> 'From here you can manage the special rooms to be displayed in chat.<br />You can order by dragging rooms to its correct position.',
	'CHAT_TEXTS_TITLE'		=> 'Manage texts and rules',
	'CHAT_TEXTS_EXPLAIN'	=> 'From here you can manage the announcements, tips and rules of the chat.<br />
		To choose the order of texts, drag and drop them to the correct position.',
	
	'CHAT_ALLOW_BBCODE'			=> 'Allow BBcode',
	'CHAT_ALLOW_BBCODE_EXPLAIN'	=> 'Defines whether users can use BBcode tags in the chat.',
	'CHAT_ALLOW_PM'				=> 'Allow private messages',
	'CHAT_ALLOW_PM_EXPLAIN'		=> 'Enable/Disable the private messages between users.',
	'CHAT_AUTOCONNECT'			=> 'Autoconnect',
	'CHAT_AUTOCONNECT_EXPLAIN'	=> 'Sets if the chat autoconnect on page load.',
	'CHAT_AUTO_AWAY'			=> '<em>Available</em> status time',
	'CHAT_AUTO_AWAY_EXPLAIN'	=> 'Defines the timeout (in minutes) after which the status of a user <em><strong>Available</strong></em> switch to <em><strong>Away</strong></em>.<br /><em> Set to 0 to disable this function</em>.',
	'CHAT_AUTO_AWAY_ERROR'		=> 'The time of status change should be less than disconnection time',
	'CHAT_AVATARS'				=> 'Show avatars',
	'CHAT_BBCODE_FORMAT'		=> 'Custom BBCode format',
	'CHAT_BBCODE_FORMAT_EXPLAIN'	=> 'Set the look of the Custom BBcodes in the chat.',
	'CHAT_BBCODE_INBUTTON'		=> 'Buttons',
	'CHAT_BBCODE_INSELECT'		=> 'Selectable menu',
	'CHAT_CHARS'				=> 'Messages characters',
	'CHAT_CHARS_EXPLAIN'		=> 'Maximum number of characters allowed in messages.<br />
		<em>Set 0 to disable this limit</em>.',
	'CHAT_DIRECTION'			=> 'Messages direction',
	'CHAT_DIRECTION_EXPLAIN'	=> 'Sets the order of the messages in the chat.',
	'CHAT_DIRECTION_DOWN'		=> 'Oldest first',
	'CHAT_DIRECTION_UP'			=> 'Newest first',
	'CHAT_DISALLOWED_BBCODE'	=> 'BBcode tags no allowed',
	'CHAT_DISALLOWED_BBCODE_EXPLAIN'	=> 'BBcode tags that will <strong>not</strong> be allowed in the chat.<br />
		You can select multiple tags using the <em>Ctrl</em> key on your keyboard.',
	'CHAT_ENABLED'				=> 'Chat enabled',
	'CHAT_ENABLED_EXPLAIN'		=> 'Enable/Disable all chat functions.',
	'CHAT_FLOOD'				=> 'Flood limit',
	'CHAT_FLOOD_EXPLAIN'		=> 'Sets the time (in seconds) that the users must wait to write a new message.<br />
		<em>Set 0 to disable this limit</em>.',
	'CHAT_FORUM_POSTS'			=> 'Forum posts',
	'CHAT_FORUM_POSTS_EXPLAIN'	=> 'Sets if the new topics or new messajes in the forum will be shown in the <em>General</em> room of the chat.',
	'CHAT_GROUP_USERS'			=> 'Group users by groups',
	'CHAT_GROUP_USERS_EXPLAIN'	=> 'If enabled, the users will be grouped in the chat by their default group.',
	'CHAT_HEIGHT'				=> 'Chat height',
	'CHAT_HEIGHT_EXPLAIN'		=> 'Sets the height (in pixels) of the conversation container.',
	'CHAT_HEIGHT_PAGE'			=> 'Chat height',
	'CHAT_HEIGHT_PAGE_EXPLAIN'	=> 'Set the height (in pixels) of the conversation container in this page.<br /><em>Set 0 to use the default value.</em>',
	'CHAT_HELP'					=> 'Documentation and Support',
	'CHAT_MAIN_CONFIG'			=> 'Main configuration',
	'CHAT_MAX_PM'				=> 'Private messages limit',
	'CHAT_MAX_PM_EXPLAIN'		=> 'Sets the maximum number of private messages that a user can open simultaneously.<br /><em>Set 0 to disable this limit</em>.',
	'CHAT_MESSAGES_CONFIG'		=> 'Message configuration',
	'CHAT_NOTICES_ADD'			=> 'Add announcement',
	'CHAT_NOTICES_EDIT'			=> 'Edit announcement',
	'CHAT_NOTICES_EXPLAIN'		=> 'This texts will be shown as announcements or alerts in the top of chat.',
	'CHAT_NOTICES_ITEM'			=> 'Announcement',
	'CHAT_NOTICES_ITEM_EXPLAIN'	=> 'You can use language variables, for example <em>{L_CHAT}</em>.<br />
		<em>BBcode or HTML is allowed.<br />
		Smilies are allowed.</em>',
	'CHAT_NOTICES_TITLE'		=> 'Announcements',
	'CHAT_PAGE_ALIAS'			=> 'Page ID',
	'CHAT_PAGE_ALIAS_EXPLAIN'	=> 'Sets an unique id for the page that will be used in the configuration file.<br /><em>Only allowed letters and numbers</em>.',
	'CHAT_PAGE_CONFIG'			=> 'Page configuration',
	'CHAT_PAGE_CUSTOM'			=> 'Custom path',
	'CHAT_PAGE_CUSTOM_EXPLAIN'	=> 'Sets the full path (relative to phpBB) of the page.<br />For example: <em>folder/file.php</em>.',
	'CHAT_PAGE_ENABLED'			=> 'Chat page enabled',
	'CHAT_PAGE_ENABLED_EXPLAIN'	=> 'Enable/Disable the main page of the chat.',
	'CHAT_PAGE_FILE'			=> 'Page filename',
	'CHAT_PAGE_FILE_EXPLAIN'	=> 'Sets the file that will be load the chat.',
	'CHAT_PAGE_FORUMS'			=> 'Forums',
	'CHAT_PAGE_FORUMS_EXPLAIN'	=> 'Set the forums where the chat is displayed.<br />You can select as many as you like using the <em>Ctrl</em> key on your keyboard.<br /><em>If you don\'t select any forum the chat show in all.</em> ',
	'CHAT_PM_CONFIG'			=> 'Private message configuration',
	'CHAT_POSITION'				=> 'Chat position',
	'CHAT_POSITION_EXPLAIN'		=> 'Chat position inside the page.',
	'CHAT_POSITION_BOTTOM'		=> 'Bottom',
	'CHAT_POSITION_TOP'			=> 'Top',
	'CHAT_REFRESH_TIME'			=> 'Refresh interval',
	'CHAT_REFRESH_TIME_EXPLAIN'	=> 'Time interval (in seconds) that the chat wait to refresh.',
	'CHAT_REMEMBER_STATUS'		=> 'Remember user status',
	'CHAT_REMEMBER_STATUS_EXPLAIN'	=> 'If enabled, the chat will remember the state of users in new connections, however, users will have the status <em><strong>Available</strong></em> when they connect.',
	'CHAT_ROOM_AUTH'			=> 'Display permissions',
	'CHAT_ROOM_AUTOPURGE'		=> 'Autopurge',
	'CHAT_ROOM_AUTOPURGE_EXPLAIN'	=> 'Define how often all the messages are removed from this room.',
	'CHAT_ROOM_CONFIG'			=> 'Room configuration',
	'CHAT_ROOM_ENABLED'			=> 'Room enabled',
	'CHAT_ROOM_GROUPS'			=> 'Allowed groups',
	'CHAT_ROOM_GROUPS_EXPLAIN'	=> 'Sets groups of users who can use this room.<br />You can select multiple groups using the <em>Ctrl</em> key on your keyboard.',
	'CHAT_ROOM_ADDED'			=> 'The room has been created successfully.',
	'CHAT_ROOM_UPDATED'			=> 'The room configuration was modified successfully.',
	'CHAT_ROOM_MSG_LIMIT'		=> 'Message limit',
	'CHAT_ROOM_MSG_LIMIT_EXPLAIN'	=> 'Sets the maximum number of messages that are stored in this room. If this limit is exceeded, the oldest messages are deleted periodically.
		<br /><em>Set 0 to disable this limit.</em>',
	'CHAT_ROOM_TITLE'			=> 'Room title',
	'CHAT_ROOM_TITLE_EXPLAIN'	=> 'Supports language variables.',
	'CHAT_ROOM_USERS'			=> 'Allowed users',
	'CHAT_ROOM_USERS_EXPLAIN'	=> 'Sets users who can use this room.<br />Set one username per line.',
	'CHAT_ROWS'					=> 'Messages on chat',
	'CHAT_ROWS_EXPLAIN'			=> 'Maximum number of messages that will be shown in the conversation container.',
	'CHAT_RULES_ADD'			=> 'Add rule',
	'CHAT_RULES_EDIT'			=> 'Edit rule',
	'CHAT_RULES_EXPLAIN'		=> 'This texts will be shown as <em>rules</em> in the list of chat rules.',
	'CHAT_RULES_ITEM'			=> 'Rule',
	'CHAT_RULES_ITEM_EXPLAIN'	=> 'You can use language variables, for example <em>{L_CHAT}</em>.<br />
		<em>BBcode or HTML is allowed.<br />
		Smilies are allowed.</em>',
	'CHAT_RULES_TITLE'			=> 'Rules',
	'CHAT_SOUND_ENABLED'		=> 'Sound enabled',
	'CHAT_SHOW_NONE'			=> 'Don\'t show',
	'CHAT_SHOW_POSTS'			=> 'All new posts',
	'CHAT_SHOW_TOPICS'			=> 'Only new topics',
	'CHAT_TIMEOUT'				=> 'Disconnection time',
	'CHAT_TIMEOUT_EXPLAIN'		=> 'Sets the time (in minutes) that the chat need to consider an user to "inactive" and disconnect the chat.<br /><em>Set to 0 to disable this function</em>.',
	'CHAT_TIPS_ADD'				=> 'Add tip',
	'CHAT_TIPS_EDIT'			=> 'Edit tip',
	'CHAT_TIPS_EXPLAIN'			=> 'This texts will be shown as small tips over the chat input field.',
	'CHAT_TIPS_ITEM'			=> 'Tip',
	'CHAT_TIPS_ITEM_EXPLAIN'	=> 'You can use language variables, for example <em>{L_CHAT}</em>.<br />
		<em>BBcode or HTML is allowed.<br />
		Smilies are allowed.</em>',
	'CHAT_TIPS_TITLE'			=> 'Tips',
	'CHAT_USERS_CONFIG'			=> 'User configuration',
	
	'EACH_DAY'		=> 'Each day',
	'EACH_WEEK'		=> 'Each week',
	'EACH_MONTH'	=> 'Each month',
	'EACH_YEAR'		=> 'Each year',
	
	'ADD_ROOM'				=> 'Add room',
	'CONTENT'				=> 'Content',
	'CUSTOM_BBCODES'		=> 'Custom BBcodes',
	'CUSTOM_FILE'			=> 'Custom file',
	'CUSTOM_FILES'			=> 'Custom files',
	'DEFAULT_BBCODES'		=> 'Default BBcodes',
	'FORUM_FILES'			=> 'Forum files',
	'MOD_NOT_INSTALLED'		=> 'Mod not installed correctly',
	'NO_PAGES'				=> 'No available pages',
	'NO_TEXTS'				=> 'No available texts',
	'PAGE_ADD'				=> 'Add page',
	'PAGE_ALIAS'			=> 'Page Id',
	'PAGE_URL'				=> 'Page url',
	'ROOM_TITLE'			=> 'Room title',
	'SELECT_PAGE'			=> 'Select page',
	
	'INVALID_FILE'			=> 'The file not exists or has an invalid format.',
	'NO_ALIAS'				=> 'The page ID is invalid.',
	'PAGE_ALREADY_EXISTS'	=> 'The page is already in use.',
	
	'REMOVE_ROOM_CONFIRM'	=> 'Are you sure you want to delete this room and all messages?',
			
	'CHAT_VERSION_NOT_UP_TO_DATE'	=> 'A newer version of cBB Chat is available.<br />
		Below you will find a link to the publication notice of the latest version and instructions on how to upgrade it.',
));
