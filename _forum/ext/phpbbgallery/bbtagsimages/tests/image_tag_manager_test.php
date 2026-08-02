<?php
// phpcs:disable PSR1.Files.SideEffects.FoundWithSymbols -- The focused database test double is loaded beside this test case.
/**
 * phpBB Gallery BBTags Images relation tests.
 *
 * @package   phpbbgallery/bbtagsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbtagsimages\tests;

use phpbbgallery\bbtagsimages\image_tag_manager;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/fake_db.php';

final class image_tag_manager_test extends TestCase
{
	public function test_relations_are_idempotent_counted_and_removed_without_deleting_catalogue_tags(): void
	{
		$db = new fake_db();
		$db->images = [10 => 3, 11 => 3];
		$db->catalogue = [7 => 'anime', 8 => 'manga'];
		$manager = new image_tag_manager($db, 'image_tags', 'images', 'bbtags', 'bbtags_context');

		$this->assertTrue($manager->image_matches_album(10, 3));
		$this->assertFalse($manager->image_matches_album(10, 4));
		$this->assertTrue($manager->attach_tag(10, 7));
		$this->assertTrue($manager->attach_tag(10, 7));
		$this->assertCount(1, $db->relations);
		$this->assertSame(1, $db->usage[7]);

		$this->assertTrue($manager->attach_tag(11, 7));
		$this->assertSame(2, $db->usage[7]);
		$this->assertSame([7], $manager->get_tag_ids_for_image(10));
		$this->assertSame('anime', $manager->get_tags_for_image(10)[0]['tag']);
		$this->assertTrue($manager->replace_tags(10, [8, 8]));
		$this->assertSame([8], $manager->get_tag_ids_for_image(10));
		$this->assertSame(1, $db->usage[7]);
		$this->assertSame(1, $db->usage[8]);

		$this->assertTrue($manager->delete_for_images([10, 10, 0]));
		$this->assertSame(0, $db->usage[8]);
		$this->assertTrue($manager->delete_for_images([11]));
		$this->assertSame(0, $db->usage[7]);
		$this->assertSame([], $db->relations);
		$this->assertSame(['begin', 'commit', 'begin', 'commit', 'begin', 'commit'], $db->transactions);
	}

	public function test_invalid_identifiers_fail_closed(): void
	{
		$manager = new image_tag_manager(new fake_db(), 'image_tags', 'images', 'bbtags', 'bbtags_context');

		$this->assertFalse($manager->image_matches_album(0, 1));
		$this->assertFalse($manager->attach_tag(1, 0));
		$this->assertSame([], $manager->get_tag_ids_for_image(0));
		$this->assertFalse($manager->replace_tags(0, [1]));
		$this->assertTrue($manager->delete_for_images([0, -1]));
	}

	public function test_image_deleted_while_attaching_a_tag_leaves_no_relation(): void
	{
		$db = new fake_db();
		$db->images = [10 => 3];
		$db->delete_image_on_relation_insert = true;
		$manager = new image_tag_manager($db, 'image_tags', 'images', 'bbtags', 'bbtags_context');

		$this->assertFalse($manager->attach_tag(10, 7));
		$this->assertSame([], $db->relations);
		$this->assertSame(0, $db->usage[7]);
	}

	public function test_image_deleted_while_replacing_tags_leaves_no_relation(): void
	{
		$db = new fake_db();
		$db->images = [10 => 3];
		$db->catalogue = [7 => 'anime'];
		$db->delete_image_on_relation_insert = true;
		$manager = new image_tag_manager($db, 'image_tags', 'images', 'bbtags', 'bbtags_context');

		$this->assertFalse($manager->replace_tags(10, [7]));
		$this->assertSame([], $db->relations);
		$this->assertSame(0, $db->usage[7]);
		$this->assertSame(['begin', 'commit'], $db->transactions);
	}

	public function test_facets_preserve_album_boundaries_from_the_core_search(): void
	{
		$db = new fake_db();
		$db->facet_rows = [
			['tag_id' => 7, 'tag' => 'anime', 'tag_clean' => 'anime', 'image_album_id' => 3, 'image_count' => 4],
			['tag_id' => 7, 'tag' => 'anime', 'tag_clean' => 'anime', 'image_album_id' => 4, 'image_count' => 2],
		];
		$manager = new image_tag_manager($db, 'image_tags', 'images', 'bbtags', 'bbtags_context');

		$this->assertSame([], $manager->get_facet_rows(''));
		$this->assertSame(
			[
				['tag_id' => 7, 'tag' => 'anime', 'tag_clean' => 'anime', 'album_id' => 3, 'image_count' => 4],
				['tag_id' => 7, 'tag' => 'anime', 'tag_clean' => 'anime', 'album_id' => 4, 'image_count' => 2],
			],
			$manager->get_facet_rows('i.image_status = 1')
		);
	}

	public function test_reactivation_removes_relations_for_missing_images_and_resyncs_usage(): void
	{
		$db = new fake_db();
		$db->relations = [
			['image_id' => 10, 'tag_id' => 7],
			['image_id' => 99, 'tag_id' => 7],
		];
		$db->images = [10 => 3];
		$db->usage = [7 => 2];
		$manager = new image_tag_manager($db, 'image_tags', 'images', 'bbtags', 'bbtags_context');

		$this->assertSame(1, $manager->reconcile_orphans());
		$this->assertSame([['image_id' => 10, 'tag_id' => 7]], $db->relations);
		$this->assertSame(1, $db->usage[7]);
	}
}
