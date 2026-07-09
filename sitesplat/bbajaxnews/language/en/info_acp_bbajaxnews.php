<?php
/**
*
* @package BBajaxnews
* @copyright (c) 2018 SiteSplat All rights reserved
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
	'ACP_BBAJAXNEWS_TITLE'			=> 'BBajaxnews',
	'ACP_BBAJAXNEWS_TITLE_EXPLAIN'	=> 'BBajaxnews is a powerful and revolutionary extension allows your phpBB forum running SiteSplat\'s premium products to have real live notifications for your users!<br/>Adjust your preferences below and make sure to clear the forum cache every time you change any settings here.',
	'ACP_BBAJAXNEWS_SETTING_SAVED'	=> 'BBajaxnews settings has been saved.',

	'SPECIAL'	=> 'Special News',
	'CASUAL'	=> 'Casual News',
	'SPECIAL_EXPLAIN'	=> 'Special news events are triggered when a specific rule criteria is met. IE: user registration, new topic, New announcement etc. (See below for the included news).',
	'CASUAL_EXPLAIN'	=> 'Casual news events are triggered after a user is not presented with any other live news by a specified amount of time (configurable above).',

	'SITESPLAT_BBAJAXNEWS_DRIVER'							=> 'Driver',
	'SITESPLAT_BBAJAXNEWS_DRIVER_EXPLAIN'					=> 'Select from the list of providers which driver you want to use. Different providers have different pricing, but also different availability, support, etc.',
	'DRIVER_PUSHER'											=> 'Pusher',
	'DRIVER_PUBNUB'											=> 'PubNub',
	
	'SITESPLAT_BBAJAXNEWS_PUBNUB_PUB'						=> 'PubNub Publish Key',
	'SITESPLAT_BBAJAXNEWS_PUBNUB_PUB_EXPLAIN'				=> 'You can find your PubNub Publish Key in <a href="https://admin.pubnub.com/" target="_blank">PubNub Admin</a>.',
	'SITESPLAT_BBAJAXNEWS_PUBNUB_SUB'						=> 'PubNub Subscribe Key',
	'SITESPLAT_BBAJAXNEWS_PUBNUB_SUB_EXPLAIN'				=> 'You can find your PubNub Subscribe Key in <a href="https://admin.pubnub.com/" target="_blank">PubNub Admin</a>.',
	
	'SITESPLAT_BBAJAXNEWS_PUSHER_APP_KEY'					=> 'Pusher App Key',
	'SITESPLAT_BBAJAXNEWS_PUSHER_APP_KEY_EXPLAIN'			=> 'You can find your Pusher App Key in <a href="https://dashboard.pusher.com/" target="_blank">Pusher dashboard</a>.',
	'SITESPLAT_BBAJAXNEWS_PUSHER_APP_SEC'					=> 'Pusher App Secret',
	'SITESPLAT_BBAJAXNEWS_PUSHER_APP_SEC_EXPLAIN'			=> 'You can find your Pusher App Secret in <a href="https://dashboard.pusher.com/" target="_blank">Pusher dashboard</a>.',
	'SITESPLAT_BBAJAXNEWS_PUSHER_APP_ID'					=> 'Pusher App ID',
	'SITESPLAT_BBAJAXNEWS_PUSHER_APP_ID_EXPLAIN'			=> 'You can find your Pusher App ID in <a href="https://dashboard.pusher.com/" target="_blank">Pusher dashboard</a>.',
	'SITESPLAT_BBAJAXNEWS_PUSHER_APP_CLUSTER'				=> 'Pusher Cluster',
	'SITESPLAT_BBAJAXNEWS_PUSHER_APP_CLUSTER_EXPLAIN'		=> 'You can find your Pusher Cluster in <a href="https://dashboard.pusher.com/" target="_blank">Pusher dashboard</a>.',
	
	'SITESPLAT_BBAJAXNEWS_INTERVAL'							=> 'Interval between casual live news',
	'SITESPLAT_BBAJAXNEWS_INTERVAL_EXPLAIN'					=> 'When user is not presented with any live news by specified number of minutes, one of causal live news will be displayed to them. Enter 0 to disable casual news.',
	'SITESPLAT_BBAJAXNEWS_NOTY_VISIBILITY_CONTROL'			=> 'Visibility control',
	'SITESPLAT_BBAJAXNEWS_NOTY_VISIBILITY_CONTROL_EXPLAIN'	=> 'This will display/trigger the BBnews only when user is actively browsing the board. Note: this is a browser API (<a href="https://developer.mozilla.org/en-US/docs/Web/API/Page_Visibility_API" target="_blank">Page Visibility API</a>) feature.',
	'SITESPLAT_BBAJAXNEWS_NOTY_TIMEOUT'						=> 'Delay for closing',
	'SITESPLAT_BBAJAXNEWS_NOTY_TIMEOUT_EXPLAIN'				=> 'Set milliseconds after which live news will be closed. E.g. 5000 means the live news will close after 5 seconds. Set to 0 for permanent live news (will close only after user action).',
	'SITESPLAT_BBAJAXNEWS_NOTY_PROGRESS_BAR'				=> 'Display a progress bar',
	'SITESPLAT_BBAJAXNEWS_NOTY_PROGRESS_BAR_EXPLAIN'		=> 'Set to Yes to display a progress bar which will signal when an live news will close. <br/>Note: a progress bar is only available if the above option "Delay for closing" is in use.',
	'SITESPLAT_BBAJAXNEWS_NOTY_LAYOUT'						=> 'Notification Position',
	'SITESPLAT_BBAJAXNEWS_NOTY_LAYOUT_EXPLAIN'				=> 'Select the position of the notification',
	'SITESPLAT_BBAJAXNEWS_NOTY_MO'							=> 'Use mo.js animation',
	'SITESPLAT_BBAJAXNEWS_NOTY_MO_EXPLAIN'					=> 'This will use a JavaScript powered fancy animation but requires to load an additional JS file. <br/>(Approx: 35.4kB Minified + Gzipped) It is already included in BBajaxNews and you can use it right away if you choose to enable the animation.',
	'LAYOUT_TOP'			=> 'Top',
	'LAYOUT_TOPLEFT'		=> 'Top left',
	'LAYOUT_TOPCENTER'		=> 'Top center',
	'LAYOUT_TOPRIGHT'		=> 'Top right',
	'LAYOUT_CENTER'			=> 'Center',
	'LAYOUT_CENTERLEFT'		=> 'Center left',
	'LAYOUT_CENTERRIGHT'	=> 'Center right',
	'LAYOUT_BOTTOM'			=> 'Bottom',
	'LAYOUT_BOTTOMLEFT'		=> 'Bottom left',
	'LAYOUT_BOTTOMCENTER'	=> 'Bottom center',
	'LAYOUT_BOTTOMRIGHT'	=> 'Bottom right',

	'SITESPLAT_BBAJAXNEWS_BBDONATION'			=> 'Enable live news when a user makes a donation (requires BBdonation extension)',
	'SITESPLAT_BBAJAXNEWS_BBMEMBERSHIP'			=> 'Enable live news when a user purchases a membership (requires BBmembership extension)',
	'SITESPLAT_BBAJAXNEWS_BBVOTE'				=> 'Enable live news when the best answer is marked (requires BBvote extension)',
	'SITESPLAT_BBAJAXNEWS_FRIEND_LOGGED_IN'		=> 'Enable live news when a friend of user logs in',
	'SITESPLAT_BBAJAXNEWS_NEW_ANNOUNCEMENT'		=> 'Enable live news when a topic is made an (global) announcement',
	'SITESPLAT_BBAJAXNEWS_NEW_STICKY'			=> 'Enable live news when a topic is made sticky',
	'SITESPLAT_BBAJAXNEWS_NEW_TOPIC'			=> 'Enable live news when a new topic is created',
	'SITESPLAT_BBAJAXNEWS_USER_JOINED_BOARD'	=> 'Enable live news when a new user joins the board',
	'SITESPLAT_BBAJAXNEWS_USER_JOINED_GROUP'	=> 'Enable live news when user(s) are added to the special group',

	'SITESPLAT_BBAJAXNEWS_NEW_POSTS_TODAY'		=> 'Enable live news informing about number of posts posted today so far',
	'SITESPLAT_BBAJAXNEWS_RANDOM_POLL'			=> 'Enable live news encouraging user to participate into random poll not yet voted in',
	'SITESPLAT_BBAJAXNEWS_USERS_ONLINE_24H'		=> 'Enable live news informing about number of users online in the last 24h',
	'SITESPLAT_BBAJAXNEWS_USERS_ONLINE'			=> 'Enable live news informing about number of online users',

	'LOG_BBAJAXNEWS_PUBLISH_FAIL'	=> '<strong>BBAjaxNews publishing of “%s” type failed</strong><br />» %s',
	
	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'BBAJAXNEWS_NOTICE'	            => '<div class="phpinfo"><p>The settings for this extension are under the "Extensions" tab.</p></div>',
));