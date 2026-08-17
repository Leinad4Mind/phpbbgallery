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
use phpbbgallery\core\image\batch_editor;
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

	public function test_batch_edit_updates_all_metadata_fields_and_logs_each_image(): void
	{
		$queries = [];
		[$db, $database_state] = $this->database([
			['image_id' => 5, 'image_album_id' => 2, 'image_name' => 'Old first', 'image_status' => 1],
			['image_id' => 7, 'image_album_id' => 3, 'image_name' => 'Old second', 'image_status' => 1],
		], $queries);
		$log = $this->createMock(log::class);
		$log->expects($this->exactly(2))->method('add_log');
		$cache = $this->createMock(cache::class);
		$cache->expects($this->once())->method('destroy_images');
		$dispatcher = $this->createMock(\phpbb\event\dispatcher_interface::class);
		$dispatcher->expects($this->exactly(2))
			->method('trigger_event')
			->with('phpbbgallery.core.image.batch_edit_after', $this->anything())
			->willReturnArgument(1);
		$image = $this->image_service($db, $log, $cache, $dispatcher);

		$this->assertSame(2, $image->edit_images([
			5 => [
				'image_name' => 'New first',
				'image_subtitle' => 'Subtitle 1',
				'image_desc' => 'Stored first',
				'image_desc_uid' => 'uid1',
				'image_desc_bitfield' => 'bf1',
			],
			7 => [
				'image_name' => 'New second',
				'image_subtitle' => 'Subtitle 2',
				'image_desc' => 'Stored second',
				'image_desc_uid' => 'uid2',
				'image_desc_bitfield' => 'bf2',
			],
		]));
		$sql = implode("\n", $queries);
		$this->assertStringContainsString("image_name = 'New first'", $sql);
		$this->assertStringContainsString("image_subtitle = 'Subtitle 1'", $sql);
		$this->assertStringContainsString("image_desc = 'Stored first'", $sql);
		$this->assertStringContainsString("image_desc_uid = 'uid1'", $sql);
		$this->assertStringContainsString("image_desc_bitfield = 'bf1'", $sql);
		$this->assertStringContainsString('WHERE image_id = 5', $sql);
		$this->assertStringContainsString("image_name = 'New second'", $sql);
		$this->assertStringContainsString('WHERE image_id = 7', $sql);
		$this->assertSame(['begin', 'commit'], $database_state->transactions);
	}

	public function test_batch_edit_rejects_incomplete_and_oversized_values_before_querying(): void
	{
		$image = (new \ReflectionClass(image::class))->newInstanceWithoutConstructor();
		$valid = [
			'image_name' => 'Valid',
			'image_subtitle' => '',
			'image_desc' => '',
			'image_desc_uid' => '',
			'image_desc_bitfield' => '',
		];
		$invalid_updates = [
			array_replace($valid, ['image_name' => '']),
			array_replace($valid, ['image_name' => str_repeat('x', 256)]),
			array_replace($valid, ['image_subtitle' => str_repeat('x', 256)]),
			array_diff_key($valid, ['image_desc_bitfield' => true]),
		];

		foreach ($invalid_updates as $invalid_update)
		{
			try
			{
				$image->edit_images([5 => $invalid_update]);
				$this->fail('Invalid batch image update accepted.');
			}
			catch (\InvalidArgumentException)
			{
				$this->addToAssertionCount(1);
			}
		}
	}

	public function test_batch_edit_does_not_partially_update_when_a_selected_row_disappears(): void
	{
		$queries = [];
		[$db, $database_state] = $this->database([
			['image_id' => 5, 'image_album_id' => 2, 'image_name' => 'First', 'image_status' => 1],
		], $queries);
		$image = $this->image_service(
			$db,
			$this->createMock(log::class),
			$this->createMock(cache::class)
		);
		$update = [
			'image_name' => 'Updated',
			'image_subtitle' => '',
			'image_desc' => '',
			'image_desc_uid' => '',
			'image_desc_bitfield' => '',
		];

		$this->expectException(\RuntimeException::class);
		try
		{
			$image->edit_images([5 => $update, 7 => $update]);
		}
		finally
		{
			$this->assertSame([], $database_state->transactions);
			$this->assertStringNotContainsString('UPDATE gallery_images', implode("\n", $queries));
		}
	}

	public function test_batch_sequence_only_replaces_explicit_num_tokens(): void
	{
		$this->assertSame('Cover 8 / 8', batch_editor::apply_sequence('Cover {NUM} / {NUM}', 8));
		$this->assertSame('[b]Keep {OTHER}[/b]', batch_editor::apply_sequence('[b]Keep {OTHER}[/b]', 9));
		$this->assertSame('Zero 0', batch_editor::apply_sequence('Zero {NUM}', 0));
		$this->assertSame('Bounded 999999999', batch_editor::apply_sequence('Bounded {NUM}', PHP_INT_MAX));
	}

	public function test_batch_author_change_rejects_untrusted_identity_without_querying(): void
	{
		$image = (new \ReflectionClass(image::class))->newInstanceWithoutConstructor();

		$this->assertSame(0, $image->change_author([5], ['user_id' => 0, 'username' => 'Guest']));
		$this->assertSame(0, $image->change_author([5], ['user_id' => 42, 'username' => '']));
		$this->assertSame(0, $image->change_author([-5, 0], ['user_id' => 42, 'username' => 'Target']));
	}

	public function test_controller_reauthorizes_batch_edits_and_requires_csrf_before_persisting(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/moderate.php');
		$authorization = strpos($source, '$authorized_action = $this->authorize_action_images($actions_array');
		$change = strpos($source, '$this->image->change_author(', $authorization);
		$batch_form = strpos($source, '$this->batch_edit_images(', $authorization);
		$batch_persist = strpos($source, '$this->image->edit_images(', $batch_form);

		$this->assertStringContainsString("'change_author' => 'm_edit'", $source);
		$this->assertStringContainsString("'edit'\t\t=> 'm_edit'", $source);
		$this->assertNotFalse($authorization);
		$this->assertNotFalse($change);
		$this->assertNotFalse($batch_form);
		$this->assertNotFalse($batch_persist);
		$this->assertLessThan($change, $authorization);
		$this->assertLessThan($batch_form, $authorization);
		$this->assertLessThan($batch_persist, $batch_form);
		$this->assertStringContainsString("\$hidden_data['change_author'] = \$change_author", $source);
		$this->assertStringContainsString('$s_hidden_fields = build_hidden_fields($hidden_data)', $source);
		$this->assertStringContainsString("if (\$submit && !check_form_key('gallery'))", $source);
		$this->assertStringContainsString('batch_editor::apply_sequence', $source);
		$this->assertStringContainsString('parse_image_description(', $source);
		$this->assertStringContainsString('if ($album_id < 1)', $source);
		$this->assertStringContainsString('phpbbgallery.core.image.batch_edit_validate', $source);
		$this->assertStringContainsString('phpbbgallery.core.image.batch_edit_display', $source);
	}

	public function test_controller_validates_complete_posts_limits_and_bbcode_before_persisting(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/moderate.php');
		$method = strstr($source, 'private function batch_edit_images');
		$this->assertIsString($method);
		$method = strstr($method, 'private function decode_image_description', true);

		$this->assertStringContainsString('array_key_exists($image_id, $image_names)', $method);
		$this->assertStringContainsString('array_key_exists($image_id, $image_subtitles)', $method);
		$this->assertStringContainsString('array_key_exists($image_id, $image_descriptions)', $method);
		$this->assertStringContainsString('utf8_strlen($image_name) > 255', $method);
		$this->assertStringContainsString('IMAGE_SUBTITLE_MAX_LENGTH', $method);
		$this->assertStringContainsString('utf8_strlen($image_description) > $description_max_length', $method);
		$this->assertLessThan(
			strpos($method, '$this->image->edit_images('),
			strpos($method, '$this->parse_image_description(')
		);

		$parser = strstr($source, 'private function parse_image_description');
		$this->assertIsString($parser);
		$this->assertStringContainsString('$message_parser->parse(true, true, true, true, false, true, true, true)', $parser);
		$this->assertStringContainsString("'image_desc_uid'", (string) file_get_contents(dirname(__DIR__) . '/image/image.php'));
		$this->assertStringContainsString("'image_desc_bitfield'", (string) file_get_contents(dirname(__DIR__) . '/image/image.php'));
	}

	public function test_all_moderation_templates_use_a_dedicated_batch_editor(): void
	{
		foreach (\gallery_test_existing_styles(dirname(__DIR__)) as $style)
		{
			$overview = (string) file_get_contents(dirname(__DIR__) . '/styles/' . $style . '/template/gallery/moderate_album_overview.html');
			$editor = (string) file_get_contents(dirname(__DIR__) . '/styles/' . $style . '/template/gallery/moderate_batch_edit.html');

			$this->assertStringContainsString('S_CAN_EDIT_IMAGES', $overview, $style);
			$this->assertStringNotContainsString('name="image_name[{{ overview.U_IMAGE_ID }}]"', $overview, $style);
			$this->assertStringContainsString('name="change_author"', $overview, $style);
			$this->assertStringContainsString('U_FIND_USERNAME', $overview, $style);
			$this->assertStringContainsString('name="action[]"', $editor, $style);
			$this->assertStringContainsString('name="image_name[{{ batch_image.IMAGE_ID }}]"', $editor, $style);
			$this->assertStringContainsString('name="image_subtitle[{{ batch_image.IMAGE_ID }}]"', $editor, $style);
			$this->assertStringContainsString('name="message[{{ batch_image.IMAGE_ID }}]"', $editor, $style);
			$this->assertStringContainsString('name="image_num"', $editor, $style);
			$this->assertStringContainsString('S_FORM_TOKEN', $editor, $style);
			$this->assertStringContainsString('data-gallery-character-counter', $editor, $style);
			$this->assertStringContainsString('phpbbgallery_core_moderate_batch_edit_image_fields', $editor, $style);
		}
	}

	public function test_moderation_batch_actions_are_rendered_by_each_style(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/moderate.php');
		$this->assertStringContainsString("assign_block_vars('overview_actions'", $source);
		$this->assertStringContainsString("'U_ACTION_SELECT'", $source);

		foreach (\gallery_test_existing_styles(dirname(__DIR__)) as $style)
		{
			$template = (string) file_get_contents(dirname(__DIR__) . '/styles/' . $style . '/template/gallery/moderate_album_overview.html');
			$this->assertStringContainsString('{% for action in overview_actions %}', $template, $style);
			$this->assertStringContainsString('name="select_action" id="select_action"', $template, $style);
			$this->assertStringContainsString('class="gallery-mcp-action-row"', $template, $style);
			$this->assertStringContainsString('class="gallery-mcp-bulk-action"', $template, $style);
			$this->assertStringContainsString('gallery-mcp-change-author', $template, $style);
			$this->assertLessThan(
				strpos($template, 'gallery-mcp-change-author'),
				strpos($template, 'gallery-mcp-bulk-action'),
				$style
			);
			$this->assertStringNotContainsString('{{ U_ACTION_SELECT }}', $template, $style);
		}

		foreach (\gallery_test_existing_styles(dirname(__DIR__), ['BBOOTS', 'FLATBOOTS'], $this) as $style)
		{
			$template = (string) file_get_contents(dirname(__DIR__) . '/styles/' . $style . '/template/gallery/moderate_album_overview.html');
			$this->assertStringContainsString('class="selectpicker"', $template, $style);
			$this->assertStringContainsString('data-style="btn btn-default form-control"', $template, $style);
		}
	}

	public function test_batch_edit_action_is_translated_in_every_catalog(): void
	{
		foreach (glob(dirname(__DIR__) . '/language/*/gallery_mcp.php') as $catalog)
		{
			$language = (string) file_get_contents($catalog);
			$this->assertStringContainsString("'EDIT_SELECTED_IMAGES'", $language, $catalog);
			$this->assertStringContainsString("'BATCH_EDIT_IMAGES'", $language, $catalog);
			$this->assertStringContainsString("'BATCH_EDIT_NUMBERING_EXPLAIN'", $language, $catalog);
			$this->assertStringNotContainsString("'RENAME_IMAGES'", $language, $catalog);
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
