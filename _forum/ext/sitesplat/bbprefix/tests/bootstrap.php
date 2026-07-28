<?php
// phpcs:disable PSR1.Files.SideEffects
/**
 * BBPrefix tests.
 *
 * @package BBprefix
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace
{
	if (!defined('IN_PHPBB'))
	{
		define('IN_PHPBB', true);
	}

	// Normally defined by the extension's event listener once phpBB has booted.
	if (!defined('BBPREFIX_TABLE'))
	{
		define('BBPREFIX_TABLE', 'phpbb_bbprefix');
	}

	if (!defined('BBPREFIX_INSTANCES_TABLE'))
	{
		define('BBPREFIX_INSTANCES_TABLE', 'phpbb_bbprefix_instances');
	}

	if (!defined('GROUPS_TABLE'))
	{
		define('GROUPS_TABLE', 'phpbb_groups');
	}

	if (!defined('FORUMS_TABLE'))
	{
		define('FORUMS_TABLE', 'phpbb_forums');
	}

	require_once dirname(__DIR__, 4) . '/phpbb/db/driver/driver_interface.php';
	require_once dirname(__DIR__, 4) . '/phpbb/cache/driver/driver_interface.php';
	require_once dirname(__DIR__) . '/core/manager.php';
	require_once __DIR__ . '/fake_cache.php';
	require_once __DIR__ . '/fake_db.php';
	require_once __DIR__ . '/fake_log.php';

	// The real group_memberships() lives in includes/functions_user.php and
	// queries the database through the global $db. Stubbing it here means
	// get_allowed_prefixes() never takes that include path in tests, and the
	// membership list stays under the test's control instead.
	if (!function_exists('group_memberships'))
	{
		function group_memberships($group_type = false, $user_id = false, $no_update = false)
		{
			return $GLOBALS['bbprefix_test_group_memberships'] ?? [];
		}
	}
}
