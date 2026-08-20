<?php
/**
 * phpBB Gallery - album-list pagination tests.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;
use phpbbgallery\core\album\display;
use phpbbgallery\core\block;

class album_list_pagination_test extends TestCase
{
	public function test_category_heading_is_repeated_without_consuming_a_page_slot(): void
	{
		$display = $this->display(2, 2);
		$rows = [
			10 => ['album_id' => 10, 'parent_id' => 0, 'album_type' => block::TYPE_CAT],
			11 => ['album_id' => 11, 'parent_id' => 10, 'album_type' => 1],
			12 => ['album_id' => 12, 'parent_id' => 10, 'album_type' => 1],
			13 => ['album_id' => 13, 'parent_id' => 10, 'album_type' => 1],
			20 => ['album_id' => 20, 'parent_id' => 0, 'album_type' => 1],
		];

		[$selected, $total] = $this->paginate($display, $rows, 0);

		$this->assertSame(4, $total);
		$this->assertSame([10, 13, 20], array_keys($selected));
	}

	public function test_single_album_inside_category_keeps_its_heading_and_counts_as_visible(): void
	{
		$display = $this->display(0, 15);
		$rows = [
			10 => ['album_id' => 10, 'parent_id' => 0, 'album_type' => block::TYPE_CAT],
			11 => ['album_id' => 11, 'parent_id' => 10, 'album_type' => block::TYPE_UPLOAD],
		];

		[$selected, $total] = $this->paginate($display, $rows, 0);

		$this->assertSame(1, $total);
		$this->assertSame([10, 11], array_keys($selected));
	}

	public function test_page_starting_in_second_category_uses_its_own_heading(): void
	{
		$display = $this->display(1, 1);
		$rows = [
			10 => ['album_id' => 10, 'parent_id' => 0, 'album_type' => block::TYPE_CAT],
			11 => ['album_id' => 11, 'parent_id' => 10, 'album_type' => block::TYPE_UPLOAD],
			20 => ['album_id' => 20, 'parent_id' => 0, 'album_type' => block::TYPE_CAT],
			21 => ['album_id' => 21, 'parent_id' => 20, 'album_type' => block::TYPE_UPLOAD],
		];

		[$selected, $total] = $this->paginate($display, $rows, 0);

		$this->assertSame(2, $total);
		$this->assertSame([20, 21], array_keys($selected));
	}

	public function test_descendants_do_not_consume_slots_separately_from_their_displayed_parent(): void
	{
		$display = $this->display(1, 1);
		$rows = [
			1 => ['album_id' => 1, 'parent_id' => 0, 'album_type' => 1, 'attached_descendants' => [2, 3]],
			4 => ['album_id' => 4, 'parent_id' => 0, 'album_type' => 1, 'attached_descendants' => [5]],
		];

		[$selected, $total] = $this->paginate($display, $rows, 0);

		$this->assertSame(2, $total);
		$this->assertSame([4], array_keys($selected));
		$this->assertSame([5], $selected[4]['attached_descendants']);
	}

	public function test_zero_limit_preserves_the_complete_unpaginated_list(): void
	{
		$display = $this->display(0, 0);
		$rows = [
			10 => ['album_id' => 10, 'parent_id' => 0, 'album_type' => block::TYPE_CAT],
			11 => ['album_id' => 11, 'parent_id' => 10, 'album_type' => 1],
		];

		[$selected, $total] = $this->paginate($display, $rows, 0);

		$this->assertSame(1, $total);
		$this->assertSame($rows, $selected);
	}

	public function test_categories_and_root_albums_receive_independent_limits(): void
	{
		$display = $this->display(0, 2);
		$display->configure_category_pagination(['routes' => 'gallery']);
		$rows = [
			10 => ['album_id' => 10, 'parent_id' => 0, 'album_type' => block::TYPE_CAT],
			11 => ['album_id' => 11, 'parent_id' => 10, 'album_type' => block::TYPE_UPLOAD],
			12 => ['album_id' => 12, 'parent_id' => 10, 'album_type' => block::TYPE_UPLOAD],
			13 => ['album_id' => 13, 'parent_id' => 10, 'album_type' => block::TYPE_UPLOAD],
			20 => ['album_id' => 20, 'parent_id' => 0, 'album_type' => block::TYPE_CAT],
			21 => ['album_id' => 21, 'parent_id' => 20, 'album_type' => block::TYPE_UPLOAD],
			22 => ['album_id' => 22, 'parent_id' => 20, 'album_type' => block::TYPE_UPLOAD],
			30 => ['album_id' => 30, 'parent_id' => 0, 'album_type' => block::TYPE_UPLOAD],
			31 => ['album_id' => 31, 'parent_id' => 0, 'album_type' => block::TYPE_UPLOAD],
			32 => ['album_id' => 32, 'parent_id' => 0, 'album_type' => block::TYPE_UPLOAD],
		];

		[$selected, $total] = $this->paginate($display, $rows, 0);

		$this->assertSame(8, $total);
		$this->assertSame(3, $display->album_root_total);
		$this->assertSame([10, 11, 12, 20, 21, 22, 30, 31], array_keys($selected));
		$this->assertSame(31, $display->last_root_album_id);
	}

	public function test_one_category_page_does_not_change_its_siblings_or_root_page(): void
	{
		$display = $this->display(1, 1);
		$display->configure_category_pagination(['routes' => 'gallery']);
		$request = $this->createMock(\phpbb\request\request_interface::class);
		$request->method('variable')->willReturnCallback(
			static fn (string $name, mixed $default): mixed => $name === 'category_page_10' ? 2 : $default
		);
		$request_property = new \ReflectionProperty(display::class, 'request');
		$request_property->setValue($display, $request);
		$rows = [
			10 => ['album_id' => 10, 'parent_id' => 0, 'album_type' => block::TYPE_CAT],
			11 => ['album_id' => 11, 'parent_id' => 10, 'album_type' => block::TYPE_UPLOAD],
			12 => ['album_id' => 12, 'parent_id' => 10, 'album_type' => block::TYPE_UPLOAD],
			20 => ['album_id' => 20, 'parent_id' => 0, 'album_type' => block::TYPE_CAT],
			21 => ['album_id' => 21, 'parent_id' => 20, 'album_type' => block::TYPE_UPLOAD],
			22 => ['album_id' => 22, 'parent_id' => 20, 'album_type' => block::TYPE_UPLOAD],
			30 => ['album_id' => 30, 'parent_id' => 0, 'album_type' => block::TYPE_UPLOAD],
			31 => ['album_id' => 31, 'parent_id' => 0, 'album_type' => block::TYPE_UPLOAD],
		];

		[$selected] = $this->paginate($display, $rows, 0);

		$this->assertSame([10, 12, 20, 21, 31], array_keys($selected));
		$this->assertSame(['category_page_10' => 2], $display->category_page_params());
		$this->assertSame(31, $display->last_root_album_id);
	}

	public function test_last_root_album_is_identified_before_later_categories(): void
	{
		$display = $this->display(0, 10);
		$display->configure_category_pagination(['routes' => 'gallery']);
		$rows = [
			30 => ['album_id' => 30, 'parent_id' => 0, 'album_type' => block::TYPE_UPLOAD],
			10 => ['album_id' => 10, 'parent_id' => 0, 'album_type' => block::TYPE_CAT],
			11 => ['album_id' => 11, 'parent_id' => 10, 'album_type' => block::TYPE_UPLOAD],
			20 => ['album_id' => 20, 'parent_id' => 0, 'album_type' => block::TYPE_CAT],
			21 => ['album_id' => 21, 'parent_id' => 20, 'album_type' => block::TYPE_UPLOAD],
		];

		[$selected, $total] = $this->paginate($display, $rows, 0);

		$this->assertSame(3, $total);
		$this->assertSame([30, 10, 11, 20, 21], array_keys($selected));
		$this->assertSame(30, $display->last_root_album_id);
	}

	public function test_icon_space_is_not_reserved_when_a_group_has_no_icons(): void
	{
		$display = $this->display(0, 10);
		$rows = [
			10 => ['album_id' => 10, 'parent_id' => 0, 'album_type' => block::TYPE_CAT],
			11 => ['album_id' => 11, 'parent_id' => 10, 'album_type' => block::TYPE_UPLOAD, 'album_image' => ''],
			12 => ['album_id' => 12, 'parent_id' => 10, 'album_type' => block::TYPE_UPLOAD],
			20 => ['album_id' => 20, 'parent_id' => 0, 'album_type' => block::TYPE_UPLOAD, 'album_image' => ''],
		];

		$this->assertSame([0 => false, 10 => false], $this->icon_groups($display, $rows, 0));
	}

	public function test_icon_space_is_reserved_only_inside_groups_with_icons(): void
	{
		$display = $this->display(0, 10);
		$rows = [
			10 => ['album_id' => 10, 'parent_id' => 0, 'album_type' => block::TYPE_CAT],
			11 => ['album_id' => 11, 'parent_id' => 10, 'album_type' => block::TYPE_UPLOAD, 'album_image' => ''],
			12 => ['album_id' => 12, 'parent_id' => 10, 'album_type' => block::TYPE_UPLOAD, 'album_image' => 'images/galleryicons/dvd.svg'],
			20 => ['album_id' => 20, 'parent_id' => 0, 'album_type' => block::TYPE_CAT],
			21 => ['album_id' => 21, 'parent_id' => 20, 'album_type' => block::TYPE_UPLOAD, 'album_image' => ''],
			30 => ['album_id' => 30, 'parent_id' => 0, 'album_type' => block::TYPE_UPLOAD, 'album_image' => 'images/galleryicons/root.svg'],
			31 => ['album_id' => 31, 'parent_id' => 0, 'album_type' => block::TYPE_UPLOAD, 'album_image' => ''],
		];

		$this->assertSame([0 => true, 10 => true, 20 => false], $this->icon_groups($display, $rows, 0));
	}

	public function test_album_group_totals_keep_categories_and_root_albums_independent(): void
	{
		$display = $this->display(0, 2);
		$rows = [
			10 => ['album_id' => 10, 'parent_id' => 0, 'album_type' => block::TYPE_CAT],
			11 => ['album_id' => 11, 'parent_id' => 10, 'album_type' => block::TYPE_UPLOAD],
			12 => ['album_id' => 12, 'parent_id' => 10, 'album_type' => block::TYPE_UPLOAD],
			20 => ['album_id' => 20, 'parent_id' => 0, 'album_type' => block::TYPE_CAT],
			21 => ['album_id' => 21, 'parent_id' => 20, 'album_type' => block::TYPE_UPLOAD],
			30 => ['album_id' => 30, 'parent_id' => 0, 'album_type' => block::TYPE_UPLOAD],
		];

		$this->assertSame([0 => 1, 10 => 2, 20 => 1], $this->group_totals($display, $rows, 0));
	}

	private function display(int $start, int $limit): display
	{
		$display = (new \ReflectionClass(display::class))->newInstanceWithoutConstructor();
		$display->album_start = $start;
		$display->album_limit = $limit;

		return $display;
	}

	private function paginate(display $display, array $rows, int $root_album_id): array
	{
		$method = new \ReflectionMethod(display::class, 'paginate_album_rows');
		$method->setAccessible(true);

		return $method->invoke($display, $rows, $root_album_id);
	}

	private function icon_groups(display $display, array $rows, int $root_album_id): array
	{
		$method = new \ReflectionMethod(display::class, 'album_icon_groups');
		$method->setAccessible(true);

		return $method->invoke($display, $rows, $root_album_id);
	}

	private function group_totals(display $display, array $rows, int $root_album_id): array
	{
		$method = new \ReflectionMethod(display::class, 'album_group_totals');
		$method->setAccessible(true);

		return $method->invoke($display, $rows, $root_album_id);
	}
}
