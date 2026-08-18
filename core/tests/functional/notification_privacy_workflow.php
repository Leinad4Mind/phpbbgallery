<?php
/**
 * phpBB Gallery - moderation notification privacy functional tests.
 *
 * @package   phpbbgallery/core
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests\functional;

/**
 * Exercise Gallery notification audiences through real phpBB routes and storage.
 *
 * @group functional
 */
class notification_privacy_workflow extends \phpbb_functional_test_case
{
	private const ALBUM_NAME = 'Functional notification album';
	private const AUTHOR = 'gallery-notify-author';
	private const DUAL = 'gallery-notify-dual';
	private const MODERATOR = 'gallery-notify-moderator';
	private const REPORTER = 'gallery-notify-reporter';

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

	public function test_moderation_identities_are_visible_only_to_the_album_team(): void
	{
		global $phpbb_root_path;

		$this->add_lang_ext('phpbbgallery/core', ['gallery', 'gallery_mcp', 'gallery_notifications']);
		$author_id = $this->create_user(self::AUTHOR);
		$dual_id = $this->create_user(self::DUAL);
		$moderator_id = $this->create_user(self::MODERATOR);
		$reporter_id = $this->create_user(self::REPORTER);
		[$album_id, $images] = $this->seed_gallery($author_id, $dual_id, $moderator_id, $reporter_id, $phpbb_root_path);
		$this->clear_gallery_notifications();

		$this->login();
		$this->confirm_route('app.php/gallery/moderate/image/' . $images['approve_author'] . '/approve?sid=' . $this->sid);
		$this->confirm_route('app.php/gallery/moderate/image/' . $images['approve_dual'] . '/approve?sid=' . $this->sid);
		$this->confirm_route('app.php/gallery/image/' . $images['delete'] . '/delete?sid=' . $this->sid);
		$this->confirm_route('app.php/gallery/image/' . $images['reject'] . '/delete?sid=' . $this->sid);
		$this->logout();

		$this->login(self::REPORTER);
		$this->report_image($images['report']);
		$this->logout();

		$notifications = $this->gallery_notifications();
		$this->assert_recipients($notifications, 'phpbbgallery.core.notification.image_approved', '', [$author_id]);
		$this->assert_recipients($notifications, 'phpbbgallery.core.notification.image_not_approved', '', [$author_id]);
		$this->assert_recipients($notifications, 'phpbbgallery.core.notification.image_removed', '', [$author_id]);
		$this->assert_recipients($notifications, 'phpbbgallery.core.notification.image_moderated', 'approved', [$dual_id, $moderator_id]);
		$this->assert_recipients($notifications, 'phpbbgallery.core.notification.image_moderated', 'rejected', [$dual_id, $moderator_id]);
		$this->assert_recipients($notifications, 'phpbbgallery.core.notification.image_moderated', 'deleted', [$dual_id, $moderator_id]);
		$this->assert_recipients($notifications, 'phpbbgallery.core.notification.new_report', '', [2, $dual_id, $moderator_id]);

		foreach ($notifications as $notification)
		{
			$data = $notification['data'];
			if (in_array($notification['type'], [
				'phpbbgallery.core.notification.image_approved',
				'phpbbgallery.core.notification.image_not_approved',
				'phpbbgallery.core.notification.image_removed',
			], true))
			{
				$this->assertArrayNotHasKey('actor_id', $data);
			}
			if ($notification['type'] === 'phpbbgallery.core.notification.image_moderated')
			{
				$this->assertSame(2, (int) $data['actor_id']);
			}
			if ($notification['type'] === 'phpbbgallery.core.notification.new_report')
			{
				$this->assertSame($reporter_id, (int) $data['reporter']);
			}
		}

		$author_titles = $this->notification_titles(self::AUTHOR);
		$this->assertStringContainsString('were approved', $author_titles);
		$this->assertStringContainsString('were not approved', $author_titles);
		$this->assertStringContainsString('were removed by the moderation team', $author_titles);
		$this->assertStringNotContainsString('admin approved', $author_titles);
		$this->assertStringNotContainsString(self::REPORTER . ' reported', $author_titles);

		$team_titles = $this->notification_titles(self::DUAL);
		$this->assertStringContainsString('admin approved images', $team_titles);
		$this->assertStringContainsString('admin rejected images', $team_titles);
		$this->assertStringContainsString('admin removed images', $team_titles);
		$this->assertStringContainsString(self::REPORTER . ' reported image', $team_titles);

		$this->assertSame($album_id, $this->album_id_from_notifications($notifications));
	}

	/** @return array{0: int, 1: array<string, int>} */
	private function seed_gallery(int $author_id, int $dual_id, int $moderator_id, int $reporter_id, string $phpbb_root_path): array
	{
		$db = $this->get_db();
		$db->sql_query('INSERT INTO phpbb_gallery_albums ' . $db->sql_build_array('INSERT', [
			'parent_id' => 0,
			'album_parents' => '',
			'left_id' => 1,
			'right_id' => 2,
			'album_type' => \phpbbgallery\core\block::TYPE_UPLOAD,
			'album_status' => \phpbbgallery\core\block::ALBUM_OPEN,
			'album_name' => self::ALBUM_NAME,
			'album_user_id' => \phpbbgallery\core\block::PUBLIC_ALBUM,
			'album_images' => 2,
			'album_images_real' => 5,
		]));
		$album_id = (int) $db->sql_nextid();

		$team_permissions = ['a_list', 'i_view', 'i_watermark', 'm_status', 'm_delete', 'm_report'];
		$this->grant_album_role($album_id, 2, $team_permissions);
		$this->grant_album_role($album_id, $dual_id, $team_permissions);
		$this->grant_album_role($album_id, $moderator_id, $team_permissions);
		$this->grant_album_role($album_id, $author_id, ['a_list', 'i_view']);
		$this->grant_album_role($album_id, $reporter_id, ['a_list', 'i_view', 'i_report']);

		$definitions = [
			'approve_author' => [$author_id, self::AUTHOR, \phpbbgallery\core\block::STATUS_UNAPPROVED],
			'approve_dual' => [$dual_id, self::DUAL, \phpbbgallery\core\block::STATUS_UNAPPROVED],
			'report' => [$author_id, self::AUTHOR, \phpbbgallery\core\block::STATUS_APPROVED],
			'delete' => [$author_id, self::AUTHOR, \phpbbgallery\core\block::STATUS_APPROVED],
			'reject' => [$author_id, self::AUTHOR, \phpbbgallery\core\block::STATUS_UNAPPROVED],
		];
		$images = [];
		foreach ($definitions as $key => [$user_id, $username, $status])
		{
			$filename = 'notification-' . str_replace('_', '-', $key) . '.png';
			foreach (['source', 'medium', 'mini'] as $directory)
			{
				$this->write_test_png($phpbb_root_path . 'files/phpbbgallery/core/' . $directory . '/' . $filename);
			}
			$db->sql_query('INSERT INTO phpbb_gallery_images ' . $db->sql_build_array('INSERT', [
				'image_filename' => $filename,
				'image_name' => 'Notification ' . $key,
				'image_name_clean' => 'notification ' . $key,
				'image_user_id' => $user_id,
				'image_username' => $username,
				'image_username_clean' => utf8_clean_string($username),
				'image_time' => time(),
				'image_album_id' => $album_id,
				'image_status' => $status,
				'filesize_upload' => (int) filesize($phpbb_root_path . 'files/phpbbgallery/core/source/' . $filename),
			]));
			$images[$key] = (int) $db->sql_nextid();
		}

		$db->sql_query('UPDATE phpbb_gallery_albums SET album_last_image_id = ' . max($images) . ' WHERE album_id = ' . $album_id);
		foreach ([$author_id => 2, $dual_id => 0, $moderator_id => 0, $reporter_id => 0] as $user_id => $image_count)
		{
			$db->sql_query('DELETE FROM phpbb_gallery_users WHERE user_id = ' . (int) $user_id);
			$db->sql_query('INSERT INTO phpbb_gallery_users ' . $db->sql_build_array('INSERT', [
				'user_id' => $user_id,
				'user_images' => $image_count,
				'user_permissions' => '',
			]));
		}
		$db->sql_query('UPDATE phpbb_gallery_users SET ' . $db->sql_build_array('UPDATE', ['user_permissions' => '']) . ' WHERE user_id = 2');
		$db->sql_query('UPDATE phpbb_config SET ' . $db->sql_build_array('UPDATE', ['config_value' => '2']) . ' WHERE config_name = ' . chr(39) . 'phpbb_gallery_num_images' . chr(39));
		$this->purge_cache();

		return [$album_id, $images];
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

	private function confirm_route(string $route): void
	{
		$crawler = self::request('GET', $route);
		$form = $crawler->selectButton($this->lang('YES'))->form();
		self::submit($form);
	}

	private function report_image(int $image_id): void
	{
		$crawler = self::request('GET', 'app.php/gallery/image/' . $image_id . '/report?sid=' . $this->sid);
		$form = $crawler->selectButton($this->lang('SUBMIT'))->form();
		self::submit($form, ['message' => 'Functional notification report', 'submit' => true]);
	}

	private function clear_gallery_notifications(): void
	{
		$db = $this->get_db();
		$sql = 'SELECT notification_type_id FROM ' . NOTIFICATION_TYPES_TABLE . '
			WHERE notification_type_name LIKE ' . chr(39) . 'phpbbgallery.core.notification.%' . chr(39);
		$result = $db->sql_query($sql);
		$type_ids = [];
		while ($row = $db->sql_fetchrow($result))
		{
			$type_ids[] = (int) $row['notification_type_id'];
		}
		$db->sql_freeresult($result);
		if ($type_ids)
		{
			$db->sql_query('DELETE FROM ' . NOTIFICATIONS_TABLE . ' WHERE ' . $db->sql_in_set('notification_type_id', $type_ids));
		}
	}

	/** @return array<int, array{type: string, user_id: int, data: array}> */
	private function gallery_notifications(): array
	{
		$db = $this->get_db();
		$sql = 'SELECT nt.notification_type_name, n.user_id, n.notification_data
			FROM ' . NOTIFICATIONS_TABLE . ' n
			INNER JOIN ' . NOTIFICATION_TYPES_TABLE . ' nt ON nt.notification_type_id = n.notification_type_id
			WHERE nt.notification_type_name LIKE ' . chr(39) . 'phpbbgallery.core.notification.%' . chr(39) . '
			ORDER BY n.notification_id ASC';
		$result = $db->sql_query($sql);
		$rows = [];
		while ($row = $db->sql_fetchrow($result))
		{
			$data = unserialize((string) $row['notification_data'], ['allowed_classes' => false]);
			$this->assertIsArray($data);
			$rows[] = [
				'type' => (string) $row['notification_type_name'],
				'user_id' => (int) $row['user_id'],
				'data' => $data,
			];
		}
		$db->sql_freeresult($result);

		return $rows;
	}

	private function assert_recipients(array $notifications, string $type, string $action, array $expected): void
	{
		$recipients = [];
		foreach ($notifications as $notification)
		{
			if ($notification['type'] === $type && ($notification['data']['action'] ?? '') === $action)
			{
				$recipients[] = $notification['user_id'];
			}
		}
		$recipients = array_values(array_unique($recipients));
		sort($recipients);
		sort($expected);
		$this->assertSame($expected, $recipients, $type . ':' . $action);
	}

	private function notification_titles(string $username): string
	{
		$this->login($username);
		$crawler = self::request('GET', 'ucp.php?i=ucp_notifications&mode=notification_list&sid=' . $this->sid);
		$titles = $crawler->filter('.notifications_title')->each(static fn($node): string => trim($node->text()));
		$this->logout();

		return implode(chr(10), $titles);
	}

	private function album_id_from_notifications(array $notifications): int
	{
		foreach ($notifications as $notification)
		{
			if (isset($notification['data']['album_id']))
			{
				return (int) $notification['data']['album_id'];
			}
		}

		return 0;
	}

	private function write_test_png(string $path): void
	{
		$png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=', true);
		$this->assertNotFalse($png);
		$this->assertNotFalse(file_put_contents($path, $png));
	}
}
