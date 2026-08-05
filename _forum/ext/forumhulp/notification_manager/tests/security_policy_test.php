<?php

namespace forumhulp\notification_manager\tests;

use PHPUnit\Framework\TestCase;

class security_policy_test extends TestCase
{
	public function test_selected_actions_require_post_and_a_valid_form_key(): void
	{
		$module = $this->module_source();
		$post_guard = strpos($module, "is_set_post('submit')");
		$form_check = strpos($module, 'check_form_key(self::FORM_KEY)');

		$this->assertNotFalse($post_guard);
		$this->assertNotFalse($form_check);
		$this->assertLessThan($form_check, $post_guard);
		$this->assertSame(4, substr_count($module, 'request_interface::POST'));
		$this->assertStringContainsString("private const FORM_KEY = 'ucp_notification_manager'", $module);
		$this->assertStringContainsString('redirect($this->u_action)', $module);
	}

	public function test_all_selected_mutations_are_scoped_to_the_current_user(): void
	{
		$module = $this->module_source();

		$this->assertGreaterThanOrEqual(2, substr_count($module, "WHERE user_id = ' . (int) \$this->user->data['user_id']"));
		$this->assertSame(2, substr_count($module, "sql_in_set('notification_id', \$notification_ids)"));
		$this->assertStringNotContainsString('mark_notifications_by_id(', $module);
		$this->assertSame(1, substr_count($module, "'DELETE FROM '"));
		$this->assertStringNotContainsString('foreach ($delete', $module);
	}

	public function test_missing_and_invalid_ids_cannot_trigger_database_writes(): void
	{
		$reflection = new \ReflectionClass(\forumhulp\notification_manager\ucp\noties_module::class);
		$module = $reflection->newInstanceWithoutConstructor();
		$normalise = $reflection->getMethod('normalise_notification_ids');

		$this->assertSame([], $normalise->invoke($module, [0, -1, 'invalid']));
		$this->assertSame([2, 3], $normalise->invoke($module, [2, '2', 3, 2]));
	}

	public function test_module_respects_the_board_notification_setting(): void
	{
		$info = file_get_contents($this->root() . '/ucp/noties_info.php');

		$this->assertStringContainsString(
			'ext_forumhulp/notification_manager && cfg_allow_board_notifications',
			$info
		);
	}

	public function test_lifecycle_updates_are_scoped_and_do_not_enable_dependencies(): void
	{
		$extension = file_get_contents($this->root() . '/ext.php');

		$this->assertStringContainsString("WHERE module_class = 'ucp'", $extension);
		$this->assertStringContainsString('AND module_langname = ', $extension);
		$this->assertStringContainsString('AND module_mode = ', $extension);
		$this->assertStringNotContainsString("->enable('forumhulp/helper')", $extension);
	}

	public function test_templates_keep_the_csrf_token(): void
	{
		foreach ([
			'/styles/all/template/ucp_noties.html',
			'/styles/FLATBOOTS/template/ucp_noties.html',
		] as $template_path)
		{
			$template = file_get_contents($this->root() . $template_path);
			$this->assertStringContainsString('{{ S_FORM_TOKEN }}', $template, $template_path);
			$this->assertStringContainsString('name="form_time"', $template, $template_path);
		}
	}

	private function module_source(): string
	{
		return file_get_contents($this->root() . '/ucp/noties_module.php');
	}

	private function root(): string
	{
		return dirname(__DIR__);
	}
}
