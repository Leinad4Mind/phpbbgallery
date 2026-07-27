<?php
// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- Minimal isolated dependency stubs share the bootstrap.
/**
 * phpBB Gallery - Image Revisions test bootstrap
 *
 * @package   phpbbgallery/imagerevisions
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbb\db\driver
{
	interface driver_interface
	{
	}
}

namespace phpbb
{
	class user
	{
		public array $data = [];
	}
}

namespace phpbbgallery\core
{
	class url
	{
	}

	class log
	{
	}

	class cache
	{
	}

	class block
	{
		public const STATUS_APPROVED = 1;
		public const STATUS_ORPHAN = 3;
	}
}

namespace phpbbgallery\core\file
{
	class file
	{
	}
}

namespace
{
	if (!defined('IN_PHPBB'))
	{
		define('IN_PHPBB', true);
	}
	if (!defined('USERS_TABLE'))
	{
		define('USERS_TABLE', 'users');
	}

	require_once dirname(__DIR__) . '/revision.php';
}
