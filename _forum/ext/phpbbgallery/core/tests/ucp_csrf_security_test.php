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
use phpbbgallery\core\ucp\main_module as ucp_main_module;

class ucp_csrf_security_test extends TestCase
{
	public function test_form_submission_requires_a_post_field_and_valid_token(): void
	{
		$module = new ucp_main_module();
		$validate = \Closure::bind(function ($request, $field, $form_key_valid): bool
		{
			return $this->is_valid_form_submission($request, $field, $form_key_valid);
		}, $module, ucp_main_module::class);

		$request = $this->request_stub(['submit']);

		$this->assertTrue($validate($request, 'submit', true));
		$this->assertFalse($validate($request, 'submit', false));
		$this->assertFalse($validate($request, 'move', true));
	}

	public function test_only_explicit_album_move_directions_are_accepted(): void
	{
		$module = new ucp_main_module();
		$validate = \Closure::bind(function ($move): bool
		{
			return $this->is_valid_move_direction($move);
		}, $module, ucp_main_module::class);

		$this->assertTrue($validate('move_up'));
		$this->assertTrue($validate('move_down'));
		$this->assertFalse($validate(''));
		$this->assertFalse($validate('delete'));
	}

	public function test_gallery_ucp_action_is_built_from_the_board_root(): void
	{
		$module = new ucp_main_module();
		$build = \Closure::bind(function ($url, string $module_id): string
		{
			return $this->build_ucp_action($url, $module_id, 'manage_albums');
		}, $module, ucp_main_module::class);
		$module_ids = [
			'-phpbbgallery-core-ucp-main_module',
			'\\phpbbgallery\\core\\ucp\\main_module',
		];
		foreach ($module_ids as $module_id)
		{
			$encoded_id = rawurlencode($module_id);
			$url = $this->createMock(\phpbbgallery\core\url::class);
			$url->expects($this->once())
				->method('append_sid')
				->with('phpbb', 'ucp', 'i=' . $encoded_id . '&mode=manage_albums')
				->willReturn('./ucp.php?i=' . $encoded_id . '&amp;mode=manage_albums');

			$this->assertSame('./ucp.php?i=' . $encoded_id . '&amp;mode=manage_albums', $build($url, $module_id));
		}
	}

	public function test_personal_album_creation_checks_csrf_before_inserting(): void
	{
		$method = $this->method('initialise_album', 'manage_albums');
		$guard = strpos($method, "is_valid_form_submission(\$request, 'submit')");
		$mutation = strpos($method, "\$db->sql_query('INSERT INTO ");

		$this->assertNotFalse($guard);
		$this->assertNotFalse($mutation);
		$this->assertLessThan($mutation, $guard);
	}

	public function test_personal_album_root_cannot_be_attached_to_a_submitted_parent(): void
	{
		$method = $this->method('initialise_album', 'manage_albums');

		$this->assertStringContainsString("'parent_id'\t\t\t\t\t\t=> 0", $method);
		$this->assertStringNotContainsString("\$request->variable('parent_id'", $method);
	}

	public function test_confirmed_album_deletion_revalidates_posted_ownership(): void
	{
		$method = $this->method('delete_album', 'move_album');
		$confirmed = strpos($method, 'if (confirm_box(true))');
		$post_read = strpos($method, "variable('album_id', 0, false, \\phpbb\\request\\request_interface::POST)", $confirmed);
		$ownership_check = strpos($method, 'check_user($album_id)', $post_read);
		$album_query = strpos($method, "'SELECT album_id, left_id, right_id, parent_id", $post_read);

		$this->assertNotFalse($confirmed);
		$this->assertNotFalse($post_read);
		$this->assertNotFalse($ownership_check);
		$this->assertNotFalse($album_query);
		$this->assertLessThan($ownership_check, $post_read);
		$this->assertLessThan($album_query, $ownership_check);
	}

	public function test_album_reordering_reads_post_and_checks_csrf_before_updating(): void
	{
		$method = $this->method('move_album', 'manage_subscriptions');
		$guard = strpos($method, "is_valid_form_submission(\$request, 'move')");
		$mutation = strpos($method, '$db->sql_query($sql)');

		$this->assertNotFalse($guard);
		$this->assertSame(2, substr_count($method, 'request_interface::POST'));
		$this->assertStringContainsString('is_valid_move_direction($move)', $method);
		$this->assertNotFalse($mutation);
		$this->assertLessThan($mutation, $guard);
	}

	public function test_unsubscribe_reads_post_and_checks_csrf_before_removing(): void
	{
		$method = $this->method('manage_subscriptions', 'subscribe_pegas');
		$guard = strpos($method, "is_valid_form_submission(\$request, 'action')");
		$mutation = strpos($method, 'remove_albums(');

		$this->assertNotFalse($guard);
		$this->assertSame(3, substr_count($method, 'request_interface::POST'));
		$this->assertNotFalse($mutation);
		$this->assertLessThan($mutation, $guard);
	}

	public function test_ucp_module_does_not_access_superglobals_directly(): void
	{
		$this->assertStringNotContainsString('$' . '_POST', $this->source());
	}

	public function test_every_album_reorder_control_is_a_tokenized_post_form(): void
	{
		foreach ($this->reorder_templates() as $template_path)
		{
			$template = file_get_contents($template_path);
			$ucp_action = str_contains($template, '{{ S_UCP_ACTION }}') ? '{{ S_UCP_ACTION }}' : '{S_UCP_ACTION}';
			$album_id = str_contains($template, '{{ album_row.ALBUM_ID }}') ? '{{ album_row.ALBUM_ID }}' : '{album_row.ALBUM_ID}';
			$form_token = str_contains($template, '{{ S_FORM_TOKEN }}') ? '{{ S_FORM_TOKEN }}' : '{S_FORM_TOKEN}';
			$form_start = strpos($template, '<form method="post" action="' . $ucp_action . '"');
			$this->assertNotFalse($form_start, $template_path);
			$form_end = strpos($template, '</form>', $form_start);
			$this->assertNotFalse($form_end, $template_path);
			$form = substr($template, $form_start, $form_end - $form_start);

			$this->assertStringContainsString('name="action" value="move"', $form, $template_path);
			$this->assertStringContainsString('name="album_id" value="' . $album_id . '"', $form, $template_path);
			$this->assertStringContainsString('name="move" value="move_up"', $form, $template_path);
			$this->assertStringContainsString('name="move" value="move_down"', $form, $template_path);
			$this->assertStringContainsString($form_token, $form, $template_path);
			$this->assertStringNotContainsString('href="{album_row.U_MOVE_', $template, $template_path);
			$this->assertStringNotContainsString('href="{{ album_row.U_MOVE_', $template, $template_path);
		}
	}

	public function test_every_personal_album_creation_form_submits_a_phpbb_form_token(): void
	{
		foreach ($this->reorder_templates() as $template_path)
		{
			$template = file_get_contents($template_path);
			$ucp_action = str_contains($template, '{{ S_UCP_ACTION }}') ? '{{ S_UCP_ACTION }}' : '{S_UCP_ACTION}';
			$form_token = str_contains($template, '{{ S_FORM_TOKEN }}') ? '{{ S_FORM_TOKEN }}' : '{S_FORM_TOKEN}';
			$form_start = strpos($template, '<form id="ucp" method="post" action="' . $ucp_action . '"');
			$this->assertNotFalse($form_start, $template_path);
			$form_end = strpos($template, '</form>', $form_start);
			$this->assertNotFalse($form_end, $template_path);
			$form = substr($template, $form_start, $form_end - $form_start);

			$this->assertStringContainsString('name="submit"', $form, $template_path);
			$this->assertStringContainsString($form_token, $form, $template_path);
		}
	}

	public function test_every_album_editor_posts_to_the_gallery_ucp_action(): void
	{
		foreach ($this->reorder_templates() as $template_path)
		{
			$template = (string) file_get_contents($template_path);
			$this->assertStringContainsString('<form id="acp_gallery" method="post" action="{{ S_UCP_ACTION }}">', $template, $template_path);
			$this->assertStringNotContainsString('action="{{ U_ACTION }}"', $template, $template_path);
		}

		$create = $this->method('create_album', 'edit_album');
		$edit = $this->method('edit_album', 'delete_album');
		$this->assertStringContainsString("'S_UCP_ACTION'", $create);
		$this->assertStringContainsString("'S_UCP_ACTION'", $edit);
		$this->assertStringNotContainsString("'S_ALBUM_ACTION'", $edit);
	}

	public function test_every_subscription_form_submits_a_phpbb_form_token(): void
	{
		foreach ($this->subscription_templates() as $template_path)
		{
			$template = file_get_contents($template_path);
			$ucp_action = str_contains($template, '{{ S_UCP_ACTION }}') ? '{{ S_UCP_ACTION }}' : '{S_UCP_ACTION}';
			$form_token = str_contains($template, '{{ S_FORM_TOKEN }}') ? '{{ S_FORM_TOKEN }}' : '{S_FORM_TOKEN}';
			$form_start = strrpos($template, '<form id="ucp_gallery" method="post" action="' . $ucp_action . '">');
			$this->assertNotFalse($form_start, $template_path);
			$form_end = strpos($template, '</form>', $form_start);
			$this->assertNotFalse($form_end, $template_path);
			$form = substr($template, $form_start, $form_end - $form_start);

			$this->assertStringContainsString($form_token, $form, $template_path);
		}
	}

	private function request_stub(array $post_fields): object
	{
		return new class($post_fields)
		{
			/** @var array */
			private array $post_fields;

			public function __construct(array $post_fields)
			{
				$this->post_fields = array_fill_keys($post_fields, true);
			}

			public function is_set_post($field): bool
			{
				return isset($this->post_fields[$field]);
			}
		};
	}

	private function method(string $method, string $next_method): string
	{
		return $this->extract_section($this->source(), "\n\tpublic function $method(", "\n\tpublic function $next_method(");
	}

	private function source(): string
	{
		return file_get_contents(dirname(__DIR__) . '/ucp/main_module.php');
	}

	private function reorder_templates(): array
	{
		return [
			dirname(__DIR__) . '/styles/prosilver/template/gallery/ucp_gallery_manage_subalbuns.html',
			dirname(__DIR__) . '/styles/BBOOTS/template/gallery/ucp_gallery_manage_subalbuns.html',
			dirname(__DIR__) . '/styles/FLATBOOTS/template/gallery/ucp_gallery_manage_subalbuns.html',
		];
	}

	private function subscription_templates(): array
	{
		return [
			dirname(__DIR__) . '/styles/prosilver/template/gallery/ucp_gallery_manage_subscriptions.html',
			dirname(__DIR__) . '/styles/BBOOTS/template/gallery/ucp_gallery_manage_subscriptions.html',
			dirname(__DIR__) . '/styles/FLATBOOTS/template/gallery/ucp_gallery_manage_subscriptions.html',
		];
	}

	private function extract_section(string $contents, string $start_marker, string $end_marker): string
	{
		$start = strpos($contents, $start_marker);
		$this->assertNotFalse($start);
		$end = strpos($contents, $end_marker, $start + strlen($start_marker));
		$this->assertNotFalse($end);

		return substr($contents, $start, $end - $start);
	}
}
