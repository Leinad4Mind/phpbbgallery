<?php
/**
 * phpBB Gallery - ACP Cleanup test bootstrap
 *
 * @package   phpbbgallery/acpcleanup
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- Isolated test doubles are loaded only by this bootstrap.

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
	}
}

namespace phpbb
{
	class user
	{
		public function format_date(int $timestamp, bool $show_rfc3339 = false, bool $forcedate = false): string
		{
			return (string) $timestamp;
		}
	}
}

namespace phpbb\language
{
	class language
	{
		public function lang(string $key, mixed ...$arguments): string
		{
			return $key . ($arguments ? ':' . implode(',', $arguments) : '');
		}
	}
}

namespace phpbbgallery\core\file
{
	class file
	{
		public array $deleted = [];
		public array $deleted_cache = [];

		public function delete(string $filename): void
		{
			$this->deleted[] = $filename;
		}

		public function delete_cache(string $filename): void
		{
			$this->deleted_cache[] = $filename;
		}
	}
}

namespace phpbbgallery\core\album
{
	class album
	{
		public function get_public(): int
		{
			return 0;
		}
	}
}

namespace phpbbgallery\core
{
	class block
	{
		public function get_image_status_unapproved(): int
		{
			return 0;
		}

		public function get_image_status_orphan(): int
		{
			return 2;
		}
	}

	class comment
	{
		public array $deleted = [];

		public function delete_comments(array $comment_ids): void
		{
			$this->deleted[] = $comment_ids;
		}
	}

	class config
	{
		public function get(string $key): int|string
		{
			return 0;
		}

		public function set(string $key, int|string $value): void
		{
		}

		public function dec(string $key, int $value): void
		{
		}
	}

	class log
	{
		public array $entries = [];

		public function add_log(string $mode, string $operation, int $reportee_id, int $image_id, array $data): void
		{
			$this->entries[] = [$mode, $operation, $reportee_id, $image_id, $data];
		}
	}

	class moderate
	{
		public array $deleted = [];

		public function delete_images(array $image_ids, mixed $files = []): void
		{
			$this->deleted[] = [$image_ids, $files];
		}
	}
}

namespace
{
	require_once dirname(__DIR__) . '/cleanup.php';
	require_once dirname(__DIR__) . '/acp/main_module.php';
	require_once dirname(__DIR__) . '/migrations/m1_init.php';
}
