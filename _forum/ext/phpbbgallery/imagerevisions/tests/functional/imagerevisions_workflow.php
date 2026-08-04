<?php
/**
 * phpBB Gallery - Image Revisions functional tests.
 *
 * @package   phpbbgallery/imagerevisions
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\imagerevisions\tests\functional;

/**
 * Exercise per-album revision policy editing against an installed phpBB board.
 *
 * @group functional
 */
class imagerevisions_workflow extends \phpbb_functional_test_case
{
	protected static function setup_extensions(): array
	{
		return ['phpbbgallery/core', 'phpbbgallery/imagerevisions'];
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

	public function test_per_album_revision_settings_inherit_and_override(): void
	{
		$this->add_lang_ext('phpbbgallery/core', 'gallery_acp');
		$this->add_lang_ext('phpbbgallery/imagerevisions', 'info_acp_imagerevisions');
		$this->login();
		$this->admin_login();

		$root_id = $this->create_album(0, 'Revision policy root', 1, 8);
		$child_id = $this->create_album($root_id, 'Revision policy child', -1, -1);
		$this->assert_rule($root_id, 1, 8);
		$this->assertSame(0, $this->rule_count($child_id));

		$crawler = $this->album_form($child_id, $root_id, 'edit');
		$this->assertStringContainsString('8', $crawler->filter('body')->text());
		$form = $crawler->selectButton($this->lang('SUBMIT'))->form();
		$crawler = self::submit($form, [
			'imagerevisions_enabled' => 0,
			'imagerevisions_limit' => -1,
		]);
		$this->assertStringContainsString($this->lang('ALBUM_UPDATED'), $crawler->filter('body')->text());
		$this->assert_rule($child_id, 0, -1);

		$module_id = $this->module_id('acp', '\phpbbgallery\imagerevisions\acp\main_module', 'settings');
		$crawler = self::request('GET', 'adm/index.php?i=' . $module_id . '&mode=settings&sid=' . $this->sid);
		$body = $crawler->filter('body')->text();
		$this->assertStringContainsString('Revision policy root', $body);
		$this->assertStringContainsString('Revision policy child', $body);
		$this->assertSame(0, $crawler->filter('input[name^="album_rules["]')->count());
		$this->assertSame(1, $crawler->filter('a[href*="a=' . $child_id . '"][href*="action=edit"]')->count());

		$this->logout();
		$this->disable_ext('phpbbgallery/imagerevisions');
		$db = $this->get_db();
		$db->sql_query('DELETE FROM ' . $this->table('gallery_albums') . ' WHERE '
			. $db->sql_in_set('album_id', [$root_id, $child_id]));
		$this->assertSame(1, $this->rule_count($root_id));
		$this->assertSame(1, $this->rule_count($child_id));
		$this->install_ext('phpbbgallery/imagerevisions');
		$this->assertSame(0, $this->rule_count($root_id));
		$this->assertSame(0, $this->rule_count($child_id));
	}

	private function create_album(int $parent_id, string $name, int $enabled, int $limit): int
	{
		$crawler = $this->album_form(0, $parent_id, 'add');
		$this->assertSame(1, $crawler->filter('select[name="imagerevisions_enabled"]')->count());
		$this->assertSame(1, $crawler->filter('input[name="imagerevisions_limit"]')->count());
		$form = $crawler->selectButton($this->lang('SUBMIT'))->form();
		$crawler = self::submit($form, [
			'album_type' => \phpbbgallery\core\block::TYPE_UPLOAD,
			'album_name' => $name,
			'parent_id' => $parent_id,
			'album_status' => \phpbbgallery\core\block::ALBUM_OPEN,
			'album_watermark' => 0,
			'display_in_rrc' => 1,
			'display_subalbum_list' => 1,
			'display_on_index' => 1,
			'imagerevisions_enabled' => $enabled,
			'imagerevisions_limit' => $limit,
		]);
		$this->assertStringContainsString($this->lang('ALBUM_CREATED'), $crawler->filter('body')->text());

		$db = $this->get_db();
		$result = $db->sql_query('SELECT album_id FROM ' . $this->table('gallery_albums')
			. " WHERE album_name = '" . $db->sql_escape($name) . "'");
		$album_id = (int) $db->sql_fetchfield('album_id');
		$db->sql_freeresult($result);
		$this->assertGreaterThan(0, $album_id);

		return $album_id;
	}

	private function album_form(int $album_id, int $parent_id, string $action)
	{
		$module_id = $this->module_id('acp', '\phpbbgallery\core\acp\albums_module', 'manage');
		return self::request('GET', 'adm/index.php?i=' . $module_id . '&mode=manage&parent_id=' . $parent_id
			. '&action=' . $action . '&a=' . $album_id . '&sid=' . $this->sid);
	}

	private function assert_rule(int $album_id, int $enabled, int $limit): void
	{
		$db = $this->get_db();
		$result = $db->sql_query('SELECT enabled, revision_limit FROM '
			. $this->table('gallery_imagerevisions_album_rules') . ' WHERE album_id = ' . $album_id);
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
		$this->assertSame(['enabled' => $enabled, 'revision_limit' => $limit], $row);
	}

	private function rule_count(int $album_id): int
	{
		$db = $this->get_db();
		$result = $db->sql_query('SELECT COUNT(album_id) AS total FROM '
			. $this->table('gallery_imagerevisions_album_rules') . ' WHERE album_id = ' . $album_id);
		$count = (int) $db->sql_fetchfield('total');
		$db->sql_freeresult($result);
		return $count;
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

	private function table(string $suffix): string
	{
		return self::$config['table_prefix'] . $suffix;
	}
}
