<?php
/**
 * Minimal phpBB config stub for isolated Gallery tests.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbb\config;

class config implements \ArrayAccess
{
	private array $values;

	public function __construct(array $values)
	{
		$this->values = $values;
	}

	// phpcs:disable PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- Required ArrayAccess API.
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
	// phpcs:enable PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed

	public function set(string $key, mixed $value): void
	{
		$this->values[$key] = $value;
	}

	public function increment(string $key, int $increment): void
	{
		$this->values[$key] = (int) ($this->values[$key] ?? 0) + $increment;
	}
}
