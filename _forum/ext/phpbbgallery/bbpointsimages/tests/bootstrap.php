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

namespace phpbbgallery\core
{
	final class block
	{
		public const STATUS_APPROVED = 1;
	}
}

namespace sitesplat\bbpoints\core
{
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

	require_once dirname(__DIR__) . '/ext.php';
	require_once dirname(__DIR__) . '/policy.php';
	require_once dirname(__DIR__) . '/migrations/m1_init.php';
	require_once dirname(__DIR__) . '/migrations/m2_reward_lifecycle.php';
	require_once dirname(__DIR__) . '/reward_manager.php';
	require_once __DIR__ . '/fake_db.php';
	require_once __DIR__ . '/reward_fake_db.php';
}
