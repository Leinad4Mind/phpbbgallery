<?php

namespace devspace\autodbbackup\tests;

use devspace\autodbbackup\core\functions;
use PHPUnit\Framework\TestCase;

class functions_test extends TestCase
{
	public function test_all_version_constraints_must_pass(): void
	{
		$functions = $this->get_functions();

		$this->assertTrue($functions->constraints('3.3.12', '>=3.3.0,<4.0.0@dev'));
		$this->assertFalse($functions->constraints('3.2.11', '>=3.3.0,<4.0.0@dev'));
		$this->assertFalse($functions->constraints('4.0.0', '>=3.3.0,<4.0.0@dev'));
	}

	public function test_malformed_constraint_fails_closed(): void
	{
		$this->assertFalse($this->get_functions()->constraints('3.3.12', '^3.3'));
	}

	private function get_functions()
	{
		return new class extends functions
		{
			public function __construct()
			{
			}

			public function constraints($current, $constraints)
			{
				return $this->matches_constraints($current, $constraints);
			}
		};
	}
}
