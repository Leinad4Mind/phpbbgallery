<?php
/**
 * Shared phpBB Gallery add-on functional-test helpers.
 *
 * @package   phpbbgallery/core
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests\functional;

abstract class addon_workflow_test_case extends \phpbb_functional_test_case
{
	public function install_ext($extension): void
	{
		$this->add_lang('acp/extensions');
		$this->login();
		$this->admin_login();

		$ext_path = str_replace('/', '%2F', $extension);
		$crawler = self::request('GET', 'adm/index.php?i=acp_extensions&mode=main&action=enable_pre&ext_name=' . $ext_path . '&sid=' . $this->sid);
		$this->assertGreaterThan(1, $crawler->filter('div.main fieldset.submit-buttons input')->count());
		$crawler = self::submit($crawler->selectButton($this->lang('EXTENSION_ENABLE'))->form());
		for ($step = 0; $step < 20; $step++)
		{
			$meta = $crawler->filter('meta[http-equiv="refresh"]');
			if (!$meta->count())
			{
				break;
			}
			preg_match('#url=.+/(adm.+)#', (string) $meta->attr('content'), $matches);
			$this->assertArrayHasKey(1, $matches);
			$crawler = self::request('POST', html_entity_decode($matches[1], ENT_QUOTES, 'UTF-8'));
		}

		$this->assertNotSame('', trim($crawler->filter('div.successbox')->text()));
		$this->logout();
	}

	protected function module_id(string $class, string $basename, string $mode): int
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

	protected function acp_url(int $module_id, string $mode): string
	{
		return 'adm/index.php?i=' . $module_id . '&mode=' . $mode . '&sid=' . $this->sid;
	}

	protected function insert_album(string $name, bool $feed = false): int
	{
		$db = $this->get_db();
		$db->sql_query('INSERT INTO phpbb_gallery_albums ' . $db->sql_build_array('INSERT', [
			'parent_id' => 0,
			'album_parents' => '',
			'album_desc' => '',
			'left_id' => 1,
			'right_id' => 2,
			'album_type' => \phpbbgallery\core\block::TYPE_UPLOAD,
			'album_status' => \phpbbgallery\core\block::ALBUM_OPEN,
			'album_name' => $name,
			'album_user_id' => \phpbbgallery\core\block::PUBLIC_ALBUM,
			'display_on_index' => 1,
			'album_feed' => $feed ? 1 : 0,
		]));

		return (int) $db->sql_nextid();
	}

	protected function grant_admin_album_permissions(int $album_id, bool $favorite = false): void
	{
		$db = $this->get_db();
		$role = array_fill_keys([
			'a_list', 'i_view', 'i_download', 'i_download_free', 'i_statistics',
			'i_watermark', 'i_upload', 'i_edit', 'i_delete', 'i_rate', 'i_approve',
			'i_lock', 'i_report', 'i_unlimited', 'c_read', 'c_post', 'c_edit',
			'c_delete', 'm_comments', 'm_delete', 'm_edit', 'm_move', 'm_report',
			'm_status', 'i_move', 'a_unlimited',
		], 1);
		if ($favorite)
		{
			$role['i_favorite'] = 1;
		}
		$role['i_count'] = 100;
		$role['a_count'] = 100;
		$role['a_restrict'] = 0;
		$db->sql_query('INSERT INTO phpbb_gallery_roles ' . $db->sql_build_array('INSERT', $role));
		$db->sql_query('INSERT INTO phpbb_gallery_permissions ' . $db->sql_build_array('INSERT', [
			'perm_role_id' => (int) $db->sql_nextid(),
			'perm_album_id' => $album_id,
			'perm_user_id' => 2,
			'perm_group_id' => 0,
			'perm_system' => 0,
		]));
		$db->sql_query("UPDATE phpbb_gallery_users SET user_permissions = '' WHERE user_id IN (1, 2)");
		$this->purge_cache();
	}

	protected function insert_image(int $album_id, string $filename, string $name = 'Functional image', array $extra = []): int
	{
		$db = $this->get_db();
		$row = array_merge([
			'image_filename' => $filename,
			'image_name' => $name,
			'image_name_clean' => utf8_clean_string($name),
			'image_desc' => '',
			'image_user_id' => 2,
			'image_username' => 'admin',
			'image_username_clean' => 'admin',
			'image_time' => time(),
			'image_album_id' => $album_id,
			'image_status' => \phpbbgallery\core\block::STATUS_APPROVED,
			'filesize_upload' => 68,
		], $extra);
		$db->sql_query('INSERT INTO phpbb_gallery_images ' . $db->sql_build_array('INSERT', $row));

		return (int) $db->sql_nextid();
	}

	protected function write_png(string $path): void
	{
		$contents = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=', true);
		$this->assertNotFalse($contents);
		$this->assertNotFalse(file_put_contents($path, $contents));
	}

	protected function relative_url(string $url): string
	{
		return (string) preg_replace('#^https?://[^/]+/#', '', html_entity_decode($url, ENT_QUOTES, 'UTF-8'));
	}
}
