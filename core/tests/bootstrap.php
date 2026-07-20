<?php
/**
 * phpBB Gallery - Core Extension tests
 *
 * @package   phpbbgallery/core
 * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbb\filesystem
{
	if (!interface_exists('phpbb\\filesystem\\filesystem_interface'))
	{
		interface filesystem_interface
		{
			const CHMOD_READ = 4;
			const CHMOD_WRITE = 2;
		}
	}
}

namespace
{
	if (!defined('IN_PHPBB'))
	{
		define('IN_PHPBB', true);
	}

	if (!function_exists('unique_id'))
	{
		function unique_id()
		{
			if (isset($GLOBALS['phpbbgallery_test_unique_id']))
			{
				return $GLOBALS['phpbbgallery_test_unique_id'];
			}

			return uniqid('', true);
		}
	}

	require_once dirname(__DIR__) . '/upload.php';
}
