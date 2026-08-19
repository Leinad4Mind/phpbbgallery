<?php
/**
 * phpBB Gallery - personal album hierarchy privacy tests.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\album\display;
use PHPUnit\Framework\TestCase;

final class personal_album_hierarchy_test extends TestCase
{
	public function test_hidden_child_never_crosses_into_next_owner_with_similar_username_prefix(): void
	{
		$display = $this->display_with_zebra_states([
			10 => 5,
			11 => 2,
			20 => 5,
			21 => 5,
		]);
		$rows = [
			$this->row(10, 7, 0, 0, 'el'),
			$this->row(11, 7, 10, 3, 'el'),
			$this->row(20, 8, 0, 0, 'en'),
			$this->row(21, 8, 20, 0, 'en'),
		];

		$visible = $this->visible_rows($display, $rows, [10, 11, 20, 21]);
		$mapping = $this->display_parent_mapping($display, $visible);

		$this->assertSame([10, 20, 21], array_column($visible, 'album_id'));
		$this->assertSame([10 => 10, 20 => 20, 21 => 20], $mapping);
		$this->assertArrayNotHasKey(11, $mapping);
	}

	public function test_visible_descendant_of_hidden_root_is_rejected_even_when_direct_acl_allows_it(): void
	{
		$display = $this->display_with_zebra_states([10 => 5, 11 => 5, 20 => 5]);
		$rows = [
			$this->row(10, 7, 0, 0, 'el'),
			$this->row(11, 7, 10, 0, 'el'),
			$this->row(20, 8, 0, 0, 'en'),
		];

		$visible = $this->visible_rows($display, $rows, [11, 20]);

		$this->assertSame([20], array_column($visible, 'album_id'));
		$this->assertSame([20 => 20], $this->display_parent_mapping($display, $visible));
	}

	/** @dataProvider friendship_access_provider */
	public function test_friendship_and_administrator_levels_preserve_expected_visibility(int $viewer_state, int $required_access, bool $expected): void
	{
		$display = $this->display_with_zebra_states([10 => $viewer_state]);
		$visible = $this->visible_rows($display, [$this->row(10, 7, 0, $required_access, 'owner')], [10]);

		$this->assertSame($expected ? [10] : [], array_column($visible, 'album_id'));
	}

	public static function friendship_access_provider(): array
	{
		return [
			'foe' => [1, 2, false],
			'ordinary user' => [2, 2, true],
			'friend' => [3, 3, true],
			'special friend' => [4, 4, true],
			'administrator or moderator' => [5, 4, true],
		];
	}

	public function test_display_parent_state_cannot_cross_owner_boundaries(): void
	{
		$display = $this->display_with_zebra_states([]);
		$owner_states = [];
		$resolver = new \ReflectionMethod(display::class, 'resolve_album_display_parent');
		$first_arguments = [$this->row(10, 7, 0, 0, 'el'), 0, &$owner_states];
		$orphan_arguments = [$this->row(21, 8, 20, 0, 'en'), 0, &$owner_states];

		$this->assertSame(10, $resolver->invokeArgs($display, $first_arguments));
		$this->assertFalse($resolver->invokeArgs($display, $orphan_arguments));
		$this->assertSame(10, $owner_states[7]['card_id']);
		$this->assertSame(0, $owner_states[8]['card_id']);

		$source = (string) file_get_contents(dirname(__DIR__) . '/album/display.php');
		$this->assertStringContainsString('u.username_clean, a.album_user_id, a.left_id', $source);
		$this->assertStringContainsString('$this->db->get_any_char()', $source);
		$this->assertStringNotContainsString('$this->db->any_char', $source);
		$this->assertStringNotContainsString('isset($right_id)', $source);
	}

	private function display_with_zebra_states(array $states): display
	{
		$gallery_auth = $this->createMock(\phpbbgallery\core\auth\auth::class);
		$gallery_auth->method('get_zebra_state')
			->willReturnCallback(static fn (array $zebra, int $owner_id, int $album_id): int => $states[$album_id] ?? 5);
		$display = (new \ReflectionClass(display::class))->newInstanceWithoutConstructor();
		(new \ReflectionProperty(display::class, 'gallery_auth'))->setValue($display, $gallery_auth);

		return $display;
	}

	private function visible_rows(display $display, array $rows, array $listable): array
	{
		return (new \ReflectionMethod(display::class, 'filter_visible_hierarchy_rows'))
			->invoke($display, $rows, $listable, [], 0);
	}

	private function display_parent_mapping(display $display, array $rows): array
	{
		$resolver = new \ReflectionMethod(display::class, 'resolve_album_display_parent');
		$owner_states = [];
		$mapping = [];
		foreach ($rows as $row)
		{
			$arguments = [$row, 0, &$owner_states];
			$parent_id = $resolver->invokeArgs($display, $arguments);
			if ($parent_id !== false)
			{
				$mapping[(int) $row['album_id']] = $parent_id;
			}
		}

		return $mapping;
	}

	private function row(int $album_id, int $owner_id, int $parent_id, int $access, string $username_prefix): array
	{
		return [
			'album_id' => $album_id,
			'album_user_id' => $owner_id,
			'parent_id' => $parent_id,
			'album_auth_access' => $access,
			'album_type' => 1,
			'username_clean' => $username_prefix,
		];
	}
}
