<?php
/**
 * phpBB Gallery EXIF functional tests.
 *
 * @package   phpbbgallery/exif
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\exif\tests\functional;

require_once dirname(__DIR__, 3) . '/core/tests/functional/addon_workflow_test_case.php';

class exif_workflow extends \phpbbgallery\core\tests\functional\addon_workflow_test_case
{
	protected static function setup_extensions(): array
	{
		return ['phpbbgallery/core', 'phpbbgallery/exif'];
	}

	public function test_cached_exif_is_visible_to_an_administrator(): void
	{
		$album_id = $this->insert_album('EXIF functional album');
		$this->grant_admin_album_permissions($album_id);
		$data = json_encode([
			'IFD0' => ['Model' => 'functional camera'],
			'EXIF' => [
				'DateTimeOriginal' => '2026:08:23 12:34:56',
				'ISOSpeedRatings' => 400,
			],
		], JSON_THROW_ON_ERROR);
		$image_id = $this->insert_image($album_id, 'functional-exif.jpg', 'EXIF functional image', [
			'image_has_exif' => \phpbbgallery\exif\exif::DBSAVED,
			'image_exif_data' => $data,
		]);

		$db = $this->get_db();
		$db->sql_query("UPDATE phpbb_gallery_users SET user_viewexif = 1, user_permissions = '' WHERE user_id = 2");
		foreach (['disp_exifdata', 'exif_show_date', 'exif_show_iso', 'exif_show_cam_model'] as $name)
		{
			$db->sql_query("UPDATE phpbb_config SET config_value = '1' WHERE config_name = 'phpbb_gallery_$name'");
		}
		$this->purge_cache();

		$this->login();
		$this->admin_login();
		$crawler = self::request('GET', 'app.php/gallery/image/' . $image_id . '?sid=' . $this->sid);
		$body = $crawler->filter('body')->text();
		$this->assertStringContainsString('EXIF functional image', $body);
		$this->assertStringContainsString('Functional Camera', $body);
		$this->assertStringContainsString('400', $body);
		$this->logout();
	}
}
