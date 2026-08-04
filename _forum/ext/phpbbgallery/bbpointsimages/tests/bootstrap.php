<?php
// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- Isolated dependency stubs share the bootstrap.
// phpcs:disable PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- Native ArrayAccess methods.
/**
 * phpBB Gallery BBPoints Images test bootstrap
 *
 * @package   phpbbgallery/bbpointsimages
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

namespace phpbb\notification
{
	class exception extends \RuntimeException
	{
	}

	class manager
	{
		public array $calls = [];

		public function add_notifications(string $type, array $data): void
		{
			$this->calls[] = compact('type', 'data');
		}
	}
}

namespace phpbb\notification\type
{
	abstract class base
	{
		protected object $language;
		private array $test_data = [];

		public function __construct()
		{
			$this->language = new class {
				public function lang(string $key, mixed ...$arguments): string
				{
					return $key . ':' . implode('|', array_map('strval', $arguments));
				}
			};
		}

		protected function check_user_notification_options(array $users, mixed $options = []): array
		{
			return array_combine($users, $users) ?: [];
		}

		protected function set_data(string $name, mixed $value): void
		{
			$this->test_data[$name] = $value;
		}

		protected function get_data(string $name): mixed
		{
			return $this->test_data[$name] ?? null;
		}

		public function create_insert_array(mixed $data, mixed $pre_create_data = []): void
		{
		}
	}
}

namespace phpbb\controller
{
	class helper
	{
		public function route(string $name, array $parameters = []): string
		{
			return '/' . $name . '/' . ($parameters['image_id'] ?? 0);
		}
	}
}

namespace phpbb
{
	class user_loader
	{
		public array $loaded = [];

		public function load_users(array $user_ids): void
		{
			$this->loaded = array_values(array_unique(array_merge($this->loaded, $user_ids)));
		}

		public function get_username(int $user_id, string $mode): string
		{
			return 'User ' . $user_id;
		}

		public function get_avatar(int $user_id, bool $ignore_config = false, bool $lazy = false): string
		{
			return 'avatar:' . $user_id;
		}
	}
}

namespace phpbbgallery\core
{
	final class block
	{
		public const STATUS_APPROVED = 1;
	}

	final class url
	{
		public function __construct(private string $source_path)
		{
		}

		public function path(string $type): string
		{
			return $this->source_path;
		}
	}
}

namespace sitesplat\bbpoints\core
{
	final class distribution
	{
		public function __construct(private bool $created)
		{
		}

		public function was_created(): bool
		{
			return $this->created;
		}
	}

	final class operation
	{
		public function __construct(private bool $created)
		{
		}

		public function was_created(): bool
		{
			return $this->created;
		}
	}

	class ledger
	{
		public array $credits = [];
		public array $transfers = [];
		public array $distributions = [];

		public function credit(int $user_id, int $amount, string $reason, string $key): operation
		{
			$created = !isset($this->credits[$key]);
			$this->credits[$key] = compact('user_id', 'amount', 'reason', 'key');
			return new operation($created);
		}

		public function transfer(int $from_user_id, int $to_user_id, int $amount,
			string $reason, string $key, bool $allow_negative = false): operation
		{
			$created = !isset($this->transfers[$key]);
			$this->transfers[$key] = compact(
				'from_user_id', 'to_user_id', 'amount', 'reason', 'key', 'allow_negative'
			);
			return new operation($created);
		}

		public function distribute(int $from_user_id, array $recipients, string $reason,
			string $key, bool $allow_negative = false): distribution
		{
			$created = !isset($this->distributions[$key]);
			$this->distributions[$key] = compact(
				'from_user_id', 'recipients', 'reason', 'key', 'allow_negative'
			);
			return new distribution($created);
		}
	}
}

namespace phpbb\extension
{
	class base
	{
		protected object $container;

		public function enable_step(mixed $old_state): mixed
		{
			return false;
		}
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
	if (!function_exists('utf8_clean_string'))
	{
		function utf8_clean_string(string $value): string
		{
			return function_exists('mb_strtolower') ? mb_strtolower($value, 'UTF-8') : strtolower($value);
		}
	}
	if (!function_exists('utf8_htmlspecialchars'))
	{
		function utf8_htmlspecialchars(string $value): string
		{
			return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
		}
	}

	require_once dirname(__DIR__) . '/ext.php';
	require_once dirname(__DIR__) . '/policy.php';
	require_once dirname(__DIR__) . '/migrations/m1_init.php';
	require_once dirname(__DIR__) . '/migrations/m2_reward_lifecycle.php';
	require_once dirname(__DIR__) . '/migrations/m3_acp_settings.php';
	require_once dirname(__DIR__) . '/migrations/m4_contributor_policy.php';
	require_once dirname(__DIR__) . '/reward_manager.php';
	require_once dirname(__DIR__) . '/purchase_manager.php';
	require_once dirname(__DIR__) . '/contributor_manager.php';
	require_once dirname(__DIR__) . '/notification/helper.php';
	require_once dirname(__DIR__) . '/notification/type/reward.php';
	require_once dirname(__DIR__) . '/notification/type/source_purchase.php';
	require_once dirname(__DIR__) . '/retro_sync.php';
	require_once __DIR__ . '/fake_db.php';
	require_once __DIR__ . '/reward_fake_db.php';
	require_once __DIR__ . '/purchase_fake_db.php';
	require_once __DIR__ . '/contributor_fake_db.php';
}
