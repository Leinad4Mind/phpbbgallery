<?php
/**
 * phpBB Gallery - Export test bootstrap
 *
 * @package   phpbbgallery/export
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

namespace phpbb\config
{
	if (!class_exists('phpbb\\config\\config', false))
	{
		class config implements \ArrayAccess
		{
			protected array $values;

			public function __construct(array $values = [])
			{
				$this->values = $values;
			}

			public function offsetExists(mixed $offset): bool
			{
				return isset($this->values[$offset]);
			}

			#[\ReturnTypeWillChange]
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

			public function set(string $key, mixed $value): void
			{
				$this->values[$key] = $value;
			}
		}
	}
}

namespace phpbb\language
{
	if (!class_exists('phpbb\\language\\language', false))
	{
		/**
		 * Returns the key itself, so a test can assert on the string the code chose
		 * rather than on a translation.
		 */
		class language
		{
			public function lang(string $key, ...$args): string
			{
				return $key;
			}
		}
	}
}

namespace phpbb\cron\task
{
	if (!class_exists('phpbb\\cron\\task\\base', false))
	{
		abstract class base
		{
			protected string $name = '';

			public function set_name(string $name): void
			{
				$this->name = $name;
			}

			public function get_name(): string
			{
				return $this->name;
			}
		}
	}
}

namespace phpbbgallery\core
{
	if (!class_exists('phpbbgallery\\core\\cache', false))
	{
		class cache
		{
			protected array $albums;

			public function __construct(array $albums = [])
			{
				$this->albums = $albums;
			}

			public function get_albums(): array
			{
				return $this->albums;
			}
		}
	}
}

namespace phpbbgallery\core\auth
{
	if (!class_exists('phpbbgallery\\core\\auth\\auth', false))
	{
		class auth
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

	if (!function_exists('generate_board_url'))
	{
		function generate_board_url(): string
		{
			return 'https://board.example';
		}
	}

	if (!function_exists('get_formatted_filesize'))
	{
		function get_formatted_filesize(int $bytes): string
		{
			return $bytes . ' B';
		}
	}

	// The extension restores an image's real name from the display name plus the
	// extension of the stored file, so the core helper that maps one to the other
	// is exercised as it ships rather than re-implemented here.
	require_once dirname(__DIR__, 2) . '/core/block.php';
	require_once dirname(__DIR__, 2) . '/core/file/file.php';

	require_once dirname(__DIR__) . '/path.php';
	require_once dirname(__DIR__) . '/archive.php';
	require_once dirname(__DIR__) . '/job_storage.php';
	require_once dirname(__DIR__) . '/export.php';
	require_once dirname(__DIR__) . '/runner.php';
	require_once dirname(__DIR__) . '/cron/prune_exports.php';
}
