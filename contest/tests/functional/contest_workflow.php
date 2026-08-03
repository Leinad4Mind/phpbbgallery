<?php
/**
 * phpBB Gallery - Contest functional tests
 *
 * @package   phpbbgallery/contest
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\contest\tests\functional;

/**
 * Exercise the authenticated contest lifecycle against an installed phpBB board.
 *
 * @group functional
 */
class contest_workflow extends \phpbb_functional_test_case
{
	private const COMPONENTS = [
		'phpbbgallery/core',
		'phpbbgallery/contest',
	];
	private const PARTICIPANT = 'gallery-contest-participant';
	private const VIEWER = 'gallery-contest-viewer';
	private const ALBUM_NAME = 'Functional Contest Album';
	private const IMAGE_NAMES = [
		'Functional contest first',
		'Functional contest second',
		'Functional contest third',
	];

	protected static function setup_extensions(): array
	{
		return self::COMPONENTS;
	}

	/**
	 * Accept extension-specific activation messages and migration continuations.
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

	public function test_complete_authenticated_contest_lifecycle(): void
	{
		global $phpbb_root_path;

		$this->add_lang_ext('phpbbgallery/core', ['gallery', 'gallery_acp']);
		$this->add_lang_ext('phpbbgallery/contest', ['contest', 'contest_acp']);
		$participant_id = $this->create_user(self::PARTICIPANT);
		$viewer_id = $this->create_user(self::VIEWER);

		$this->login();
		$this->admin_login();
		[$album_id, $contest_id] = $this->create_contest_album();
		$this->grant_album_permissions($album_id, $participant_id, $viewer_id);
		$this->logout();
		$this->purge_cache();

		$this->login(self::PARTICIPANT);
		$image_ids = [];
		foreach (self::IMAGE_NAMES as $index => $name)
		{
			$image_ids[] = $this->upload_image($album_id, $name, $index, $phpbb_root_path);
		}
		$this->logout();

		$this->assert_active_privacy($album_id, $image_ids[0]);
		$this->assert_fail_closed_without_addon($album_id, $image_ids[0]);
		$this->advance_to_rating_phase($contest_id);
		$this->rate_images($image_ids);
		$contest_end = $this->advance_to_completed_phase($contest_id, $album_id);
		$this->assert_podium_is_published($album_id, $contest_id, $contest_end, $image_ids);
	}

	/**
	 * Create the contest through the real ACP form and its add-on fields.
	 *
	 * @return array{0: int, 1: int}
	 */
	private function create_contest_album(): array
	{
		$module_id = $this->module_id('acp', '\\phpbbgallery\\core\\acp\\albums_module', 'manage');
		$path = 'adm/index.php?i=' . $module_id . '&mode=manage&action=add&parent_id=0&sid=' . $this->sid;
		$crawler = self::request('GET', $path);
		self::assert_response_html(200);
		$this->assertSame(1, $crawler->filter('select[name="album_type"] option[value="2"]')->count());
		$this->assertSame(1, $crawler->filter('input[name="contest_start"]')->count());
		$this->assertSame(1, $crawler->filter('input[name="contest_rating"]')->count());
		$this->assertSame(1, $crawler->filter('input[name="contest_end"]')->count());

		$timezone = new \DateTimeZone('UTC');
		$start = new \DateTimeImmutable('-5 minutes', $timezone);
		$rating = new \DateTimeImmutable('+30 minutes', $timezone);
		$end = new \DateTimeImmutable('+60 minutes', $timezone);
		$form = $crawler->selectButton($this->lang('SUBMIT'))->form();
		$crawler = self::submit($form, [
			'album_type' => \phpbbgallery\contest\manager::ALBUM_TYPE,
			'album_name' => self::ALBUM_NAME,
			'parent_id' => 0,
			'album_status' => \phpbbgallery\core\block::ALBUM_OPEN,
			'album_watermark' => 0,
			'display_in_rrc' => 1,
			'display_subalbum_list' => 1,
			'display_on_index' => 1,
			'contest_start' => $start->format('Y-n-j G:i'),
			'contest_rating' => $rating->format('Y-n-j G:i'),
			'contest_end' => $end->format('Y-n-j G:i'),
		]);
		$this->assertStringContainsString($this->lang('ALBUM_CREATED'), $crawler->filter('body')->text());

		$db = $this->get_db();
		$sql = 'SELECT a.album_id, a.album_contest, c.contest_id, c.contest_marked
			FROM ' . $this->table('gallery_albums') . ' a
			JOIN ' . $this->table('gallery_contests') . " c ON c.contest_album_id = a.album_id
			WHERE a.album_name = '" . $db->sql_escape(self::ALBUM_NAME) . "'
				AND a.album_type = " . \phpbbgallery\contest\manager::ALBUM_TYPE;
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		$this->assertIsArray($row);
		$this->assertSame((int) $row['contest_id'], (int) $row['album_contest']);
		$this->assertSame(\phpbbgallery\contest\manager::STATE_ACTIVE, (int) $row['contest_marked']);

		return [(int) $row['album_id'], (int) $row['contest_id']];
	}

	private function grant_album_permissions(int $album_id, int $participant_id, int $viewer_id): void
	{
		$permissions = [
			'a_list', 'i_view', 'i_watermark', 'i_upload', 'i_edit', 'i_delete',
			'i_rate', 'i_approve', 'i_lock', 'i_report', 'i_unlimited', 'c_read',
			'c_post', 'c_edit', 'c_delete', 'm_comments', 'm_delete', 'm_edit',
			'm_move', 'm_report', 'm_status', 'i_move', 'a_unlimited',
		];
		$participant_role = array_fill_keys($permissions, 0);
		foreach (['a_list', 'i_view', 'i_watermark', 'i_upload', 'i_edit', 'i_delete', 'i_rate', 'i_approve', 'i_unlimited', 'c_read', 'c_post'] as $permission)
		{
			$participant_role[$permission] = 1;
		}
		$participant_role['i_count'] = 100;
		$participant_role['a_count'] = 100;
		$participant_role['a_restrict'] = 0;

		$viewer_role = array_fill_keys($permissions, 0);
		foreach (['a_list', 'i_view', 'i_watermark', 'i_rate', 'c_read', 'c_post'] as $permission)
		{
			$viewer_role[$permission] = 1;
		}
		$viewer_role['i_count'] = 100;
		$viewer_role['a_count'] = 100;
		$viewer_role['a_restrict'] = 0;

		$this->insert_album_permission($album_id, $participant_id, $this->insert_role($participant_role));
		$this->insert_album_permission($album_id, $viewer_id, $this->insert_role($viewer_role));
		$db = $this->get_db();
		$db->sql_query('UPDATE ' . $this->table('gallery_users') . "
			SET user_permissions = ''
			WHERE user_id IN (1, 2, " . $participant_id . ', ' . $viewer_id . ')');
	}

	private function upload_image(int $album_id, string $name, int $index, string $root): int
	{
		$fixture = $root . 'store/contest-functional-' . $index . '.png';
		$this->write_test_png($fixture, (string) $index);
		$path = 'app.php/gallery/album/' . $album_id . '/upload?sid=' . $this->sid;
		$crawler = self::request('GET', $path);
		$form = $crawler->selectButton($this->lang('CONTINUE'))->form();
		$this->assertTrue($form->has('files[0]'));
		$form['files[0]']->upload($fixture);
		$crawler = self::submit($form);
		$this->assertTrue(unlink($fixture));

		$form = $crawler->selectButton($this->lang('SUBMIT'))->form();
		$crawler = self::submit($form, [
			'image_name' => [$name],
			'image_subtitle' => [''],
			'message' => ['Private description ' . $index],
		]);
		$this->assertStringContainsString($this->lang('ALBUM_UPLOAD_SUCCESSFUL'), $crawler->filter('body')->text());

		$db = $this->get_db();
		$sql = 'SELECT image_id, image_status, image_contest, image_contest_end
			FROM ' . $this->table('gallery_images') . "
			WHERE image_name = '" . $db->sql_escape($name) . "'
				AND image_album_id = " . $album_id;
		$result = $db->sql_query($sql);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		$this->assertIsArray($row);
		$this->assertSame(\phpbbgallery\core\block::STATUS_APPROVED, (int) $row['image_status']);
		$this->assertSame(\phpbbgallery\contest\manager::STATE_ACTIVE, (int) $row['image_contest']);
		$this->assertSame(0, (int) $row['image_contest_end']);

		return (int) $row['image_id'];
	}

	private function assert_active_privacy(int $album_id, int $image_id): void
	{
		$this->login(self::VIEWER);
		$crawler = self::request('GET', 'app.php/gallery/album/' . $album_id . '?sid=' . $this->sid);
		self::assert_response_html(200);
		$body = $crawler->filter('body')->text();
		foreach (self::IMAGE_NAMES as $name)
		{
			$this->assertStringContainsString($name, $body);
		}
		$this->assertStringNotContainsString(self::PARTICIPANT, $body);
		$this->assertStringContainsString(strip_tags($this->lang('CONTEST_USERNAME')), $body);

		$crawler = self::request('GET', 'app.php/gallery/image/' . $image_id . '?sid=' . $this->sid, [], false);
		self::assert_response_status_code(200);
		$body = $crawler->filter('body')->text();
		$this->assertStringNotContainsString('Private description 0', $body);
		$this->assertStringNotContainsString(self::PARTICIPANT, $body);
		$this->assertSame(0, $crawler->filter('select[name="rating"]')->count());
		$this->logout();
	}

	private function assert_fail_closed_without_addon(int $album_id, int $image_id): void
	{
		$this->disable_ext('phpbbgallery/contest');
		$this->assert_extension_state(false);
		$this->login(self::VIEWER);

		$crawler = self::request('GET', 'app.php/gallery/album/' . $album_id . '?sid=' . $this->sid);
		self::assert_response_html(200);
		$this->assertStringNotContainsString(self::PARTICIPANT, $crawler->filter('body')->text());
		$crawler = self::request('GET', 'app.php/gallery/image/' . $image_id . '?sid=' . $this->sid, [], false);
		self::assert_response_status_code(200);
		$body = $crawler->filter('body')->text();
		$this->assertStringNotContainsString(self::PARTICIPANT, $body);
		$this->assertStringNotContainsString('Private description 0', $body);
		$this->assertSame(0, $crawler->filter('select[name="rating"]')->count());
		$this->logout();

		$this->install_ext('phpbbgallery/contest');
		$this->assert_extension_state(true);
		$this->assertSame(3, $this->active_image_count($album_id));
	}

	private function advance_to_rating_phase(int $contest_id): void
	{
		$db = $this->get_db();
		$result = $db->sql_query('SELECT contest_start FROM ' . $this->table('gallery_contests') . ' WHERE contest_id = ' . $contest_id);
		$start = (int) $db->sql_fetchfield('contest_start');
		$db->sql_freeresult($result);
		$rating_duration = max(1, time() - $start - 1);
		$db->sql_query('UPDATE ' . $this->table('gallery_contests') . '
			SET contest_rating = ' . $rating_duration . '
			WHERE contest_id = ' . $contest_id);
		$this->purge_cache();
	}

	/**
	 * Submit a real rating for every entry as a different user.
	 *
	 * @param int[] $image_ids
	 */
	private function rate_images(array $image_ids): void
	{
		$this->login(self::VIEWER);
		foreach ($image_ids as $index => $image_id)
		{
			$crawler = self::request('GET', 'app.php/gallery/image/' . $image_id . '?sid=' . $this->sid, [], false);
			self::assert_response_status_code(200);
			$this->assertSame(1, $crawler->filter('select[name="rating"]')->count(), $crawler->filter('body')->text());
			$form = $crawler->filter('form#postform')->form();
			$crawler = self::submit($form, ['rating' => 10 - $index], false);
			self::assert_response_status_code(200);
			$this->assertStringContainsString($this->lang('RATING_SUCCESSFUL'), $crawler->filter('body')->text());
		}
		$this->logout();

		$db = $this->get_db();
		$result = $db->sql_query('SELECT COUNT(rate_image_id) AS total FROM ' . $this->table('gallery_rates') . '
			WHERE ' . $db->sql_in_set('rate_image_id', $image_ids));
		$this->assertSame(count($image_ids), (int) $db->sql_fetchfield('total'));
		$db->sql_freeresult($result);
	}

	private function advance_to_completed_phase(int $contest_id, int $album_id): int
	{
		$start = time() - 120;
		$end_duration = 60;
		$end_time = $start + $end_duration;
		$db = $this->get_db();
		$db->sql_query('UPDATE ' . $this->table('gallery_contests') . '
			SET contest_start = ' . $start . ', contest_rating = 30, contest_end = ' . $end_duration . ',
				contest_marked = ' . \phpbbgallery\contest\manager::STATE_ACTIVE . '
			WHERE contest_id = ' . $contest_id);
		$db->sql_query('UPDATE ' . $this->table('gallery_images') . '
			SET image_contest = ' . \phpbbgallery\contest\manager::STATE_ACTIVE . ',
				image_contest_end = ' . $end_time . ', image_contest_rank = 0
			WHERE image_album_id = ' . $album_id);
		$this->purge_cache();

		return $end_time;
	}

	/**
	 * @param int[] $image_ids
	 */
	private function assert_podium_is_published(int $album_id, int $contest_id, int $end_time, array $image_ids): void
	{
		$this->login(self::VIEWER);
		$crawler = self::request('GET', 'app.php/gallery/album/' . $album_id . '?sid=' . $this->sid);
		self::assert_response_html(200);
		$this->assertStringContainsString(self::ALBUM_NAME, $crawler->filter('body')->text());

		$db = $this->get_db();
		$result = $db->sql_query('SELECT contest_marked, contest_first, contest_second, contest_third
			FROM ' . $this->table('gallery_contests') . ' WHERE contest_id = ' . $contest_id);
		$contest = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
		$this->assertIsArray($contest);
		$this->assertSame(\phpbbgallery\contest\manager::STATE_INACTIVE, (int) $contest['contest_marked']);
		$this->assertSame($image_ids, [
			(int) $contest['contest_first'],
			(int) $contest['contest_second'],
			(int) $contest['contest_third'],
		]);

		$result = $db->sql_query('SELECT image_id, image_contest, image_contest_end, image_contest_rank
			FROM ' . $this->table('gallery_images') . '
			WHERE ' . $db->sql_in_set('image_id', $image_ids) . '
			ORDER BY image_contest_rank ASC');
		$ranks = [];
		while ($row = $db->sql_fetchrow($result))
		{
			$this->assertSame(\phpbbgallery\contest\manager::STATE_INACTIVE, (int) $row['image_contest']);
			$this->assertSame($end_time, (int) $row['image_contest_end']);
			$ranks[(int) $row['image_contest_rank']] = (int) $row['image_id'];
		}
		$db->sql_freeresult($result);
		$this->assertSame([1 => $image_ids[0], 2 => $image_ids[1], 3 => $image_ids[2]], $ranks);

		$crawler = self::request('GET', 'app.php/gallery/search/contests?sid=' . $this->sid);
		self::assert_response_html(200);
		$body = $crawler->filter('body')->text();
		foreach (self::IMAGE_NAMES as $name)
		{
			$this->assertStringContainsString($name, $body);
		}
		$this->assertStringContainsString(self::ALBUM_NAME, $body);

		$crawler = self::request('GET', 'app.php/gallery?sid=' . $this->sid);
		$this->assertSame(1, $crawler->filter('a[href*="gallery/search/contests"]')->count());
		$this->logout();
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

	private function module_id(string $class, string $basename, string $mode): int
	{
		$db = $this->get_db();
		$sql = 'SELECT module_id FROM ' . $this->table('modules') . "
			WHERE module_class = '" . $db->sql_escape($class) . "'
				AND module_basename = '" . $db->sql_escape($basename) . "'
				AND module_mode = '" . $db->sql_escape($mode) . "'";
		$result = $db->sql_query($sql);
		$module_id = (int) $db->sql_fetchfield('module_id');
		$db->sql_freeresult($result);
		$this->assertGreaterThan(0, $module_id, $basename);

		return $module_id;
	}

	private function assert_extension_state(bool $active): void
	{
		$db = $this->get_db();
		$result = $db->sql_query('SELECT ext_active FROM ' . $this->table('ext') . "
			WHERE ext_name = 'phpbbgallery/contest'");
		$this->assertSame((int) $active, (int) $db->sql_fetchfield('ext_active'));
		$db->sql_freeresult($result);
	}

	private function active_image_count(int $album_id): int
	{
		$db = $this->get_db();
		$result = $db->sql_query('SELECT COUNT(image_id) AS total FROM ' . $this->table('gallery_images') . '
			WHERE image_album_id = ' . $album_id . '
				AND image_contest = ' . \phpbbgallery\contest\manager::STATE_ACTIVE);
		$count = (int) $db->sql_fetchfield('total');
		$db->sql_freeresult($result);

		return $count;
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
