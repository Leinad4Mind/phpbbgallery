<?php
/** 
* main.php [English [En]]
*
* @package language cBB Blockgets
* @version v2.0.0 30/05/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
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
	'BLG_READ_MORE'		=> '%sRead more%s',

	'ACCEPT'				=> 'Accept',
	'ADD_PAGE'				=> 'Create page',
	'CALENDAR'				=> 'Calendar',
	'COPY_TO_LIST'			=> 'Copy to current list',
	'EDIT'					=> 'Edit',
	'EDIT_CONFIGURATION'	=> 'Edit configuration',
	'EDIT_THIS_PAGE'		=> 'Edit this page',
	'EDITOR'				=> 'Editor',
	'EXPAND_CONTRACT'		=> 'Expand/collapse',
	'IMAGE_CLOSE'			=> 'Close',
	'IMAGE_ENLARGE'			=> 'Click to view full size image',
	'INSERT_ON_ENTRY'		=> 'Insert on text',
	'MANAGE_BLOCKS'			=> 'Manage blocks',
	'PRINT'					=> 'Print',
	'SAVE'					=> 'Save',
	'SET_ICON'				=> 'Set icon',
	'SET_IMAGE'				=> 'Set image',
	'SMILIES'				=> 'Emoticons',
	'TODAY'					=> 'Today',
	
	// Image Manager
	'CREATE_SERVER_COPY'	=> 'Create copy on this server',
	'ICON_PREVIEW'			=> 'Icon preview',
	'IMAGE_DESCRIPTION'		=> 'Description',
	'IMAGE_DETAILS'			=> 'Image details',
	'IMAGE_DIMENSIONS'		=> '<#width#> × <#height#> pixels',
	'IMAGE_SAVE_ERROR'		=> 'Could not save image',
	'IMAGE_TITLE'			=> 'Title',
	'IMAGE_URL'				=> 'Url',
	'FILES_DELETED'			=> 'Files deleted',
	'FILES_DRAG'			=> 'Drag and drop files to upload',
	'FILES_DROP'			=> 'Drop files to upload',
	'FILES_REMOVE_CONFIRM'	=> 'You are about to permanently delete the selected files<br />Do you want to continue?',
	'FORMAT_INVALID'		=> 'Invalid format',
	'MAX_FILESIZE'			=> 'Maximum file size: %s.',
	'MEDIA_UPDATED'			=> 'Changes saved',
	'NO_ELEMENTS'			=> 'No elements',
	'PROCCESS'				=> 'Process',
	'SELECT_FILE'			=> 'Select file',
	'SELECT_FILES'			=> 'Select files',
	'SELECTED_COUNT'		=> '<span class="value">0</span> selected',
	'UPDATE'				=> 'Update',
	'UPLOADING_FILES'		=> 'Uploading files...',
	
	'BANNERS'			=> 'Banners',
	'CURRENT_LIST'		=> 'Current list',
	'GALLERY'			=> 'Gallery',
	'ICONS'				=> 'Icons',
	'INSERT_URL'		=> 'Insert from URL',
	'UPLOAD_IMAGE'		=> 'Upload Image',
	
	'ICON_ACCESSIBILITY'	=> 'Accessibility',
	'ICON_BRAND'			=> 'Brand',
	'ICON_CHART'			=> 'Chart',
	'ICON_DIRECTIONAL'		=> 'Directional',
	'ICON_FILE_TYPE'		=> 'File Type',
	'ICON_FORM_CONTROL'		=> 'Form Control',
	'ICON_GENDER'			=> 'Gender',
	'ICON_HAND'				=> 'Hand',
	'ICON_MEDICAL'			=> 'Medical',
	'ICON_PAYMENT'			=> 'Payment and Currency',
	'ICON_SPINNER'			=> 'Spinner',
	'ICON_TEXT_EDITOR'		=> 'Text Editor',
	'ICON_TRANSPORTATION'	=> 'Transportation',
	'ICON_VIDEO_PLAYER'		=> 'Video Player',
	'ICON_WEB_APPLICATION'	=> 'Web Application',

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
	'ATTACH_DATE'				=> '<strong>Published:</strong> %s',
	'ATTACH_SIZE'				=> '<strong>Size:</strong> %s',
	'ATTACH_DOWNLOAD_COUNT'		=> '<strong>Downloaded:</strong> %d time',
	'ATTACH_DOWNLOAD_COUNTS'	=> '<strong>Downloaded:</strong> %d times',
	'ATTACH_VIEWED_COUNT'		=> '<strong>Viewed:</strong> %d time',
	'ATTACH_VIEWED_COUNTS'		=> '<strong>Viewed:</strong> %d times',
	'VIEW_TOPIC'				=> 'View Topic',
	'DOWNLOAD'					=> 'Download',
	'NO_ATTACHMENTS'			=> 'No attachments available',

	// news_block
	'POSTED_BY'			=> 'Posted by',
	'COMMENTS'			=> 'Comments',
	'POLL'				=> 'Poll',
	'TOPIC_VIEWS'		=> 'Views',
	'NO_NEWS'			=> 'No news available',
	'VIEW_COMMENTS'		=> 'View comments',

	// last_replies_block
	'LAST_REPLY_BY'		=> 'Last reply by',
	'COMMENTS'			=> 'Comments',
	'POLL'				=> 'Poll',
	'TOPIC_VIEWS'		=> 'Views',
	'NO_LAST_REPLIES'	=> 'No last replies available',
	'VIEW_COMMENTS'		=> 'View comments',

	// recent_topics_block
	'RECENT_TOPICS'		=> 'Recent topics',
	'RECENT_REPLIES'	=> 'Recent replies',
	'RECENT_ANN'		=> 'Recents announcements',

	'NO_RECENT_TOPICS'	=> 'No recent topics',
	'NO_RECENT_REPLIES'	=> 'No recents replies',
	'NO_RECENT_ANN'		=> 'No recents announcements',

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
	'CONTACT_ERROR'		=> 'An error occurs with your request.',
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
	'TOTAL_STYLES'		=> 'Total styles',
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

	'ALL_GROUPS'		=> 'All groups',
	'EMPTY_EVENT_TITLE'	=> 'You must specify an event title.',
	'EVENT_ADDED'		=> 'Event added successfully',
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
	'PLAYER'			=> 'Player',
	'STOP'				=> 'Stop',
	'STOP_MSG'			=> 'Stopped',
	'VOLUME'			=> 'Volume',
	'VOLUME_MSG'		=> 'Volume: %d%',
	
	// rss block
	'NO_RSS'		=> 'No Rss/Feed to show.',

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
	'EVENT_ERROR'		=> 'The selected event does not exist',
	'GET_FLASH'			=> 'Please download the lastest <a class="blank" href="http://www.adobe.com/go/getflashplayer" rel="nofollow">Flash Player</a> to view this content.',
	'NO_TRACKLIST'		=> 'No avaliable tracklist.',
	'NO_PAGE'			=> 'This page no exists.',
	'URL_INVALID'		=> 'The URL is not valid.',
));
