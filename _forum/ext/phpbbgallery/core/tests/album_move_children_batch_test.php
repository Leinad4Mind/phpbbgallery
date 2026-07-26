<?php
/**
 * phpBB Gallery - Core Extension tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\album\album;
use phpbbgallery\core\album\manage;
use PHPUnit\Framework\TestCase;

final class album_move_children_batch_test extends TestCase
{
	public function test_contiguous_album_branches_are_moved_with_one_query_set(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$queries = [];
		$db->expects($this->exactly(5))
			->method('sql_query')
			->willReturnCallback(function (string $sql) use (&$queries): int
			{
				$queries[] = $sql;

				return count($queries);
			});
		$db->method('sql_in_set')
			->willReturnCallback(function (string $field, array $values, bool $negate = false): string
			{
				return $field . ($negate ? ' NOT IN (' : ' IN (') . implode(', ', $values) . ')';
			});

		$gallery_album = $this->createMock(album::class);
		$gallery_album->expects($this->exactly(2))
			->method('get_info')
			->with(20)
			->willReturnOnConsecutiveCalls(
				['album_id' => 20, 'right_id' => 12],
				['album_id' => 20, 'right_id' => 6]
			);

		$manager = $this->manager($db, $gallery_album);
		$move = \Closure::bind(function (): array
		{
			return $this->move_album_nodes(
				[
					['album_id' => 2],
					['album_id' => 3],
					['album_id' => 4],
				],
				20,
				2,
				7
			);
		}, $manager, manage::class);

		$this->assertSame([], $move());
		$this->assertCount(5, $queries);
		$this->assertStringContainsString('right_id = right_id - 6', $queries[0]);
		$this->assertStringContainsString('left_id < 7', $queries[0]);
		$this->assertStringContainsString('left_id > 7', $queries[1]);
		$this->assertStringContainsString('6 BETWEEN left_id AND right_id', $queries[2]);
		$this->assertStringContainsString('album_id NOT IN (2, 3, 4)', $queries[2]);
		$this->assertStringContainsString('left_id = left_id + 4', $queries[4]);
		$this->assertStringContainsString('album_id IN (2, 3, 4)', $queries[4]);
	}

	public function test_album_deletion_moves_children_as_one_interval(): void
	{
		$source = file_get_contents(dirname(__DIR__) . '/album/manage.php');

		$this->assertStringContainsString('->move_album_children($album_id, $subalbums_to_id)', $source);
		$this->assertStringNotContainsString('->move_album($row[\'album_id\'], $subalbums_to_id)', $source);
	}

	public function test_descendant_destination_is_rejected_before_tree_changes(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->never())->method('sql_query');
		$gallery_album = $this->createMock(album::class);
		$gallery_album->expects($this->once())
			->method('get_info')
			->with(3)
			->willReturn(['album_id' => 3, 'right_id' => 6]);
		$language = $this->createMock(\phpbb\language\language::class);
		$language->expects($this->once())
			->method('lang')
			->with('ALBUM_PARENT_INVALID')
			->willReturn('invalid');

		$manager = $this->manager($db, $gallery_album, $language);
		$move = \Closure::bind(function (): array
		{
			return $this->move_album_nodes(
				[
					['album_id' => 2],
					['album_id' => 3],
					['album_id' => 4],
				],
				3,
				2,
				7
			);
		}, $manager, manage::class);

		$this->assertSame(['invalid'], $move());
	}

	private function manager(
		\phpbb\db\driver\driver_interface $db,
		album $gallery_album,
		?\phpbb\language\language $language = null
	): manage
	{
		$reflection = new \ReflectionClass(manage::class);
		$manager = $reflection->newInstanceWithoutConstructor();
		$initialize = \Closure::bind(function ($database, $album_service, $language_service): void
		{
			$this->db = $database;
			$this->gallery_album = $album_service;
			if ($language_service)
			{
				$this->language = $language_service;
			}
			$this->albums_table = 'gallery_albums';
			$this->user_id = 0;
		}, $manager, manage::class);
		$initialize($db, $gallery_album, $language);

		return $manager;
	}
}
