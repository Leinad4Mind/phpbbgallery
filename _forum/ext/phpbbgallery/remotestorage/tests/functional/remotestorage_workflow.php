<?php
/**
 * phpBB Gallery - Remote Storage functional tests
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\tests\functional;

/** Exercise local, MinIO and Azurite storage migrations and delivery. */
class remotestorage_workflow extends \phpbb_functional_test_case
{
	private const ENDPOINT = 'http://127.0.0.1:9000';
	private const BUCKET = 'phpbbgallery-functional';
	private const ACCESS_KEY = 'phpbbgallery';
	private const SECRET_KEY = 'phpbbgallery-functional-secret';
	private const PREFIX = 'functional-board';
	private const AZURE_ENDPOINT = 'http://127.0.0.1:10000/devstoreaccount1';
	private const AZURE_ACCOUNT = 'devstoreaccount1';
	private const AZURE_CONTAINER = 'phpbbgallery-functional';
	private const AZURE_ACCOUNT_KEY = 'Eby8vdM02xNOcqFlqUwJPLlmEtlCDXJ1OUzFT50uSRZ6IFsuFq2UVErCz4I6tq/K1SZFPTOtr/KBHBeksoGMGw==';

	protected static function setup_extensions(): array
	{
		return ['phpbbgallery/core', 'phpbbgallery/remotestorage'];
	}

	/** Accept the Gallery component activation success messages. */
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
		$meta_refresh = $crawler->filter('meta[http-equiv=' . chr(34) . 'refresh' . chr(34) . ']');
		while ($meta_refresh->count())
		{
			preg_match('#url=.+/(adm.+)#', $meta_refresh->attr('content'), $matches);
			$crawler = self::request('POST', $matches[1]);
			$meta_refresh = $crawler->filter('meta[http-equiv=' . chr(34) . 'refresh' . chr(34) . ']');
		}

		$this->assertNotSame('', trim($crawler->filter('div.successbox')->text()));
		$this->logout();
	}

	public function test_remote_provider_migration_delivery_and_temporary_cleanup(): void
	{
		global $phpbb_root_path;

		$this->add_lang_ext('phpbbgallery/remotestorage', 'info_acp_remotestorage');
		$this->login();
		$this->admin_login();
		$module_id = $this->module_id();
		$this->save_connections($module_id);

		[$album_id, $image_id, $filename, $original] = $this->create_remote_image($phpbb_root_path);
		$this->migrate($module_id, 's3');
		$this->assertSame('s3', $this->config_value('phpbb_gallery_storage_provider'));

		$this->remove_local_variants($phpbb_root_path, $filename);
		$this->assertSame(0, $this->workspace_file_count($phpbb_root_path));
		$this->assert_remote_source($album_id, $image_id, $original, $phpbb_root_path);
		$this->migrate($module_id, 'azure');
		$this->assertSame('azure', $this->config_value('phpbb_gallery_storage_provider'));
		$this->assert_remote_source($album_id, $image_id, $original, $phpbb_root_path);

		$this->migrate($module_id, 'local');
		$this->assertSame('local', $this->config_value('phpbb_gallery_storage_provider'));
		foreach (['source', 'medium', 'mini'] as $variant)
		{
			$this->assertFileExists($phpbb_root_path . 'files/phpbbgallery/core/' . $variant . '/' . $filename);
		}
	}

	private function save_connections(int $module_id): void
	{
		$crawler = self::request('GET', $this->module_url($module_id));
		$form = $crawler->selectButton('save_s3')->form();
		$crawler = self::submit($form, [
			'endpoint' => self::ENDPOINT,
			'bucket' => self::BUCKET,
			'access_key' => self::ACCESS_KEY,
			'secret_key' => self::SECRET_KEY,
			'region' => 'us-east-1',
			'prefix' => self::PREFIX,
		]);
		$this->assertStringContainsString(
			$this->lang('REMOTE_STORAGE_SETTINGS_SAVED'),
			$crawler->filter('body')->text()
		);

		$crawler = self::request('GET', $this->module_url($module_id));
		$form = $crawler->selectButton('save_azure')->form();
		$crawler = self::submit($form, [
			'endpoint' => self::AZURE_ENDPOINT,
			'account' => self::AZURE_ACCOUNT,
			'container' => self::AZURE_CONTAINER,
			'account_key' => self::AZURE_ACCOUNT_KEY,
			'prefix' => self::PREFIX,
		]);
		$this->assertStringContainsString(
			$this->lang('REMOTE_STORAGE_SETTINGS_SAVED'),
			$crawler->filter('body')->text()
		);
	}

	private function migrate(int $module_id, string $target): void
	{
		$crawler = self::request('GET', $this->module_url($module_id));
		$form = $crawler->selectButton('start_migration')->form();
		$crawler = self::submit($form, ['target_provider' => $target]);
		$form = $crawler->selectButton($this->lang('YES'))->form();
		$crawler = self::submit($form);

		for ($step = 0; $step < 10 && $this->config_value('phpbb_gallery_storage_provider') !== $target; $step++)
		{
			$this->assertSame(1, $crawler->filter('input[name=continue_migration]')->count(), $crawler->filter('body')->text());
			$form = $crawler->selectButton('continue_migration')->form();
			$crawler = self::submit($form);
		}

		$this->assertSame($target, $this->config_value('phpbb_gallery_storage_provider'));
		$this->assertStringContainsString($this->lang('REMOTE_STORAGE_MIGRATION_COMPLETE'), $crawler->filter('body')->text());
	}

	/** @return array{0: int, 1: int, 2: string, 3: string} */
	private function create_remote_image(string $root): array
	{
		$db = $this->get_db();
		$album = [
			'parent_id' => 0,
			'left_id' => 1,
			'right_id' => 2,
			'album_type' => \phpbbgallery\core\block::TYPE_UPLOAD,
			'album_status' => \phpbbgallery\core\block::ALBUM_OPEN,
			'album_name' => 'MinIO Functional Album',
			'album_user_id' => \phpbbgallery\core\block::PUBLIC_ALBUM,
			'album_watermark' => 1,
		];
		$db->sql_query('INSERT INTO phpbb_gallery_albums ' . $db->sql_build_array('INSERT', $album));
		$album_id = (int) $db->sql_nextid();

		$role = array_fill_keys([
			'a_list', 'i_view', 'i_upload', 'i_edit', 'i_delete', 'i_rate',
			'i_approve', 'i_lock', 'i_report', 'i_unlimited', 'c_read', 'c_post',
			'c_edit', 'c_delete', 'm_comments', 'm_delete', 'm_edit', 'm_move',
			'm_report', 'm_status', 'i_move', 'a_unlimited',
		], 1);
		$role['i_watermark'] = 0;
		$role['i_count'] = 100;
		$role['a_count'] = 100;
		$role['a_restrict'] = 0;
		$db->sql_query('INSERT INTO phpbb_gallery_roles ' . $db->sql_build_array('INSERT', $role));
		$role_id = (int) $db->sql_nextid();
		$db->sql_query('INSERT INTO phpbb_gallery_permissions ' . $db->sql_build_array('INSERT', [
			'perm_role_id' => $role_id,
			'perm_album_id' => $album_id,
			'perm_user_id' => 2,
			'perm_group_id' => 0,
			'perm_system' => 0,
		]));

		$filename = 'minio-functional.png';
		$source = $root . 'files/phpbbgallery/core/source/' . $filename;
		$this->write_png($source, 400, 300);
		$original = (string) file_get_contents($source);
		foreach (['medium', 'mini'] as $variant)
		{
			$this->write_png($root . 'files/phpbbgallery/core/' . $variant . '/' . $filename, 80, 60);
		}

		$image = [
			'image_filename' => $filename,
			'image_name' => 'MinIO functional image',
			'image_name_clean' => 'minio functional image',
			'image_user_id' => 2,
			'image_username' => 'admin',
			'image_username_clean' => 'admin',
			'image_time' => time(),
			'image_album_id' => $album_id,
			'image_status' => \phpbbgallery\core\block::STATUS_APPROVED,
			'filesize_upload' => strlen($original),
		];
		$db->sql_query('INSERT INTO phpbb_gallery_images ' . $db->sql_build_array('INSERT', $image));
		$image_id = (int) $db->sql_nextid();
		$db->sql_query('UPDATE phpbb_gallery_users SET user_permissions = ' . chr(39) . chr(39) . ' WHERE user_id = 2');
		$this->set_config_value('phpbb_gallery_watermark_enabled', '1');
		$this->set_config_value('phpbb_gallery_watermark_height', '0');
		$this->set_config_value('phpbb_gallery_watermark_width', '0');
		$this->purge_cache();

		return [$album_id, $image_id, $filename, $original];
	}

	private function assert_remote_source(int $album_id, int $image_id, string $original, string $root): void
	{
		self::$client->setServerParameter('HTTP_USER_AGENT', 'Mozilla/5.0');
		$path = 'app.php/gallery/image/' . $image_id . '/source?sid=' . $this->sid;
		self::request('GET', $path, [], false);
		self::assert_response_status_code(200);
		$response = self::$client->getResponse();
		$this->assertSame('nosniff', $response->getHeader('X-Content-Type-Options'));
		$this->assertStringStartsWith('inline;', (string) $response->getHeader('Content-Disposition'));
		$this->assertStringStartsWith('image/png', (string) $response->getHeader('Content-Type'));
		$this->assertNotSame($original, $response->getContent());
		$this->assertSame(0, $this->workspace_file_count($root));

		$db = $this->get_db();
		$db->sql_query('UPDATE phpbb_gallery_roles SET i_watermark = 1 WHERE role_id IN (
			SELECT perm_role_id FROM phpbb_gallery_permissions
			WHERE perm_album_id = ' . $album_id . ' AND perm_user_id = 2)');
		$db->sql_query('UPDATE phpbb_gallery_users SET user_permissions = ' . chr(39) . chr(39) . ' WHERE user_id = 2');
		$this->purge_cache();

		self::request('GET', $path, [], false);
		self::assert_response_status_code(200);
		$this->assertSame($original, self::$client->getResponse()->getContent());
		$this->assertSame(0, $this->workspace_file_count($root));
	}

	private function remove_local_variants(string $root, string $filename): void
	{
		foreach (['source', 'medium', 'mini'] as $variant)
		{
			$path = $root . 'files/phpbbgallery/core/' . $variant . '/' . $filename;
			$this->assertFileExists($path);
			$this->assertTrue(unlink($path));
		}
	}

	private function workspace_file_count(string $root): int
	{
		$count = 0;
		foreach (glob($root . 'cache/*/phpbbgallery/storage-workspace', GLOB_ONLYDIR) ?: [] as $directory)
		{
			$iterator = new \RecursiveIteratorIterator(
				new \RecursiveDirectoryIterator($directory, \FilesystemIterator::SKIP_DOTS)
			);
			foreach ($iterator as $item)
			{
				if ($item->isFile())
				{
					$count++;
				}
			}
		}

		return $count;
	}

	private function write_png(string $path, int $width, int $height): void
	{
		$image = imagecreatetruecolor($width, $height);
		$this->assertInstanceOf(\GdImage::class, $image);
		$colour = imagecolorallocate($image, 30, 90, 170);
		$this->assertIsInt($colour);
		$this->assertTrue(imagefill($image, 0, 0, $colour));
		$this->assertTrue(imagepng($image, $path));
	}

	private function module_id(): int
	{
		$db = $this->get_db();
		$sql = 'SELECT module_id FROM ' . MODULES_TABLE . '
			WHERE module_class = ' . chr(39) . 'acp' . chr(39) . '
				AND module_basename = ' . chr(39) . $db->sql_escape('\\phpbbgallery\\remotestorage\\acp\\main_module') . chr(39) . '
				AND module_mode = ' . chr(39) . 'settings' . chr(39);
		$result = $db->sql_query($sql);
		$module_id = (int) $db->sql_fetchfield('module_id');
		$db->sql_freeresult($result);
		$this->assertGreaterThan(0, $module_id);

		return $module_id;
	}

	private function module_url(int $module_id): string
	{
		return 'adm/index.php?i=' . $module_id . '&mode=settings&sid=' . $this->sid;
	}

	private function set_config_value(string $name, string $value): void
	{
		$db = $this->get_db();
		$db->sql_query('UPDATE ' . CONFIG_TABLE . ' SET ' . $db->sql_build_array('UPDATE', [
			'config_value' => $value,
		]) . ' WHERE config_name = ' . chr(39) . $db->sql_escape($name) . chr(39));
	}

	private function config_value(string $name): string
	{
		$db = $this->get_db();
		$result = $db->sql_query('SELECT config_value FROM ' . CONFIG_TABLE . '
			WHERE config_name = ' . chr(39) . $db->sql_escape($name) . chr(39));
		$value = (string) $db->sql_fetchfield('config_value');
		$db->sql_freeresult($result);

		return $value;
	}
}
