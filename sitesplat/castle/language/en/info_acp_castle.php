<?php
/**
*
* Castle
*
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*
*/

/**
* DO NOT CHANGE
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
	'ACP_CASTLE_TITLE'								=> 'BBCastle',
	'ACP_CASTLE_TITLE_EXPLAIN'						=> 'BBCastle, An end-to-end account takeover solution. BBCastle understands user behavior across web, mobile and APIs. Depending on the risk associated with an individual device, BBcastle automatically triggers security notifications, challenges and account reset workflows.',
	'ACP_CASTLE_SETTING_SAVED'						=> 'Castle settings has been saved.',
	'CASTLE_APP_ID'									=> 'Castle App ID',
	'CASTLE_APP_ID_EXPLAIN'							=> 'Enter your Castle App ID here. You can find it in your <a href="https://dashboard.castle.io/settings/general">Castle dashboard settings</a>.',
	'CASTLE_API_SECRET'								=> 'Castle API Secret',
	'CASTLE_API_SECRET_EXPLAIN'						=> 'Enter your Castle API Secret here. You can find it in your <a href="https://dashboard.castle.io/settings/general">Castle dashboard settings</a>.',
	'CASTLE_HOOK_CONFIGURED'						=> 'Castle webhook configured',
	'CASTLE_HOOK_CONFIGURED_EXPLAIN'				=> 'In order to use Castle\'s Adaptive Authentication (new authentication layer), Castle needs to know your board\'s URL to inform about malicious logins.<br><ol><li>Go to <a href="https://dashboard.castle.io/settings/webhooks">Castle\'s Webhooks Settings</a></li><li>Click on Add new endpoint</li><li>Set this URL as Endpoint URL: <samp>%s</samp></li><li>Click Save</li><li>Check this checkbox</li>',
	'CASTLE_FEEDBACK_REDIRECT_CONFIGURED'			=> 'Castle feedback configured',
	'CASTLE_FEEDBACK_REDIRECT_CONFIGURED_EXPLAIN'	=> 'In order to use custom landing page when user is notified about suspicous activity, Castle needs to know your board\'s URL.<br><ol><li>Go to <a href="https://dashboard.castle.io/settings/appearance">Castle\'s Appearance Settings</a></li><li>Set this URL as Feedback Redirect URL: <samp>%s</samp></li><li>Click Save</li><li>Check this checkbox</li>',
	
	'SS_HELPER_NOTY'	                => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'CASTLE_NOTICE'					    => '<div class="phpinfo"><p>The settings for this extension are in <strong>ACP &#187; EXTENSIONS &#187; Castle</strong>.</p></div>',
));
