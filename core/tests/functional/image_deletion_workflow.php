<?php
/**
 * phpBB Gallery - recoverable image deletion functional tests.
 *
 * @package   phpbbgallery/core
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests\functional;

/**
 * Exercise the author request and moderator decision flow on an installed board.
 *
 * @group functional
 */
class image_deletion_workflow extends \phpbb_functional_test_case
{
	private const AUTHOR = 'gallery-deletion-author';

	protected static function setup_extensions(): array
	{
		return ['phpbbgallery/core'];
	}

	/**
	 * Accept the Gallery-specific activation message.
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

	public function test_author_deletion_can_be_restored_then_permanently_deleted(): void
	{
		global $phpbb_root_path;

		$this->add_lang('mcp');
		$this->add_lang_ext('phpbbgallery/core', ['gallery', 'gallery_mcp']);
		$author_id = $this->create_user(self::AUTHOR);
		[$album_id, $image_id, $filename] = $this->seed_image($author_id, $phpbb_root_path);

		$this->login(self::AUTHOR);
		$this->request_image_deletion($image_id);
		$this->assert_requested_state($image_id, $author_id, $album_id);
		$this->assert_image_is_hidden_from_album($album_id);
		$this->logout();

		$this->login();
		$this->moderate_request($album_id, $image_id, 'restore', $this->lang('RESTORE'));
		$this->assert_restored_state($image_id, $album_id);
		$this->logout();

		$this->login(self::AUTHOR);
		$this->request_image_deletion($image_id);
		$this->logout();

		$this->login();
		$this->moderate_request($album_id, $image_id, 'delete_request', $this->lang('DELETE'));
		$this->assert_permanently_deleted($image_id, $filename, $album_id, $phpbb_root_path);
		$this->logout();
	}

	/**
	 * @return array{0: int, 1: int, 2: string}
	 */
	private function seed_image(int $author_id, string $phpbb_root_path): array
	{
		$db = $this->get_db();
		$db->sql_query('INSERT INTO phpbb_gallery_albums ' . $db->sql_build_array('INSERT', [
			'parent_id' => 0,
			'album_parents' => '',
			'left_id' => 1,
			'right_id' => 2,
			'album_type' => \phpbbgallery\core\block::TYPE_UPLOAD,
			'album_status' => \phpbbgallery\core\block::ALBUM_OPEN,
			'album_name' => 'Recoverable deletion album',
			'album_user_id' => \phpbbgallery\core\block::PUBLIC_ALBUM,
			'album_images' => 1,
			'album_images_real' => 1,
		]));
		$album_id = (int) $db->sql_nextid();

		$this->grant_album_role($album_id, $author_id, ['a_list', 'i_view', 'i_delete', 'c_read']);
		$this->grant_album_role($album_id, 2, ['a_list', 'i_view', 'i_watermark', 'm_delete']);

		$filename = 'recoverable-deletion.png';
		foreach (['source', 'medium', 'mini'] as $directory)
		{
			$this->write_test_png($phpbb_root_path . 'files/phpbbgallery/core/' . $directory . '/' . $filename);
		}
		$db->sql_query('INSERT INTO phpbb_gallery_images ' . $db->sql_build_array('INSERT', [
			'image_filename' => $filename,
			'image_name' => 'Recoverable deletion image',
			'image_name_clean' => 'recoverable deletion image',
			'image_user_id' => $author_id,
			'image_username' => self::AUTHOR,
			'image_username_clean' => utf8_clean_string(self::AUTHOR),
			'image_time' => time(),
			'image_album_id' => $album_id,
			'image_status' => \phpbbgallery\core\block::STATUS_APPROVED,
			'filesize_upload' => (int) filesize($phpbb_root_path . 'files/phpbbgallery/core/source/' . $filename),
		]));
		$image_id = (int) $db->sql_nextid();

		$db->sql_query('UPDATE phpbb_gallery_albums
			SET album_last_image_id = ' . $image_id . '
			WHERE album_id = ' . $album_id);
		$db->sql_query('DELETE FROM phpbb_gallery_users WHERE user_id = ' . $author_id);
		$db->sql_query('INSERT INTO phpbb_gallery_users ' . $db->sql_build_array('INSERT', [
			'user_id' => $author_id,
			'user_images' => 1,
		]));
		$db->sql_query("UPDATE phpbb_config
			SET config_value = '1'
			WHERE config_name = 'phpbb_gallery_num_images'");
		$db->sql_query("UPDATE phpbb_gallery_users
			SET user_permissions = ''
			WHERE user_id IN (2, " . $author_id . ')');
		$this->purge_cache();

		return [$album_id, $image_id, $filename];
	}

	private function grant_album_role(int $album_id, int $user_id, array $enabled): void
	{
		$db = $this->get_db();
		$role = array_fill_keys([
			'a_list', 'i_view', 'i_watermark', 'i_upload', 'i_edit', 'i_delete',
			'i_rate', 'i_approve', 'i_lock', 'i_report', 'i_unlimited', 'c_read',
			'c_post', 'c_edit', 'c_delete', 'm_comments', 'm_delete', 'm_edit',
			'm_move', 'm_report', 'm_status', 'i_move', 'a_unlimited',
		], 0);
		foreach ($enabled as $permission)
		{
			$role[$permission] = 1;
		}
		$role['i_count'] = 100;
		$role['a_count'] = 100;
		$role['a_restrict'] = 0;
		$db->sql_query('INSERT INTO phpbb_gallery_roles ' . $db->sql_build_array('INSERT', $role));
		$role_id = (int) $db->sql_nextid();
		$db->sql_query('INSERT INTO phpbb_gallery_permissions ' . $db->sql_build_array('INSERT', [
			'perm_role_id' => $role_id,
			'perm_album_id' => $album_id,
			'perm_user_id' => $user_id,
			'perm_group_id' => 0,
			'perm_system' => 0,
		]));
	}

	private function request_image_deletion(int $image_id): void
	{
		$crawler = self::request('GET', 'app.php/gallery/image/' . $image_id . '/delete?sid=' . $this->sid);
		$form = $crawler->selectButton($this->lang('YES'))->form();
		$crawler = self::submit($form);
		$this->assertStringContainsString($this->lang('IMAGE_DELETION_REQUESTED'), $crawler->filter('body')->text());
	}

	private function moderate_request(int $album_id, int $image_id, string $action, string $button): void
	{
		$crawler = self::request('GET', 'app.php/gallery/moderate/approve?sid=' . $this->sid);
		self::assert_response_html(200);
		$this->assertStringContainsString('Recoverable deletion image', $crawler->filter('#gallery_delete_requests')->text());

		$form = $crawler->selectButton($button)->form();
		$crawler = self::submit($form, [
			'deletion' => [$album_id => [$image_id]],
			'action' => [$action => $action],
		]);
		$form = $crawler->selectButton($this->lang('YES'))->form();
		self::submit($form);
	}

	private function assert_requested_state(int $image_id, int $author_id, int $album_id): void
	{
		$row = $this->image_row($image_id);
		$this->assertSame(\phpbbgallery\core\block::STATUS_DELETE_REQUESTED, (int) $row['image_status']);
		$this->assertSame(\phpbbgallery\core\block::STATUS_APPROVED, (int) $row['image_delete_previous_status']);
		$this->assertSame($author_id, (int) $row['image_delete_request_user_id']);
		$this->assertGreaterThan(0, (int) $row['image_delete_request_time']);
		$this->assertSame(0, $this->counter('phpbb_gallery_albums', 'album_images', 'album_id = ' . $album_id));
		$this->assertSame(0, $this->counter('phpbb_gallery_users', 'user_images', 'user_id = ' . $author_id));
		$this->assertSame(0, $this->config_counter('phpbb_gallery_num_images'));
	}

	private function assert_restored_state(int $image_id, int $album_id): void
	{
		$row = $this->image_row($image_id);
		$this->assertSame(\phpbbgallery\core\block::STATUS_APPROVED, (int) $row['image_status']);
		$this->assertSame(0, (int) $row['image_delete_request_user_id']);
		$this->assertSame(0, (int) $row['image_delete_request_time']);
		$this->assertSame(1, $this->counter('phpbb_gallery_albums', 'album_images', 'album_id = ' . $album_id));
		$this->assertSame(1, $this->config_counter('phpbb_gallery_num_images'));
	}

	private function assert_image_is_hidden_from_album(int $album_id): void
	{
		$crawler = self::request('GET', 'app.php/gallery/album/' . $album_id . '?sid=' . $this->sid);
		self::assert_response_html(200);
		$this->assertStringNotContainsString('Recoverable deletion image', $crawler->filter('body')->text());
	}

	private function assert_permanently_deleted(int $image_id, string $filename, int $album_id, string $phpbb_root_path): void
	{
		$db = $this->get_db();
		$result = $db->sql_query('SELECT COUNT(image_id) AS total
			FROM phpbb_gallery_images
			WHERE image_id = ' . $image_id);
		$this->assertSame(0, (int) $db->sql_fetchfield('total'));
		$db->sql_freeresult($result);
		$this->assertSame(0, $this->counter('phpbb_gallery_albums', 'album_images', 'album_id = ' . $album_id));
		$this->assertSame(0, $this->config_counter('phpbb_gallery_num_images'));
		foreach (['source', 'medium', 'mini'] as $directory)
		{
			$this->assertFileDoesNotExist($phpbb_root_path . 'files/phpbbgallery/core/' . $directory . '/' . $filename);
		}
	}

	private function image_row(int $image_id): array
	{
		$db = $this->get_db();
		$result = $db->sql_query('SELECT image_status, image_delete_previous_status,
				image_delete_request_user_id, image_delete_request_time
			FROM phpbb_gallery_images
			WHERE image_id = ' . $image_id);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
		$this->assertIsArray($row);

		return $row;
	}

	private function counter(string $table, string $column, string $where): int
	{
		$db = $this->get_db();
		$result = $db->sql_query('SELECT ' . $column . ' FROM ' . $table . ' WHERE ' . $where);
		$value = (int) $db->sql_fetchfield($column);
		$db->sql_freeresult($result);

		return $value;
	}

	private function config_counter(string $name): int
	{
		$db = $this->get_db();
		$result = $db->sql_query("SELECT config_value
			FROM phpbb_config
			WHERE config_name = '" . $db->sql_escape($name) . "'");
		$value = (int) $db->sql_fetchfield('config_value');
		$db->sql_freeresult($result);

		return $value;
	}

	private function write_test_png(string $path): void
	{
		$png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=', true);
		$this->assertNotFalse($png);
		$this->assertNotFalse(file_put_contents($path, $png));
	}
}
