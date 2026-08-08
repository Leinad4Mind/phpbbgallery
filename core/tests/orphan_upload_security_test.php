<?php
/**
 * phpBB Gallery - Core Extension tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;

class orphan_upload_security_test extends TestCase
{
	public function test_only_exact_orphans_owned_by_the_user_in_the_album_are_loaded(): void
	{
		$database = $this->database([
			$this->image_row(10, 'owner.png', 42, 7),
			$this->image_row(11, 'other-user.png', 99, 7),
			$this->image_row(12, 'other-album.png', 42, 8),
		]);
		$upload = $this->new_upload($database);

		$upload->get_images([
			'10$owner.png',
			'11$other-user.png',
			'12$other-album.png',
		]);

		$this->assertSame([10], $upload->images);
		$this->assertSame(1, $upload->loaded_files);
		$this->assertSame('owner.png', $upload->image_data[10]['image_filename']);
		$this->assertCount(1, $database->queries);
		$this->assertStringContainsString('image_status = 3', $database->queries[0]);
		$this->assertStringContainsString('image_user_id = 42', $database->queries[0]);
		$this->assertStringContainsString('image_album_id = 7', $database->queries[0]);
	}

	public function test_truncated_filename_token_is_rejected(): void
	{
		$database = $this->database([
			$this->image_row(13, 'abcdefgh-complete.png', 42, 7),
		]);
		$upload = $this->new_upload($database);

		$upload->get_images(['13$abcdefgh']);

		$this->assertSame([], $upload->images);
		$this->assertSame(0, $upload->loaded_files);
	}

	public function test_malformed_identifiers_are_ignored_without_a_query(): void
	{
		$database = $this->database([]);
		$upload = $this->new_upload($database);

		$upload->get_images([
			[],
			'missing-token',
			'$filename.png',
			'0$filename.png',
			'-1$filename.png',
			'not-an-id$filename.png',
			'14$',
		]);

		$this->assertSame([], $upload->images);
		$this->assertSame([], $database->queries);
	}

	public function test_duplicate_identifiers_cannot_replace_the_first_token(): void
	{
		$database = $this->database([
			$this->image_row(14, 'actual.png', 42, 7),
		]);
		$upload = $this->new_upload($database);

		$upload->get_images([
			'14$wrong.png',
			'14$actual.png',
		]);

		$this->assertSame([], $upload->images);
	}

	public function test_hidden_fields_contain_the_complete_server_filename(): void
	{
		$upload = $this->new_upload($this->database([]));
		$upload->images = [15];
		$upload->image_data[15] = [
			'image_filename' => 'abcdefgh-complete.png',
		];

		$this->assertSame(
			['15$abcdefgh-complete.png'],
			$upload->generate_hidden_fields()
		);
	}

	public function test_upload_edit_requires_post_and_csrf_before_database_access(): void
	{
		$source = $this->controller_source();
		$section = $this->upload_edit_section($source);
		$post_submit = strpos($source, "\$submit = \$this->request->is_set_post('submit');");
		$guard = strpos($section, "check_form_key('gallery')");
		$query = strpos($section, '$this->db->sql_query($sql)');
		$load = strpos($section, '$process->get_images($upload_ids)');
		$update = strpos($section, '$process->update_image(');

		$this->assertNotFalse($post_submit);
		$this->assertNotFalse($guard);
		$this->assertNotFalse($query);
		$this->assertNotFalse($load);
		$this->assertNotFalse($update);
		$this->assertLessThan($query, $guard);
		$this->assertLessThan($load, $guard);
		$this->assertLessThan($update, $guard);
	}

	public function test_upload_edit_reads_every_mutating_field_from_post(): void
	{
		$section = $this->upload_edit_section($this->controller_source());

		$this->assertStringContainsString("variable('message', [''], true, request_interface::POST)", $section);
		$this->assertStringContainsString("variable('upload_ids', [''], false, request_interface::POST)", $section);
		$this->assertStringContainsString("variable('rotate', [0], false, request_interface::POST)", $section);
		$this->assertStringContainsString("variable('orientation', [], false, request_interface::POST)", $section);
		$this->assertStringContainsString("variable('image_name', [''], true, request_interface::POST)", $section);
		$this->assertStringContainsString("variable('image_subtitle', [''], true, request_interface::POST)", $section);
		$this->assertStringContainsString("variable('image_num', 0, false, request_interface::POST)", $section);
		$this->assertStringContainsString("variable('same_name', false, false, request_interface::POST)", $section);
		$this->assertSame(9, substr_count($section, 'request_interface::POST'));
	}

	public function test_every_upload_edit_form_submits_a_phpbb_form_token(): void
	{
		foreach ($this->posting_templates() as $template_path)
		{
			$template = file_get_contents($template_path);
			$album_action = str_contains($template, '{{ S_ALBUM_ACTION }}') ? '{{ S_ALBUM_ACTION }}' : '{S_ALBUM_ACTION}';
			$form_token = str_contains($template, '{{ S_FORM_TOKEN }}') ? '{{ S_FORM_TOKEN }}' : '{S_FORM_TOKEN}';
			$form_start = strpos($template, '<form id="postform" action="' . $album_action . '" method="post" enctype="multipart/form-data">');
			$this->assertNotFalse($form_start, $template_path);
			$form_end = strpos($template, '</form>', $form_start);
			$this->assertNotFalse($form_end, $template_path);
			$form = substr($template, $form_start, $form_end - $form_start);

			$this->assertStringContainsString('name="mode" value="upload_edit"', $form, $template_path);
			$this->assertStringContainsString('name="submit"', $form, $template_path);
			$this->assertStringContainsString($form_token, $form, $template_path);
		}
	}

	private function database(array $rows): object
	{
		return new class($rows)
		{
			/** @var array */
			public $queries = [];

			/** @var array */
			private $rows;

			/** @var array */
			private $result_rows = [];

			public function __construct(array $rows)
			{
				$this->rows = $rows;
			}

			public function sql_in_set(string $field, array $values): string
			{
				return $field . ' IN (' . implode(', ', array_map('intval', $values)) . ')';
			}

			public function sql_query(string $sql)
			{
				$this->queries[] = $sql;
				$filters = [
					'image_status'   => $this->integer_filter($sql, 'image_status'),
					'image_user_id'  => $this->integer_filter($sql, 'image_user_id'),
					'image_album_id' => $this->integer_filter($sql, 'image_album_id'),
				];
				$image_ids = $this->image_ids($sql);
				$this->result_rows = array_values(array_filter($this->rows, static function (array $row) use ($filters, $image_ids): bool
				{
					foreach ($filters as $column => $value)
					{
						if ($value !== null && (int) $row[$column] !== $value)
						{
							return false;
						}
					}

					return empty($image_ids) || in_array((int) $row['image_id'], $image_ids, true);
				}));

				return true;
			}

			public function sql_fetchrow($result)
			{
				if (empty($this->result_rows))
				{
					return false;
				}

				return array_shift($this->result_rows);
			}

			public function sql_freeresult($result): void
			{
			}

			private function integer_filter(string $sql, string $column)
			{
				if (!preg_match('/' . preg_quote($column, '/') . ' = ([0-9]+)/', $sql, $matches))
				{
					return null;
				}

				return (int) $matches[1];
			}

			private function image_ids(string $sql): array
			{
				if (!preg_match('/image_id IN \(([^)]+)\)/', $sql, $matches))
				{
					return [];
				}

				return array_map('intval', explode(',', $matches[1]));
			}
		};
	}

	private function new_upload($database): \phpbbgallery\core\upload
	{
		$reflection = new \ReflectionClass(\phpbbgallery\core\upload::class);
		$upload = $reflection->newInstanceWithoutConstructor();
		$this->set_upload_property($upload, 'db', $database);
		$this->set_upload_property($upload, 'user', new class
		{
			/** @var array */
			public $data = [
				'user_id'       => 42,
				'is_registered' => true,
				'session_id'    => 'registered-test-session',
			];

			/** @var string */
			public $session_id = 'registered-test-session';
		});
		$this->set_upload_property($upload, 'block', new class
		{
			public function get_image_status_orphan(): int
			{
				return 3;
			}
		});
		$this->set_upload_property($upload, 'images_table', 'phpbb_gallery_images');
		$this->set_upload_property($upload, 'album_id', 7);

		return $upload;
	}

	private function image_row(int $image_id, string $filename, int $user_id, int $album_id): array
	{
		return [
			'image_id'       => $image_id,
			'image_filename' => $filename,
			'image_user_id'  => $user_id,
			'image_album_id' => $album_id,
			'image_status'   => 3,
		];
	}

	private function set_upload_property(\phpbbgallery\core\upload $upload, string $name, $value): void
	{
		$property = new \ReflectionProperty(\phpbbgallery\core\upload::class, $name);
		if (PHP_VERSION_ID < 80100)
		{
		}
		$property->setValue($upload, $value);
	}

	private function controller_source(): string
	{
		return file_get_contents(dirname(__DIR__) . '/controller/upload.php');
	}

	private function upload_edit_section(string $source): string
	{
		$start_marker = "\n\t\tif (\$mode == 'upload_edit')";
		$end_marker = "\n\t\treturn \$this->helper->render";
		$start = strpos($source, $start_marker);
		$this->assertNotFalse($start);
		$end = strpos($source, $end_marker, $start);
		$this->assertNotFalse($end);

		return substr($source, $start, $end - $start);
	}

	private function posting_templates(): array
	{
		return [
			dirname(__DIR__) . '/styles/prosilver/template/gallery/posting_body.html',
			dirname(__DIR__) . '/styles/BBOOTS/template/gallery/posting_body.html',
			dirname(__DIR__) . '/styles/FLATBOOTS/template/gallery/posting_body.html',
		];
	}
}
