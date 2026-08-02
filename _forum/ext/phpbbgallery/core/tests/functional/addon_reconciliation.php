<?php
/**
 * phpBB Gallery addon reactivation reconciliation tests.
 *
 * @package   phpbbgallery/core
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests\functional;

/**
 * Exercise disabled-addon cleanup against an installed phpBB board.
 *
 * @group functional
 */
class addon_reconciliation extends \phpbb_functional_test_case
{
	private const ADDONS = [
		'phpbbgallery/favorite',
		'phpbbgallery/imagerevisions',
		'phpbbgallery/bbtagsimages',
		'phpbbgallery/bbpointsimages',
	];

	protected static function setup_extensions(): array
	{
		return [
			'sitesplat/BBCore',
			'sitesplat/bbpoints',
			'sitesplat/bbtags',
			'phpbbgallery/core',
			...self::ADDONS,
		];
	}

	/**
	 * Accept extension-specific success messages and continuation steps.
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

	public function test_reactivation_reconciles_rows_files_and_compiled_container(): void
	{
		global $phpbb_root_path;

		$this->add_lang_ext('phpbbgallery/core', 'gallery');
		[$album_id, $image_id, $tag_id, $revision_path] = $this->seed_orphan_candidates($phpbb_root_path);

		foreach (self::ADDONS as $addon)
		{
			$this->disable_ext($addon);
		}

		$this->delete_image_through_core($image_id);
		$db = $this->get_db();
		$db->sql_query('DELETE FROM phpbb_gallery_albums WHERE album_id = ' . $album_id);

		$this->assertSame(1, $this->count_rows('gallery_favorites', 'image_id = ' . $image_id));
		$this->assertSame(1, $this->count_rows('gallery_image_tags', 'image_id = ' . $image_id));
		$this->assertSame(1, $this->count_rows('gallery_bbpoints_contributors', 'image_id = ' . $image_id));
		$this->assertSame(1, $this->count_rows('gallery_bbpoints_album_rules', 'album_id = ' . $album_id));
		$this->assertSame(1, $this->count_rows('gallery_image_revisions', 'image_id = ' . $image_id));
		$this->assertFileExists($revision_path);

		foreach (self::ADDONS as $addon)
		{
			$this->install_ext($addon);
		}

		$this->assertSame(0, $this->count_rows('gallery_favorites', 'image_id = ' . $image_id));
		$this->assertSame(0, $this->count_rows('gallery_image_tags', 'image_id = ' . $image_id));
		$this->assertSame(0, $this->count_rows('gallery_bbpoints_contributors', 'image_id = ' . $image_id));
		$this->assertSame(0, $this->count_rows('gallery_bbpoints_album_rules', 'album_id = ' . $album_id));
		$this->assertSame(0, $this->count_rows('gallery_image_revisions', 'image_id = ' . $image_id));
		$this->assertSame(0, $this->count_rows('bbtags_scope', "provider = 'gallery_images' AND scope_id = " . $album_id));
		$this->assertSame(1, $this->count_rows('bbtags_suggestions', "provider = 'gallery_images' AND item_id = " . $image_id . " AND status = 'cancelled'"));
		$this->assertSame(0, $this->count_rows('bbtags_context', "provider = 'gallery_images' AND tag_id = " . $tag_id . ' AND usage_count <> 0'));
		$this->assertSame(1, $this->count_rows('gallery_bbpoints_rewards', 'image_id = ' . $image_id));
		$this->assertSame(1, $this->count_rows('gallery_bbpoints_purchases', 'image_id = ' . $image_id));
		$this->assertFileDoesNotExist($revision_path);

		$sql = 'SELECT COUNT(ext_name) AS total
			FROM ' . EXT_TABLE . '
			WHERE ' . $db->sql_in_set('ext_name', self::ADDONS) . '
				AND ext_active = 1';
		$result = $db->sql_query($sql);
		$this->assertSame(count(self::ADDONS), (int) $db->sql_fetchfield('total'));
		$db->sql_freeresult($result);

		$crawler = self::request('GET', 'index.php');
		self::assert_response_html(200);
		$this->assertStringContainsString('phpBB', $crawler->filter('body')->text());
	}

	/**
	 * @return array{0: int, 1: int, 2: int, 3: string}
	 */
	private function seed_orphan_candidates(string $phpbb_root_path): array
	{
		$db = $this->get_db();
		$album = [
			'parent_id' => 0,
			'left_id' => 1,
			'right_id' => 2,
			'album_type' => \phpbbgallery\core\block::TYPE_UPLOAD,
			'album_status' => \phpbbgallery\core\block::ALBUM_OPEN,
			'album_name' => 'Addon reconciliation album',
			'album_user_id' => \phpbbgallery\core\block::PUBLIC_ALBUM,
		];
		$db->sql_query('INSERT INTO phpbb_gallery_albums ' . $db->sql_build_array('INSERT', $album));
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
		$db->sql_query('INSERT INTO phpbb_gallery_permissions ' . $db->sql_build_array('INSERT', [
			'perm_role_id' => $role_id,
			'perm_album_id' => $album_id,
			'perm_user_id' => 2,
			'perm_group_id' => 0,
			'perm_system' => 0,
		]));

		$filename = 'addon-reconciliation-current.png';
		$source_path = $phpbb_root_path . 'files/phpbbgallery/core/source/' . $filename;
		$this->write_png($source_path);
		$db->sql_query('INSERT INTO phpbb_gallery_images ' . $db->sql_build_array('INSERT', [
			'image_filename' => $filename,
			'image_name' => 'Addon reconciliation image',
			'image_name_clean' => 'addon reconciliation image',
			'image_user_id' => 2,
			'image_username' => 'admin',
			'image_username_clean' => 'admin',
			'image_time' => time(),
			'image_album_id' => $album_id,
			'image_status' => \phpbbgallery\core\block::STATUS_APPROVED,
			'filesize_upload' => (int) filesize($source_path),
		]));
		$image_id = (int) $db->sql_nextid();

		$db->sql_query('INSERT INTO phpbb_gallery_favorites ' . $db->sql_build_array('INSERT', ['user_id' => 2, 'image_id' => $image_id]));
		$db->sql_query('INSERT INTO phpbb_gallery_bbpoints_contributors ' . $db->sql_build_array('INSERT', ['image_id' => $image_id, 'user_id' => 3, 'contributor_order' => 0]));
		$db->sql_query('INSERT INTO phpbb_gallery_bbpoints_album_rules ' . $db->sql_build_array('INSERT', ['album_id' => $album_id, 'upload_reward' => 5, 'source_cost' => 10]));
		$db->sql_query('INSERT INTO phpbb_gallery_bbpoints_rewards ' . $db->sql_build_array('INSERT', ['image_id' => $image_id, 'user_id' => 2, 'amount' => 5, 'operation_key' => 'functional-reward', 'reward_time' => time()]));
		$db->sql_query('INSERT INTO phpbb_gallery_bbpoints_purchases ' . $db->sql_build_array('INSERT', ['image_id' => $image_id, 'buyer_id' => 3, 'amount' => 10, 'operation_key' => 'functional-purchase', 'purchase_time' => time()]));

		$revision_filename = 'addon-reconciliation-revision.png';
		$revision_path = $phpbb_root_path . 'files/phpbbgallery/core/source/' . $revision_filename;
		$this->write_png($revision_path);
		$db->sql_query('INSERT INTO phpbb_gallery_image_revisions ' . $db->sql_build_array('INSERT', [
			'image_id' => $image_id,
			'revision_filename' => $revision_filename,
			'revision_filesize' => (int) filesize($revision_path),
			'revision_time' => time(),
			'revision_user_id' => 2,
		]));

		$db->sql_query('INSERT INTO phpbb_bbtags ' . $db->sql_build_array('INSERT', [
			'tag' => 'Lifecycle orphan',
			'route' => 'lifecycle-orphan',
			'count' => 0,
			'tag_clean' => 'lifecycle orphan',
			'is_predefined' => 1,
			'created_by' => 2,
			'created_at' => time(),
		]));
		$tag_id = (int) $db->sql_nextid();
		$db->sql_query('INSERT INTO phpbb_bbtags_context ' . $db->sql_build_array('INSERT', [
			'tag_id' => $tag_id,
			'provider' => 'gallery_images',
			'usage_count' => 1,
			'is_enabled' => 1,
			'scope_mode' => 'restricted',
		]));
		$db->sql_query('INSERT INTO phpbb_gallery_image_tags ' . $db->sql_build_array('INSERT', ['image_id' => $image_id, 'tag_id' => $tag_id]));
		$db->sql_query('INSERT INTO phpbb_bbtags_scope ' . $db->sql_build_array('INSERT', ['tag_id' => $tag_id, 'provider' => 'gallery_images', 'scope_id' => $album_id, 'scope_rule' => 'allow']));
		$db->sql_query('INSERT INTO phpbb_bbtags_suggestions ' . $db->sql_build_array('INSERT', [
			'tag_id' => $tag_id,
			'tag' => 'Lifecycle orphan',
			'tag_clean' => 'lifecycle orphan',
			'provider' => 'gallery_images',
			'scope_id' => $album_id,
			'item_id' => $image_id,
			'suggested_by' => 2,
			'suggested_at' => time(),
			'status' => 'pending',
			'dedupe_key' => hash('sha256', 'gallery-lifecycle-' . $image_id),
		]));

		$db->sql_query("UPDATE phpbb_gallery_users SET user_permissions = '' WHERE user_id IN (1, 2)");
		$this->purge_cache();

		return [$album_id, $image_id, $tag_id, $revision_path];
	}

	private function delete_image_through_core(int $image_id): void
	{
		$this->login();
		$crawler = self::request('GET', 'app.php/gallery/image/' . $image_id . '/delete?sid=' . $this->sid);
		$form = $crawler->selectButton($this->lang('YES'))->form();
		$crawler = self::submit($form);
		$this->assertStringContainsString($this->lang('DELETED_IMAGE'), $crawler->filter('body')->text());
		$this->logout();
	}

	private function count_rows(string $table, string $where): int
	{
		$db = $this->get_db();
		$result = $db->sql_query('SELECT COUNT(*) AS total FROM phpbb_' . $table . ' WHERE ' . $where);
		$count = (int) $db->sql_fetchfield('total');
		$db->sql_freeresult($result);

		return $count;
	}

	private function write_png(string $path): void
	{
		$png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=', true);
		$this->assertNotFalse($png);
		$this->assertNotFalse(file_put_contents($path, $png));
	}
}
