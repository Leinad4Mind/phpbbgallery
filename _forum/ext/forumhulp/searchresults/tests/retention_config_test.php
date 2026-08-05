<?php

namespace forumhulp\searchresults\tests;

use PHPUnit\Framework\TestCase;

class retention_config_test extends TestCase
{
	public function test_new_installations_use_a_limit_of_fifty(): void
	{
		$migration = (string) file_get_contents(
			dirname(__DIR__) . '/migrations/v31x/m2_config_data.php'
		);

		$this->assertStringContainsString("array('prune_searchresults', 50)", $migration);
	}
}
