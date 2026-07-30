<?php
// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound, Generic.Files.OneInterfacePerFile.MultipleFound -- Isolated dependency stubs share the test bootstrap.
/**
 * BBPoints test bootstrap.
 *
 * @package sitesplat/bbpoints
 * @copyright (c) 2015-2026 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace phpbb\db\driver
{
	interface driver_interface
	{
	}
}

namespace phpbb\cache\driver
{
	interface driver_interface
	{
	}
}

namespace phpbb\event
{
	interface dispatcher_interface
	{
		public function trigger_event($event_name, $data = []);
	}
}

namespace phpbb\db\migration
{
	abstract class migration
	{
		protected string $table_prefix = 'phpbb_';
	}
}

namespace
{
	if (!defined('IN_PHPBB'))
	{
		define('IN_PHPBB', true);
	}
	if (!defined('ANONYMOUS'))
	{
		define('ANONYMOUS', 1);
	}
	if (!defined('ITEM_APPROVED'))
	{
		define('ITEM_APPROVED', 1);
	}
	if (!function_exists('utf8_substr'))
	{
		function utf8_substr(string $value, int $start, ?int $length = null): string
		{
			return mb_substr($value, $start, $length, 'UTF-8');
		}
	}

	require_once dirname(__DIR__) . '/exception/invalid_operation.php';
	require_once dirname(__DIR__) . '/exception/insufficient_funds.php';
	require_once dirname(__DIR__) . '/exception/operation_conflict.php';
	require_once dirname(__DIR__) . '/core/operation.php';
	require_once dirname(__DIR__) . '/core/ledger.php';
	require_once dirname(__DIR__) . '/migrations/v13x/m1_ledger_api.php';
	require_once __DIR__ . '/fake_db.php';
	require_once __DIR__ . '/fake_cache.php';
	require_once __DIR__ . '/fake_dispatcher.php';
}
