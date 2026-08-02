<?php
/**
 * phpBB Gallery - Core Extension functional tests
 *
 * @package   phpbbgallery/core
 * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests\functional;

/**
 * Exercise the complete Gallery lifecycle against an installed phpBB board.
 *
 * @group functional
 */
class gallery_lifecycle extends \phpbb_functional_test_case
{
	private const COMPONENTS = [
		'phpbbgallery/core',
		'phpbbgallery/acpcleanup',
		'phpbbgallery/acpimport',
		'phpbbgallery/exif',
		'phpbbgallery/export',
		'phpbbgallery/feed',
	];

	/**
	 * Enable the complete supported Gallery package on the fresh test board.
	 *
	 * @return array
	 */
	protected static function setup_extensions(): array
	{
		return self::COMPONENTS;
	}

	/**
	 * Enable a component while accepting the Gallery's translated success message.
	 *
	 * The phpBB helper requires the generic EXTENSION_ENABLE_SUCCESS text, but
	 * Gallery components intentionally replace that text with component-specific
	 * guidance. All activation requests and continuation steps remain identical
	 * to the core functional helper.
	 *
	 * @param string $extension
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

	/**
	 * Test install, permissions, import, resumable upload, update and purge.
	 */
	public function test_gallery_end_to_end_lifecycle(): void
	{
		global $phpbb_root_path;

		$this->add_lang_ext('phpbbgallery/core', 'gallery');
		$this->add_lang_ext('phpbbgallery/acpimport', 'info_acp_gallery_import');

		$this->assert_components_are_installed();
		$album_id = $this->create_uploadable_album();

		// Guests must not inherit the administrator's album upload permission.
		$crawler = self::request('GET', 'app.php/gallery/album/' . $album_id . '/upload', [], false);
		self::assert_response_html(200);
		$this->assertStringContainsString($this->lang('LOGIN'), $crawler->filter('body')->text());

		$this->login();
		$crawler = self::request('GET', 'app.php/gallery?sid=' . $this->sid);
		$this->assertStringContainsString('Functional Album', $crawler->filter('body')->text());

		$this->admin_login();
		$this->run_import($album_id, $phpbb_root_path);
		$this->assert_forum_index_images();
		$this->run_resumable_upload($album_id, $phpbb_root_path);
		$this->logout();

		$this->purge_addons();
		$this->run_update();
		$this->uninstall_ext('phpbbgallery/core');

		$this->assert_gallery_is_purged($phpbb_root_path);
	}

	/**
	 * Confirm that migrations, configuration, storage and ACLs were installed.
	 */
	private function assert_components_are_installed(): void
	{
		$db = $this->get_db();
		$sql = 'SELECT COUNT(ext_name) AS total
			FROM ' . EXT_TABLE . '
			WHERE ' . $db->sql_in_set('ext_name', self::COMPONENTS) . '
				AND ext_active = 1';
		$result = $db->sql_query($sql);
		$this->assertSame(count(self::COMPONENTS), (int) $db->sql_fetchfield('total'));
		$db->sql_freeresult($result);

		$this->assertSame('4.0.0', $this->config_value('phpbb_gallery_version'));
		$this->assertSame('45', $this->config_value('phpbb_gallery_forum_index_display'));
		$this->assertSame('0', $this->config_value('phpbb_gallery_forum_index_mode'));
		$this->assertSame('0', $this->config_value('phpbb_gallery_forum_index_personal'));
		$this->assertSame('4', $this->config_value('phpbb_gallery_forum_index_random_count'));
		$this->assertSame('4', $this->config_value('phpbb_gallery_forum_index_recent_count'));
		$this->assertSame('0', $this->config_value('phpbb_gallery_ajax_navigation'));
		$result = $db->sql_query('SELECT image_subtitle FROM phpbb_gallery_images WHERE 1 = 0');
		$this->assertNotFalse($result);
		$db->sql_freeresult($result);
		$this->assertSame(1, $this->acl_option_count('a_gallery_manage'));
		$this->assertSame(1, $this->acl_option_count('a_gallery_albums'));
		$this->assertSame(1, $this->acl_option_count('a_gallery_import'));

		global $phpbb_root_path;
		foreach (['', 'source', 'medium', 'mini'] as $directory)
		{
			$path = $phpbb_root_path . 'files/phpbbgallery/core/' . $directory;
			$this->assertDirectoryIsWritable(rtrim($path, '/'));
		}
		$this->assertDirectoryIsWritable($phpbb_root_path . 'files/phpbbgallery/import');
	}

	/**
	 * Create an album and grant its complete Gallery role only to the administrator.
	 */
	private function create_uploadable_album(): int
	{
		$db = $this->get_db();
		$sql_ary = [
			'parent_id'        => 0,
			'left_id'          => 1,
			'right_id'         => 2,
			'album_type'       => \phpbbgallery\core\block::TYPE_UPLOAD,
			'album_status'     => \phpbbgallery\core\block::ALBUM_OPEN,
			'album_name'       => 'Functional Album',
			'album_user_id'    => \phpbbgallery\core\block::PUBLIC_ALBUM,
			'display_on_index' => 1,
		];
		$db->sql_query('INSERT INTO phpbb_gallery_albums ' . $db->sql_build_array('INSERT', $sql_ary));
		$album_id = (int) $db->sql_nextid();

		$role = array_fill_keys([
			'a_list', 'i_view', 'i_watermark', 'i_upload', 'i_edit', 'i_delete',
			'i_rate', 'i_approve', 'i_lock', 'i_report', 'i_unlimited', 'c_read',
			'c_post', 'c_edit', 'c_delete', 'm_comments', 'm_delete', 'm_edit',
			'm_move', 'm_report', 'm_status', 'i_move', 'a_unlimited',
		], 1);
		$role['i_count'] = 100;
		$role['a_count'] = 100;
		$role['a_restrict'] = 0;
		$db->sql_query('INSERT INTO phpbb_gallery_roles ' . $db->sql_build_array('INSERT', $role));
		$role_id = (int) $db->sql_nextid();

		$permission = [
			'perm_role_id'  => $role_id,
			'perm_album_id' => $album_id,
			'perm_user_id'  => 2,
			'perm_group_id' => 0,
			'perm_system'   => 0,
		];
		$db->sql_query('INSERT INTO phpbb_gallery_permissions ' . $db->sql_build_array('INSERT', $permission));
		$db->sql_query("UPDATE phpbb_gallery_users SET user_permissions = '' WHERE user_id IN (1, 2)");
		$this->purge_cache();

		return $album_id;
	}

	/**
	 * Import a real image through the ACP form and its resumable state request.
	 */
	private function run_import(int $album_id, string $phpbb_root_path): void
	{
		$import_name = 'functional-import.png';
		$import_path = $phpbb_root_path . 'files/phpbbgallery/import/' . $import_name;
		$this->write_test_png($import_path);

		$db = $this->get_db();
		$module_basename = '\phpbbgallery\acpimport\acp\main_module';
		$sql = 'SELECT module_id, module_auth
			FROM ' . MODULES_TABLE . "
			WHERE module_class = 'acp'
				AND module_basename = '" . $db->sql_escape($module_basename) . "'
				AND module_mode = 'import_images'";
		$result = $db->sql_query($sql);
		$module = $db->sql_fetchrow($result);
		$duplicate_module = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
		$this->assertIsArray($module);
		$this->assertFalse($duplicate_module);
		$this->assertSame('ext_phpbbgallery/acpimport && acl_a_gallery_import', $module['module_auth']);

		$crawler = self::request(
			'GET',
			'adm/index.php?i=' . (int) $module['module_id'] . '&mode=import_images&sid=' . $this->sid
		);
		self::assert_response_html(200);
		$this->assertStringContainsString($this->lang('ACP_IMPORT_ALBUMS'), $crawler->filter('body')->text());
		$this->assertSame(1, $crawler->filter('select[name="images[]"] option[value="' . $import_name . '"]')->count());

		$form = $crawler->selectButton('submit')->form();
		$crawler = self::submit($form, [
			'album_id'   => $album_id,
			'images'     => [$import_name],
			'username'   => 'admin',
			'image_name' => 'Functional import {NUM}',
			'image_num'  => 1,
		]);
		$crawler = $this->follow_meta_refresh($crawler);

		$sql = "SELECT image_filename
			FROM phpbb_gallery_images
			WHERE image_name = 'Functional import 1'
				AND image_album_id = " . $album_id . '
				AND image_status = ' . \phpbbgallery\core\block::STATUS_APPROVED;
		$result = $db->sql_query($sql);
		$image_filename = (string) $db->sql_fetchfield('image_filename');
		$db->sql_freeresult($result);

		$this->assertNotSame('', $image_filename, $crawler->filter('body')->text());
		$this->assertFileDoesNotExist($import_path);
		$this->assertFileExists($phpbb_root_path . 'files/phpbbgallery/core/source/' . $image_filename);
	}

	/**
	 * Confirm the forum-index block is opt-in and renders a permitted image.
	 */
	private function assert_forum_index_images(): void
	{
		$crawler = self::request('GET', 'index.php?sid=' . $this->sid);
		$this->assertSame(0, $crawler->filter('.phpbbgallery-forum-index')->count());

		$db = $this->get_db();
		$db->sql_query('UPDATE ' . CONFIG_TABLE . " SET config_value = '1' WHERE config_name = 'phpbb_gallery_forum_index_mode'");
		$db->sql_query('UPDATE ' . CONFIG_TABLE . " SET config_value = '1' WHERE config_name = 'phpbb_gallery_forum_index_recent_count'");
		$this->purge_cache();

		$crawler = self::request('GET', 'index.php?sid=' . $this->sid);
		$this->assertSame(1, $crawler->filter('.phpbbgallery-forum-index')->count());
		$this->assertStringContainsString('Functional import 1', $crawler->filter('.phpbbgallery-forum-index')->text());
		$this->assertSame(1, $crawler->filter('.phpbbgallery-forum-index img')->count());
	}

	/**
	 * Resume an unfinished upload from storage and cancel it through the real form.
	 */
	private function run_resumable_upload(int $album_id, string $phpbb_root_path): void
	{
		$db = $this->get_db();
		$filename = 'functional-resume.png';
		$file_path = $phpbb_root_path . 'files/phpbbgallery/core/source/' . $filename;
		$this->write_test_png($file_path);

		$image = [
			'image_filename'            => $filename,
			'image_name'                => 'Resumable draft',
			'image_name_clean'          => 'resumable draft',
			'image_user_id'             => 2,
			'image_username'            => 'admin',
			'image_username_clean'      => 'admin',
			'image_time'                => time(),
			'image_album_id'            => $album_id,
			'image_status'              => \phpbbgallery\core\block::STATUS_ORPHAN,
			'image_upload_session_hash' => '',
			'filesize_upload'           => filesize($file_path),
		];
		$db->sql_query('INSERT INTO phpbb_gallery_images ' . $db->sql_build_array('INSERT', $image));
		$image_id = (int) $db->sql_nextid();

		$path = 'app.php/gallery/album/' . $album_id . '/upload?sid=' . $this->sid;
		$crawler = self::request('GET', $path);
		$this->assertSame(
			'Resumable draft',
			$crawler->filter('input[name^="image_name"]')->first()->attr('value')
		);
		$this->assertSame(
			$image_id . '$' . $filename,
			$crawler->filter('input[name^="upload_ids"]')->first()->attr('value')
		);

		$form = $crawler->selectButton($this->lang('CANCEL'))->form();
		self::submit($form);

		$sql = 'SELECT COUNT(image_id) AS total
			FROM phpbb_gallery_images
			WHERE image_id = ' . $image_id;
		$result = $db->sql_query($sql);
		$this->assertSame(0, (int) $db->sql_fetchfield('total'));
		$db->sql_freeresult($result);
		$this->assertFileDoesNotExist($file_path);
	}

	/**
	 * Purge each dependent add-on before Core, as required by Core's guard.
	 */
	private function purge_addons(): void
	{
		foreach (array_reverse(array_slice(self::COMPONENTS, 1)) as $component)
		{
			$this->uninstall_ext($component);
		}
	}

	/**
	 * Re-run the terminal 4.0.0 migration from a simulated 3.4.0 installation.
	 */
	private function run_update(): void
	{
		$migration = '\\phpbbgallery\\core\\migrations\\release_4_0_0';
		$this->disable_ext('phpbbgallery/core');

		$db = $this->get_db();
		$db->sql_query("DELETE FROM phpbb_migrations WHERE migration_name = '" . $db->sql_escape($migration) . "'");
		$db->sql_query('UPDATE ' . CONFIG_TABLE . " SET config_value = '3.4.0' WHERE config_name = 'phpbb_gallery_version'");

		$this->install_ext('phpbbgallery/core');
		$this->assertSame('4.0.0', $this->config_value('phpbb_gallery_version'));

		$sql = "SELECT COUNT(migration_name) AS total
			FROM phpbb_migrations
			WHERE migration_name = '" . $db->sql_escape($migration) . "'";
		$result = $db->sql_query($sql);
		$this->assertSame(1, (int) $db->sql_fetchfield('total'));
		$db->sql_freeresult($result);
	}

	/**
	 * Confirm the purge removed database state and archived user files.
	 */
	private function assert_gallery_is_purged(string $phpbb_root_path): void
	{
		$db = $this->get_db();
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

		$this->assertSame(0, $this->acl_option_count('a_gallery_manage'));
		$this->assertFileDoesNotExist($phpbb_root_path . 'files/phpbbgallery/core');
		$this->assertNotEmpty(glob($phpbb_root_path . 'files/phpbbgallery/core_backup_*'));
		$this->assertNotEmpty(glob($phpbb_root_path . 'files/phpbbgallery/import_backup_*'));
	}

	/**
	 * Follow the ACP's meta-refresh continuation request.
	 */
	private function follow_meta_refresh($crawler)
	{
		$meta = $crawler->filter('meta[http-equiv="refresh"]');
		$this->assertSame(1, $meta->count(), $crawler->filter('body')->text());
		$this->assertMatchesRegularExpression('/url=(.+)$/i', $meta->attr('content'));
		preg_match('/url=(.+)$/i', $meta->attr('content'), $matches);
		$url = html_entity_decode($matches[1], ENT_QUOTES, 'UTF-8');
		$path = preg_replace('#^https?://[^/]+/#', '', $url);

		return self::request('GET', $path);
	}

	/**
	 * Read one phpBB configuration value directly from the functional database.
	 */
	private function config_value(string $name): string
	{
		$db = $this->get_db();
		$sql = 'SELECT config_value
			FROM ' . CONFIG_TABLE . "
			WHERE config_name = '" . $db->sql_escape($name) . "'";
		$result = $db->sql_query($sql);
		$value = (string) $db->sql_fetchfield('config_value');
		$db->sql_freeresult($result);

		return $value;
	}

	/**
	 * Count one administrator permission option.
	 */
	private function acl_option_count(string $permission): int
	{
		$db = $this->get_db();
		$sql = 'SELECT COUNT(auth_option_id) AS total
			FROM ' . ACL_OPTIONS_TABLE . "
			WHERE auth_option = '" . $db->sql_escape($permission) . "'";
		$result = $db->sql_query($sql);
		$count = (int) $db->sql_fetchfield('total');
		$db->sql_freeresult($result);

		return $count;
	}

	/**
	 * Write a valid one-pixel PNG fixture without shipping binary test data.
	 */
	private function write_test_png(string $path): void
	{
		$png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=', true);
		$this->assertNotFalse($png);
		$this->assertNotFalse(file_put_contents($path, $png));
	}
}
