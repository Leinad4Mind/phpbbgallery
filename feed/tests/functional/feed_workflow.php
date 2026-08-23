<?php
/**
 * phpBB Gallery Feed functional tests.
 *
 * @package   phpbbgallery/feed
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\feed\tests\functional;

require_once dirname(__DIR__, 3) . '/core/tests/functional/addon_workflow_test_case.php';

class feed_workflow extends \phpbbgallery\core\tests\functional\addon_workflow_test_case
{
	protected static function setup_extensions(): array
	{
		return ['phpbbgallery/core', 'phpbbgallery/feed'];
	}

	public function test_atom_feed_respects_album_publication_setting(): void
	{
		$album_id = $this->insert_album('Feed functional album', true);
		$this->grant_admin_album_permissions($album_id);
		$this->insert_image($album_id, 'functional-feed.png', 'Feed functional image', [
			'image_desc' => 'Visible feed description',
		]);

		$db = $this->get_db();
		$db->sql_query("UPDATE phpbb_config SET config_value = '1' WHERE config_name = 'phpbb_gallery_feed_enable'");
		$db->sql_query("UPDATE phpbb_config SET config_value = '10' WHERE config_name = 'phpbb_gallery_feed_limit'");
		$this->purge_cache();

		$this->login();
		$this->admin_login();
		self::request('GET', 'app.php/gallery/feed?sid=' . $this->sid, [], false);
		self::assert_response_status_code(200);
		$response = self::$client->getResponse();
		$this->assertStringStartsWith('application/atom+xml', (string) $response->getHeader('Content-Type'));
		$this->assertStringContainsString('<title>Feed functional image</title>', $response->getContent());
		$this->assertStringContainsString('Visible feed description', $response->getContent());

		self::request('GET', 'app.php/gallery/feed/album/' . $album_id . '?sid=' . $this->sid, [], false);
		self::assert_response_status_code(200);
		$this->assertStringContainsString('<title>Feed functional album</title>', self::$client->getResponse()->getContent());

		$db->sql_query('UPDATE phpbb_gallery_albums SET album_feed = 0 WHERE album_id = ' . $album_id);
		self::request('GET', 'app.php/gallery/feed/album/' . $album_id . '?sid=' . $this->sid, [], false);
		self::assert_response_status_code(403);
		$this->logout();
	}
}
