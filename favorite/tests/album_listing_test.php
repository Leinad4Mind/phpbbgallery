<?php
/**
 * phpBB Gallery - Album listing favorite tests
 *
 * @package   phpbbgallery/favorite
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\favorite\tests;

use PHPUnit\Framework\TestCase;

final class album_listing_test extends TestCase
{
	public function test_listener_enriches_album_images_in_bulk_and_only_when_authorized(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/event/favorite_listener.php');
		$method = strstr($source, 'public function album_image_template_vars(');
		$method = strstr($method, '/**', true);

		$this->assertStringContainsString(
			"'phpbbgallery.core.album.image_template_vars'",
			$source
		);
		$this->assertStringContainsString('$user_id === ANONYMOUS', $method);
		$this->assertStringContainsString("acl_check('i_favorite'", $method);
		$this->assertSame(1, substr_count($method, 'get_favorited_ids('));
		$this->assertStringNotContainsString('is_favorited(', $method);
		$this->assertStringContainsString(
			'$event[' . "'image_template_vars'] = " . '$image_template_vars',
			$method
		);
	}

	public function test_album_heart_is_ajax_capable_with_a_normal_link_fallback(): void
	{
		$root = dirname(__DIR__);
		$template = (string) file_get_contents(
			$root . '/styles/all/template/event/phpbbgallery_core_album_image_actions.html'
		);
		$stylesheet = (string) file_get_contents($root . '/styles/all/theme/favorite.css');
		$head = (string) file_get_contents(
			$root . '/styles/all/template/event/overall_header_head_append.html'
		);

		$this->assertStringContainsString('{% if image.U_FAVORITE_IMAGE %}', $template);
		$this->assertStringContainsString('href="{{ image.U_FAVORITE_IMAGE }}"', $template);
		$this->assertStringContainsString('data-gallery-favorite-ajax', $template);
		$this->assertStringContainsString('data-ajax="false"', $template);
		$this->assertStringContainsString('data-favorited="', $template);
		$this->assertStringContainsString('data-toggle-url="{{ image.U_FAVORITE_IMAGE_TOGGLE }}"', $template);
		$this->assertStringContainsString('class="gallery-favorite-icon icon', $template);
		$this->assertStringContainsString('.gallery-favorite-icon.fa-heart', $stylesheet);
		$this->assertStringContainsString("INCLUDECSS '@phpbbgallery_favorite/favorite.css'", $head);
		$this->assertStringContainsString("INCLUDEJS '@phpbbgallery_favorite/favorite.js'", $head);
	}
}
