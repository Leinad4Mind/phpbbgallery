<?php
/**
 * Gallery tag search query tests.
 *
 * @package   phpbbgallery/bbtagsbridge
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbtagsbridge\tests;

use phpbbgallery\bbtagsbridge\image_search_query;
use PHPUnit\Framework\TestCase;

final class image_search_query_test extends TestCase
{
	public function test_and_search_requires_every_tag_inside_its_allowed_albums(): void
	{
		$sql = (new image_search_query())->build('gallery_image_tags', [7 => [3, 4], 8 => [4]], 'and');

		$this->assertSame(2, substr_count($sql, 'EXISTS ('));
		$this->assertStringContainsString('tag_match.tag_id = 7', $sql);
		$this->assertStringContainsString('i.image_album_id IN (3, 4)', $sql);
		$this->assertStringContainsString('tag_match.tag_id = 8', $sql);
	}

	public function test_or_search_skips_unavailable_tags_but_fails_when_none_remain(): void
	{
		$query = new image_search_query();
		$sql = $query->build('gallery_image_tags', [7 => [], 8 => [4]], 'or');

		$this->assertSame(1, substr_count($sql, 'EXISTS ('));
		$this->assertStringNotContainsString('tag_match.tag_id = 7', $sql);
		$this->assertStringContainsString('tag_match.tag_id = 8', $sql);
		$this->assertSame('1 = 0', $query->build('gallery_image_tags', [7 => []], 'or'));
		$this->assertSame('1 = 0', $query->build('invalid-table', [7 => [1]], 'and'));
	}
}
