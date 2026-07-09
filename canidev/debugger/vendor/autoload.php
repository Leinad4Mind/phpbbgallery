<?php
/**
 * @package cBB Debugger
 * @version 1.0.2 11/03/2024
 *
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

use Symfony\Component\HttpFoundation\Request;

$config = \canidev\debugger\libraries\config::instance();

// Check ips
if($allowed_ips = $config->get('allowed_ips'))
{
	$request 		= Request::createFromGlobals();
	$allowed_ips 	= explode("\n", $allowed_ips);
	$user_ip		= $request->getClientIp();

	// Cloudflare compatibility
	if($request->server->get('HTTP_CF_CONNECTING_IP', '') != '')
	{
		$user_ip = $request->server->get('HTTP_CF_CONNECTING_IP', '');
	}

	if(!in_array($user_ip, $allowed_ips))
	{
		$config
			->set('debug_enable', false)
			->set('show_stats', false);
	}
}

if($config->get('debug_enable'))
{
	@ini_set('log_errors', 0);
	@define('DEBUG', true);
	
	\phpbb\debug\debug::enable();

	if(phpbb_version_compare(PHPBB_VERSION, '3.3.0', '<') && $config->get('show_stats'))
	{
		@define('PHPBB_DISPLAY_LOAD_TIME', true);
	}
}
