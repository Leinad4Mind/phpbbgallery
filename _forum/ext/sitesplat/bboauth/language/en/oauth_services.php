<?php
/**
*
* BBOAuth
*
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
	'AUTH_PROVIDER_OAUTH_SERVICE_COINBASE'	=> 'Coinbase',
	'AUTH_PROVIDER_OAUTH_SERVICE_DISCORD'	=> 'Discord',
	'AUTH_PROVIDER_OAUTH_SERVICE_DROPBOX'	=> 'Dropbox',
	'AUTH_PROVIDER_OAUTH_SERVICE_GITHUB'	=> 'Github',
	'AUTH_PROVIDER_OAUTH_SERVICE_INSTAGRAM'	=> 'Instagram',
	'AUTH_PROVIDER_OAUTH_SERVICE_RAZER'		=> 'Razer',
	'AUTH_PROVIDER_OAUTH_SERVICE_SLACK'		=> 'Slack',
));
