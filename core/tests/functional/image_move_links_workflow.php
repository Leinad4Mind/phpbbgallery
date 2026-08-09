<?php
/**
 * phpBB Gallery - image move link-preservation functional tests.
 *
 * @package   phpbbgallery/core
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests\functional;

/**
 * Move an image without changing its URL or rendered Gallery BBCodes.
 *
 * @group functional
 */
class image_move_links_workflow extends \phpbb_functional_test_case
{
	protected static function setup_extensions(): array
	{
		return ['phpbbgallery/core'];
	}

	/** Accept the Gallery-specific extension activation message. */
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
		$meta_refresh = $crawler->filter('meta[http-equiv=refresh]');
		while ($meta_refresh->count())
		{
			preg_match('#url=.+/(adm.+)#', $meta_refresh->attr('content'), $matches);
			$crawler = self::request('POST', $matches[1]);
			$meta_refresh = $crawler->filter('meta[http-equiv=refresh]');
		}
		$this->assertNotSame('', trim($crawler->filter('div.successbox')->text()));
		$this->logout();
	}

	public function test_move_preserves_routes_and_rendered_bbcodes(): void
	{
		global $phpbb_root_path;

		$this->add_lang('mcp');
		$this->add_lang_ext('phpbbgallery/core', ['gallery', 'gallery_mcp']);
		[$source_album_id, $target_album_id, $image_id] = $this->seed_image($phpbb_root_path);
		$gallery_tags = $this->installed_gallery_bbcode_tags();

		$this->login();
		$this->admin_login();
		$topic = $this->create_reference_topic($image_id, $gallery_tags);
		$this->assert_image_routes($image_id, $target_album_id, false);
		$this->assert_topic_renders_gallery_bbcodes((int) $topic['topic_id'], $image_id, count($gallery_tags));
		$this->move_image($image_id, $target_album_id);
		$this->assert_image_moved($image_id, $source_album_id, $target_album_id);
		$this->assert_image_routes($image_id, $target_album_id, true);
		$this->assert_topic_renders_gallery_bbcodes((int) $topic['topic_id'], $image_id, count($gallery_tags));
		$this->logout();
		$this->uninstall_ext('phpbbgallery/core');
	}

	/** @return array{0: int, 1: int, 2: int} */
	private function seed_image(string $phpbb_root_path): array
	{
		$db = $this->get_db();
		$result = $db->sql_query('SELECT MAX(right_id) AS max_right FROM phpbb_gallery_albums');
		$next_left = (int) $db->sql_fetchfield('max_right') + 1;
		$db->sql_freeresult($result);
		$source_album_id = $this->create_album('Move source album', $next_left);
		$target_album_id = $this->create_album('Move target album', $next_left + 2);
		$this->grant_admin_album_access($source_album_id);
		$this->grant_admin_album_access($target_album_id);

		$filename = 'functional-move-links.png';
		foreach (['source', 'medium', 'mini'] as $directory)
		{
			$this->write_test_png($phpbb_root_path . 'files/phpbbgallery/core/' . $directory . '/' . $filename);
		}
		$db->sql_query('INSERT INTO phpbb_gallery_images ' . $db->sql_build_array('INSERT', [
			'image_filename' => $filename,
			'image_name' => 'Functional moved image',
			'image_name_clean' => 'functional moved image',
			'image_user_id' => 2,
			'image_username' => 'admin',
			'image_username_clean' => 'admin',
			'image_user_ip' => '127.0.0.1',
			'image_time' => time(),
			'image_album_id' => $source_album_id,
			'image_status' => \phpbbgallery\core\block::STATUS_APPROVED,
			'image_allow_comments' => 1,
			'filesize_upload' => (int) filesize($phpbb_root_path . 'files/phpbbgallery/core/source/' . $filename),
		]));
		$image_id = (int) $db->sql_nextid();
		$db->sql_query('UPDATE phpbb_gallery_albums
			SET album_images = 1, album_images_real = 1, album_last_image_id = ' . $image_id . '
			WHERE album_id = ' . $source_album_id);
		$db->sql_query('UPDATE phpbb_gallery_users
			SET user_permissions = ' . chr(39) . chr(39) . '
			WHERE user_id = 2');
		$this->purge_cache();

		return [$source_album_id, $target_album_id, $image_id];
	}

	private function create_album(string $name, int $left_id): int
	{
		$db = $this->get_db();
		$db->sql_query('INSERT INTO phpbb_gallery_albums ' . $db->sql_build_array('INSERT', [
			'parent_id' => 0,
			'left_id' => $left_id,
			'right_id' => $left_id + 1,
			'album_type' => \phpbbgallery\core\block::TYPE_UPLOAD,
			'album_status' => \phpbbgallery\core\block::ALBUM_OPEN,
			'album_name' => $name,
			'album_user_id' => \phpbbgallery\core\block::PUBLIC_ALBUM,
		]));

		return (int) $db->sql_nextid();
	}

	private function grant_admin_album_access(int $album_id): void
	{
		$db = $this->get_db();
		$role = array_fill_keys([
			'a_list', 'i_view', 'i_watermark', 'i_download', 'i_download_free',
			'i_upload', 'i_edit', 'i_delete', 'i_rate', 'i_approve', 'i_lock',
			'i_report', 'i_unlimited', 'c_read', 'c_post', 'c_edit', 'c_delete',
			'm_comments', 'm_delete', 'm_edit', 'm_move', 'm_report', 'm_status',
			'i_move', 'a_unlimited',
		], 1);
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
	}

	/** @return list<string> */
	private function installed_gallery_bbcode_tags(): array
	{
		$db = $this->get_db();
		$result = $db->sql_query('SELECT config_value
			FROM ' . CONFIG_TABLE . '
			WHERE config_name = ' . chr(39) . 'phpbb_gallery_bbcode_tag' . chr(39));
		$canonical = strtolower((string) $db->sql_fetchfield('config_value'));
		$db->sql_freeresult($result);
		$this->assertContains($canonical, ['image', 'galleryimage']);
		$expected = [$canonical, 'album'];
		$result = $db->sql_query('SELECT LOWER(bbcode_tag) AS bbcode_tag
			FROM ' . BBCODES_TABLE . '
			WHERE ' . $db->sql_in_set('LOWER(bbcode_tag)', $expected) . '
				AND second_pass_replace LIKE ' . chr(39) . '%/gallery/image/%' . chr(39));
		$installed = [];
		while ($tag = $db->sql_fetchfield('bbcode_tag'))
		{
			$installed[] = (string) $tag;
		}
		$db->sql_freeresult($result);
		sort($expected);
		sort($installed);
		$this->assertSame($expected, $installed);

		return $expected;
	}

	/** @param list<string> $tags */
	private function create_reference_topic(int $image_id, array $tags): array
	{
		$message = [];
		foreach ($tags as $tag)
		{
			$message[] = strtoupper($tag) . ': [' . $tag . ']' . $image_id . '[/' . $tag . ']';
		}
		$topic = $this->create_topic(2, 'Gallery moved image references', implode(PHP_EOL, $message));
		$this->assertIsArray($topic);

		return $topic;
	}

	private function assert_topic_renders_gallery_bbcodes(int $topic_id, int $image_id, int $expected_count): void
	{
		$crawler = self::request('GET', 'viewtopic.php?t=' . $topic_id . '&sid=' . $this->sid);
		self::assert_response_html(200);
		$selector = 'img[src*=' . chr(34) . '/gallery/image/' . $image_id . '/mini' . chr(34) . ']';
		$this->assertSame($expected_count, $crawler->filter($selector)->count());
	}

	private function move_image(int $image_id, int $target_album_id): void
	{
		$crawler = self::request('GET', 'app.php/gallery/moderate/image/' . $image_id . '/move?sid=' . $this->sid);
		self::assert_response_html(200);
		$form = $crawler->selectButton($this->lang('MOVE'))->form();
		$crawler = self::submit($form, ['moving_target' => $target_album_id]);
		self::assert_response_html(200);
		$this->assertNotSame('', trim($crawler->filter('body')->text()));
	}

	private function assert_image_moved(int $image_id, int $source_album_id, int $target_album_id): void
	{
		$db = $this->get_db();
		$result = $db->sql_query('SELECT image_id, image_album_id
			FROM phpbb_gallery_images
			WHERE image_id = ' . $image_id);
		$image = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
		$this->assertIsArray($image);
		$this->assertSame($image_id, (int) $image['image_id']);
		$this->assertSame($target_album_id, (int) $image['image_album_id']);
		$this->assertSame(0, $this->album_image_count($source_album_id));
		$this->assertSame(1, $this->album_image_count($target_album_id));
	}

	private function assert_image_routes(int $image_id, int $target_album_id, bool $moved): void
	{
		$crawler = self::request('GET', 'app.php/gallery/image/' . $image_id . '?sid=' . $this->sid);
		self::assert_response_html(200);
		$this->assertStringContainsString('Functional moved image', $crawler->filter('body')->text());
		if ($moved)
		{
			$this->assertStringContainsString('Move target album', $crawler->filter('body')->text());
			$this->assertSame($target_album_id, $this->image_album_id($image_id));
		}

		foreach (['mini', 'medium', 'source'] as $mode)
		{
			self::request('GET', 'app.php/gallery/image/' . $image_id . '/' . $mode . '?sid=' . $this->sid, [], false);
			self::assert_response_status_code(200);
			$response = self::$client->getResponse();
			$this->assertSame('nosniff', $response->getHeader('X-Content-Type-Options'));
			$this->assertStringStartsWith('image/png', (string) $response->getHeader('Content-Type'));
			$this->assertStringStartsWith((string) hex2bin('89504e470d0a1a0a'), $response->getContent());
		}
	}

	private function image_album_id(int $image_id): int
	{
		$db = $this->get_db();
		$result = $db->sql_query('SELECT image_album_id
			FROM phpbb_gallery_images
			WHERE image_id = ' . $image_id);
		$album_id = (int) $db->sql_fetchfield('image_album_id');
		$db->sql_freeresult($result);

		return $album_id;
	}

	private function album_image_count(int $album_id): int
	{
		$db = $this->get_db();
		$result = $db->sql_query('SELECT album_images
			FROM phpbb_gallery_albums
			WHERE album_id = ' . $album_id);
		$count = (int) $db->sql_fetchfield('album_images');
		$db->sql_freeresult($result);

		return $count;
	}

	private function write_test_png(string $path): void
	{
		$png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=', true);
		$this->assertNotFalse($png);
		$this->assertNotFalse(file_put_contents($path, $png));
	}
}
