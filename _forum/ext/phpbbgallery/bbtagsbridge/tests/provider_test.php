<?php
// phpcs:disable PSR1.Files.SideEffects.FoundWithSymbols -- The focused database test double is loaded beside this test case.
/**
 * phpBB Gallery image provider tests.
 *
 * @package   phpbbgallery/bbtagsbridge
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbtagsbridge\tests;

use phpbb\controller\helper;
use phpbbgallery\bbtagsbridge\image_tag_manager;
use phpbbgallery\bbtagsbridge\provider\image_provider;
use PHPUnit\Framework\TestCase;
use sitesplat\bbtags\provider\provider_interface;

require_once __DIR__ . '/fake_db.php';

final class provider_test extends TestCase
{
	public function test_gallery_images_implement_the_shared_provider_contract(): void
	{
		$db = new fake_db();
		$db->images = [10 => 3];
		$provider = new image_provider(
			new image_tag_manager($db, 'image_tags', 'images', 'bbtags', 'bbtags_context'),
			new helper()
		);

		$this->assertInstanceOf(provider_interface::class, $provider);
		$this->assertSame('gallery_images', $provider->get_name());
		$this->assertSame('BBTAGS_PROVIDER_GALLERY_IMAGES', $provider->get_language_key());
		$this->assertTrue($provider->validate_subject(3, 10));
		$this->assertFalse($provider->validate_subject(4, 10));
		$this->assertTrue($provider->apply_approved_tag(3, 10, 7));
		$this->assertSame([['image_id' => 10, 'tag_id' => 7]], $db->relations);
		$this->assertSame('/phpbbgallery_core_image/10', $provider->get_item_url(3, 10));
		$this->assertSame('', $provider->get_item_url(3, 0));
	}
}
