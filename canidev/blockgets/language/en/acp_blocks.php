<?php
/*
* [English [En]]
*
* @package cBB Blockgets
* @version v2.0.4 30/08/2021
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

/**
 * @acp_blockgets_pages
*/
$lang = array_merge($lang, array(
	// Blocks global config
	'BLOCK_COLLAPSE'			=> 'Allow collapse the block',
	'BLOCK_COLLAPSE_EXPLAIN'	=> 'Enable or disable the ability for each user to collapse/expand this block and defines its initial state.',
	'BLOCK_ENABLED'				=> 'Block enabled',
	'BLOCK_ENABLED_EXPLAIN'		=> 'Defines whether this block display in the forum.',
 	'BLOCK_CURRENT_ICON'			=> 'Block icon',
	'BLOCK_CURRENT_ICON_EXPLAIN'	=> 'Current icon set to the block.',
	'BLOCK_GROUP'				=> 'Groups',
	'BLOCK_GROUP_EXPLAIN'		=> 'Choose groups who may see this block in the forum.<br />You can select multiple groups using the <em>Ctrl</em> key on your keyboard.',
	'BLOCK_NO_CONFIG'			=> 'This block does not require additional configuration',
	'BLOCK_STYLE'				=> 'Look of the block',
	'BLOCK_STYLE_EXPLAIN'		=> 'With this option you can choose the look of each block individually. Note that the way it is displayed depends on the style installed on the forum and its compatibility with the extension.',
	'BLOCK_TITLE'				=> 'Block title',
	'BLOCK_TITLE_EXPLAIN'		=> 'Unique name for your block.<br />This title will be shown in the block.<br />Limit: 100 characters.',

	// Common tags
	'ALL_FORUMS'				=> 'All forums',
	'COLLAPSE_HIDDEN'			=> 'Allow (collapsed by default)',
	'COLLAPSE_NONE'				=> 'Not Allow',
	'COLLAPSE_VISIBLE'			=> 'Allow (displayed by default)',
	'CONFIG'					=> 'Configuration',
	'DESIGN_FULL'				=> 'Full',
	'DESIGN_SIMPLE'				=> 'Simple',
	'FORUMS'					=> 'Forums',
	'FORUMS_EXPLAIN'			=> 'Forums that contain the topics to show. You can select as many as you like using the <em>Ctrl</em> key on your keyboard.',
	'IGNORE_AUTH'				=> 'Ignore auth',
	'IGNORE_AUTH_EXPLAIN'		=> 'If enabled, will be show all the content ignoring if the user have the permissions to view it.',
	'NO_LISTS'					=> 'No avaliable lists',
	'SHOW_PAGINATION'			=> 'Show pagination',
	'SHOW_PAGINATION_EXPLAIN'	=> 'Show the pagination to allow user to view older posts.',
	'TITLE_LIMIT'				=> 'Title limit',
	'TITLE_LIMIT_EXPLAIN'		=> 'Maximum number of characters that will be displayed in the topic titles.<br />
		<em>Set 0 to show the full title.</em>',
	'TOPIC_DESIGN'				=> 'Block design',
	'TOPIC_DESIGN_EXPLAIN'		=> 'Determine how the topics will be displayed in the block.<br />
		<em><strong>Full:</strong> Show all information whenever possible.</em><br />
		<em><strong>Simple:</strong> Show only basic information.</em>',
	'TOPIC_PARENT_SHOW'			=> 'Show parent forum',
	'TOPIC_PARENT_SHOW_EXPLAIN'	=> 'If enabled, a link to the forum for each topic will be displayed.',
	
	// age_ranges_block
	'AGE_START'					=> 'Minimum age',
	'AGE_END'					=> 'Maximum age',
	'AGE_INTERVAL'				=> 'Interval',
	
	// announcements_block
	'ANN_MAX_NUMBER'			=> 'Announcements number',
	'ANN_MAX_NUMBER_EXPLAIN'	=> 'Maximum number of announcements that are displayed within the block.',
	'ANN_MAX_SIZE'				=> 'Announcement size',
	'ANN_MAX_SIZE_EXPLAIN'		=> 'Maximum size of characters allowed in announcements. The text is cut off if this value exceeds.',
	'ANN_SHOW_GLOBALS'			=> 'Show global announcements',
	'ANN_SHOW_GLOBALS_EXPLAIN'	=> 'If enabled, you also read the items marked as "global", otherwise only read simple announcements.',
	'ANN_COLLAPSE'				=> 'Collapse announcements',
	'ANN_COLLAPSE_EXPLAIN'		=> 'If enabled, the block only show one announcement and collapse the rest. Otherwise, the announcements will appear all at once on the block.',
	
	// attachments_block
	'ATTACH_FORUM'				=> 'Forum attachments',
	'ATTACH_FORUM_EXPLAIN'		=> 'If specified, only display attachments from this forum ignoring the rest.<br />The forum should be directly containing the topic where the attachment, the above categories or forums are ignored here.',
	'ATTACH_EXTENSION'			=> 'Attachment extensions',
	'ATTACH_EXTENSION_EXPLAIN'	=> 'If specified, all attachments which do not contain this extensions will be ignored.<br />Split the extensions with ",".<<br />Ex. valid extensions: jpg,png,gif...',
	'ATTACH_NUM'				=> 'Attachment number',
	'ATTACH_NUM_EXPLAIN'		=> 'Maximum number of attachments that are displayed simultaneously in the block.',
	'ATTACH_SPECIFIC'			=> 'Specific attachment',
	'ATTACH_SPECIFIC_EXPLAIN'	=> 'If specified, only attachment with the specified name will be show in the block. The field must contain the original filename of the attachment, Ex: myfile.jpg<br /><br /><strong>Note:</strong> this field overrides the other fields.',

	// banners_block, banners_multiple_block
	'BANNERS_TITLE'				=> 'Banner title',
	'BANNERS_TITLE_EXPLAIN'		=> 'If enabled, the title will be appear below the banners in the block.',
	'BANNERS_LS_TYPE'			=> 'List type',
	'BANNERS_LS_TYPE_EXPLAIN'	=> 'Define how to display the banners.<br />Can be set a horizontal, vertical scroll or remain fixed.',
	'BANNERS_NUMBER'			=> 'Banners to show',
	'BANNERS_NUMBER_EXPLAIN'	=> 'Maximum number of banners to display on the block.<br />
		<em>Set 0 to show all the list.</em>',
	'BANNERS_RANDOM'			=> 'Random order',
	'BANNERS_RANDOM_EXPLAIN'	=> 'Set if the elements will be show in the list order or in a random order.',
	'LIST_NO_SCROLL'			=> 'No Scroll',
	'LIST_SCROLL_H'				=> 'Horizontal scroll',
	'LIST_SCROLL_V'				=> 'Vertical scroll',
	'BANNERS_B_HEIGHT'			=> 'Block height',
	'BANNERS_B_HEIGHT_EXPLAIN'	=> 'Enter the height of the block that will be used to scroll lists.',

	// birthdays_block
 	'NEXT_BIRTHDAYS'			=> 'Upcoming Birthdays',
 	'NEXT_BIRTHDAYS_EXPLAIN'	=> 'Show birthdays that occur in the coming days.<br />
 		<em>Maximum 30 days. Set to 0 to disable it.</em>',

	// calendar_block
 	'CALENDAR_BIRTHDAYS'			=> 'Show Birthdays',
 	'CALENDAR_BIRTHDAYS_EXPLAIN'	=> 'If enabled, the users birthdays are marked and displayed in the calendar, like events.',
 	'CALENDAR_EVENTS'				=> 'Show events',
 	'CALENDAR_EVENTS_EXPLAIN'		=> 'If enabled, events are marked and displayed in the calendar.',
 	'CALENDAR_MONTHS'				=> 'Months to show',
 	'CALENDAR_MONTHS_EXPLAIN'		=> 'Number of months to be displayed simultaneously on the block.',

	// contact block
	'CONTACT_CHECK_EMAIL'			=> 'Check email',
	'CONTACT_CHECK_EMAIL_EXPLAIN'	=> 'If enabled, the domain of the user email will be checked and validated.',
	'CONTACT_EMAIL'					=> 'Target email',
	'CONTACT_HIDE_FIELDS'			=> 'Hide user data',
	'CONTACT_HIDE_FIELDS_EXPLAIN'	=> 'If enabled, the "Name" and "Email" fields for the register users will be hidden and the block will be used their profile values.',
 
	// countdown block
	'COUNTDOWN_COMPLETE_MSG'			=> 'Text upon completion',
	'COUNTDOWN_COMPLETE_MSG_EXPLAIN'	=> 'Text to be displayed when the counter reaches 0.',
	'COUNTDOWN_TARGET'					=> 'Deadline',
	'COUNTDOWN_TARGET_EXPLAIN'			=> 'Set the date and time the counter will reach 0.<br /><br />
		<em><strong>Valid formats</strong>
			<br />Year/Month/Day
			<br />Year/Month/Day Hour:Minute:Second
		</em>',
	'COUNTDOWN_RUNNING_MSG'				=> 'Hold text',
	'COUNTDOWN_RUNNING_MSG_EXPLAIN'		=> 'Text to be displayed while the counter is running.',

	// counter block
	'COUNTER_LOCAL'				=> 'Local counter',
	'COUNTER_LOCAL_EXPLAIN'		=> 'If enabled, the counter only show the visits to it\'s page, otherwise, the counter show the total visits to the forum.',

	// empty_block
	'BLOCK_CONTENT'				=> 'Block content',
	'BLOCK_CONTENT_EXPLAIN'		=> 'Content to display on the block.<br />Limit: 8000 characters.<br /><br />Language and template variables are allowed, for example, use <em>{S_USERNAME}</em> to display the name of the user.',

	// clock_block
	'DISPLAY_CLOCK'				=> 'Clock to show',
	'DISPLAY_CLOCK_EXPLAIN'		=> 'Clock displayed on the block.',
	'PREVIEW_CLOCK'				=> 'Preview',
	'PREVIEW_CLOCK_EXPLAIN'		=> 'Selected clock preview.',

	// cloud_tags_block
	'CLOUD_ANIMATION'			=> 'Animation enabled',
	'CLOUD_ANIMATION_EXPLAIN'	=> 'If enabled, the words "tags" appear in an animated cloud tag, otherwise, they appear as fixed words in block.',
	'CLOUD_MODE'				=> 'Words type',
	'CLOUD_MODE_EXPLAIN'		=> 'Specifies that words will be shown in block.',
	'CLOUD_WORDS'				=> 'Words number',
	'CLOUD_WORDS_EXPLAIN'		=> 'Maximum number of words that appear in the block.',
	'MODE_SEARCH'				=> 'Last searched words',
	'MODE_USERS'				=> 'Users with most posts',
	
	// forums block
	'FORUMS_FORUM'		=> 'Forum to show',
	
	// frame_block
	'MIME_HTML'			=> 'Web page',
	'MIME_PDF'			=> 'PDF file',
	'MIME_PLAIN'		=> 'Plain Text file',

	'FRAME_HEIGHT'				=> 'Frame height',
	'FRAME_HEIGHT_EXPLAIN'		=> 'Frame height in pixels. Set to 0 to auto adjust.',
	'FRAME_MIMETYPE'			=> 'Document type',
	'FRAME_MIMETYPE_EXPLAIN'	=> 'The document type displayed in the frame.',
	'FRAME_URL'					=> 'Document URL',
	'FRAME_URL_EXPLAIN'			=> 'URL of the document or page displayed in the frame.',
	'FRAME_WIDTH'				=> 'Frame width',
	'FRAME_WIDTH_EXPLAIN'		=> 'Frame width in pixels. Set to 0 to auto adjust.',
	
	// gallery_block
	'GALLERY_CUSTOM'				=> 'Custom images',
	'GALLERY_CUSTOM_EXPLAIN'		=> 'Specify the list containing the images to be displayed.',
	'GALLERY_DIRECTION'				=> 'Scroll direction',
	'GALLERY_FORUMS'				=> 'Forums',
	'GALLERY_FORUMS_EXPLAIN'		=> 'Defines the forums to read the attachments.',
	'GALLERY_FPS'					=> 'Scroll speed',
	'GALLERY_HEIGHT'				=> 'Gallery height',
	'GALLERY_MANAGE'				=> 'Manage gallery',
	'GALLERY_MARGIN'				=> 'Image margin',
	'GALLERY_MAX_NUMBER'			=> 'Number of images',
	'GALLERY_MAX_NUMBER_EXPLAIN'	=> 'Maximum attachments that will be read from the forums/topics/posts',
	'GALLERY_ORDER'					=> 'Order of topics/messages',
	'GALLERY_ORDER_EXPLAIN'			=> 'Defines the order in which the forum topics or posts will be loaded.',
	'GALLERY_POSTS'					=> 'Posts',
	'GALLERY_POSTS_EXPLAIN'			=> 'Posts IDs to read the attachments, splitted with commas. (Ex: 1,2,3).',
	'GALLERY_SOURCE'				=> 'Origin of the images',
	'GALLERY_SOURCE_EXPLAIN'		=> 'Define what type of images will be loaded from the forums, topics or messages specified.',
	'GALLERY_TOPICS'				=> 'Topics',
	'GALLERY_TOPICS_EXPLAIN'		=> 'Topics IDs to read the attachments, splitted with commas. (Ex: 1,2,3).',
	'GALLERY_ZOOM'					=> 'Zoom',
	'GALLERY_ZOOM_EXPLAIN'			=> 'Size difference on image\'s mouse over (in pixels)',

	'GALLERY_ORDER_LAST'			=> 'Last first',
	'GALLERY_ORDER_RAND'			=> 'Random',
	
	'GALLERY_SOURCE_ALL'			=> 'All',
	'GALLERY_SOURCE_ATTACHMENTS'	=> 'Only attachments',
	'GALLERY_SOURCE_IMAGES'			=> 'Only embedded images',
	
	'IMG_TITLE'			=> 'Image title',
	'IMG_URL'			=> 'Image url',
	'IMG_URL_EXPLAIN'	=> 'Url of an JPG, GIF or PNG image. Ej:http://mydomain.com/image.jpg',
	
	// google_translate_block
	'GOOGLE_LANGS'		=> 'Languages to show in the block',
	'GOOGLE_SHOW_NAMES'			=> 'Show names',
	'GOOGLE_SHOW_NAMES_EXPLAIN'	=> 'If enabled, the language name will be displayed next to its flag.',
	
	// latest_bots_block
	'BOTS_NUMBER'				=> 'Bots to show',
	'BOTS_NUMBER_EXPLAIN'		=> 'Maximum number of last visit bots that will be shown in the block.',

	// latest_members_block
	'MEMBERS_NUMBER'			=> 'Users to show',
	'MEMBERS_NUMBER_EXPLAIN'	=> 'Maximum number of users that will be shown in block.',
	
	// leaders_block
	'LEADERS_ALL_GROUPS'			=> 'Show users in all their groups',
	'LEADERS_ALL_GROUPS_EXPLAIN'	=> 'If enabled, users will be shown in all groups of which they are members.
		Otherwise they will only be shown in their default group.',
	'LEADERS_GROUPS'				=> 'Groups',
	'LEADERS_GROUPS_EXPLAIN'		=> 'Groups that will be show in the block. If you don\'t select groups, the block will be show the Administrators and Moderators.',
	'LEADERS_MODE'					=> 'Display mode',
	'LEADERS_MODE_ACCORDION'		=> 'Accordion',
	'LEADERS_MODE_SIMPLE'			=> 'Simple List',
	'LEADERS_ONLY_ONLINE'			=> 'Online users only',
	'LEADERS_ONLY_ONLINE_EXPLAIN'	=> 'If enabled, only users from selected groups who are logged in will be displayed.',

	// link_us_block
	'US_BANNER'					=> 'Mini banner link',
	'US_BANNER_EXPLAIN'			=> 'Mini banner that will be the image that you have to click to access the forum from the link.',

	// Login Block
	'ALT_LOGIN'					=> 'Show alternative methods',
	'ALT_LOGIN_EXPLAIN'			=> 'Enable/disable the display of alternative identification methods.<br /><em>Ex: Oauth</em>',
 	'FULL_LOGIN'				=> 'Show Full login',
 	'FULL_LOGIN_EXPLAIN'		=> 'Enable/disable the advanced options in the user identification.',
 	'SHOW_REGISTER'				=> 'Show register',
 	'SHOW_REGISTER_EXPLAIN'		=> 'Display option for the user registration.',
	
	// map_block
	'LATITUDE'					=> 'Latitude',
	'LONGITUDE'					=> 'Longitude',
	'LOCATION_ADD'				=> 'Add location',
	'LOCATION_EDIT'				=> 'Edit location',
	'LOCATION_IMAGE'			=> 'Image',
	'LOCATION_IMAGE_EXPLAIN'	=> 'Image that will mark the point on the map.<br /><em>If you do not define any, the default mark will be used</em>.',
	'LOCATION_INCORRECT'		=> 'he position entered is incorrect.',
	'LOCATION_POSITION'			=> 'Position',
	'LOCATION_POSITION_EXPLAIN'	=> 'Defines the latitude and longitude of the location.',
	'LOCATION_TEXT'				=> 'Content',
	'LOCATION_TEXT_EXPLAIN'		=> 'Text to be displayed on the map, by clicking on the location icon.<br /><em>BBcode is allowed.</em>',
	'LOCATION_TITLE'			=> 'Title',
	'MAP'						=> 'Map',
	'MAP_CENTER'				=> 'Central point',
	'MAP_CENTER_EXPLAIN'		=> 'Defines the latitude and longitude of the default center point.',
	'MAP_LOCATIONS'				=> 'Locations',
	'MAP_ZOOM'					=> 'Zoom',
	'MAP_ZOOM_EXPLAIN'			=> 'Set the default zoom.',
	'SEARCH_ADDRESS'			=> 'Search location',
	'SELECT_LOCATION'			=> 'Select location',

	// menu_block
	'DISPLAY_MENU'				=> 'Menu to show',
	'DISPLAY_MENU_EXPLAIN'		=> 'Menu to be displayed in the block. The menu must be previously created in the correct section to be reflected here.',
 	'ICON_WIDTH'				=> 'Icon width',
 	'ICON_WIDTH_EXPLAIN'		=> 'The width of the block icons, in pixels.',

	// most_poster_block
	'POSTER_LIMIT'				=> 'User Limit',
	'POSTER_LIMIT_EXPLAIN'		=> 'The limit of users that are displayed on the block.',
 	'POST_RANGE'				=> 'Message range',
 	'POST_RANGE_EXPLAIN'		=> 'Time limit for the message count.',
 
 	'ALL_POSTS'			=> 'All messages',
 	'LAST_DAY'			=> 'Last day',
 	'LAST_WEEK'			=> 'Last week',
 	'LAST_MONTH'		=> 'Last month',
 	'LAST_YEAR'			=> 'Last year',

	// news_block
	'NEWS_DISPLAY'				=> 'Information to show',
	'NEWS_DISPLAY_EXPLAIN'		=> '<em><strong>Basic content:</strong>Show title, author and date.<br />
		<strong>Full content:</strong>Show all news information.</em>',
	'NEWS_NUMBER'				=> 'News number',
	'NEWS_NUMBER_EXPLAIN'		=> 'Maximum number of news items displayed in the block.',
	'NEWS_SIZE'					=> 'News size',
	'NEWS_SIZE_EXPLAIN'			=> 'Maximum size of characters allowed in the news. The text of the news will be cut if this value exceeds.',
	'NEWS_ALL'					=> 'Show all topics',
	'NEWS_ALL_EXPLAIN'			=> 'If enabled, you also read the items marked as "announcement" and "fixed", otherwise, only read the "normal" topics.',
	'NEWS_COLLAPSE'				=> 'Collapse news',
	'NEWS_COLLAPSE_EXPLAIN'		=> 'If enabled, the block only show one notice and collapse the rest. Otherwise, the news will appear all at once on the block.',
	'NEWS_SHOW_FULL'			=> 'Complete content',
	'NEWS_SHOW_SIMPLE'			=> 'Basic content',
	
	// paypal_block
	'PAYPAL_ACCOUNT'			=> 'Paypal account',
	'PAYPAL_ACCOUNT_EXPLAIN'	=> 'Enter the e-mail address of your Paypal account ex: xxx@xxx.com',
	'PAYPAL_ITEM'				=> 'Payment description',
	'PAYPAL_ITEM_EXPLAIN'		=> 'Enter the name (description) to which payments will be identified through the block.',
	'PAYPAL_MSG'				=> 'Message',
	'PAYPAL_MSG_EXPLAIN'		=> 'Customizable message that will appear in the block.<br />Language and template variables are allowed, for example, use <em>{S_USERNAME}</em> to display the name of the user.',
	'PAYPAL_IMG'				=> 'Button Image',
 	'PAYPAL_IMG_EXPLAIN'		=> 'Image to be used for the "donate" button. Leave this field blank to use the default image.', 
	'PAYPAL_AMOUNTS'			=> 'Amounts',
	'PAYPAL_AMOUNTS_EXPLAIN'	=> 'Money amount in the select. Split the values with ";" (Ex: 5;10;15).',
	'PAYPAL_CURRENCIES'			=> 'Currencies',
	'PAYPAL_CURRENCIES_EXPLAIN'	=> 'Type of currency that will be show in the block. You can select more that one and select the default currency.',
	
	//player block
	'PLAYER_AUTOPLAY'			=> 'Autoplay',
	'PLAYER_AUTOPLAY_EXPLAIN'	=> 'Defines whether the player will automatically start playing the tracks when the page loads.<br /><br />
		<em><strong>Note:</strong>Browsers limit this feature so playback will not begin until the user clicks anywhere on the page.</em>',
	'PLAYER_PLAYLIST'			=> 'Show playlist',
	'PLAYER_PLAYLIST_EXPLAIN'	=> 'Defines if the playlist is displayed in the player.',
	'PLAYER_TRACKLIST'			=> 'Tracklist',
	'PLAYER_TRACKLIST_EXPLAIN'	=> 'The player tracks or songs.',

	'TRACK_TITLE'			=> 'Track title',
	'TRACK_TITLE_EXPLAIN'	=> 'the name or title displayed in the player.',
	'TRACK_URL'				=> 'Track URL',
	'TRACK_URL_EXPLAIN'		=> 'A radio URL (Ex: http://127.0.0.1:8888), a mp3 or wav audio file (Ex: http://myserver.com/audio.mp3) or a valid playlist file (m3u, asx, pls).',

	// poll_block
	'DISPLAY_POLL'				=> 'Poll to show',
	'DISPLAY_POLL_EXPLAIN'		=> 'Poll displayed in the block.',
	'DISPLAY_RESULTS'			=> 'Show results',
	'NO_POLLS'					=> 'No polls available',

	// poll_random_block
	'POLL_FORUM'				=> 'Poll forum',
	'POLL_FORUM_EXPLAIN'		=> 'Forum containing the polls that show on the block.',
	'POLL_NUM'					=> 'Poll number',
	'POLL_NUM_EXPLAIN'			=> 'The number of polls that will be displayed at once within the block.',
	'NO_FORUMS'					=> 'No forums avaliable',
	
	// post_view_block
	'PV_ITEM_URL'			=> 'Referral URL',
	'PV_ITEM_URL_EXPLAIN'	=> 'Specify here the URL of the forum, topic or message you want to display.<br />
		<em><strong>Note:</strong> The url of a forum or topic will display it\'s last message.</em>',
	
	// quote_of_day_block
	'QUOTE_AUTHOR'				=> 'Quote author',
	'QUOTE_TEXT'				=> 'Quote Text',
	'QUOTES_ALL_DAY'			=> 'Keep all day',
	'QUOTES_ALL_DAY_EXPLAIN'	=> 'If enabled, you will see the same quote all day. Otherwise, every time the page loads you will see a different quote.',
	'QUOTES_LIST'				=> 'Quote list',
	'QUOTES_RAND'				=> 'Random order',
	'QUOTES_RAND_EXPLAIN'		=> 'Defines if the quotes are displayed in random order or maintaining the order of the list.',
	'QUOTES_SHOW_AUTHOR'		=> 'Show author',
	'QUOTES_SHOW_AUTHOR_EXPLAIN'	=> 'Defines whether to display the author of the quote on the block.',
	
	// ranks_block
	'ORPHAN_RANKS'				=> 'Show orphan ranks',
	'ORPHAN_RANKS_EXPLAIN'		=> 'If enabled, will show the ranges are not assigned to any user.',
	'ONLY_SPECIAL_RANKS'		=> 'Only special ranks',
	
	// recent_topics_block
	'RECENT_FORUMS'					=> 'Topic forums',
	'RECENT_FORUMS_EXPLAIN'			=> 'Forums containing items to be displayed. If you do not select any, it will use all the forums. You can select as many as you like using the <em>Ctrl</em> key on your keyboard.',
	'RECENT_SECTIONS'				=> 'Sections',
	'RECENT_SECTIONS_EXPLAIN'		=> 'Define the sections to be displayed in the block and their order.',
	'RECENT_TOPIC_LIMIT'			=> 'Topic limit',
	'RECENT_TOPIC_LIMIT_EXPLAIN'	=> 'Maximum number of items to be displayed in each tab.',

	// Rss block
	'1_HOUR'		=> 'One hour',
	'2_HOURS'		=> 'Two hours',
	'6_HOURS'		=> 'Siz hours',
	
	'RSS_COLLAPSABLE'			=> 'Collapsable',
	'RSS_COLLAPSABLE_EXPLAIN'	=> 'Sets whether the items are displayed in an accordion or scrolling. If set to "Yes" will override the block scroll.',
	'RSS_DIRECTION'				=> 'Scroll direction',
	'RSS_DIRECTION_EXPLAIN'		=> 'Defining the direction of scrolling text. This option is canceled if the items are displayed in an accordion.',
	'RSS_HEIGHT'				=> 'Block height',
	'RSS_HEIGHT_EXPLAIN'		=> 'Sets the height of the block, in pixels. Only apply if items are not displayed in accordion format.',
	'RSS_IGNORE_LANG'			=> 'Ignore feed lang',
	'RSS_IGNORE_LANG_EXPLAIN'	=> 'If enabled, all URLs are read, regardless of their language, otherwise it will only display the contents written in the language of the user.',
	'RSS_LIMIT'					=> 'Feed limit',
	'RSS_LIMIT_EXPLAIN'			=> 'Maximum number of items to be read from each URL.',
	'RSS_SOURCES'				=> 'Feed sources',
	'RSS_TITLE'					=> 'Feed title',
	'RSS_TTL'					=> 'Refresh time',
	'RSS_TTL_EXPLAIN'			=> 'Time will remain cached items before attempting to read the source again.',
	'RSS_URL'					=> 'File url',
	'RSS_URL_EXPLAIN'			=> 'Ex: <em>http://midominio.com/rss.xml</em>',

	// scroll_message_block
	'MARQUEE_DIRECTION'				=> 'Scroll direction',
	'MARQUEE_DIRECTION_EXPLAIN'		=> 'Scroll direction for the text. This attribute controls the direction of scrolling.',
	'MARQUEE_SPEED'					=> 'Scroll amount',
	'MARQUEE_SPEED_EXPLAIN'			=> 'This controls the amount of movement (in pixels) between the successive displays that give the impression of animation.',
	'MARQUEE_SCROLLDELAY'			=> 'Scroll delay',
	'MARQUEE_SCROLLDELAY_EXPLAIN'	=> 'This controls the delay (in milliseconds) between the successive displays that give the impression of animation.',
	'MARQUEE_ALIGN'					=> 'Scroll align',
	'MARQUEE_ALIGN_EXPLAIN'			=> 'This tag controls the positioning of the marquee display box relative to the current text in exactly the same manner as the img tag\'s align attribute.',
	'MARQUEE_BGCOLOR'				=> 'Scroll bgcolor',
	'MARQUEE_BGCOLOR_EXPLAIN'		=> 'This tag controls the background colour of the display box.',
	'MARQUEE_HEIGHT'				=> 'Scroll height',
	'MARQUEE_HEIGHT_EXPLAIN'		=> 'This controls the height of the display box.',
	'MARQUEE_PADDING'				=> 'ScrollBox Padding',
	'MARQUEE_PADDING_EXPLAIN'		=> 'Space around the scroll box. This attribute is equivalent to the attribute "padding" of CSS.',
	'MARQUEE_TEXT'					=> 'Scroll message text',
	'MARQUEE_TEXT_EXPLAIN'			=> 'Add/change a scrollable message here. Limit 2000 characters.<br /><br />Language and template variables are allowed, for example, use <em>{S_USERNAME}</em> to display the name of the user.',

	'BOTTOM'		=> 'Bottom',
	'DOWN'			=> 'Down',
	'LEFT'			=> 'Left',
	'CENTER'		=> 'Center',
	'UP'			=> 'Up',
	'RIGHT'			=> 'Right',
	'TOP'			=> 'Top',
	
	//share_block
	'SHARE_SHOW_NAMES'			=> 'Show names',
	'SHARE_SHOW_NAMES_EXPLAIN'	=> 'If enabled, the name of the social network will be displayed next to its icon.',
	'SHARE_URL'					=> 'Reference URL',
	'SHARE_URL_EXPLAIN'			=> 'Set a fixed reference url for the buttons. Leave this field blank to use the displayed page.',
	'SHARE_BUTTONS'				=> 'Buttons to show',
	
	// stats_block
	'STATS_INLINE'			=> 'Show data in line',
 	'USER_STATS'			=> 'Display user statistics',

 	// steam_block
	'STEAM_GROUP_URL'			=> 'Group Url',
	'STEAM_GROUP_URL_EXPLAIN'	=> '<em>Ex: https://steamcommunity.com/groups/examplegroup</em>',
	
	// top_topics_block
	'TOPT_LIMIT'			=> 'Topic limit',
	'TOPT_LIMIT_EXPLAIN'	=> 'Maximun number of topic to show.',
	'TOPT_MODE'				=> 'Topic to show',
	'TOPT_MODE_ACTIVE'		=> 'Latest topics more active',
	'TOPT_MODE_UNREAD'		=> 'Latest unread topics',
	'TOPT_MODE_VIEWED'		=> 'More viewed topics',

	// topic_index_block
	'TINDEX_CHAR_SELECT'			=> 'Show Index',
	'TINDEX_CHAR_SELECT_EXPLAIN'	=> 'Only avaliable if the sort method is <em>Topic title</em>.',
	'TINDEX_PER_PAGE'			=> 'Topics per page',
	'TINDEX_PER_PAGE_EXPLAIN'	=> 'Number of topics that will be show at the same time. Set 0 to disable pagination.',
	'TINDEX_SORT_MODE'			=> 'Order by',
	'TINDEX_SORT_MODE_EXPLAIN'	=> 'Method that will be used to set the topic\'s order in the list.',
  
	'TOPIC_TIME'		=> 'Topic date',
	'LAST_POST_TIME'	=> 'Last post date',

	// welcome_block
	'WELCOME_GUEST'				=> 'Guests message',
	'WELCOME_GUEST_EXPLAIN'		=> 'Message to display to all guests. 2000 characters max.<br /><br />Language and template variables are allowed, for example, use <em>{S_USERNAME}</em> to display the name of the user.',
	'WELCOME_MEMBER'			=> 'Members message',
	'WELCOME_MEMBER_EXPLAIN'	=> 'Message to display to all the forum registered users. 2000 characters max.<br /><br />Language and template variables are allowed, for example, use <em>{S_USERNAME}</em> to display the name of the user.',

	// whos_online_block
	'WHOS_ADVANCED'				=> 'Advanced mode',
	'WHOS_ADVANCED_EXPLAIN'		=> 'If enabled, will display all the information, otherwise it will appear only basic information (suitable for side blocks).',
	'WHOS_USERNAMES'			=> 'Show user list',
	'WHOS_USERNAMES_EXPLAIN'	=> 'If enabled, displays the list of users online (only in advanced mode).',

	// youtube_block
	'YT_AUTOPLAY'				=> 'AutoPlay enabled',
	'YT_AUTOPLAY_EXPLAIN'		=> 'If enabled, the video will play automatically.<br />If you have multiple videos, only the first autoplay.',
	'YT_DISPLAY_MODE'			=> 'Display Mode',
	'YT_FULL_PREVIEW'			=> 'Show thumbnails, title and description',
	'YT_LIST'					=> 'Show a list with titles',
	'YT_RANDOM_DISPLAY'			=> 'Random Display',
	'YT_RANDOM_DISPLAY_EXPLAIN'	=> 'If enabled, only one video will be appear randomly. Otherwise, all the videos and channels appear at once.',
	'YT_RESULT_LIMIT'			=> 'Number of channel videos',
	'YT_RESULT_LIMIT_EXPLAIN'	=> 'Maximun number of videos loaded in each channel.',
	'YT_SIMPLE_PREVIEW'			=> 'Show thumbnails and titles',
	'YT_TEXT_LIMIT'				=> 'Text limit',
	'YT_TEXT_LIMIT_EXPLAIN'		=> 'Maximun number of characters in the video description.',
	'YT_VIDEO_PREVIEW'			=> 'Show video preview',
	'YT_VIDEO_SIZE'				=> 'Player size',
	'YT_VIDEO_TITLE'			=> 'Video title',
	'YT_VIDEO_URL'				=> 'Video url',
	'YT_VIDEO_URL_EXPLAIN'		=> 'Ex: <em>https://www.youtube.com/watch?v=NHH_v0k7Gus</em>',
));
