<?php

namespace dmzx\usernamecolourchanger\tests;

use dmzx\usernamecolourchanger\core\colour_helper;
use PHPUnit\Framework\TestCase;

class colour_helper_test extends TestCase
{
	/**
	 * @dataProvider valid_colour_data
	 */
	public function test_normalises_valid_colours($input, $expected)
	{
		$this->assertSame($expected, (new colour_helper())->normalise($input));
	}

	public static function valid_colour_data()
	{
		return [
			'empty' => ['', ''],
			'whitespace' => ['   ', ''],
			'six digits' => ['a1b2c3', 'A1B2C3'],
			'leading hash' => ['#abcdef', 'ABCDEF'],
			'three digits' => ['a0F', 'AA00FF'],
		];
	}

	/**
	 * @dataProvider invalid_colour_data
	 */
	public function test_rejects_invalid_colours($input)
	{
		$this->assertFalse((new colour_helper())->normalise($input));
	}

	public static function invalid_colour_data()
	{
		return [
			'too short' => ['12'],
			'too long' => ['1234567'],
			'non hexadecimal' => ['ZZZZZZ'],
			'css injection' => ['000;display:block'],
			'double hash' => ['##fff'],
		];
	}
}
