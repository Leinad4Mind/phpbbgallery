<?php
// phpcs:disable PSR1.Files.SideEffects, Generic.Files.OneClassPerFile.MultipleFound
// phpcs:disable PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- Native ArrayAccess methods.
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

namespace phpbb\config
{
	class config implements \ArrayAccess
	{
		private array $values;

		public function __construct(array $values = [])
		{
			$this->values = $values;
		}

		public function offsetExists($offset): bool
		{
			return array_key_exists($offset, $this->values);
		}

		public function offsetGet($offset): mixed
		{
			return $this->values[$offset] ?? null;
		}

		public function offsetSet($offset, $value): void
		{
			$this->values[$offset] = $value;
		}

		public function offsetUnset($offset): void
		{
			unset($this->values[$offset]);
		}
	}
}

namespace phpbb\auth
{
	class auth
	{
	}
}

namespace
{
	if (!defined('IN_PHPBB'))
	{
		define('IN_PHPBB', true);
	}

	if (!function_exists('utf8_normalize_nfc'))
	{
		function utf8_normalize_nfc(string $value): string
		{
			return $value;
		}
	}

	if (!function_exists('utf8_strtolower'))
	{
		function utf8_strtolower(string $value): string
		{
			return mb_strtolower($value, 'UTF-8');
		}
	}

	if (!function_exists('utf8_substr'))
	{
		function utf8_substr(string $value, int $offset, ?int $length = null): string
		{
			return mb_substr($value, $offset, $length, 'UTF-8');
		}
	}

	if (!function_exists('utf8_clean_string'))
	{
		function utf8_clean_string(string $value): string
		{
			return mb_strtolower(trim($value), 'UTF-8');
		}
	}

	if (!function_exists('utf8_strlen'))
	{
		function utf8_strlen(string $value): int
		{
			return mb_strlen($value, 'UTF-8');
		}
	}

	require_once dirname(__DIR__, 3) . '/sitesplat/bbtags/provider/provider_interface.php';
	require_once dirname(__DIR__, 3) . '/sitesplat/bbtags/tags/manager.php';
	require_once dirname(__DIR__) . '/image_tag_manager.php';
	require_once dirname(__DIR__) . '/input_parser.php';
	require_once dirname(__DIR__) . '/album_scope_resolver.php';
	require_once dirname(__DIR__) . '/provider/image_provider.php';
}
