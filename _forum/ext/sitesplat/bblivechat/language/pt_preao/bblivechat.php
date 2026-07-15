<?php
/**
 * BBlivechat
 * @copyright (c) 2021 SiteSplat. All rights reserved.
 * @license Proprietary
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'BBLIVECHAT_SETTINGS'			=> 'Settings',
	'BBLIVECHAT_SETTINGS_EXPLAIN'	=> 'Welcome to the BBlivechat extension! 😍🦄',
	'BBLIVECHAT_ROOMS'				=> 'Configure Rooms',
	'BBLIVECHAT_FEATURES'			=> 'Features',
	'BBLIVECHAT_SOUNDS'				=> 'Sounds',
	'PLAY_SOUND'					=> 'Play sound',
	'NO_SOUND'						=> 'No sound',

	'BBLIVECHAT_INSTALLED'			=> 'BBlivechat has been installed.',
	'BBLIVECHAT_UNINSTALL'			=> 'Uninstall',
	'BBLIVECHAT_UNINSTALL_CONFIRM'	=> 'Are you sure you want to uninstall BBlivechat?',
	'BBLIVECHAT_UNINSTALLED'		=> 'BBlivechat has been uninstalled.',

    // SETTINGS
	'BBLIVECHAT_NA'			        => 'BBlivechat Not Installed',
	'BBLIVECHAT_NA_EXPLAIN'			=> 'BBlivechat must be installed before it can be used. After installation, you will be able to configure the general and room settings. <em><strong>The installation process may take several seconds, so be patient!</strong></em>',
	'BBLIVECHAT_STATUS'			    => 'BBlivechat status',
	'BBLIVECHAT_STATUS_EXPLAIN'		=> '<span>If disabled, only administrators can access BBlivechat</span>',
	
	'BBLIVECHAT_STAND_APP'			=> 'Standalone Application',
	'BBLIVECHAT_STAND_APP_EXPLAIN'	=> '<span>If BBlivechat is a standalone application, it will support more users and have better performance. Otherwise it will use your board\'s overall_header and overall_footer templates and look like any other board page.</span>',
	'BBLIVECHAT_DFLT_ROOM'			=> 'Default room name',
	'BBLIVECHAT_DFLT_BOT'			=> 'Default username for BBlivechat bot messages',
	'BBLIVECHAT_DFLT_BOT_MSG'		=> 'Display room enter/leave messages',
	'BBLIVECHAT_DFLT_BOT_MSG_EXPLAIN'		=> '<span>ChatBot messages when users enter and leave rooms can flood the chatbox display if users change rooms often. If this is an issue, then this option should be disabled. <strong>Note, if this is disabled also the sounds for entering and leaving a room are automatically disabled.</strong></span>',
	
	'BBLIVECHAT_GEN_ANNOUNCE'	    => 'General Announcement',
	'BBLIVECHAT_GEN_ANNOUNCE_EXPLAIN'	    => '<span>HTML enabled. The character limit is 1024, and HTML tags/attributes are counted. <br /><strong>Please make sure the HTML content is SAFE and VALID before submitting!</strong></span>',
	
	'BBLIVECHAT_PVT_ROOM'			=> 'Allow private rooms',
	'BBLIVECHAT_PVT_MSG'			=> 'Allow private messages',
	'BBLIVECHAT_USR_DEL_MSG'		=> 'Allow users to delete their own messages',
	'BBLIVECHAT_AVATARS'			=> 'Display avatars in chatbox messages',
	'BBLIVECHAT_USR_TIME_INACTIVE'			=> 'Minutes until a user is declared inactive',
	'BBLIVECHAT_USR_TIME_INACTIVE_CHECK'			=> 'Interval in minutes to check for inactive users',
	'BBLIVECHAT_USR_TIME_INACTIVE_CHECK_EXPLAIN'			=> '<span>This should be the same as the above</span>',
	'BBLIVECHAT_DFLT_BAN_TIME'			=> 'Default ban time',
	'BBLIVECHAT_DFLT_BAN_TIME_EXPLAIN'			=> '<span>Default time in minutes a user gets banned if an admin/moderator doesn\'t specify a ban time</span>',
	
	
	'BBLIVECHAT_MSGS_REQUEST'		=> 'Maximum number of messages to display on each request',
	'BBLIVECHAT__MSG_INTV_CHCK'			=> 'Interval in seconds to check for new chat messages',
	'BBLIVECHAT__MSG_INTV_CHCK_EXPLAIN'			=> '<span>We suggest an initial value of 10 if you have shared hosting, and 5 if you have a VPS or dedicated server. Please try a few values to determine the best one for your site. However, <strong>the lower you make this number, the greater your risk of server issues!</strong></span>',
	'BBLIVECHAT_MAX_SIM_USRS'			=> 'Maximum number of simultaneous users',
	'BBLIVECHAT_MAX_SIM_USRS_EXPLAIN'			=> '<span>Moderators and administrators will still be able to access BBlivechat if this number is reached. <strong>The higher you make this number, the greater your risk of server issues!</strong></span>',
	'BBLIVECHAT_MAX_CHAR_MSG'			=> 'Maximum number of characters in a submitted message',
	'BBLIVECHAT_MAX_CHAR_MSG_EXPLAIN'			=> '<span>We suggest a value between 256 and 1024</span>',
	'BBLIVECHAT_MAX_MSG_MIN'			=> 'Maximum number of messages a user can send per minute',
	'BBLIVECHAT_SOUND_REC'			=> 'Sound when a message is received',
	'BBLIVECHAT_SOUND_SEND_MSG'			=> 'Sound when user sends a message',
	'BBLIVECHAT_SOUND_ENTER_ROOM'			=> 'Sound when entering a room',
	'BBLIVECHAT_SOUND_LEAVING'			=> 'Sound when leaving a room',
	'BBLIVECHAT_SOUND_SYS_MSG'			=> 'Sound when a system message is displayed',
	'BBLIVECHAT_SOUND_ERRORS'			=> 'Sound when an error occurs',
	
	'BBLIVECHAT_REMOVE'				=> 'Uninstall BBlivechat',
	'BBLIVECHAT_REMOVE_EXPLAIN'		=> '<span>BBlivechat should be uninstalled before updating to a new version. Settings and room configuration will be retained.</span>',

    // ROOMS
	'BBLIVECHAT_ROOMS_EXPLAIN'		=> 'Here is where you setup your chat rooms. BBlivechat does the heavy lifting for you and makes the magic happen. Private rooms, custom CSS, custom room images and much more. Go ahead you can cry of joy now. :-)',
	'REORDER_BUTTON'				=> 'Save new room order',
	'ORDER_DATA_INVALID'			=> 'The submitted room order was invalid. Please try again.',
	'REORDER_SUCCESS'				=> '<span style="color:#2a4">The new room order has been saved.</span>',

	'ROOM'							=> 'Room',
	'NO_ROOMS'						=> 'There are no rooms, yet. Add one right now!',
	'ADD_ROOM'						=> 'Add new room',
	'EDIT_ROOM'						=> 'Edit room',
	'ROOM_NAME'						=> 'Room name',
	'ROOM_NAME_EXPLAIN'				=> 'This is how the room will be displayed to the users.',
	'ROOM_HIDE'						=> 'Hide room if inaccessible',
	'ROOM_HIDE_EXPLAIN'				=> 'Do not display this room in the chatbox if the user does not have permission to access it.',
	'ROOM_DESC'						=> 'Room description',
	'ROOM_DESC_EXPLAIN'				=> 'This will be displayed to the users. keep it short though :)',
	'ROOM_CLASSES'					=> 'Room CSS classes',
	'ROOM_CLASSES_EXPLAIN'			=> 'Here you can specify CSS classes that will be applied to the BBlivechat messages area when this room is active. Then you can use the BBlivechat Custom CSS addon to make your own adjustments. You can also manually add the CSS to your theme\'s custom.css file. For example, you might want to tweak the background, layout, colors etc of the message area for each room. Go nuts! Enjoy the freedom of customization.',
	'ROOM_ANNOUNCEMENT'				=> 'Room announcement',
	'ROOM_ANNOUNCEMENT_EXPLAIN'		=> 'This can be used to present users with an announcement, note, rules, etc.',
	'ROOM_IMAGE'					=> 'Room image',
	'ROOM_IMAGE_EXPLAIN'			=> 'This image will be used to more attractive look of the room in the rooms list.',
	'REMOVE_IMAGE'					=> 'Remove this image',
	'ROOM_GROUPS'					=> 'Groups',
	'ROOM_GROUPS_EXPLAIN'			=> 'Only members of selected groups will be able to see and use this room. Yes Sir, finally private rooms that work :)',
	'ROOM_PURGE'					=> 'Purge messages from room',

	'NAME_REQUIRED'					=> 'The room name is required.',
	'NAME_TOO_LONG'					=> 'The room name is too long.',
	'NAME_ALREADY_TAKEN'			=> 'The room name already exists.',
	'NAME_STARTS_WITH_NUMBER'		=> 'The room name cannot start with a number.',
	'DESC_TOO_LONG'					=> 'The room description is too long.',
	'CLASSES_TOO_LONG'				=> 'The room classes are too long. Maximum of 255 characters is supported.',
	'GROUPS_AT_LEAST_ONE'			=> 'You must select at least one group.',

	'BBLIVECHAT_ROOM_ADDED'			=> 'New room has been added.',
	'BBLIVECHAT_ROOM_EDITED'		=> 'Room has been edited.',
	'BBLIVECHAT_ROOM_CONFIRM'		=> 'Are you sure you want to remove the selected room?',

	// "eed" is correct!
	'BBLIVECHAT_ROOM_DELETEED'		=> 'Room has been removed.',
	'BBLIVECHAT_ROOM_PURGEED'		=> 'Room messages have been purged.',

	'BBLIVECHAT_BAD_LAYOUT'			=> 'Invalid value specified for "Standalone Application"',
	'BBLIVECHAT_ERR_ROOM_REMOVAL'	=> 'The room could not be deleted.',
	'BBLIVECHAT_ERR_IMAGE_REMOVAL'	=> 'The image could not be deleted.',
	'BBLIVECHAT_ERR_MAX_ROOMS'		=> 'BBlivechat supports a maximum of 32 rooms. You cannot add another room unless you first delete a room.',
]);
