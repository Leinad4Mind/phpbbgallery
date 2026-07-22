<?php
/**
 * phpBB Gallery - Core Extension tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;
use phpbbgallery\core\acp\main_module;

class acp_personal_resync_test extends TestCase
{
	public function test_resync_stores_the_newest_personal_gallery(): void
	{
		$config = $this->config_spy();

		$this->update_config($config, [
			'user_id' => '42',
			'username' => 'Gallery owner',
			'user_colour' => 'AABBCC',
			'album_id' => '91',
		]);

		$this->assertSame([
			'newest_pega_user_id' => 42,
			'newest_pega_username' => 'Gallery owner',
			'newest_pega_user_colour' => 'AABBCC',
			'newest_pega_album_id' => 91,
		], $config->values);
	}

	public function test_resync_clears_newest_personal_gallery_when_no_rows_exist(): void
	{
		$config = $this->config_spy();

		$this->update_config($config, []);

		$this->assertSame([
			'newest_pega_user_id' => 0,
			'newest_pega_username' => '',
			'newest_pega_user_colour' => '',
			'newest_pega_album_id' => 0,
		], $config->values);
	}

	public function test_acp_resync_normalizes_an_empty_database_result_before_indexing(): void
	{
		$module = file_get_contents(dirname(__DIR__) . '/acp/main_module.php');

		$this->assertStringContainsString('$db->sql_fetchrow($result) ?: []', $module);
		$this->assertStringContainsString('update_newest_personal_gallery_config($phpbb_ext_gallery_config, $newest_pgallery)', $module);
		$this->assertStringNotContainsString("\$newest_pgallery['user_id']", $module);
		$this->assertStringNotContainsString("\$newest_pgallery['album_id']", $module);
	}

	/**
	 * @param object $config
	 * @param array  $gallery
	 */
	private function update_config($config, array $gallery): void
	{
		$module = new main_module();
		$update = \Closure::bind(function ($config, array $gallery): void
		{
			$this->update_newest_personal_gallery_config($config, $gallery);
		}, $module, main_module::class);
		$update($config, $gallery);
	}

	/**
	 * @return object
	 */
	private function config_spy()
	{
		return new class {
			/** @var array */
			public $values = [];

			public function set($name, $value): void
			{
				$this->values[$name] = $value;
			}
		};
	}
}
