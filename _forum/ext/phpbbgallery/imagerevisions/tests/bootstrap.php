<?php
// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- Minimal isolated dependency stubs share the bootstrap.
// phpcs:disable PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- Native ArrayAccess methods.
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

namespace phpbb\db\migration
{
	abstract class migration
	{
		protected string $table_prefix = 'phpbb_';
	}
}

namespace phpbb\config
{
	class config implements \ArrayAccess
	{
		public function __construct(private array $values = [])
		{
		}

		public function offsetExists(mixed $offset): bool
		{
			return array_key_exists($offset, $this->values);
		}

		public function offsetGet(mixed $offset): mixed
		{
			return $this->values[$offset] ?? null;
		}

		public function offsetSet(mixed $offset, mixed $value): void
		{
			$this->values[$offset] = $value;
		}

		public function offsetUnset(mixed $offset): void
		{
			unset($this->values[$offset]);
		}
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
		public const STATUS_DELETE_REQUESTED = 4;
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

	$gallery_root = dirname(__DIR__, 2);
	require_once $gallery_root . '/core/storage/provider_interface.php';
	require_once $gallery_root . '/core/storage/local_object.php';
	require_once $gallery_root . '/core/storage/local_provider.php';
	require_once $gallery_root . '/core/storage/workspace.php';
	require_once dirname(__DIR__) . '/revision.php';
	require_once dirname(__DIR__) . '/policy.php';
	require_once dirname(__DIR__) . '/migrations/m2_album_policy.php';
	require_once __DIR__ . '/fake_db.php';
}
