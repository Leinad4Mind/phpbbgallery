<?php
/**
 * phpBB Gallery - Contest Add-on test bootstrap.
 *
 * @package   phpbbgallery/contest
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbb\db\migration
{
	if (!class_exists('phpbb\\db\\migration\\migration', false))
	{
		abstract class migration
		{
			protected string $table_prefix = '';
		}
	}
}

namespace
{
	if (!defined('IN_PHPBB'))
	{
		define('IN_PHPBB', true);
	}

	require_once dirname(__DIR__, 2) . '/core/tests/bootstrap.php';
	require_once dirname(__DIR__, 4) . '/phpbb/db/tools/tools_interface.php';
	require_once dirname(__DIR__, 4) . '/phpbb/pagination.php';
	require_once dirname(__DIR__) . '/manager.php';
	require_once dirname(__DIR__) . '/winner_search.php';
	require_once dirname(__DIR__) . '/controller/winners.php';
	require_once dirname(__DIR__) . '/event/index_listener.php';
	require_once dirname(__DIR__) . '/event/presentation_listener.php';
	require_once dirname(__DIR__) . '/event/acp_listener.php';
	require_once dirname(__DIR__) . '/event/album_lifecycle_listener.php';
	require_once dirname(__DIR__) . '/event/policy_listener.php';
	require_once dirname(__DIR__) . '/migrations/m1_init.php';
	require_once dirname(__DIR__) . '/migrations/m2_settings.php';
	require_once dirname(__DIR__) . '/migrations/m3_album_storage.php';
	require_once dirname(__DIR__) . '/migrations/m4_image_end_storage.php';
	require_once dirname(__DIR__) . '/migrations/m5_image_rank_storage.php';
	require_once dirname(__DIR__) . '/migrations/m6_contest_storage.php';
	require_once dirname(__DIR__) . '/migrations/m7_winner_thumbnail.php';
}
