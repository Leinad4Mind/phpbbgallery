<?php

/**
 * BBOAuth
 * @copyright (c) 2018 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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
	'AUTH_PROVIDER_OAUTH_SERVICE_COINBASE'  => 'Coinbase',
	'AUTH_PROVIDER_OAUTH_SERVICE_DISCORD'   => 'Discord',
	'AUTH_PROVIDER_OAUTH_SERVICE_DROPBOX'   => 'Dropbox',
	'AUTH_PROVIDER_OAUTH_SERVICE_GITHUB'    => 'Github',
	'AUTH_PROVIDER_OAUTH_SERVICE_INSTAGRAM' => 'Instagram',
	'AUTH_PROVIDER_OAUTH_SERVICE_RAZER'     => 'Razer',
	'AUTH_PROVIDER_OAUTH_SERVICE_SLACK'     => 'Slack',
]);
