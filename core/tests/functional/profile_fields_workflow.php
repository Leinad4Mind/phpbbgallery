<?php
/**
 * phpBB Gallery - custom profile fields functional tests.
 *
 * @package   phpbbgallery/core
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests\functional;

/**
 * Render distinct viewtopic-enabled fields for an image and comment author.
 *
 * @group functional
 */
class profile_fields_workflow extends \phpbb_functional_test_case
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

	public function test_image_and_comment_authors_render_their_own_custom_profile_fields(): void
	{
		global $phpbb_root_path;

		$this->add_lang_ext('phpbbgallery/core', 'gallery');
		$this->login();
		$this->admin_login();
		$commenter_name = 'gallery-profile-commenter';
		$commenter_id = $this->create_user($commenter_name);
		$image_author_value = 'Gallery image author location';
		$comment_author_value = 'Gallery comment author location';

		$this->assert_viewtopic_profile_field_is_available();
		$this->set_profile_location(2, $image_author_value);
		$this->set_profile_location($commenter_id, $comment_author_value);
		$this->set_config_value('load_cpf_viewtopic', '1');
		[$image_id, $comment_id] = $this->seed_image_and_comment($commenter_id, $phpbb_root_path);
		$this->purge_cache();

		$crawler = self::request('GET', 'app.php/gallery/image/' . $image_id . '?sid=' . $this->sid);
		self::assert_response_html(200);
		$image_field = $crawler->filter('#details .profile-phpbb_location');
		$comment_field = $crawler->filterXPath('//*[@id=\'comment_' . $comment_id . '\']/following-sibling::div[1]//*[contains(concat(\' \', normalize-space(@class), \' \'), \' profile-phpbb_location \')]');

		$this->assertSame(1, $image_field->count());
		$this->assertStringContainsString($image_author_value, $image_field->text());
		$this->assertStringNotContainsString($comment_author_value, $image_field->text());
		$this->assertSame(1, $comment_field->count());
		$this->assertStringContainsString($comment_author_value, $comment_field->text());
		$this->assertStringNotContainsString($image_author_value, $comment_field->text());

		$this->logout();
		$this->uninstall_ext('phpbbgallery/core');
	}

	/** Confirm phpBB installed and exposes the migrated location custom field. */
	private function assert_viewtopic_profile_field_is_available(): void
	{
		$db = $this->get_db();
		$result = $db->sql_query('SELECT field_id, field_active, field_show_on_vt
			FROM ' . PROFILE_FIELDS_TABLE . '
			WHERE field_ident = ' . chr(39) . 'phpbb_location' . chr(39));
		$field = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		$this->assertIsArray($field);
		$this->assertSame(1, (int) $field['field_active']);
		$this->assertSame(1, (int) $field['field_show_on_vt']);
	}

	/** Store a value in phpBB's migrated location custom-profile field. */
	private function set_profile_location(int $user_id, string $value): void
	{
		$db = $this->get_db();
		$result = $db->sql_query('SELECT COUNT(user_id) AS total
			FROM ' . PROFILE_FIELDS_DATA_TABLE . '
			WHERE user_id = ' . $user_id);
		$exists = (int) $db->sql_fetchfield('total') > 0;
		$db->sql_freeresult($result);
		$data = ['pf_phpbb_location' => $value];

		if ($exists)
		{
			$db->sql_query('UPDATE ' . PROFILE_FIELDS_DATA_TABLE . '
				SET ' . $db->sql_build_array('UPDATE', $data) . '
				WHERE user_id = ' . $user_id);
			return;
		}

		$data['user_id'] = $user_id;
		$db->sql_query('INSERT INTO ' . PROFILE_FIELDS_DATA_TABLE . ' ' . $db->sql_build_array('INSERT', $data));
	}

	/** @return array{0: int, 1: int} */
	private function seed_image_and_comment(int $commenter_id, string $phpbb_root_path): array
	{
		$db = $this->get_db();
		$result = $db->sql_query('SELECT MAX(right_id) AS max_right FROM phpbb_gallery_albums');
		$left_id = (int) $db->sql_fetchfield('max_right') + 1;
		$db->sql_freeresult($result);
		$db->sql_query('INSERT INTO phpbb_gallery_albums ' . $db->sql_build_array('INSERT', [
			'parent_id' => 0,
			'album_parents' => '',
			'left_id' => $left_id,
			'right_id' => $left_id + 1,
			'album_type' => \phpbbgallery\core\block::TYPE_UPLOAD,
			'album_status' => \phpbbgallery\core\block::ALBUM_OPEN,
			'album_name' => 'Functional profile field album',
			'album_user_id' => \phpbbgallery\core\block::PUBLIC_ALBUM,
			'album_images' => 1,
			'album_images_real' => 1,
		]));
		$album_id = (int) $db->sql_nextid();
		$this->grant_admin_album_access($album_id);

		$filename = 'functional-profile-fields.png';
		foreach (['source', 'medium', 'mini'] as $directory)
		{
			$this->write_test_png($phpbb_root_path . 'files/phpbbgallery/core/' . $directory . '/' . $filename);
		}
		$db->sql_query('INSERT INTO phpbb_gallery_images ' . $db->sql_build_array('INSERT', [
			'image_filename' => $filename,
			'image_name' => 'Functional profile fields',
			'image_name_clean' => 'functional profile fields',
			'image_user_id' => 2,
			'image_username' => 'admin',
			'image_username_clean' => 'admin',
			'image_user_ip' => '127.0.0.1',
			'image_time' => time(),
			'image_album_id' => $album_id,
			'image_status' => \phpbbgallery\core\block::STATUS_APPROVED,
			'image_allow_comments' => 1,
			'image_comments' => 1,
			'filesize_upload' => (int) filesize($phpbb_root_path . 'files/phpbbgallery/core/source/' . $filename),
		]));
		$image_id = (int) $db->sql_nextid();

		$result = $db->sql_query('SELECT username, user_colour
			FROM ' . USERS_TABLE . '
			WHERE user_id = ' . $commenter_id);
		$commenter = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
		$this->assertIsArray($commenter);
		$db->sql_query('INSERT INTO phpbb_gallery_comments ' . $db->sql_build_array('INSERT', [
			'comment_image_id' => $image_id,
			'comment_user_id' => $commenter_id,
			'comment_username' => $commenter['username'],
			'comment_user_colour' => $commenter['user_colour'],
			'comment_user_ip' => '127.0.0.1',
			'comment_time' => time(),
			'comment' => 'Functional custom profile field comment',
			'comment_uid' => '',
			'comment_bitfield' => '',
		]));
		$comment_id = (int) $db->sql_nextid();
		$db->sql_query('UPDATE phpbb_gallery_images
			SET image_last_comment = ' . $comment_id . '
			WHERE image_id = ' . $image_id);
		$db->sql_query('UPDATE phpbb_gallery_albums
			SET album_last_image_id = ' . $image_id . '
			WHERE album_id = ' . $album_id);

		return [$image_id, $comment_id];
	}

	private function grant_admin_album_access(int $album_id): void
	{
		$db = $this->get_db();
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
		$db->sql_query('UPDATE phpbb_gallery_users
			SET user_permissions = ' . chr(39) . chr(39) . '
			WHERE user_id = 2');
	}

	private function set_config_value(string $name, string $value): void
	{
		$db = $this->get_db();
		$db->sql_query('UPDATE ' . CONFIG_TABLE . '
			SET ' . $db->sql_build_array('UPDATE', ['config_value' => $value]) . '
			WHERE config_name = ' . chr(39) . $db->sql_escape($name) . chr(39));
	}

	private function write_test_png(string $path): void
	{
		$png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=', true);
		$this->assertNotFalse($png);
		$this->assertNotFalse(file_put_contents($path, $png));
	}
}
