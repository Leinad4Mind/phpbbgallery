<?php
/**
 * phpBB Gallery - BBPoints Images functional tests
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbpointsimages\tests\functional;

/**
 * Exercise rewards and paid original-source access on an installed phpBB board.
 *
 * @group functional
 */
class bbpointsimages_workflow extends \phpbb_functional_test_case
{
	private const COMPONENTS = [
		'sitesplat/BBCore',
		'sitesplat/bbpoints',
		'phpbbgallery/core',
		'phpbbgallery/acpimport',
		'phpbbgallery/bbpointsimages',
	];
	private const AUTHOR = 'gallery-points-author';
	private const BUYER = 'gallery-points-buyer';
	private const CONTRIBUTOR_ONE = 'gallery-contributor-one';
	private const CONTRIBUTOR_TWO = 'gallery-contributor-two';
	private const IMPORT_AUTHOR = 'gallery-import-author';
	private const RETRO_AUTHOR = 'gallery-retro-author';
	private const REWARD = 25;
	private const SOURCE_COST = 10;

	protected static function setup_extensions(): array
	{
		return self::COMPONENTS;
	}

	/**
	 * Accept extension-specific activation messages and migration continuations.
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

	public function test_complete_bbpoints_image_lifecycle(): void
	{
		global $phpbb_root_path;

		$this->add_lang_ext('phpbbgallery/core', 'gallery');
		$this->add_lang_ext('phpbbgallery/acpimport', 'info_acp_gallery_import');
		$this->add_lang_ext('phpbbgallery/bbpointsimages', 'info_acp_bbpointsimages');

		$author_id = $this->create_user(self::AUTHOR);
		$buyer_id = $this->create_user(self::BUYER);
		$contributor_one_id = $this->create_user(self::CONTRIBUTOR_ONE);
		$contributor_two_id = $this->create_user(self::CONTRIBUTOR_TWO);
		$import_author_id = $this->create_user(self::IMPORT_AUTHOR);
		$retro_author_id = $this->create_user(self::RETRO_AUTHOR);
		$approved_album = $this->create_album($author_id, true, 'Paid sources');
		$moderated_album = $this->create_album($author_id, false, 'Moderated rewards');

		$this->set_config('phpbb_gallery_bbpoints_upload_reward', self::REWARD);
		$this->set_config('phpbb_gallery_bbpoints_source_cost', self::SOURCE_COST);
		$this->set_config('phpbb_gallery_bbpoints_contributors_enabled', 1);
		$this->seed_points($buyer_id, 50);
		$this->purge_cache();

		$this->login();
		[$paid_image_id, $paid_filename] = $this->upload_image(
			$approved_album,
			$phpbb_root_path,
			'Paid functional image',
			'paid',
			self::AUTHOR,
			[self::CONTRIBUTOR_ONE, self::CONTRIBUTOR_TWO]
		);
		$this->assert_reward($paid_image_id, $author_id, self::REWARD, $paid_filename, $phpbb_root_path);
		$this->assertSame(self::REWARD, $this->balance($author_id));
		$this->assertSame(0, $this->balance(2));
		$this->assert_contributors($paid_image_id, [$contributor_one_id, $contributor_two_id]);
		$this->assert_notification('phpbbgallery.bbpointsimages.notification.reward', $author_id, $paid_image_id);
		$this->logout();

		$this->login(self::BUYER);
		$this->purchase_and_download($paid_image_id, $buyer_id);
		$this->assertSame(40, $this->balance($buyer_id));
		$this->assertSame(self::REWARD + 4, $this->balance($author_id));
		$this->assertSame(3, $this->balance($contributor_one_id));
		$this->assertSame(3, $this->balance($contributor_two_id));
		$this->assert_notification('phpbbgallery.bbpointsimages.notification.source_purchase', $author_id, $paid_image_id);
		$this->assert_notification('phpbbgallery.bbpointsimages.notification.source_purchase', $contributor_one_id, $paid_image_id);
		$this->assert_notification('phpbbgallery.bbpointsimages.notification.source_purchase', $contributor_two_id, $paid_image_id);
		$this->logout();

		$this->login(self::AUTHOR);
		[$pending_image_id, $pending_filename] = $this->upload_image(
			$moderated_album,
			$phpbb_root_path,
			'Pending functional image',
			'pending'
		);
		$this->assertSame(\phpbbgallery\core\block::STATUS_UNAPPROVED, $this->image_status($pending_image_id));
		$this->assertSame(0, $this->reward_count($pending_image_id));
		$this->logout();

		$this->login();
		$this->approve_image($pending_image_id);
		$this->assertSame(\phpbbgallery\core\block::STATUS_APPROVED, $this->image_status($pending_image_id));
		$this->assert_reward($pending_image_id, $author_id, self::REWARD, $pending_filename, $phpbb_root_path);
		$this->approve_image($pending_image_id);
		$this->assertSame(1, $this->reward_count($pending_image_id));

		$import_image_id = $this->import_image($approved_album, $phpbb_root_path, self::IMPORT_AUTHOR);
		$this->assert_reward_row($import_image_id, $import_author_id, self::REWARD);
		$this->assertSame(self::REWARD, $this->balance($import_author_id));
		$this->assertSame(0, $this->balance(2));

		$retro_image_id = $this->insert_historical_image($approved_album, $retro_author_id, $phpbb_root_path);
		$this->assertSame(0, $this->reward_count($retro_image_id));
		$this->run_retro_sync();
		$this->assert_reward_row($retro_image_id, $retro_author_id, self::REWARD);
		$this->assertSame(self::REWARD, $this->balance($retro_author_id));
		$this->run_retro_sync();
		$this->assertSame(self::REWARD, $this->balance($retro_author_id));
		$this->logout();

		$this->disable_ext('phpbbgallery/bbpointsimages');
		$this->assert_extension_state('phpbbgallery/bbpointsimages', false);
		$this->assert_notification_type_state(false);
		$this->install_ext('phpbbgallery/bbpointsimages');
		$this->assert_extension_state('phpbbgallery/bbpointsimages', true);
		$this->assert_notification_type_state(true);
		$this->assertSame(1, $this->reward_count($paid_image_id));
	}

	private function create_album(int $uploader_id, bool $approve, string $name): int
	{
		$db = $this->get_db();
		$album = [
			'parent_id' => 0,
			'left_id' => 1,
			'right_id' => 2,
			'album_type' => \phpbbgallery\core\block::TYPE_UPLOAD,
			'album_status' => \phpbbgallery\core\block::ALBUM_OPEN,
			'album_name' => $name,
			'album_user_id' => \phpbbgallery\core\block::PUBLIC_ALBUM,
			'display_on_index' => 1,
		];
		$db->sql_query('INSERT INTO ' . $this->table('gallery_albums') . ' ' . $db->sql_build_array('INSERT', $album));
		$album_id = (int) $db->sql_nextid();

		$uploader_role = array_fill_keys([
			'a_list', 'i_view', 'i_watermark', 'i_upload', 'i_edit', 'i_delete',
			'i_rate', 'i_lock', 'i_report', 'i_unlimited', 'c_read', 'c_post',
			'c_edit', 'c_delete', 'i_move', 'a_unlimited',
		], 1);
		$uploader_role += array_fill_keys(['m_comments', 'm_delete', 'm_edit', 'm_move', 'm_report', 'm_status'], 0);
		$uploader_role['i_approve'] = (int) $approve;
		$uploader_role['i_count'] = 100;
		$uploader_role['a_count'] = 100;
		$uploader_role['a_restrict'] = 0;
		$uploader_role_id = $this->insert_role($uploader_role);

		$moderator_role = $uploader_role;
		foreach (['i_approve', 'm_comments', 'm_delete', 'm_edit', 'm_move', 'm_report', 'm_status'] as $permission)
		{
			$moderator_role[$permission] = 1;
		}
		$moderator_role_id = $this->insert_role($moderator_role);
		$this->insert_album_permission($album_id, $uploader_id, $uploader_role_id);
		$this->insert_album_permission($album_id, 2, $moderator_role_id);

		$db->sql_query('UPDATE ' . $this->table('gallery_users') . " SET user_permissions = '' WHERE user_id IN (1, 2, " . $uploader_id . ')');
		return $album_id;
	}

	private function insert_role(array $role): int
	{
		$db = $this->get_db();
		$db->sql_query('INSERT INTO ' . $this->table('gallery_roles') . ' ' . $db->sql_build_array('INSERT', $role));
		return (int) $db->sql_nextid();
	}

	private function insert_album_permission(int $album_id, int $user_id, int $role_id): void
	{
		$db = $this->get_db();
		$row = [
			'perm_role_id' => $role_id,
			'perm_album_id' => $album_id,
			'perm_user_id' => $user_id,
			'perm_group_id' => 0,
			'perm_system' => 0,
		];
		$db->sql_query('INSERT INTO ' . $this->table('gallery_permissions') . ' ' . $db->sql_build_array('INSERT', $row));
	}

	/** @return array{0: int, 1: string} */
	private function upload_image(int $album_id, string $root, string $name, string $salt,
		string $author = '', array $contributors = []): array
	{
		$fixture = $root . 'store/bbpointsimages-' . $salt . '.png';
		$this->write_test_png($fixture, $salt);
		$path = 'app.php/gallery/album/' . $album_id . '/upload?sid=' . $this->sid;
		$crawler = self::request('GET', $path);
		$form = $crawler->selectButton($this->lang('CONTINUE'))->form();
		$form['files[0]']->upload($fixture);
		$first_step = $author === '' ? [] : ['change_author' => $author];
		$crawler = self::submit($form, $first_step);
		$this->assertTrue(unlink($fixture));

		$form = $crawler->selectButton($this->lang('SUBMIT'))->form();
		$values = [
			'image_name' => [$name],
			'image_subtitle' => [''],
			'message' => [''],
			'bbpointsimages_contributors_0' => implode("\n", $contributors),
		];
		if ($author !== '')
		{
			$values['change_author'] = $author;
		}
		$crawler = self::submit($form, $values);
		$this->assertStringContainsString($this->lang('ALBUM_UPLOAD_SUCCESSFUL'), $crawler->filter('body')->text());

		$db = $this->get_db();
		$sql = 'SELECT image_id, image_filename FROM ' . $this->table('gallery_images') . "
			WHERE image_name = '" . $db->sql_escape($name) . "' AND image_album_id = " . $album_id;
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
		$this->assertIsArray($row);
		return [(int) $row['image_id'], (string) $row['image_filename']];
	}

	private function purchase_and_download(int $image_id, int $buyer_id): void
	{
		$path = 'app.php/gallery/image/' . $image_id . '/source';
		$crawler = self::request('GET', $path);
		$this->assertStringContainsString((string) self::SOURCE_COST, $crawler->filter('body')->text());
		$this->assertSame(0, $this->purchase_count($image_id, $buyer_id));
		$form = $crawler->selectButton($this->lang('YES'))->form();
		self::submit($form);
		$this->assertSame(1, $this->purchase_count($image_id, $buyer_id));
		$this->assert_download_counters($image_id, $buyer_id, 1);

		$balance = $this->balance($buyer_id);
		self::request('GET', $path);
		$this->assertSame(1, $this->purchase_count($image_id, $buyer_id));
		$this->assertSame($balance, $this->balance($buyer_id));
		$this->assert_download_counters($image_id, $buyer_id, 2);
	}

	private function approve_image(int $image_id): void
	{
		$crawler = self::request('GET', 'app.php/gallery/moderate/image/' . $image_id . '/approve?sid=' . $this->sid);
		$form = $crawler->selectButton($this->lang('YES'))->form();
		self::submit($form);
	}

	private function import_image(int $album_id, string $root, string $author): int
	{
		$filename = 'bbpointsimages-import.png';
		$path = $root . 'files/phpbbgallery/import/' . $filename;
		$this->write_test_png($path, 'import');
		$module_id = $this->module_id('acp', '\\phpbbgallery\\acpimport\\acp\\main_module', 'import_images');
		$crawler = self::request('GET', 'adm/index.php?i=' . $module_id . '&mode=import_images&sid=' . $this->sid);
		$form = $crawler->selectButton('submit')->form();
		$crawler = self::submit($form, [
			'album_id' => $album_id,
			'images' => [$filename],
			'username' => $author,
			'image_name' => 'Imported points image {NUM}',
			'image_num' => 1,
		]);
		$this->follow_meta_refresh($crawler);
		$this->assertFileDoesNotExist($path);

		$db = $this->get_db();
		$result = $db->sql_query('SELECT image_id FROM ' . $this->table('gallery_images') . " WHERE image_name = 'Imported points image 1'");
		$image_id = (int) $db->sql_fetchfield('image_id');
		$db->sql_freeresult($result);
		$this->assertGreaterThan(0, $image_id);
		return $image_id;
	}

	private function insert_historical_image(int $album_id, int $author_id, string $root): int
	{
		$db = $this->get_db();
		$filename = 'bbpointsimages-historical.png';
		$this->write_test_png($root . 'files/phpbbgallery/core/source/' . $filename, 'historical');
		$image = [
			'image_filename' => $filename,
			'image_name' => 'Historical points image',
			'image_name_clean' => 'historical points image',
			'image_user_id' => $author_id,
			'image_username' => self::RETRO_AUTHOR,
			'image_username_clean' => utf8_clean_string(self::RETRO_AUTHOR),
			'image_time' => time(),
			'image_album_id' => $album_id,
			'image_status' => \phpbbgallery\core\block::STATUS_APPROVED,
		];
		$db->sql_query('INSERT INTO ' . $this->table('gallery_images') . ' ' . $db->sql_build_array('INSERT', $image));
		return (int) $db->sql_nextid();
	}

	private function run_retro_sync(): void
	{
		$module_id = $this->module_id('acp', '\\phpbbgallery\\bbpointsimages\\acp\\main_module', 'settings');
		$crawler = self::request('GET', 'adm/index.php?i=' . $module_id . '&mode=settings&sid=' . $this->sid);
		$form = $crawler->selectButton($this->lang('ACP_BBPOINTSIMAGES_SYNC_BUTTON'))->form();
		$crawler = self::submit($form);
		$form = $crawler->selectButton($this->lang('YES'))->form();
		$crawler = self::submit($form);
		$this->assertNotSame('', trim($crawler->filter('div.successbox')->text()));
	}

	private function assert_reward(int $image_id, int $user_id, int $amount, string $filename, string $root): void
	{
		$this->assert_reward_row($image_id, $user_id, $amount);
		$db = $this->get_db();
		$result = $db->sql_query('SELECT source_sha256 FROM ' . $this->table('gallery_bbpoints_image_stats') . ' WHERE image_id = ' . $image_id);
		$hash = (string) $db->sql_fetchfield('source_sha256');
		$db->sql_freeresult($result);
		$this->assertSame(hash_file('sha256', $root . 'files/phpbbgallery/core/source/' . $filename), $hash);
	}

	private function assert_reward_row(int $image_id, int $user_id, int $amount): void
	{
		$db = $this->get_db();
		$result = $db->sql_query('SELECT user_id, amount, operation_key FROM ' . $this->table('gallery_bbpoints_rewards') . ' WHERE image_id = ' . $image_id);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
		$this->assertIsArray($row);
		$this->assertSame($user_id, (int) $row['user_id']);
		$this->assertSame($amount, (int) $row['amount']);
		$this->assertSame('gallery:image:' . $image_id . ':reward', $row['operation_key']);
	}

	private function assert_contributors(int $image_id, array $expected): void
	{
		$db = $this->get_db();
		$result = $db->sql_query('SELECT user_id FROM ' . $this->table('gallery_bbpoints_contributors') . ' WHERE image_id = ' . $image_id . ' ORDER BY contributor_order ASC');
		$actual = [];
		while ($row = $db->sql_fetchrow($result))
		{
			$actual[] = (int) $row['user_id'];
		}
		$db->sql_freeresult($result);
		$this->assertSame($expected, $actual);
	}

	private function assert_download_counters(int $image_id, int $buyer_id, int $count): void
	{
		$db = $this->get_db();
		$result = $db->sql_query('SELECT download_count FROM ' . $this->table('gallery_bbpoints_image_stats') . ' WHERE image_id = ' . $image_id);
		$this->assertSame($count, (int) $db->sql_fetchfield('download_count'));
		$db->sql_freeresult($result);
		$result = $db->sql_query('SELECT download_count FROM ' . $this->table('gallery_bbpoints_purchases') . ' WHERE image_id = ' . $image_id . ' AND buyer_id = ' . $buyer_id);
		$this->assertSame($count, (int) $db->sql_fetchfield('download_count'));
		$db->sql_freeresult($result);
	}

	private function assert_notification(string $type, int $user_id, int $image_id): void
	{
		$db = $this->get_db();
		$sql = 'SELECT COUNT(n.notification_id) AS total FROM ' . $this->table('notifications') . ' n
			JOIN ' . $this->table('notification_types') . " t ON t.notification_type_id = n.notification_type_id
			WHERE t.notification_type_name = '" . $db->sql_escape($type) . "'
				AND n.user_id = " . $user_id . ' AND n.item_id = ' . $image_id;
		$result = $db->sql_query($sql);
		$this->assertGreaterThan(0, (int) $db->sql_fetchfield('total'), $type . ':' . $user_id);
		$db->sql_freeresult($result);
	}

	private function assert_notification_type_state(bool $enabled): void
	{
		$db = $this->get_db();
		$sql = 'SELECT COUNT(notification_type_id) AS total FROM ' . $this->table('notification_types') . "
			WHERE notification_type_name IN ('phpbbgallery.bbpointsimages.notification.reward', 'phpbbgallery.bbpointsimages.notification.source_purchase')
				AND notification_type_enabled = " . (int) $enabled;
		$result = $db->sql_query($sql);
		$this->assertSame(2, (int) $db->sql_fetchfield('total'));
		$db->sql_freeresult($result);
	}

	private function assert_extension_state(string $extension, bool $active): void
	{
		$db = $this->get_db();
		$result = $db->sql_query('SELECT ext_active FROM ' . EXT_TABLE . " WHERE ext_name = '" . $db->sql_escape($extension) . "'");
		$this->assertSame((int) $active, (int) $db->sql_fetchfield('ext_active'));
		$db->sql_freeresult($result);
	}

	private function image_status(int $image_id): int
	{
		$db = $this->get_db();
		$result = $db->sql_query('SELECT image_status FROM ' . $this->table('gallery_images') . ' WHERE image_id = ' . $image_id);
		$status = (int) $db->sql_fetchfield('image_status');
		$db->sql_freeresult($result);
		return $status;
	}

	private function reward_count(int $image_id): int
	{
		$db = $this->get_db();
		$result = $db->sql_query('SELECT COUNT(image_id) AS total FROM ' . $this->table('gallery_bbpoints_rewards') . ' WHERE image_id = ' . $image_id);
		$count = (int) $db->sql_fetchfield('total');
		$db->sql_freeresult($result);
		return $count;
	}

	private function purchase_count(int $image_id, int $buyer_id): int
	{
		$db = $this->get_db();
		$result = $db->sql_query('SELECT COUNT(image_id) AS total FROM ' . $this->table('gallery_bbpoints_purchases') . ' WHERE image_id = ' . $image_id . ' AND buyer_id = ' . $buyer_id);
		$count = (int) $db->sql_fetchfield('total');
		$db->sql_freeresult($result);
		return $count;
	}

	private function seed_points(int $user_id, int $amount): void
	{
		$db = $this->get_db();
		$row = ['from_id' => 0, 'to_id' => $user_id, 'bbpoints' => $amount, 'reason' => 'Functional seed', 'timestamp' => time()];
		$db->sql_query('INSERT INTO ' . $this->table('bbpoints') . ' ' . $db->sql_build_array('INSERT', $row));
	}

	private function balance(int $user_id): int
	{
		$db = $this->get_db();
		$sql = 'SELECT COALESCE(SUM(CASE WHEN to_id = ' . $user_id . ' THEN bbpoints ELSE 0 END), 0)
			- COALESCE(SUM(CASE WHEN from_id = ' . $user_id . ' THEN bbpoints ELSE 0 END), 0) AS total
			FROM ' . $this->table('bbpoints');
		$result = $db->sql_query($sql);
		$balance = (int) $db->sql_fetchfield('total');
		$db->sql_freeresult($result);
		return $balance;
	}

	private function set_config(string $name, int $value): void
	{
		$db = $this->get_db();
		$db->sql_query('UPDATE ' . CONFIG_TABLE . " SET config_value = '" . $value . "' WHERE config_name = '" . $db->sql_escape($name) . "'");
	}

	private function module_id(string $class, string $basename, string $mode): int
	{
		$db = $this->get_db();
		$sql = 'SELECT module_id FROM ' . MODULES_TABLE . " WHERE module_class = '" . $db->sql_escape($class) . "'
			AND module_basename = '" . $db->sql_escape($basename) . "' AND module_mode = '" . $db->sql_escape($mode) . "'";
		$result = $db->sql_query($sql);
		$module_id = (int) $db->sql_fetchfield('module_id');
		$db->sql_freeresult($result);
		$this->assertGreaterThan(0, $module_id, $basename);
		return $module_id;
	}

	private function follow_meta_refresh($crawler)
	{
		$meta = $crawler->filter('meta[http-equiv="refresh"]');
		$this->assertSame(1, $meta->count(), $crawler->filter('body')->text());
		preg_match('/url=(.+)$/i', $meta->attr('content'), $matches);
		$url = html_entity_decode($matches[1], ENT_QUOTES, 'UTF-8');
		return self::request('GET', preg_replace('#^https?://[^/]+/#', '', $url));
	}

	private function table(string $suffix): string
	{
		return self::$config['table_prefix'] . $suffix;
	}

	private function write_test_png(string $path, string $salt): void
	{
		$png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=', true);
		$this->assertNotFalse($png);
		$this->assertNotFalse(file_put_contents($path, $png . $salt));
	}
}
