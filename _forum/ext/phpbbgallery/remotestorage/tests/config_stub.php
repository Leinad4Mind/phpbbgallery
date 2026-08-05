<?php
// phpcs:ignoreFile PSR1.Files.SideEffects.FoundWithSymbols -- Isolated phpBB config test double.

namespace phpbb\config;

if (!class_exists(config::class))
{
	class config implements \ArrayAccess
	{
		/** @param array<string, string> $values */
		public function __construct(private array $values)
		{
		}

		public function offsetExists(mixed $offset): bool
		{
			return isset($this->values[$offset]);
		}

		public function offsetGet(mixed $offset): mixed
		{
			return $this->values[$offset] ?? '';
		}

		public function offsetSet(mixed $offset, mixed $value): void
		{
			$this->values[$offset] = $value;
		}

		public function offsetUnset(mixed $offset): void
		{
			unset($this->values[$offset]);
		}

		public function set(string $key, mixed $value, bool $use_cache = true): void
		{
			$this->values[$key] = $value;
		}
	}
}
