<?php

/**
 *
 * Debrider extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

/**
 * DO NOT CHANGE
 */
if (!defined('IN_PHPBB')) {
	exit;
}

if (empty($lang) || !is_array($lang)) {
	$lang = [];
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, [
	'ACP_ENABLE' => 'Enable Debrider',
	'ACP_API_KEY' => 'API Key',

	'ACP_MAIN_MODULE_TITLE' => 'Debrider',
	'ACP_DEBRIDER' => 'Debrider',
	'ACP_DEBRIDER_SETTING_SAVED' => 'Settings saved',

	'ACP_PROVIDER' => 'Provider',
	'ACP_PROVIDER_REALDEBRID' => 'Real Debrid',
	'ACP_PROVIDER_ALLDEBRID' => 'All Debrid',
	'ACP_USE_PROXY' => 'Use proxy',
	'ACP_PROXY_CREDENTIALS' => 'Proxy credentials',
	'ACP_PROXY_CREDENTIALS_EXPLAIN' => 'Insert the format Username:Password',
	'ACP_PROXY_TYPE' => 'Proxy type',
	'ACP_PROXY_TYPE_CURLPROXY_HTTP' => 'HTTP Proxy. Default',
	'ACP_PROXY_TYPE_CURLPROXY_HTTPS' => 'HTTPS Proxy. (For OpenSSL, GnuTLS and NSS)',
	
	'ACP_PROXY_TYPE_CURLPROXY_HTTP_1_0' => 'HTTP 1.0 Proxy. (For any CONNECT tunneling)',
	'ACP_PROXY_TYPE_CURLPROXY_SOCKS4' => 'SOCKS4 Proxy',
	'ACP_PROXY_TYPE_CURLPROXY_SOCKS4A' => 'SOCKS4a Proxy. Proxy resolves URL hostname',
	'ACP_PROXY_TYPE_CURLPROXY_SOCKS5' => 'SOCKS5 Proxy',
	'ACP_PROXY_TYPE_CURLPROXY_SOCKS5_HOSTNAME' => 'SOCKS5 Proxy. Proxy resolves URL hostname',
	'ACP_PROXY_HOST' => 'Proxy host',
	'ACP_PROXY_HOST_EXPLAIN' => 'Insert the format Host:Port',

	'DEBRIDER_PRESELECTED' => 'Preselected',
	'DEBRIDER_CAN_ENABLE' => 'Can enable debrider?',
	'DEBRIDER_CAN_ENABLE_EXPLAIN' => 'If set to yes, the option will appear on topics but unselected, if set to no, it will not appear and if set to preselect it will appear already selected',
	'DEBRIDER_MYSQL_UPDATE' => 'MySQL Helper',
	'DEBRIDER_MYSQL_UPDATE_EXPLAIN' => 'Run this mysql query after choosing which forums should have the debrider enabled on the topics.<br>The can_debrider_enabled = 2 means preselected, = 1 means yes, = 0 means no.',
	'DEBRIDER_MYSQL_UPDATE_CODE' => 'UPDATE phpbb_topics SET debrider_enabled = 1 WHERE forum_id IN (SELECT forum_id from phpbb_forums WHERE can_debrider_enabled = 2)',

	'INSTALL_NOTICE' => '<div class="phpinfo"><p>You need to set the permissions for Users, to select which user groups are able to see Debrid Buttons on topics.<br>Set permissions to Moderators, so they can see the option "Enable Debrider" at Topic Creation.<br>And finally choose which forums should have this feature.</p></div></p></div>',
	'PHP_ERROR'      => 'This extension requires PHP 7.1.0 (or greater).',
	'PHPBB_ERROR'    => 'This extension requires phpBB 3.3.0 (or greater).',
]);
