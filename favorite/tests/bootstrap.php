<?php
/**
 * phpBB Gallery - Favorite test bootstrap
 *
 * @package   phpbbgallery/favorite
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbb\db\driver
{
	if (!interface_exists('phpbb\\db\\driver\\driver_interface', false))
	{
		interface driver_interface
		{
		}
	}
}

namespace
{
	require_once dirname(__DIR__, 2) . '/core/tests/style_matrix.php';

	if (!defined('IN_PHPBB'))
	{
		define('IN_PHPBB', true);
	}

	require_once dirname(__DIR__) . '/favorite.php';
}
