<?php
// phpcs:ignoreFile PSR1.Files.SideEffects.FoundWithSymbols -- Functional fixture loads the shared test base.
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
		$second_id = $this->insert_image($album_id, 'functional-featured-second.png', 'Second featured image');
		$hidden_id = $this->insert_image($album_id, 'functional-unapproved.png', 'Unapproved featured image', [
			'image_status' => \phpbbgallery\core\block::STATUS_UNAPPROVED,
		]);

		$this->login();
		$this->admin_login();
		$this->toggle_from_image_page($image_id, 'feature');
		$this->toggle_from_image_page($second_id, 'feature');

		$db = $this->get_db();
		$result = $db->sql_query('SELECT COUNT(image_id) AS total FROM phpbb_gallery_featured');
		$this->assertSame(2, (int) $db->sql_fetchfield('total'));
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
		$this->assertStringContainsString('Second featured image', $body);
		$this->assertStringNotContainsString('Unapproved featured image', $body);
		$this->assertSame(1, $crawler->filter('[data-gallery-featured]')->count());
		$this->assertSame('0', $crawler->filter('[data-gallery-featured]')->attr('data-autoplay'));
		$this->assertSame('6000', $crawler->filter('[data-gallery-featured]')->attr('data-interval'));
		$this->assertSame(1, $crawler->filter('[data-gallery-featured-track]')->count());
		$this->assertSame(2, $crawler->filter('[data-gallery-featured-slide]')->count());
		$this->assertSame(0, $crawler->filter('[data-gallery-featured-slide][hidden]')->count());
		$this->assertSame(2, $crawler->filter('[data-gallery-featured-go]')->count());
		$this->assertSame(1, $crawler->filter('[data-gallery-featured-previous]')->count());
		$this->assertSame(1, $crawler->filter('[data-gallery-featured-next]')->count());
		$this->assertSame(1, $crawler->filter('[data-gallery-featured-play]')->count());

		// Switching presentation mode retains the curated, permission-filtered images.
		$this->set_config('phpbb_gallery_featured_slideshow', '0');
		$crawler = self::request('GET', 'app.php/gallery?sid=' . $this->sid);
		$body = $crawler->filter('body')->text();
		$this->assertSame(0, $crawler->filter('[data-gallery-featured]')->count());
		$this->assertStringContainsString('Featured functional image', $body);
		$this->assertStringContainsString('Second featured image', $body);
		$this->assertStringNotContainsString('Unapproved featured image', $body);
		$this->set_config('phpbb_gallery_featured_slideshow', '1');

		// Curated images must not bypass album permissions for an anonymous visitor.
		$this->logout();
		$crawler = self::request('GET', 'app.php/gallery');
		$body = $crawler->filter('body')->text();
		$this->assertSame(0, $crawler->filter('[data-gallery-featured]')->count());
		$this->assertStringNotContainsString('Featured functional image', $body);
		$this->assertStringNotContainsString('Second featured image', $body);

		$this->login();
		$this->admin_login();
		$this->toggle_from_image_page($image_id, 'unfeature');
		$this->toggle_from_image_page($second_id, 'unfeature');

		$result = $db->sql_query('SELECT COUNT(image_id) AS total FROM phpbb_gallery_featured WHERE image_id IN (' . $image_id . ', ' . $second_id . ')');
		$this->assertSame(0, (int) $db->sql_fetchfield('total'));
		$db->sql_freeresult($result);
		$this->logout();
	}

	private function toggle_from_image_page(int $image_id, string $mode): void
	{
		$crawler = self::request('GET', 'app.php/gallery/image/' . $image_id . '?sid=' . $this->sid);
		$link = $crawler->filter('a[data-gallery-featured-toggle][href*="/' . $mode . '"]');
		$this->assertSame(1, $link->count(), $crawler->filter('body')->text());
		self::request('GET', $this->relative_url((string) $link->attr('href')));
	}

	private function set_config(string $name, string $value): void
	{
		$db = $this->get_db();
		$db->sql_query('UPDATE ' . CONFIG_TABLE . '
			SET config_value = ' . chr(39) . $db->sql_escape($value) . chr(39) . '
			WHERE config_name = ' . chr(39) . $db->sql_escape($name) . chr(39));
		$this->purge_cache();
	}
}
