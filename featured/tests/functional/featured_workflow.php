<?php
/**
 * phpBB Gallery Featured Images functional tests.
 *
 * @package   phpbbgallery/featured
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\featured\tests\functional;

require_once dirname(__DIR__, 3) . '/core/tests/functional/addon_workflow_test_case.php';

class featured_workflow extends \phpbbgallery\core\tests\functional\addon_workflow_test_case
{
	protected static function setup_extensions(): array
	{
		return ['phpbbgallery/core', 'phpbbgallery/featured'];
	}

	public function test_moderator_can_feature_render_and_unfeature_an_approved_image(): void
	{
		$this->add_lang_ext('phpbbgallery/featured', 'featured');

		$album_id = $this->insert_album('Featured functional album');
		$this->grant_admin_album_permissions($album_id);
		$image_id = $this->insert_image($album_id, 'functional-featured.png', 'Featured functional image');
		$hidden_id = $this->insert_image($album_id, 'functional-unapproved.png', 'Unapproved featured image', [
			'image_status' => \phpbbgallery\core\block::STATUS_UNAPPROVED,
		]);

		$this->login();
		$this->admin_login();
		$crawler = self::request('GET', 'app.php/gallery/image/' . $image_id . '?sid=' . $this->sid);
		$link = $crawler->filter('a[data-gallery-featured-toggle][href*="/feature"]');
		$this->assertSame(1, $link->count(), $crawler->filter('body')->text());
		self::request('GET', $this->relative_url((string) $link->attr('href')));

		$db = $this->get_db();
		$result = $db->sql_query('SELECT COUNT(image_id) AS total FROM phpbb_gallery_featured WHERE image_id = ' . $image_id);
		$this->assertSame(1, (int) $db->sql_fetchfield('total'));
		$db->sql_freeresult($result);

		// A stale or manually inserted unapproved selection must never be rendered.
		$db->sql_query('INSERT INTO phpbb_gallery_featured ' . $db->sql_build_array('INSERT', [
			'image_id' => $hidden_id,
			'featured_by' => 2,
			'featured_time' => time() + 1,
		]));
		$crawler = self::request('GET', 'app.php/gallery?sid=' . $this->sid);
		$body = $crawler->filter('body')->text();
		$this->assertStringContainsString($this->lang('FEATURED_IMAGES'), $body);
		$this->assertStringContainsString('Featured functional image', $body);
		$this->assertStringNotContainsString('Unapproved featured image', $body);
		$this->assertSame(1, $crawler->filter('[data-gallery-featured]')->count());

		$crawler = self::request('GET', 'app.php/gallery/image/' . $image_id . '?sid=' . $this->sid);
		$link = $crawler->filter('a[data-gallery-featured-toggle][href*="/unfeature"]');
		$this->assertSame(1, $link->count(), $crawler->filter('body')->text());
		self::request('GET', $this->relative_url((string) $link->attr('href')));
		$result = $db->sql_query('SELECT COUNT(image_id) AS total FROM phpbb_gallery_featured WHERE image_id = ' . $image_id);
		$this->assertSame(0, (int) $db->sql_fetchfield('total'));
		$db->sql_freeresult($result);
		$this->logout();
	}
}
