<?php
/**
 * phpBB Gallery - BBTags Images functional tests
 *
 * @package   phpbbgallery/bbtagsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbtagsimages\tests\functional;

/**
 * Exercise the authenticated image-tag lifecycle against an installed phpBB board.
 *
 * @group functional
 */
class bbtagsimages_workflow extends \phpbb_functional_test_case
{
	private const COMPONENTS = [
		'sitesplat/BBCore',
		'sitesplat/bbtags',
		'phpbbgallery/core',
		'phpbbgallery/bbtagsimages',
	];

	private const UPLOADER = 'gallery-tag-user';
	private const IMAGE_NAME = 'Functional tagged image';
	private const TAG_NAME = 'Functional integration tag';

	/**
	 * Enable the complete tag integration on the fresh test board.
	 *
	 * @return array
	 */
	protected static function setup_extensions(): array
	{
		return self::COMPONENTS;
	}

	/**
	 * Enable extensions while accepting component-specific success messages.
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
	 * Upload, suggest, moderate, search and delete one tagged Gallery image.
	 */
	public function test_authenticated_tag_workflow(): void
	{
		global $phpbb_root_path;

		$this->add_lang_ext('phpbbgallery/core', 'gallery');
		$this->add_lang_ext('phpbbgallery/bbtagsimages', 'bbtagsimages');
		$this->add_lang_ext('sitesplat/bbtags', ['bbtags', 'info_mcp_bbtags']);

		$uploader_id = $this->create_user(self::UPLOADER);
		$this->grant_global_permission($uploader_id, 'u_bbtags');
		$this->grant_global_permission($uploader_id, 'u_bbtags_read');
		$this->grant_global_permission(2, 'm_bbtags_moderate');
		$album_id = $this->create_uploadable_album($uploader_id);
		$this->purge_cache();

		$this->login(self::UPLOADER);
		[$image_id, $filename] = $this->upload_tagged_image($album_id, $phpbb_root_path);
		$suggestion_id = $this->assert_pending_suggestion($album_id, $image_id, $uploader_id);
		$this->logout();

		$this->approve_in_mcp($suggestion_id);
		$tag_id = $this->assert_approved_relation($suggestion_id, $image_id);
		$this->logout();

		$this->login(self::UPLOADER);
		$this->assert_image_is_searchable($image_id);
		$this->delete_image($image_id);
		$this->assert_deleted_state($image_id, $tag_id, $filename, $phpbb_root_path);
		$this->logout();
	}

	/**
	 * Create an uploadable public album for one non-moderator user.
	 */
	private function create_uploadable_album(int $user_id): int
	{
		$db = $this->get_db();
		$album = [
			'parent_id'        => 0,
			'left_id'          => 1,
			'right_id'         => 2,
			'album_type'       => \phpbbgallery\core\block::TYPE_UPLOAD,
			'album_status'     => \phpbbgallery\core\block::ALBUM_OPEN,
			'album_name'       => 'Functional Tags Album',
			'album_user_id'    => \phpbbgallery\core\block::PUBLIC_ALBUM,
			'display_on_index' => 1,
		];
		$db->sql_query('INSERT INTO ' . $this->table('gallery_albums') . ' ' . $db->sql_build_array('INSERT', $album));
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
		$db->sql_query('INSERT INTO ' . $this->table('gallery_roles') . ' ' . $db->sql_build_array('INSERT', $role));
		$role_id = (int) $db->sql_nextid();

		$permission = [
			'perm_role_id'  => $role_id,
			'perm_album_id' => $album_id,
			'perm_user_id'  => $user_id,
			'perm_group_id' => 0,
			'perm_system'   => 0,
		];
		$db->sql_query('INSERT INTO ' . $this->table('gallery_permissions') . ' ' . $db->sql_build_array('INSERT', $permission));

		return $album_id;
	}

	/**
	 * Complete both real HTTP steps of the resumable Gallery upload.
	 *
	 * @return array{0: int, 1: string}
	 */
	private function upload_tagged_image(int $album_id, string $phpbb_root_path): array
	{
		$fixture = $phpbb_root_path . 'store/bbtagsimages-functional.png';
		$this->write_test_png($fixture);
		$path = 'app.php/gallery/album/' . $album_id . '/upload?sid=' . $this->sid;

		$crawler = self::request('GET', $path);
		$form = $crawler->selectButton($this->lang('CONTINUE'))->form();
		$this->assertTrue($form->has('files[0]'));
		$form['files[0]']->upload($fixture);
		$crawler = self::submit($form);
		$this->assertFileExists($fixture);
		$this->assertTrue(unlink($fixture));
		$this->assertSame(1, $crawler->filter('input[name="bbtagsimages_tags[0]"]')->count());

		$form = $crawler->selectButton($this->lang('SUBMIT'))->form();
		$crawler = self::submit($form, [
			'image_name'       => [self::IMAGE_NAME],
			'message'          => [''],
			'bbtagsimages_tags' => [self::TAG_NAME],
		]);
		$this->assertStringContainsString($this->lang('ALBUM_UPLOAD_SUCCESSFUL'), $crawler->filter('body')->text());

		$db = $this->get_db();
		$sql = 'SELECT image_id, image_filename, image_status
			FROM ' . $this->table('gallery_images') . "
			WHERE image_name = '" . $db->sql_escape(self::IMAGE_NAME) . "'
				AND image_album_id = " . $album_id;
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		$this->assertIsArray($row);
		$this->assertSame(\phpbbgallery\core\block::STATUS_APPROVED, (int) $row['image_status']);
		$this->assertFileExists($phpbb_root_path . 'files/phpbbgallery/core/source/' . $row['image_filename']);

		return [(int) $row['image_id'], (string) $row['image_filename']];
	}

	/**
	 * Confirm a normal uploader produced an invisible moderation suggestion.
	 */
	private function assert_pending_suggestion(int $album_id, int $image_id, int $user_id): int
	{
		$db = $this->get_db();
		$sql = 'SELECT suggestion_id, tag_id, status, suggested_by
			FROM ' . $this->table('bbtags_suggestions') . "
			WHERE provider = 'gallery_images'
				AND scope_id = " . $album_id . '
				AND item_id = ' . $image_id . "
				AND tag_clean = '" . $db->sql_escape(utf8_clean_string(self::TAG_NAME)) . "'";
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		$this->assertIsArray($row);
		$this->assertSame('pending', $row['status']);
		$this->assertSame(0, (int) $row['tag_id']);
		$this->assertSame($user_id, (int) $row['suggested_by']);
		$this->assertSame(0, $this->relation_count($image_id));

		return (int) $row['suggestion_id'];
	}

	/**
	 * Approve the pending tag through the real MCP form and its CSRF token.
	 */
	private function approve_in_mcp(int $suggestion_id): void
	{
		$this->login();
		$module_id = $this->module_id('mcp', '\\sitesplat\\bbtags\\mcp\\bbtags_module', 'queue');
		$crawler = self::request('GET', 'mcp.php?i=' . $module_id . '&mode=queue&sid=' . $this->sid);
		$form_node = $crawler->filter('form')->reduce(static function ($node) use ($suggestion_id): bool
		{
			return $node->filter('input[name="action"][value="approve"]')->count() === 1
				&& $node->filter('input[name="suggestion_id"][value="' . $suggestion_id . '"]')->count() === 1;
		})->first();
		$this->assertSame(1, $form_node->count(), $crawler->filter('body')->text());
		$crawler = self::submit($form_node->form());
		$this->assertStringContainsString($this->lang('BBTAGS_SUGGESTION_APPROVED'), $crawler->filter('body')->text());
	}

	/**
	 * Confirm moderation published the tag and attached it to the image.
	 */
	private function assert_approved_relation(int $suggestion_id, int $image_id): int
	{
		$db = $this->get_db();
		$sql = 'SELECT tag_id, status, reviewed_by
			FROM ' . $this->table('bbtags_suggestions') . '
			WHERE suggestion_id = ' . $suggestion_id;
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		$this->assertSame('approved', $row['status']);
		$this->assertSame(2, (int) $row['reviewed_by']);
		$this->assertGreaterThan(0, (int) $row['tag_id']);
		$this->assertSame(1, $this->relation_count($image_id));

		return (int) $row['tag_id'];
	}

	/**
	 * Search through the public Gallery route as the original uploader.
	 */
	private function assert_image_is_searchable(int $image_id): void
	{
		$query = http_build_query([
			'tags'         => self::TAG_NAME,
			'tag_operator' => 'and',
			'filtered'     => 1,
			'sid'          => $this->sid,
		]);
		$crawler = self::request('GET', 'app.php/gallery/search?' . $query);
		$this->assertStringContainsString(self::IMAGE_NAME, $crawler->filter('body')->text());
		$this->assertGreaterThan(0, $crawler->filter('a[href*="/gallery/image/' . $image_id . '"]')->count());
	}

	/**
	 * Delete the image through the real confirmation form.
	 */
	private function delete_image(int $image_id): void
	{
		$crawler = self::request('GET', 'app.php/gallery/image/' . $image_id . '/delete?sid=' . $this->sid);
		$form = $crawler->selectButton($this->lang('YES'))->form();
		$crawler = self::submit($form);
		$this->assertStringContainsString($this->lang('DELETED_IMAGE'), $crawler->filter('body')->text());
	}

	/**
	 * Verify both Core storage and the add-on relation were cleaned.
	 */
	private function assert_deleted_state(int $image_id, int $tag_id, string $filename, string $phpbb_root_path): void
	{
		$db = $this->get_db();
		$result = $db->sql_query('SELECT COUNT(image_id) AS total FROM ' . $this->table('gallery_images') . ' WHERE image_id = ' . $image_id);
		$this->assertSame(0, (int) $db->sql_fetchfield('total'));
		$db->sql_freeresult($result);
		$this->assertSame(0, $this->relation_count($image_id));
		$this->assertFileDoesNotExist($phpbb_root_path . 'files/phpbbgallery/core/source/' . $filename);

		$result = $db->sql_query('SELECT usage_count FROM ' . $this->table('bbtags_context') . " WHERE provider = 'gallery_images' AND tag_id = " . $tag_id);
		$this->assertSame(0, (int) $db->sql_fetchfield('usage_count'));
		$db->sql_freeresult($result);
	}

	private function relation_count(int $image_id): int
	{
		$db = $this->get_db();
		$result = $db->sql_query('SELECT COUNT(image_id) AS total FROM ' . $this->table('gallery_image_tags') . ' WHERE image_id = ' . $image_id);
		$count = (int) $db->sql_fetchfield('total');
		$db->sql_freeresult($result);

		return $count;
	}

	private function grant_global_permission(int $user_id, string $permission): void
	{
		$db = $this->get_db();
		$sql = 'SELECT auth_option_id FROM ' . ACL_OPTIONS_TABLE . " WHERE auth_option = '" . $db->sql_escape($permission) . "'";
		$result = $db->sql_query($sql);
		$option_id = (int) $db->sql_fetchfield('auth_option_id');
		$db->sql_freeresult($result);
		$this->assertGreaterThan(0, $option_id, $permission);

		$db->sql_query('DELETE FROM ' . ACL_USERS_TABLE . ' WHERE user_id = ' . $user_id . ' AND forum_id = 0 AND auth_option_id = ' . $option_id);
		$row = [
			'user_id'        => $user_id,
			'forum_id'       => 0,
			'auth_option_id' => $option_id,
			'auth_role_id'   => 0,
			'auth_setting'   => ACL_YES,
		];
		$db->sql_query('INSERT INTO ' . ACL_USERS_TABLE . ' ' . $db->sql_build_array('INSERT', $row));
	}

	private function module_id(string $class, string $basename, string $mode): int
	{
		$db = $this->get_db();
		$sql = 'SELECT module_id FROM ' . MODULES_TABLE . "
			WHERE module_class = '" . $db->sql_escape($class) . "'
				AND module_basename = '" . $db->sql_escape($basename) . "'
				AND module_mode = '" . $db->sql_escape($mode) . "'";
		$result = $db->sql_query($sql);
		$module_id = (int) $db->sql_fetchfield('module_id');
		$db->sql_freeresult($result);
		$this->assertGreaterThan(0, $module_id);

		return $module_id;
	}

	private function table(string $suffix): string
	{
		return self::$config['table_prefix'] . $suffix;
	}

	private function write_test_png(string $path): void
	{
		$png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=', true);
		$this->assertNotFalse($png);
		$this->assertNotFalse(file_put_contents($path, $png));
	}
}
