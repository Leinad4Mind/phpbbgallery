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
		}
	}
}

namespace
{
	if (!defined('IN_PHPBB'))
	{
		define('IN_PHPBB', true);
	}

	require_once dirname(__DIR__) . '/migrations/m1_init.php';
}
