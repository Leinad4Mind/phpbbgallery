<?php
/**
 * phpBB Gallery packaged component lifecycle functional tests.
 *
 * @package   phpbbgallery/core
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests\functional;

/**
 * Exercise every packaged Gallery component on a fresh phpBB board.
 *
 * @group functional
 */
class package_lifecycle extends \phpbb_functional_test_case
{
	private const ADDONS = [
		'phpbbgallery/acpcleanup' => '1.4.0',
		'phpbbgallery/acpimport' => '1.4.0',
		'phpbbgallery/bbpointsimages' => '1.0.0',
		'phpbbgallery/bbtagsimages' => '1.0.0',
		'phpbbgallery/contest' => '1.0.0',
		'phpbbgallery/exif' => '1.4.0',
		'phpbbgallery/export' => '1.0.0',
		'phpbbgallery/favorite' => '1.0.0',
		'phpbbgallery/feed' => '1.0.0',
		'phpbbgallery/imagerevisions' => '1.0.0',
		'phpbbgallery/remotestorage' => '1.0.0',
	];

	private const COMPONENTS = [
		'phpbbgallery/core' => '4.0.0',
		...self::ADDONS,
	];

	protected static function setup_extensions(): array
	{
		return [
			'sitesplat/BBCore',
			'sitesplat/bbpoints',
			'sitesplat/bbtags',
			...array_keys(self::COMPONENTS),
		];
	}

	/**
	 * Accept component-specific success messages and continuation steps.
	 *
	 * @param string $extension Extension identifier
	 */
	public function install_ext($extension): void
	{
		$this->add_lang('acp/extensions');
		$this->login();
		$this->admin_login();

		$ext_path = str_replace('/', '%2F', $extension);
		$crawler = self::request('GET', 'adm/index.php?i=acp_extensions&mode=main&action=enable_pre&ext_name=' . $ext_path . '&sid=' . $this->sid);
		$this->assertGreaterThan(1, $crawler->filter('div.main fieldset.submit-buttons input')->count());
		$form = $crawler->selectButton($this->lang('EXTENSION_ENABLE'))->form();
		$crawler = self::submit($form);
		$meta_refresh = $crawler->filter('meta[http-equiv="refresh"]');
		while ($meta_refresh->count())
		{
			preg_match('#url=.+/(adm.+)#', $meta_refresh->attr('content'), $matches);
			$crawler = self::request('POST', $matches[1]);
			$meta_refresh = $crawler->filter('meta[http-equiv="refresh"]');
		}

		$this->assertNotSame('', trim($crawler->filter('div.successbox')->text()));
		$this->logout();
	}

	public function test_every_release_package_can_be_disabled_reenabled_and_purged(): void
	{
		global $phpbb_root_path;

		$this->assert_packaged_versions($phpbb_root_path);
		$this->assert_active_components(array_keys(self::COMPONENTS));

		// Core owns the dependency boundary and must disable every Gallery add-on first.
		$this->disable_ext('phpbbgallery/core');
		$this->assert_active_components([]);

		$this->install_ext('phpbbgallery/core');
		foreach (array_keys(self::ADDONS) as $addon)
		{
			$this->install_ext($addon);
		}
		$this->assert_active_components(array_keys(self::COMPONENTS));

		foreach (array_reverse(array_keys(self::ADDONS)) as $addon)
		{
			$this->uninstall_ext($addon);
		}
		$this->uninstall_ext('phpbbgallery/core');

		$this->assert_components_are_purged();
	}

	private function assert_packaged_versions(string $phpbb_root_path): void
	{
		foreach (self::COMPONENTS as $extension => $expected_version)
		{
			$composer_path = $phpbb_root_path . 'ext/' . $extension . '/composer.json';
			$this->assertFileExists($composer_path);
			$composer = json_decode((string) file_get_contents($composer_path), true, 512, JSON_THROW_ON_ERROR);
			$this->assertSame($extension, $composer['name']);
			$this->assertSame($expected_version, $composer['version']);
			$this->assertFileExists($phpbb_root_path . 'ext/' . $extension . '/license.txt');
		}
	}

	/**
	 * @param list<string> $expected_components
	 */
	private function assert_active_components(array $expected_components): void
	{
		$db = $this->get_db();
		$sql = 'SELECT ext_name
			FROM ' . EXT_TABLE . '
			WHERE ' . $db->sql_in_set('ext_name', array_keys(self::COMPONENTS)) . '
				AND ext_active = 1
			ORDER BY ext_name ASC';
		$result = $db->sql_query($sql);
		$actual_components = [];
		while ($row = $db->sql_fetchrow($result))
		{
			$actual_components[] = $row['ext_name'];
		}
		$db->sql_freeresult($result);

		sort($expected_components);
		$this->assertSame($expected_components, $actual_components);
	}

	private function assert_components_are_purged(): void
	{
		$db = $this->get_db();

		$sql = 'SELECT COUNT(ext_name) AS total
			FROM ' . EXT_TABLE . '
			WHERE ' . $db->sql_in_set('ext_name', array_keys(self::COMPONENTS));
		$result = $db->sql_query($sql);
		$this->assertSame(0, (int) $db->sql_fetchfield('total'));
		$db->sql_freeresult($result);

		$sql = 'SELECT COUNT(config_name) AS total
			FROM ' . CONFIG_TABLE . "
			WHERE config_name LIKE 'phpbb_gallery_%'";
		$result = $db->sql_query($sql);
		$this->assertSame(0, (int) $db->sql_fetchfield('total'));
		$db->sql_freeresult($result);

		$sql = "SELECT COUNT(name) AS total
			FROM sqlite_master
			WHERE type = 'table'
				AND name LIKE 'phpbb_gallery_%'";
		$result = $db->sql_query($sql);
		$this->assertSame(0, (int) $db->sql_fetchfield('total'));
		$db->sql_freeresult($result);
	}
}
