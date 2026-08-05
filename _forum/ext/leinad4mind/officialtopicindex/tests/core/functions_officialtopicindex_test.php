<?php

namespace leinad4mind\officialtopicindex\tests\core;

use leinad4mind\officialtopicindex\core\functions_officialtopicindex;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class functions_officialtopicindex_test extends TestCase
{
	/**
	 * @dataProvider display_mode_provider
	 */
	public function test_normalises_display_mode($input, $expected)
	{
		$reflection = new ReflectionClass(functions_officialtopicindex::class);
		$functions = $reflection->newInstanceWithoutConstructor();

		$this->assertSame($expected, $functions->normalise_display_mode($input));
	}

	public static function display_mode_provider()
	{
		return [
			'before' => ['before', 'before'],
			'after' => ['after', 'after'],
			'replace' => ['replace', 'replace'],
			'invalid' => ['invalid', 'after'],
		];
	}
}
