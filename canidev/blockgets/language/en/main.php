<?php
/*
* main.php [English [En]]
* @package cBB Blockgets
* @version v2.0.3 26/07/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

if(empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'PORTAL'			=> 'Portal',
	'READ_FULL'			=> 'Read full topic',
	'BLG_OR'			=> 'or',
	'BLG_READ_MORE'		=> '%sRead more%s',

	'ADD_PAGE'					=> 'Create page',
	'BANNERS'					=> 'Banners',
	'CALENDAR'					=> 'Calendar',
	'CALENDAR_BIRTHDAY_TITLE'	=> '%1$s and <strong>%2$d more</strong>.',
	'EDIT_CONFIGURATION'		=> 'Edit configuration',
	'EDIT_THIS_PAGE'			=> 'Edit this page',
	'EDITOR'					=> 'Editor',
	'EXPAND_CONTRACT'			=> 'Expand/collapse',
	'INSERT_ON_ENTRY'			=> 'Insert on text',
	'MANAGE_BLOCKS'				=> 'Manage blocks',
	'PRINT'						=> 'Print',
	'SELECT_COLOUR'				=> 'Select color',
	'SMILIES'					=> 'Emoticons',
	'TODAY'						=> 'Today',

	// Editor
	'HTML_TITLE' 		=> 'Html:',
	'INSERT_HTML' 		=> 'Insert HTML code',

	// Login Block
	'HIDE_ME_NOW'			=> 'Hide me in this session',
	'MY_BOOKMARKS'			=> 'Favorites',
	'MY_SUBSCRIBED'			=> 'Subscriptions',
	'REMEMBER_ME'			=> 'Remember me',

	// Link Us Block
	'LINK_US_TXT'			=> 'Please feel free to link to <strong>%s</strong>. Use the following HTML:',

	// Stats Block and whos_online block
	'GUEST_VISITS_TOTAL'		=> '%d Guests',
	'GUEST_VISIT_TOTAL'			=> '%d Guest',
	'HIDDEN_VISITS_TOTAL'		=> '%d hidden, ',
	'HIDDEN_VISIT_TOTAL'		=> '%d hidden, ',
	'LASTVISIT_VISITS_TOTAL'	=> 'In total there were <strong>%d</strong> users online in the last 24 hours :: ',
	'LASTVISIT_VISIT_TOTAL'		=> 'In total there is <strong>%d</strong> user online in the last 24 hours  :: ',
	'REG_VISITS_TOTAL'			=> '%d Registered, ',
	'REG_VISIT_TOTAL'			=> '%d Registered, ',

	'ST_ACTIVE_POSTERS'			=> 'Active posters',
	'ST_ANNS'					=> 'Announcements',
	'ST_ATTACHMENTS'			=> 'Attachments',
	'ST_BOARD_STARTDATE'		=> 'Start date',
	'ST_NEW'					=> 'New',
	'ST_NEWEST_USER'			=> 'Newest member',
	'ST_POSTS'					=> 'Posts',
	'ST_POSTS_PER_DAY'			=> 'Posts per day',
	'ST_POSTS_PER_TOPIC'		=> 'Posts per topic',
	'ST_POSTS_PER_USER'			=> 'Posts per user',
	'ST_STICKYS'				=> 'Importants',
	'ST_TOP'					=> 'Total',
	'ST_TOPICS'					=> 'Topics',
	'ST_TOPICS_PER_DAY'			=> 'Topics per day',
	'ST_TOPICS_PER_USER'		=> 'Topics per user',
	'ST_TOTAL_USERS'			=> 'Total users',
	'ST_USERS_PER_DAY'			=> 'Users per day',
	'ST_VISIT_IP'				=> 'Your IP',

	'WIO_ONLINE'			=> 'Online users',
	'WIO_LASTDAY'			=> 'Today users',
	'WIO_TOTAL'				=> 'Total',
	'WIO_REGISTERED'		=> 'Registered',
	'WIO_HIDDEN'			=> 'Hidden',
	'WIO_GUEST'				=> 'Guests',

	// polls
	'NO_POLL'			=> 'Poll not available',

	// attachments_block
	'ATTACH_DATE'			=> 'Published',
	'ATTACH_SIZE'			=> 'Size',
	'ATTACH_DOWNLOAD'		=> 'Downloaded',
	'ATTACH_VIEW'			=> 'Viewed',

	'ATTACH_COUNT'				=> array(
		0	=> 'Never',
		1	=> '%d time',
		2	=> '%d times',
	),

	'VIEW_TOPIC'				=> 'View Topic',
	'DOWNLOAD'					=> 'Download',
	'NO_ATTACHMENTS'			=> 'No attachments available',

	// language_select_block
	'LANGUAGE_CHANGE'		=> 'Change language',
	'LANGUAGE_DEFAULT'		=> 'Original language',
	'LANGUAGE_SET_MINE'		=> 'Set as my language',
	'LANGUAGE_SELECT'		=> 'Language select',

	// news_block
	'POSTED_BY'			=> 'Posted by',
	'COMMENTS'			=> 'Comments',
	'POLL'				=> 'Poll',
	'TOPIC_VIEWS'		=> 'Views',
	'NO_NEWS'			=> 'No news available',
	'VIEW_COMMENTS'		=> 'View comments',

	// recent_topics_block
	'BLG_RECENT_ACTIVITY'	=> 'Recent activity',
	'BLG_RECENT_ANN'		=> 'Recent announcements',
	'BLG_RECENT_TOPICS'		=> 'Recent topics',

	// paypal_block
	'AMOUNT_MSG'		=> 'Amount to donate',
	'CLICK_MSG'			=> 'Proceed to donation',
	'CODE_MSG'			=> 'Currency',
	
	'currencies'	=> array(
		'AUD'	=> 'Aussie',
		'CAD' 	=> 'Canadian Dollar',
		'CZK' 	=> 'Czech Koruna',
		'DKK' 	=> 'Danish Kroner',
		'HKD' 	=> 'Hong Kong Dollar',
		'HUF' 	=> 'Hungarian Forint',
		'NZD' 	=> 'New Zealand Dollar',
		'NOK' 	=> 'Norwegian Kroner',
		'PLN' 	=> 'Polish Zlotych',
		'GBP' 	=> 'British Pounds',
		'SGD' 	=> 'Singapore Dollar',
		'SEK' 	=> 'Swedish Kronor',
		'CHF' 	=> 'Swiss Francs',
		'JPY' 	=> 'Japanese Yen',
		'USD' 	=> 'Dollar',
		'EUR' 	=> 'Euro',
		'AUD' 	=> 'Mexican Peso',
		'ILS' 	=> 'New Israeli Shekels'
	),

	// most_poster_block
	'MEMBER_POSTS'		=> '%d (%.2f/day)',
	'USER'				=> 'User',
	'NO_MOST_POSTER'	=> 'No users to display',

	// contact block
	'EMAIL_EMPTY'		=> 'You must set an email.',
	'EMAIL_INVALID'		=> 'The entered email is invalid.',

	// counter block
	'COUNTER_LOCAL'		=> 'Visits to this page',
	'COUNTER_TOTAL' 	=> 'Total visits',
	'COUNTER_STARTDATE' => 'Counting from:<br />%s',
	'HITS_PER_DAY'		=> 'Visits per day',
	'HITS_PER_HOUR'		=> 'Visits per hour',
	'HITS_PER_MONTH'	=> 'Visits per month',
	'HITS_PER_USER'		=> 'Visits per user',
	'HITS_PER_WEEK'		=> 'Visits per week',
	'HITS_PER_YEAR'		=> 'Visits per year',

	// style_select_block
	'STYLE_CHANGE'		=> 'Change Style',
	'STYLE_DEFAULT'		=> 'Original style',
	'STYLE_SET_MINE'	=> 'Set as my style',
	'STYLE_SELECT'		=> 'Select style',

	// latest_bots_block
	'NO_BOTS'			=> 'No bot visited the forum',

	// latest_unread_block
	'NO_UNREAD'			=> 'No topics',

	// ranks_block
	'MIN_POSTS'			=> 'Minimum Posts',
	'SPECIAL_RANK'		=> 'Special Rank',

	// online_friends_block
	'FRIENDS_ONLINE'		=> 'Online friends',
	'FRIENDS_OFFLINE'		=> 'Offline friends',
	'NO_FRIENDS_ONLINE'		=> 'No friends online',
	'NO_FRIENDS_OFFLINE'	=> 'No friends offline',
	'NO_FRIENDS'			=> 'No friends found',

	// age_ranges_block
	'RANGE'				=> 'Rank',
	'RANGE_USERS'		=> 'Users (%)',
	'AGE_COUNTS'		=> 'Counted users',
	'AGE_AV'			=> 'Average age',
	'AGE_AV_COUNT'		=> '%.2f years',

	// search_block
	'SH_ENGINE'			=> 'Search Engines',

	// announcements_block
	'NO_ANNOUNCEMENTS'	=> 'No Announcements',

	//birthday_block
	'TODAY_BIRTHDAYS'		=> 'Today Birthdays',
	'TOMORROW_BIRTHDAYS'	=> 'Tomorrow Birthdays',
	'BIRTHDAYS_FOR'			=> 'Birthdays for %1$s of %2$s',

	// calendar
	'ADD_EVENT'				=> 'Add event',
	'DELETE_EVENT'			=> 'Delete Event',
	'EDIT_EVENT'			=> 'Edit Event',
	'EVENTS'				=> 'Events',

	'EMPTY_EVENT_TITLE'	=> 'You must specify an event title.',
	'EVENT_ADDED'		=> 'Event added successfully',
	'EVENT_COLOR'		=> 'Color',
	'EVENT_EDITED'		=> 'Event edited successfully',
	'EVENT_GROUPS'		=> 'Authorized groups',
	'EVENT_TITLE'		=> 'Event title',
	'EVENT_TIME'		=> 'Event date',
	'EVENT_DETAILS'		=> 'Details',
	'EVENT_REMOVED'		=> 'Events deleted successfully',
	'NO_EVENTS'			=> 'No events',
	
	//player block
	'MUTE'				=> 'Mute',
	'WIN_CLOSE'			=> 'Close window and return to block',
	'WIN_OPEN'			=> 'Open in new window',
	'WIN_OPEN_EXPLAIN'	=> 'Playing in Window',
	'WIN_RETURN'		=> 'Forze player in the block',
	'PLAY'				=> 'Play',
	'PLAY_MSG'			=> 'Playing',
	'PLAYER'			=> 'Player',
	'STOP'				=> 'Stop',
	'STOP_MSG'			=> 'Stopped',
	'VOLUME'			=> 'Volume',
	'VOLUME_MSG'		=> 'Volume: %d%',
	
	// rss block
	'NO_RSS'		=> 'No Rss/Feed to show.',

	// steam block
	'STEAM_IN_GAME'		=> 'Playing',
	'STEAM_ONLINE'		=> 'Online',
	'STEAM_MEMBERS'		=> 'Members',

	// topic index block
	'CHAR_ALL'		=> 'All',
	
	// youtube block
	'YT_EMPTY'		=> 'No videos to show',
	'YT_VIEWS'		=> '%d views',
));

// General messages
$lang = array_merge($lang, array(
	'ACTION_ERROR'		=> 'No action taken',
	'BLOCK_LOAD_ERROR'	=> 'Failed to load block',
	'FORMAT_INVALID'	=> 'The format is not valid',
	'EVENT_ERROR'		=> 'The selected event does not exist',
	'NO_TRACKLIST'		=> 'No avaliable tracklist.',
	'NO_PAGE'			=> 'This page no exists.',
	'URL_INVALID'		=> 'The URL is not valid.',
));
