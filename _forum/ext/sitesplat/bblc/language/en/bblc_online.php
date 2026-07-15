<?php
/**
 * BBlivechat Online List Addon
 * @copyright (c) 2021 SiteSplat. All rights reserved.
 * @license Proprietary
 */

if (!defined('IN_PHPBB')) {
	return;
}

if (empty($addon_lang)) {
	$addon_lang = [];
}

$addon_lang = array_merge($addon_lang, [
	'BBLIVECHAT_MSGCOUNT'	=> 'Number of chat messages in the last 24 hours',
	'BBLIVECHAT_CHATTERS'	=> 'Number of members in the chatbox',

	'OL_BOTH'				=> 'Both',
	'OL_NUSERS'				=> 'Count',
	'OL_NULIST'				=> 'Count plus list',
	'OL_MCNT'				=> 'Display online message count',
	'OL_MCNT_EXPLAIN'		=> 'Count of chat messages posted in the last 24 hours',
	'OL_OLST'				=> 'Display online list',
	'OL_OLST_EXPLAIN'		=> 'No online information, a count of online users, or a count plus a list of online users',
	'OL_LFMT'				=> 'Online list format',
	'OL_LFMT_EXPLAIN'		=> 'The online list can include usernames, user avatars, or both',
]);
