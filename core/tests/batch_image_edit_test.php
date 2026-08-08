<?php
// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- Focused image-service test double.
/**
 * phpBB Gallery - Batch image editing tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\cache;
use phpbbgallery\core\image\image;
use phpbbgallery\core\log;
use PHPUnit\Framework\TestCase;

final class batch_image_edit_test extends TestCase
{
	public function test_batch_author_change_updates_identity_counters_logs_and_cache(): void
	{
		$queries = [];
		[$db, $database_state] = $this->database([
			['image_id' => 5, 'image_album_id' => 2, 'image_name' => 'First'],
			['image_id' => 7, 'image_album_id' => 2, 'image_name' => 'Second'],
		], $queries);
		$log = $this->createMock(log::class);
		$log->expects($this->exactly(2))->method('add_log')->with('moderator', 'edit', 2, $this->anything(), $this->anything());
		$cache = $this->createMock(cache::class);
		$cache->expects($this->once())->method('destroy_images');
		$dispatcher = $this->createMock(\phpbb\event\dispatcher_interface::class);
		$dispatcher->expects($this->once())
			->method('trigger_event')
			->with('phpbbgallery.core.image.change_author_after', $this->callback(
				static fn (array $data): bool => $data['image_ids'] === [5, 7]
					&& (int) $data['author']['user_id'] === 42
			))
			->willReturnArgument(1);
		$image = $this->image_service($db, $log, $cache, $dispatcher);

		$this->assertSame(2, $image->change_author([5, 7, 5], [
			'user_id'     => 42,
			'username'    => 'Target User',
			'user_colour' => 'A1B2C3',
		]));
		$this->assertSame([
			['ids' => [5, 7], 'add' => false, 'readd' => false],
			['ids' => [5, 7], 'add' => true, 'readd' => false],
		], $image->counter_calls);
		$this->assertStringContainsString('image_user_id = 42', implode("\n", $queries));
		$this->assertStringContainsString("image_username = 'Target User'", implode("\n", $queries));
		$this->assertSame(['begin', 'commit'], $database_state->transactions);
	}

	public function test_batch_rename_updates_each_selected_name_and_logs_it(): void
	{
		$queries = [];
		[$db, $database_state] = $this->database([
			['image_id' => 5, 'image_album_id' => 2, 'image_name' => 'Old first'],
			['image_id' => 7, 'image_album_id' => 3, 'image_name' => 'Old second'],
		], $queries);
		$log = $this->createMock(log::class);
		$log->expects($this->exactly(2))->method('add_log');
		$cache = $this->createMock(cache::class);
		$cache->expects($this->once())->method('destroy_images');
		$image = $this->image_service($db, $log, $cache);

		$this->assertSame(2, $image->rename_images([5 => 'New first', 7 => 'New second']));
		$sql = implode("\n", $queries);
		$this->assertStringContainsString("image_name = 'New first'", $sql);
		$this->assertStringContainsString('WHERE image_id = 5', $sql);
		$this->assertStringContainsString("image_name = 'New second'", $sql);
		$this->assertStringContainsString('WHERE image_id = 7', $sql);
		$this->assertSame(['begin', 'commit'], $database_state->transactions);
	}

	public function test_batch_rename_rejects_missing_and_oversized_names_before_querying(): void
	{
		$image = (new \ReflectionClass(image::class))->newInstanceWithoutConstructor();

		foreach (['', str_repeat('x', 256)] as $invalid_name)
		{
			try
			{
				$image->rename_images([5 => $invalid_name]);
				$this->fail('Invalid image name accepted.');
			}
			catch (\InvalidArgumentException)
			{
				$this->addToAssertionCount(1);
			}
		}
	}

	public function test_batch_author_change_rejects_untrusted_identity_without_querying(): void
	{
		$image = (new \ReflectionClass(image::class))->newInstanceWithoutConstructor();

		$this->assertSame(0, $image->change_author([5], ['user_id' => 0, 'username' => 'Guest']));
		$this->assertSame(0, $image->change_author([5], ['user_id' => 42, 'username' => '']));
		$this->assertSame(0, $image->change_author([-5, 0], ['user_id' => 42, 'username' => 'Target']));
	}

	public function test_controller_reauthorizes_batch_edits_and_preserves_confirmation_data(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/moderate.php');
		$authorization = strpos($source, '$authorized_action = $this->authorize_action_images($actions_array');
		$change = strpos($source, '$this->image->change_author(', $authorization);
		$rename = strpos($source, '$this->image->rename_images(', $authorization);

		$this->assertStringContainsString("'change_author' => 'm_edit'", $source);
		$this->assertStringContainsString("'rename'\t=> 'm_edit'", $source);
		$this->assertNotFalse($authorization);
		$this->assertNotFalse($change);
		$this->assertNotFalse($rename);
		$this->assertLessThan($change, $authorization);
		$this->assertLessThan($rename, $authorization);
		$this->assertStringContainsString("\$hidden_data['change_author'] = \$change_author", $source);
		$this->assertStringContainsString("\$hidden_data['image_name'] = \$renamed_images", $source);
		$this->assertStringContainsString('$s_hidden_fields = build_hidden_fields($hidden_data)', $source);
	}

	public function test_all_moderation_templates_expose_per_image_names_and_new_author(): void
	{
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$template = (string) file_get_contents(dirname(__DIR__) . '/styles/' . $style . '/template/gallery/moderate_album_overview.html');

			$this->assertStringContainsString('S_CAN_EDIT_IMAGES', $template, $style);
			$this->assertStringContainsString('name="image_name[{{ overview.U_IMAGE_ID }}]"', $template, $style);
			$this->assertStringContainsString('name="change_author"', $template, $style);
			$this->assertStringContainsString('U_FIND_USERNAME', $template, $style);
		}
	}

	public function test_moderation_batch_actions_are_rendered_by_each_style(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/moderate.php');
		$this->assertStringContainsString("assign_block_vars('overview_actions'", $source);
		$this->assertStringContainsString("'U_ACTION_SELECT'", $source);

		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$template = (string) file_get_contents(dirname(__DIR__) . '/styles/' . $style . '/template/gallery/moderate_album_overview.html');
			$this->assertStringContainsString('{% for action in overview_actions %}', $template, $style);
			$this->assertStringContainsString('name="select_action" id="select_action"', $template, $style);
			$this->assertStringNotContainsString('{{ U_ACTION_SELECT }}', $template, $style);
		}

		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			$template = (string) file_get_contents(dirname(__DIR__) . '/styles/' . $style . '/template/gallery/moderate_album_overview.html');
			$this->assertStringContainsString('class="selectpicker"', $template, $style);
			$this->assertStringContainsString('data-style="btn btn-default form-control"', $template, $style);
		}
	}

	public function test_rename_action_is_translated_in_every_catalog(): void
	{
		foreach (glob(dirname(__DIR__) . '/language/*/gallery_mcp.php') as $catalog)
		{
			$this->assertStringContainsString("'RENAME_IMAGES'", (string) file_get_contents($catalog), $catalog);
		}
	}

	public function test_comment_counter_sum_is_not_split_by_previous_author(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/image/image.php');
		$start = strpos($source, 'SELECT SUM(image_comments) as comments');
		$end = strpos($source, '$this->db->sql_query($sql)', $start);
		$query = substr($source, $start, $end - $start);

		$this->assertStringNotContainsString('GROUP BY image_user_id', $query);
	}

	private function database(array $rows, array &$queries): array
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$row = 0;
		$state = (object) ['transactions' => []];
		$db->method('sql_in_set')->willReturnCallback(static fn ($field, $array): string => $field . ' IN (' . implode(', ', array_map('intval', (array) $array)) . ')');
		$db->method('sql_query')->willReturnCallback(static function ($query) use (&$queries): bool
		{
			$queries[] = $query;
			return true;
		});
		$db->method('sql_fetchrow')->willReturnCallback(static function () use (&$rows, &$row): array|false
		{
			return $rows[$row++] ?? false;
		});
		$db->method('sql_freeresult')->willReturn(true);
		$db->method('sql_build_array')->willReturnCallback(static function ($query, $assoc_ary): string
		{
			$parts = [];
			foreach ($assoc_ary as $key => $value)
			{
				$parts[] = $key . ' = ' . (is_int($value) ? $value : "'" . $value . "'");
			}
			return implode(', ', $parts);
		});
		$db->method('sql_transaction')->willReturnCallback(static function ($status) use ($state): bool
		{
			$state->transactions[] = $status;
			return true;
		});

		return [$db, $state];
	}

	private function image_service(object $db, log $log, cache $cache,
		?\phpbb\event\dispatcher_interface $dispatcher = null): batch_edit_image
	{
		$image = (new \ReflectionClass(batch_edit_image::class))->newInstanceWithoutConstructor();
		foreach ([
			'db'            => $db,
			'gallery_log'   => $log,
			'gallery_cache' => $cache,
			'phpbb_dispatcher' => $dispatcher ?? $this->createMock(\phpbb\event\dispatcher_interface::class),
			'table_images'  => 'gallery_images',
		] as $name => $value)
		{
			(new \ReflectionProperty(image::class, $name))->setValue($image, $value);
		}

		return $image;
	}
}

final class batch_edit_image extends image
{
	public array $counter_calls = [];

	public function handle_counter(array|int $image_id_ary, bool $add, bool $readd = false): void
	{
		$this->counter_calls[] = [
			'ids'   => (array) $image_id_ary,
			'add'   => $add,
			'readd' => $readd,
		];
	}
}
