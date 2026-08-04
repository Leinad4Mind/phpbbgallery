<?php

namespace dmzx\topicindex\tests\core;

use dmzx\topicindex\core\functions_topicindex;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class functions_topicindex_test extends TestCase
{
	/**
	 * @dataProvider display_mode_provider
	 */
	public function test_normalises_display_mode($input, $expected)
	{
		$reflection = new ReflectionClass(functions_topicindex::class);
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
