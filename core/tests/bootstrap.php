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
			// phpcs:ignore -- PHPUnit fixture override uses the PHP superglobal.
			if (isset($GLOBALS['phpbbgallery_test_unique_id']))
			{
				// phpcs:ignore -- PHPUnit fixture override uses the PHP superglobal.
				return $GLOBALS['phpbbgallery_test_unique_id'];
			}

			return uniqid('', true);
		}
	}

	if (!function_exists('phpbb_optionget'))
	{
		function phpbb_optionget(int $bit, int $data): bool
		{
			return (bool) ($data & 1 << $bit);
		}
	}

	if (!function_exists('phpbb_optionset'))
	{
		function phpbb_optionset(int $bit, bool $set, int $data): int
		{
			if ($set)
			{
				return $data | 1 << $bit;
			}

			return $data & ~(1 << $bit);
		}
	}

	require_once dirname(__DIR__, 4) . '/phpbb/db/driver/driver_interface.php';
	require_once dirname(__DIR__, 4) . '/phpbb/cache/service.php';
	require_once __DIR__ . '/stubs/phpbb_extension_base.php';
	require_once __DIR__ . '/stubs/phpbb_notification_exception.php';
	require_once __DIR__ . '/stubs/phpbb_config.php';
	require_once dirname(__DIR__) . '/upload.php';
	require_once dirname(__DIR__) . '/auth/image_authorization.php';
	require_once dirname(__DIR__) . '/ext.php';
	require_once dirname(__DIR__) . '/controller/moderate.php';
	require_once dirname(__DIR__) . '/acp/main_module.php';
	require_once dirname(__DIR__) . '/ucp/main_module.php';
	require_once dirname(__DIR__) . '/config.php';
	require_once dirname(__DIR__) . '/cache.php';
	require_once dirname(__DIR__) . '/url.php';
	require_once dirname(__DIR__) . '/auth/set.php';
	require_once dirname(__DIR__) . '/auth/level.php';
	require_once dirname(__DIR__) . '/block.php';
	require_once dirname(__DIR__) . '/album/album.php';
	require_once dirname(__DIR__) . '/album/display.php';
	require_once dirname(__DIR__) . '/album/loader.php';
	require_once dirname(__DIR__) . '/album/manage.php';
	require_once dirname(__DIR__) . '/image/image.php';
	require_once dirname(__DIR__) . '/comment.php';
	require_once dirname(__DIR__) . '/rating.php';
	require_once dirname(__DIR__) . '/report.php';
	require_once dirname(__DIR__) . '/notification.php';
	require_once dirname(__DIR__) . '/moderate.php';
	require_once dirname(__DIR__) . '/user.php';
}
