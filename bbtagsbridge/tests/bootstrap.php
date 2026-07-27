<?php
// phpcs:disable PSR1.Files.SideEffects
/**
 * phpBB Gallery BBTags Bridge test bootstrap.
 *
 * @package   phpbbgallery/bbtagsbridge
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbb\db\driver
{
	interface driver_interface
	{
	}
}

namespace phpbb\controller
{
	class helper
	{
		public function route($name, array $parameters = []): string
		{
			return '/' . $name . '/' . ($parameters['image_id'] ?? '');
		}
	}
}

namespace
{
	if (!defined('IN_PHPBB'))
	{
		define('IN_PHPBB', true);
	}

	require_once dirname(__DIR__, 3) . '/sitesplat/bbtags/provider/provider_interface.php';
	require_once dirname(__DIR__) . '/image_tag_manager.php';
	require_once dirname(__DIR__) . '/provider/image_provider.php';
}
