<?php
/**
 * BBPrefix tests.
 *
 * @package BBprefix
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbprefix\tests;

/**
 * Reproduces the one behaviour of phpbb\request\request that these tests
 * actually depend on: reading a raw scalar value against an array-typed
 * $default discards it to an empty array
 * (type_cast_helper::recursive_set_var()'s `is_array($var) !== is_array($default)`
 * branch) - it does not coerce it into a one-element array. The plain
 * manager_test_request double used elsewhere always echoes back whatever
 * $default it is given, which cannot represent "the user actually sent
 * ?prefix=16" at all, so it cannot exercise that regression.
 */
class fake_request
{
	/** @var array Raw values as if read from $_GET/$_POST, keyed by name */
	public array $raw = [];

	public function variable($name, $default = '', $multibyte = false)
	{
		if (!array_key_exists($name, $this->raw))
		{
			return $default;
		}

		$value = $this->raw[$name];

		if (is_array($value) !== is_array($default))
		{
			return is_array($default) ? [] : $default;
		}

		if (is_array($default))
		{
			return array_map('intval', $value);
		}

		return is_int($default) ? (int) $value : $value;
	}

	public function is_set_post($name)
	{
		return array_key_exists($name, $this->raw);
	}
}
