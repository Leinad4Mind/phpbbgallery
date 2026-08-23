<?php
/**
 * phpBB Gallery ACP Import functional tests.
 *
 * @package   phpbbgallery/acpimport
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\acpimport\tests\functional;

require_once dirname(__DIR__, 3) . '/core/tests/functional/addon_workflow_test_case.php';

class acpimport_workflow extends \phpbbgallery\core\tests\functional\addon_workflow_test_case
{
	protected static function setup_extensions(): array
	{
		return ['phpbbgallery/core', 'phpbbgallery/acpimport'];
	}

	public function test_png_is_imported_through_the_acp_batch_flow(): void
	{
		global $phpbb_root_path;

		$this->add_lang_ext('phpbbgallery/acpimport', 'info_acp_gallery_import');
		$album_id = $this->insert_album('Import functional album');
		$this->grant_admin_album_permissions($album_id);
		$filename = 'functional-import.png';
		$import_path = $phpbb_root_path . 'files/phpbbgallery/import/' . $filename;
		$this->write_png($import_path);

		$this->login();
		$this->admin_login();
		$module = $this->module_id('acp', '\\phpbbgallery\\acpimport\\acp\\main_module', 'import_images');
		$crawler = self::request('GET', $this->acp_url($module, 'import_images'));
		$this->assertSame(1, $crawler->filter('option[value="' . $filename . '"]')->count(), $crawler->filter('body')->text());
		$form = $crawler->selectButton('submit')->form();
		$crawler = self::submit($form, [
			'album_id' => $album_id,
			'images' => [$filename],
			'username' => 'admin',
			'filename' => 'filename',
		]);
		for ($step = 0; $step < 20; $step++)
		{
			$meta = $crawler->filter('meta[http-equiv="refresh"]');
			if (!$meta->count())
			{
				break;
			}
			preg_match('/url=(.+)$/i', (string) $meta->attr('content'), $matches);
			$this->assertArrayHasKey(1, $matches);
			$crawler = self::request('GET', $this->relative_url($matches[1]));
		}

		$db = $this->get_db();
		$result = $db->sql_query("SELECT image_id, image_filename, image_status FROM phpbb_gallery_images WHERE image_album_id = $album_id AND image_name = 'functional-import'");
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
		$this->assertIsArray($row, $crawler->filter('body')->text());
		$this->assertSame(\phpbbgallery\core\block::STATUS_APPROVED, (int) $row['image_status']);
		$this->assertFileDoesNotExist($import_path);
		$this->assertFileExists($phpbb_root_path . 'files/phpbbgallery/core/source/' . $row['image_filename']);
		$this->logout();
	}
}
