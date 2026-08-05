<?php
/**
 *
 * @package Error Pages
 * @copyright (c) 2014 ForumHulp.com
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

namespace forumhulp\errorpages\tests\migrations;

use forumhulp\errorpages\migrations\errorpages_3_2_0;
use forumhulp\errorpages\migrations\install_errorpages;
use phpbb\config\config;
use phpbb\db\driver\driver_interface;
use phpbb\db\tools\tools_interface;
use PHPUnit\Framework\TestCase;

class migration_test extends TestCase
{
	public function test_installation_requires_both_settings()
	{
		$migration = $this->create_migration(install_errorpages::class, ['error_pages_log' => 1]);
		self::assertFalse($migration->effectively_installed());

		$migration = $this->create_migration(install_errorpages::class, [
			'error_pages_log' => 1,
			'error_pages_explain' => 1,
		]);
		self::assertTrue($migration->effectively_installed());
	}

	public function test_clean_install_defaults_to_safe_logging()
	{
		$migration = $this->create_migration(install_errorpages::class, []);
		self::assertSame([
			['config.add', ['error_pages_log', 0]],
			['config.add', ['error_pages_explain', 1]],
		], $migration->update_data());
	}

	public function test_upgrade_repairs_missing_settings_without_version_config()
	{
		$migration = $this->create_migration(errorpages_3_2_0::class, []);
		$data = $migration->update_data();

		self::assertSame('config.add', $data[0][0]);
		self::assertSame('config.add', $data[1][0]);
		self::assertStringNotContainsString('config.update', var_export($data, true));
	}

	private function create_migration($class, array $settings)
	{
		return new $class(
			new config($settings),
			$this->createMock(driver_interface::class),
			$this->createMock(tools_interface::class),
			'',
			'php',
			'phpbb_'
		);
	}
}
