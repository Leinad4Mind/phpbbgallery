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

class resumable_upload_test extends TestCase
{
	public function test_registered_user_resumes_only_drafts_from_the_current_album(): void
	{
		$database = $this->database([
			$this->image_row(21, 42, 7, ''),
			$this->image_row(22, 99, 7, ''),
			$this->image_row(23, 42, 8, ''),
			$this->image_row(24, 42, 7, '', 1),
		]);
		$upload = $this->new_upload($database, 42, true, 'current-session');

		$this->assertSame(1, $upload->load_pending_images());
		$this->assertSame([21], $upload->images);
		$this->assertSame(0, $upload->array_id2row[21]);
		$this->assertSame('file-21.png', $upload->image_data[21]['image_filename']);
		$this->assertStringNotContainsString('image_upload_session_hash', $database->queries[0]);
	}

	public function test_guest_resumes_only_drafts_from_the_current_session(): void
	{
		$database = $this->database([
			$this->image_row(31, 1, 7, 'guest-session'),
			$this->image_row(32, 1, 7, 'another-session'),
		]);
		$upload = $this->new_upload($database, 1, false, 'guest-session');

		$this->assertSame(1, $upload->load_pending_images());
		$this->assertSame([31], $upload->images);
		$this->assertStringContainsString("image_upload_session_hash = '" . hash('sha256', 'guest-session') . "'", $database->queries[0]);
	}

	public function test_guest_without_a_session_cannot_claim_legacy_drafts(): void
	{
		$database = $this->database([
			$this->image_row(33, 1, 7, ''),
		]);
		$upload = $this->new_upload($database, 1, false, '');

		$this->assertSame(0, $upload->load_pending_images());
		$this->assertSame([], $upload->images);
		$this->assertStringContainsString('AND 1 = 0', $database->queries[0]);
	}

	public function test_cancel_deletes_only_the_server_selected_draft(): void
	{
		$database = $this->database([
			$this->image_row(41, 42, 7, 'old-session'),
			$this->image_row(42, 42, 7, 'new-session'),
			$this->image_row(43, 99, 7, 'other-user'),
		]);
		$image_service = $this->image_service();
		$upload = $this->new_upload($database, 42, true, 'new-session', $image_service);

		$this->assertSame(2, $upload->discard_pending_images());
		$this->assertSame([
			[
				'images'       => [41, 42],
				'required_status' => 3,
				'filenames'     => [
					41 => 'file-41.png',
					42 => 'file-42.png',
				],
				'resync_albums' => false,
			],
		], $image_service->calls);
		$this->assertSame([], $upload->images);
		$this->assertSame([], $upload->image_data);
		$this->assertSame(0, $upload->loaded_files);
	}

	public function test_controller_resumes_before_accepting_new_files(): void
	{
		$source = $this->controller_source();
		$load = strpos($source, '$process->load_pending_images()');
		$resume = strpos($source, "\$mode = 'upload_edit';", $load);
		$upload = strpos($source, '$process->upload_file(');

		$this->assertNotFalse($load);
		$this->assertNotFalse($resume);
		$this->assertNotFalse($upload);
		$this->assertLessThan($upload, $load);
		$this->assertLessThan($upload, $resume);
		$this->assertStringContainsString("if (!\$is_ajax && (\$mode != 'upload_edit' || !\$submit))", $source);
		$this->assertStringContainsString("if (\$mode == 'upload'", $source);
	}

	public function test_cancel_requires_post_and_csrf_before_deletion(): void
	{
		$source = $this->controller_source();
		$post = strpos($source, "is_set_post('discard_pending')");
		$guard = strpos($source, "check_form_key('gallery')", $post);
		$delete = strpos($source, '$process->discard_pending_images()', $post);
		$redirect = strpos($source, "redirect(\$this->helper->route('phpbbgallery_core_album_upload'", $post);

		$this->assertNotFalse($post);
		$this->assertNotFalse($guard);
		$this->assertNotFalse($delete);
		$this->assertNotFalse($redirect);
		$this->assertLessThan($delete, $guard);
		$this->assertLessThan($redirect, $delete);
	}

	public function test_ajax_checks_csrf_before_uploading(): void
	{
		$source = $this->controller_source();
		$ajax = strpos($source, "if (\$mode == 'upload' && \$is_ajax");
		$guard = strpos($source, "check_form_key('gallery')", $ajax);
		$upload = strpos($source, '$process->upload_file(1)', $ajax);

		$this->assertNotFalse($ajax);
		$this->assertNotFalse($guard);
		$this->assertNotFalse($upload);
		$this->assertLessThan($upload, $guard);
	}

	public function test_native_ajax_upload_submits_the_current_form_fields_and_file(): void
	{
		$javascript = (string) file_get_contents(dirname(__DIR__) . '/styles/all/template/js/quick_upload.js');

		$this->assertStringContainsString('new FormData(form)', $javascript);
		$this->assertStringContainsString('if (!(value instanceof File))', $javascript);
		$this->assertStringContainsString("data.append('files[]', task.file, task.file.name)", $javascript);
		$this->assertStringContainsString("request.setRequestHeader('X-Requested-With', 'XMLHttpRequest')", $javascript);
		$this->assertStringContainsString("mode.value = 'upload_edit'", $javascript);
		$this->assertStringContainsString('window.HTMLFormElement.prototype.submit.call(form)', $javascript);
		foreach ($this->posting_templates() as $template_path)
		{
			$template = file_get_contents($template_path);

			$this->assertStringContainsString('data-gallery-quick-upload', $template, $template_path);
			$this->assertStringContainsString('{{ S_FORM_TOKEN }}', $template, $template_path);
		}
	}

	public function test_ajax_upload_stages_drafts_before_opening_the_metadata_review(): void
	{
		$source = $this->controller_source();
		$start = strpos($source, "if (\$mode == 'upload' && \$is_ajax");
		$end = strpos($source, "\n\t\tif (\$mode == 'upload')", $start + 1);
		$this->assertNotFalse($start);
		$this->assertNotFalse($end);
		$ajax = substr($source, $start, $end - $start);

		$this->assertStringContainsString('$process->load_pending_images()', $ajax);
		$this->assertStringContainsString("'review_required' => true", $ajax);
		$this->assertStringNotContainsString('$process->update_image(', $ajax);
		$this->assertStringNotContainsString('$this->image->handle_counter(', $ajax);
		$this->assertStringNotContainsString('$this->notification_helper->', $ajax);
	}

	public function test_metadata_review_preserves_and_finalizes_image_descriptions(): void
	{
		$section = $this->upload_edit_section();

		$this->assertStringContainsString('$description_array = []', $section);
		$this->assertStringContainsString("variable('message', [''], true, request_interface::POST)", $section);
		$this->assertStringContainsString('$process->set_descriptions($description_array)', $section);
		$this->assertStringContainsString("'IMAGE_DESC' => \$description_array[\$num_images] ?? \$data['image_desc']", $section);
	}

	public function test_empty_or_expired_draft_cannot_be_finalized(): void
	{
		$section = $this->upload_edit_section();
		$load = strpos($section, '$process->get_images($upload_ids)');
		$guard = strpos($section, 'if (!$process->images)', $load);
		$update = strpos($section, '$process->update_image(', $load);

		$this->assertNotFalse($load);
		$this->assertNotFalse($guard);
		$this->assertNotFalse($update);
		$this->assertLessThan($update, $guard);
	}

	public function test_entire_draft_is_checked_against_current_quotas(): void
	{
		$section = $this->upload_edit_section();
		$count = strpos($section, '$pending_count = count($process->images)');
		$album_quota = strpos($section, '$album_image_count + $pending_count', $count);
		$user_quota = strpos($section, '$pending_count > $upload_files_limit', $count);
		$update = strpos($section, '$process->update_image(', $count);

		$this->assertNotFalse($count);
		$this->assertNotFalse($album_quota);
		$this->assertNotFalse($user_quota);
		$this->assertNotFalse($update);
		$this->assertLessThan($update, $album_quota);
		$this->assertLessThan($update, $user_quota);
	}

	public function test_every_review_form_has_a_tokenized_cancel_button(): void
	{
		foreach ($this->posting_templates() as $template_path)
		{
			$template = file_get_contents($template_path);
			$album_action = str_contains($template, '{{ S_ALBUM_ACTION }}') ? '{{ S_ALBUM_ACTION }}' : '{S_ALBUM_ACTION}';
			$cancel = str_contains($template, "{{ lang('CANCEL') }}") ? "{{ lang('CANCEL') }}" : '{L_CANCEL}';
			$form_token = str_contains($template, '{{ S_FORM_TOKEN }}') ? '{{ S_FORM_TOKEN }}' : '{S_FORM_TOKEN}';
			$form_start = strpos($template, '<form id="postform" class="gallery-upload-details-form"');
			$this->assertNotFalse($form_start, $template_path);
			$form_header_end = strpos($template, '>', $form_start);
			$this->assertNotFalse($form_header_end, $template_path);
			$form_header = substr($template, $form_start, $form_header_end - $form_start);
			$this->assertStringContainsString('action="' . $album_action . '"', $form_header, $template_path);
			$this->assertStringContainsString('method="post"', $form_header, $template_path);
			$this->assertStringContainsString('enctype="multipart/form-data"', $form_header, $template_path);
			$form_end = strpos($template, '</form>', $form_start);
			$this->assertNotFalse($form_end, $template_path);
			$form = substr($template, $form_start, $form_end - $form_start);

			$this->assertStringContainsString('name="discard_pending"', $form, $template_path);
			$this->assertStringContainsString($cancel, $form, $template_path);
			$this->assertStringContainsString($form_token, $form, $template_path);
		}
	}

	public function test_session_binding_is_persisted_only_while_the_image_is_pending(): void
	{
		$source = file_get_contents(dirname(__DIR__) . '/upload.php');
		$insert = $this->extract_section($source, "\n\tpublic function file_to_database(", "\n\t/**\n\t * Delete unfinished");
		$update = $this->extract_section($source, "\n\tpublic function update_image(", "\n\t/**\n\t* Prepare file on upload");

		$this->assertStringContainsString("'image_upload_session_hash'\t=> \$this->get_session_hash()", $insert);
		$this->assertStringContainsString("'image_width'", $insert);
		$this->assertStringContainsString("'image_height'", $insert);
		$this->assertStringContainsString("'image_upload_session_hash'\t=> ''", $update);
		$this->assertStringContainsString('$this->image_dimensions?->inspect_file(', $update);
		$this->assertStringContainsString("\$sql_ary['image_width']", $update);
		$this->assertStringContainsString("\$sql_ary['image_height']", $update);
	}

	public function test_session_fingerprint_does_not_store_the_session_identifier(): void
	{
		$session_id = 'secret-phpbb-session';
		$upload = $this->new_upload($this->database([]), 1, false, $session_id);
		$fingerprint = \Closure::bind(function (): string
		{
			return $this->get_session_hash();
		}, $upload, \phpbbgallery\core\upload::class);
		$hash = $fingerprint();

		$this->assertSame(hash('sha256', $session_id), $hash);
		$this->assertNotSame($session_id, $hash);
	}

	public function test_drafts_are_retained_for_seven_days(): void
	{
		$reflection = new \ReflectionClass(\phpbbgallery\core\upload::class);

		$this->assertSame(604800, $reflection->getConstant('ORPHAN_RETENTION_SECONDS'));
	}

	public function test_migration_adds_session_binding_and_owner_index(): void
	{
		$this->load_migration();
		$reflection = new \ReflectionClass(\phpbbgallery\core\migrations\resumable_uploads::class);
		$migration = $reflection->newInstanceWithoutConstructor();
		$property = new \ReflectionProperty(\phpbb\db\migration\migration::class, 'table_prefix');
		if (PHP_VERSION_ID < 80100)
		{
		}
		$property->setValue($migration, 'phpbb_');

		$schema = $migration->update_schema();
		$this->assertSame(
			['VCHAR:64', ''],
			$schema['add_columns']['phpbb_gallery_images']['image_upload_session_hash']
		);
		$this->assertSame(
			['image_status', 'image_album_id', 'image_user_id', 'image_upload_session_hash'],
			$schema['add_index']['phpbb_gallery_images']['draft_owner']
		);
		$this->assertSame([
			'\phpbbgallery\core\migrations\release_3_4_0',
			'\phpbbgallery\core\migrations\release_1_2_0_db_create',
		], $migration::depends_on());
	}

	private function new_upload($database, int $user_id, bool $registered, string $session_id, $image_service = null): \phpbbgallery\core\upload
	{
		$reflection = new \ReflectionClass(\phpbbgallery\core\upload::class);
		$upload = $reflection->newInstanceWithoutConstructor();
		$this->set_upload_property($upload, 'db', $database);
		$this->set_upload_property($upload, 'user', $this->user($user_id, $registered, $session_id));
		$this->set_upload_property($upload, 'block', new class
		{
			public function get_image_status_orphan(): int
			{
				return 3;
			}
		});
		$this->set_upload_property($upload, 'gallery_image', $image_service ?: $this->image_service());
		$this->set_upload_property($upload, 'images_table', 'phpbb_gallery_images');
		$this->set_upload_property($upload, 'album_id', 7);

		return $upload;
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

			public function sql_query(string $sql)
			{
				$this->queries[] = $sql;
				if (strpos($sql, '1 = 0') !== false)
				{
					$this->result_rows = [];
					return true;
				}

				$filters = [
					'image_status'   => $this->integer_filter($sql, 'image_status'),
					'image_user_id'  => $this->integer_filter($sql, 'image_user_id'),
					'image_album_id' => $this->integer_filter($sql, 'image_album_id'),
				];
				$session_hash = $this->string_filter($sql, 'image_upload_session_hash');
				$this->result_rows = array_values(array_filter($this->rows, static function (array $row) use ($filters, $session_hash): bool
				{
					foreach ($filters as $column => $value)
					{
						if ($value !== null && (int) $row[$column] !== $value)
						{
							return false;
						}
					}
					if ($session_hash !== null && $row['image_upload_session_hash'] !== $session_hash)
					{
						return false;
					}

					return true;
				}));

				return true;
			}

			public function sql_fetchrow($result)
			{
				return empty($this->result_rows) ? false : array_shift($this->result_rows);
			}

			public function sql_freeresult($result): void
			{
			}

			public function sql_escape(string $value): string
			{
				return str_replace("'", "''", $value);
			}

			private function integer_filter(string $sql, string $column)
			{
				if (!preg_match('/' . preg_quote($column, '/') . ' = ([0-9]+)/', $sql, $matches))
				{
					return null;
				}

				return (int) $matches[1];
			}

			private function string_filter(string $sql, string $column)
			{
				if (!preg_match('/' . preg_quote($column, '/') . " = '([^']*)'/", $sql, $matches))
				{
					return null;
				}

				return str_replace("''", "'", $matches[1]);
			}
		};
	}

	private function user(int $user_id, bool $registered, string $session_id): object
	{
		return new class($user_id, $registered, $session_id)
		{
			/** @var array */
			public $data;

			/** @var string */
			public $session_id;

			public function __construct(int $user_id, bool $registered, string $session_id)
			{
				$this->data = [
					'user_id'       => $user_id,
					'is_registered' => $registered,
					'session_id'    => $session_id,
				];
				$this->session_id = $session_id;
			}
		};
	}

	private function image_service(): object
	{
		return new class
		{
			/** @var array */
			public $calls = [];

			public function delete_images_matching_status(array $images, int $required_status, array $filenames, bool $resync_albums): int
			{
				$this->calls[] = [
					'images'        => $images,
					'required_status' => $required_status,
					'filenames'      => $filenames,
					'resync_albums' => $resync_albums,
				];

				return count($images);
			}
		};
	}

	private function image_row(int $image_id, int $user_id, int $album_id, string $session_id, int $status = 3): array
	{
		return [
			'image_id'                => $image_id,
			'image_filename'          => 'file-' . $image_id . '.png',
			'image_name'              => 'Image ' . $image_id,
			'image_desc'              => '',
			'image_user_id'           => $user_id,
			'image_album_id'          => $album_id,
			'image_status'            => $status,
			'image_upload_session_hash' => $session_id === '' ? '' : hash('sha256', $session_id),
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

	private function upload_edit_section(): string
	{
		return $this->extract_section(
			$this->controller_source(),
			"\n\t\tif (\$mode == 'upload_edit')",
			"\n\t\treturn \$this->helper->render"
		);
	}

	private function extract_section(string $source, string $start_marker, string $end_marker): string
	{
		$start = strpos($source, $start_marker);
		$this->assertNotFalse($start);
		$end = strpos($source, $end_marker, $start + strlen($start_marker));
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

	private function load_migration(): void
	{
		if (class_exists(\phpbbgallery\core\migrations\resumable_uploads::class))
		{
			return;
		}

		$phpbb_root = dirname(__DIR__, 4);
		require_once $phpbb_root . '/phpbb/db/migration/migration_interface.php';
		require_once $phpbb_root . '/phpbb/db/migration/migration.php';
		require_once dirname(__DIR__) . '/migrations/resumable_uploads.php';
	}
}
