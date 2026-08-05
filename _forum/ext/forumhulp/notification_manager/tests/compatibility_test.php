<?php

namespace forumhulp\notification_manager\tests;

use PHPUnit\Framework\TestCase;

class compatibility_test extends TestCase
{
	public function test_composer_constraints_match_the_typed_phpbb_33_codebase(): void
	{
		$composer = json_decode(file_get_contents(dirname(__DIR__) . '/composer.json'), true);

		$this->assertSame('3.3.0', $composer['version']);
		$this->assertSame('>=8.1', $composer['require']['php']);
		$this->assertSame('>=3.3.12,<4.0.0', $composer['require']['phpbb/phpbb']);
		$this->assertSame('proprietary', $composer['license']);
	}
}
