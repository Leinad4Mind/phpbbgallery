<?php
/**
 * phpBB Gallery - ACP Cleanup migration tests
 *
 * @package   phpbbgallery/acpcleanup
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\acpcleanup\tests;

use phpbbgallery\acpcleanup\migrations\m1_init;
use PHPUnit\Framework\TestCase;

final class migration_test extends TestCase
{
	public function test_migration_contract_is_public_and_typed(): void
	{
		$reflection = new \ReflectionClass(m1_init::class);

		foreach (['depends_on', 'update_data'] as $method_name)
		{
			$method = $reflection->getMethod($method_name);
			$this->assertTrue($method->isPublic(), $method_name);
			$this->assertSame('array', (string) $method->getReturnType(), $method_name);
			$this->assertSame([], $method->getParameters(), $method_name);
		}
	}

	public function test_migration_installs_the_expected_permission_and_module(): void
	{
		$migration = new m1_init();
		$steps = $migration->update_data();

		$this->assertSame(['\phpbbgallery\core\migrations\release_1_2_0'], m1_init::depends_on());
		$this->assertSame(['permission.add', ['a_gallery_cleanup', true, 'a_board']], $steps[0]);
		$this->assertSame('module.add', $steps[1][0]);
		$this->assertSame('\phpbbgallery\acpcleanup\acp\main_module', $steps[1][1][2]['module_basename']);
		$this->assertSame('ext_phpbbgallery/acpcleanup && acl_a_gallery_cleanup', $steps[1][1][2]['module_auth']);
	}
}
