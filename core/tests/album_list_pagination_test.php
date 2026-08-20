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
}
