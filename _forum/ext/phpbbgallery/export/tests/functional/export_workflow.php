<?php
/**
 * phpBB Gallery - Export functional tests
 *
 * @package   phpbbgallery/export
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\export\tests\functional;

/** Exercise ACP and UCP exports through their real HTTP interfaces. */
class export_workflow extends \phpbb_functional_test_case
{
	private const MEMBER = 'gallery-export-member';

	protected static function setup_extensions(): array
	{
		return ['phpbbgallery/core', 'phpbbgallery/export'];
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

	public function test_complete_acp_and_ucp_export_workflow(): void
	{
		global $phpbb_root_path;

		$this->add_lang_ext('phpbbgallery/export', ['info_export', 'info_acp_gallery_export', 'info_ucp_gallery_export']);
		$member_id = $this->create_user(self::MEMBER);
		[$root_id, $child_id, $admin_image, $member_image] = $this->create_gallery_tree($member_id, $phpbb_root_path);

		$this->login();
		$this->admin_login();
		$acp_module = $this->module_id('acp', '\\phpbbgallery\\export\\acp\\main_module', 'export');
		$this->configure_single_image_batches($acp_module);
		$acp_download = $this->run_acp_export($acp_module, [$root_id, $child_id]);
		$this->assert_archive_access_is_protected($acp_download);

		$this->login();
		$this->admin_login();
		$acp_archive = $this->download_archive($acp_download);
		$this->assert_export_archive($acp_archive, [
			$root_id => $admin_image,
			$child_id => $member_image,
		], true);
		$this->logout();

		$this->login(self::MEMBER);
		$ucp_module = $this->module_id('ucp', '\\phpbbgallery\\export\\ucp\\main_module', 'export_images');
		$ucp_download = $this->run_ucp_export($ucp_module);
		$ucp_archive = $this->download_archive($ucp_download);
		$this->assert_export_archive($ucp_archive, [$child_id => $member_image], false);
		$this->logout();
	}

	private function configure_single_image_batches(int $module_id): void
	{
		$crawler = self::request('GET', $this->acp_url($module_id));
		$form = $crawler->selectButton('save_settings')->form();
		$crawler = self::submit($form, [
			'export_max_images' => 5000,
			'export_max_size_mib' => 2048,
			'export_batch_size' => 1,
		]);
		$this->assertStringContainsString($this->lang('EXPORT_SETTINGS_SAVED'), $crawler->filter('body')->text());

		$crawler = self::request('GET', $this->acp_url($module_id));
		$this->assertSame('1', $crawler->filter('input[name=export_batch_size]')->attr('value'));
	}

	/** @param list<int> $album_ids */
	private function run_acp_export(int $module_id, array $album_ids): string
	{
		$crawler = self::request('GET', $this->acp_url($module_id));
		$form = $crawler->selectButton('submit')->form();
		$crawler = self::submit($form, [
			'album_ids' => $album_ids,
			'delivery' => 'download',
		]);
		$crawler = $this->follow_export_refreshes($crawler);
		$this->assertStringContainsString($this->lang('EXPORT_FINISHED', 2), $crawler->filter('body')->text());

		$crawler = self::request('GET', $this->acp_url($module_id));
		$links = $crawler->filter('a[href*=/gallery/export/][href$=/download]');
		$this->assertGreaterThan(0, $links->count(), $crawler->filter('body')->text());

		return $this->relative_url((string) $links->first()->attr('href'));
	}

	private function run_ucp_export(int $module_id): string
	{
		$url = 'ucp.php?i=' . $module_id . '&mode=export_images&sid=' . $this->sid;
		$crawler = self::request('GET', $url);
		$form = $crawler->selectButton('start_export')->form();
		$crawler = self::submit($form);
		$crawler = $this->follow_export_refreshes($crawler);

		$links = $crawler->filter('a[href*=/gallery/export/][href$=/download]');
		$this->assertSame(1, $links->count(), $crawler->filter('body')->text());

		return $this->relative_url((string) $links->attr('href'));
	}

	private function follow_export_refreshes($crawler)
	{
		for ($step = 0; $step < 10; $step++)
		{
			$meta = $crawler->filter('meta[http-equiv=' . chr(34) . 'refresh' . chr(34) . ']');
			if ($meta->count() === 0)
			{
				return $crawler;
			}
			preg_match('/url=(.+)$/i', (string) $meta->attr('content'), $matches);
			$this->assertArrayHasKey(1, $matches);
			$crawler = self::request('GET', $this->relative_url(html_entity_decode($matches[1], ENT_QUOTES, 'UTF-8')));
		}

		$this->fail('The export did not finish within ten HTTP batches.');
	}

	private function assert_archive_access_is_protected(string $download): void
	{
		$this->logout();
		$this->login(self::MEMBER);
		self::request('GET', $download, [], false);
		self::assert_response_status_code(403);
		$this->logout();
	}

	private function download_archive(string $download): string
	{
		self::request('GET', $download, [], false);
		self::assert_response_status_code(200);
		$response = self::$client->getResponse();
		$this->assertSame('application/zip', $response->getHeader('Content-Type'));
		$this->assertSame('nosniff', $response->getHeader('X-Content-Type-Options'));
		$this->assertStringStartsWith('attachment;', (string) $response->getHeader('Content-Disposition'));

		$path = tempnam(sys_get_temp_dir(), 'gallery-export-functional-');
		$this->assertNotFalse($path);
		$this->assertNotFalse(file_put_contents($path, $response->getContent()));

		return $path;
	}

	/**
	 * @param array<int, array{id: int, author: int, name: string, filename: string, contents: string}> $images
	 */
	private function assert_export_archive(string $path, array $images, bool $complete_tree): void
	{
		$zip = new \ZipArchive();
		$this->assertTrue($zip->open($path) === true);
		try
		{
			$expected = [];
			foreach ($images as $album_id => $image)
			{
				$album_path = $complete_tree && count($expected) === 0
					? 'Capas de Verão'
					: 'Capas de Verão/Sub-álbum';
				$entry = $album_path . '/' . $image['id'] . '_' . $image['author'] . '_' . $image['name'] . '.png';
				$expected[] = $entry;
				$this->assertSame($image['contents'], $zip->getFromName($entry), 'Missing or altered archive entry for album ' . $album_id);
			}

			$this->assertNotFalse($zip->locateName('manifest.csv'));
			$manifest = json_decode((string) $zip->getFromName('manifest.json'), true, 512, JSON_THROW_ON_ERROR);
			$this->assertCount(count($images), $manifest['images']);
			$this->assertSame($expected, array_column($manifest['images'], 'zip_path'));
			$this->assertSame(count($images), (int) $manifest['export']['images']);
			$this->assertSame([], $manifest['export']['errors']);
		}
		finally
		{
			$zip->close();
			unlink($path);
		}
	}

	/**
	 * @return array{0: int, 1: int, 2: array{id: int, author: int, name: string, filename: string, contents: string}, 3: array{id: int, author: int, name: string, filename: string, contents: string}}
	 */
	private function create_gallery_tree(int $member_id, string $root): array
	{
		$db = $this->get_db();
		$root_id = $this->insert_album(0, 1, 4, 'Capas de Verão');
		$child_id = $this->insert_album($root_id, 2, 3, 'Sub:álbum');

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
		$db->sql_query('INSERT INTO phpbb_gallery_permissions ' . $db->sql_build_array('INSERT', [
			'perm_role_id' => $role_id,
			'perm_album_id' => $child_id,
			'perm_user_id' => $member_id,
			'perm_group_id' => 0,
			'perm_system' => 0,
		]));

		$admin = $this->insert_image($root_id, 2, 'admin', 'Capa principal', 'export-admin.png', $root);
		$member = $this->insert_image($child_id, $member_id, self::MEMBER, 'Edição - especial', 'export-member.png', $root);
		$db->sql_query('UPDATE phpbb_gallery_users SET user_permissions = ' . chr(39) . chr(39)
			. ' WHERE user_id IN (2, ' . $member_id . ')');
		$this->purge_cache();

		return [$root_id, $child_id, $admin, $member];
	}

	private function insert_album(int $parent_id, int $left_id, int $right_id, string $name): int
	{
		$db = $this->get_db();
		$db->sql_query('INSERT INTO phpbb_gallery_albums ' . $db->sql_build_array('INSERT', [
			'parent_id' => $parent_id,
			'left_id' => $left_id,
			'right_id' => $right_id,
			'album_type' => \phpbbgallery\core\block::TYPE_UPLOAD,
			'album_status' => \phpbbgallery\core\block::ALBUM_OPEN,
			'album_name' => $name,
			'album_user_id' => \phpbbgallery\core\block::PUBLIC_ALBUM,
		]));

		return (int) $db->sql_nextid();
	}

	/** @return array{id: int, author: int, name: string, filename: string, contents: string} */
	private function insert_image(int $album_id, int $author_id, string $username, string $name, string $filename, string $root): array
	{
		$contents = (string) base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=', true);
		$path = $root . 'files/phpbbgallery/core/source/' . $filename;
		$this->assertNotFalse(file_put_contents($path, $contents));

		$db = $this->get_db();
		$db->sql_query('INSERT INTO phpbb_gallery_images ' . $db->sql_build_array('INSERT', [
			'image_filename' => $filename,
			'image_name' => $name,
			'image_name_clean' => utf8_clean_string($name),
			'image_user_id' => $author_id,
			'image_username' => $username,
			'image_username_clean' => utf8_clean_string($username),
			'image_time' => time(),
			'image_album_id' => $album_id,
			'image_status' => \phpbbgallery\core\block::STATUS_APPROVED,
			'filesize_upload' => strlen($contents),
		]));

		return [
			'id' => (int) $db->sql_nextid(),
			'author' => $author_id,
			'name' => $name,
			'filename' => $filename,
			'contents' => $contents,
		];
	}

	private function module_id(string $class, string $basename, string $mode): int
	{
		$db = $this->get_db();
		$sql = 'SELECT module_id FROM ' . MODULES_TABLE . '
			WHERE module_class = ' . chr(39) . $db->sql_escape($class) . chr(39) . '
				AND module_basename = ' . chr(39) . $db->sql_escape($basename) . chr(39) . '
				AND module_mode = ' . chr(39) . $db->sql_escape($mode) . chr(39);
		$result = $db->sql_query($sql);
		$module_id = (int) $db->sql_fetchfield('module_id');
		$db->sql_freeresult($result);
		$this->assertGreaterThan(0, $module_id);

		return $module_id;
	}

	private function acp_url(int $module_id): string
	{
		return 'adm/index.php?i=' . $module_id . '&mode=export&sid=' . $this->sid;
	}

	private function relative_url(string $url): string
	{
		return (string) preg_replace('#^https?://[^/]+/#', '', $url);
	}
}
