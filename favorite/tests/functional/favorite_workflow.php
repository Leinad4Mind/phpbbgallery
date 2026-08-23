<?php
/**
 * phpBB Gallery Favorite functional tests.
 *
 * @package   phpbbgallery/favorite
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\favorite\tests\functional;

require_once dirname(__DIR__, 3) . '/core/tests/functional/addon_workflow_test_case.php';

class favorite_workflow extends \phpbbgallery\core\tests\functional\addon_workflow_test_case
{
	protected static function setup_extensions(): array
	{
		return ['phpbbgallery/core', 'phpbbgallery/favorite'];
	}

	public function test_image_can_be_favorited_listed_and_removed(): void
	{
		$this->add_lang_ext('phpbbgallery/favorite', 'info_ucp_gallery_favorite');

		$album_id = $this->insert_album('Favorite functional album');
		$this->grant_admin_album_permissions($album_id, true);
		$image_id = $this->insert_image($album_id, 'functional-favorite.png', 'Favorite functional image');

		$this->login();
		$this->admin_login();
		$crawler = self::request('GET', 'app.php/gallery/image/' . $image_id . '?sid=' . $this->sid);
		$link = $crawler->filter('a[data-gallery-favorite-ajax][href*="/favorite"]');
		$this->assertSame(1, $link->count(), $crawler->filter('body')->text());
		self::request('GET', $this->relative_url((string) $link->attr('href')));

		$db = $this->get_db();
		$result = $db->sql_query("SELECT COUNT(favorite_id) AS total FROM phpbb_gallery_favorites WHERE user_id = 2 AND image_id = $image_id");
		$this->assertSame(1, (int) $db->sql_fetchfield('total'));
		$db->sql_freeresult($result);

		$module = $this->module_id('ucp', '\\phpbbgallery\\favorite\\ucp\\main_module', 'manage_favorites');
		$url = 'ucp.php?i=' . $module . '&mode=manage_favorites&sid=' . $this->sid;
		$crawler = self::request('GET', $url);
		$this->assertStringContainsString('Favorite functional image', $crawler->filter('body')->text());
		$form = $crawler->filter('form#ucp_gallery')->form();
		$crawler = self::submit($form, [
			'action' => 'remove_favorite',
			'image_id_ary' => [$image_id],
		]);
		$this->assertStringContainsString($this->lang('UNFAVORITED_IMAGES'), $crawler->filter('body')->text());
		$result = $db->sql_query("SELECT COUNT(favorite_id) AS total FROM phpbb_gallery_favorites WHERE user_id = 2 AND image_id = $image_id");
		$this->assertSame(0, (int) $db->sql_fetchfield('total'));
		$db->sql_freeresult($result);
		$this->logout();
	}
}
