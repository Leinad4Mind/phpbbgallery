<?php
// phpcs:disable PSR1.Files.SideEffects
/**
 * BBTags tests.
 *
 * @package sitesplat/bbtags
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace
{
	if (!defined('IN_PHPBB'))
	{
		define('IN_PHPBB', true);
	}

	if (!function_exists('utf8_strtolower'))
	{
		function utf8_strtolower($value)
		{
			return mb_strtolower($value, 'UTF-8');
		}
	}

	if (!function_exists('utf8_substr'))
	{
		function utf8_substr($value, $offset, $length = null)
		{
			return mb_substr($value, $offset, $length, 'UTF-8');
		}
	}

	require_once __DIR__ . '/stubs/phpbb_config.php';
	require_once __DIR__ . '/stubs/phpbb_auth.php';
	require_once dirname(__DIR__, 4) . '/phpbb/db/driver/driver_interface.php';
	require_once dirname(__DIR__) . '/tags/manager.php';
}
