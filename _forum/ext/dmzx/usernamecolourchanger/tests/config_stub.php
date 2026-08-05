<?php

namespace phpbb\config;

class config implements \ArrayAccess
{
	/** @var array */
	private $values;

	public function __construct(array $values)
	{
		$this->values = $values;
	}

	#[\ReturnTypeWillChange]
	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- Required ArrayAccess API.
	public function offsetExists($offset)
	{
		return isset($this->values[$offset]);
	}

	#[\ReturnTypeWillChange]
	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- Required ArrayAccess API.
	public function offsetGet($offset)
	{
		return $this->values[$offset] ?? '';
	}

	#[\ReturnTypeWillChange]
	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- Required ArrayAccess API.
	public function offsetSet($offset, $value)
	{
		$this->values[$offset] = $value;
	}

	#[\ReturnTypeWillChange]
	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- Required ArrayAccess API.
	public function offsetUnset($offset)
	{
		unset($this->values[$offset]);
	}

	public function set($key, $value, $use_cache = true)
	{
		$this->values[$key] = $value;
	}
}
