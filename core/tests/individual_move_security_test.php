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

class individual_move_security_test extends TestCase
{
	public function test_move_route_only_accepts_get_and_post(): void
	{
		$routing = file_get_contents(dirname(__DIR__) . '/config/routing.yml');
		$route = $this->extract_section($routing, 'phpbbgallery_core_moderate_image_move:', 'phpbbgallery_core_moderate_image_lock:');

		$this->assertStringContainsString('methods: [GET, POST]', $route);
	}

	public function test_move_reads_the_target_only_from_post_and_checks_the_form_key(): void
	{
		$method = $this->move_method();
		$csrf_check = strpos($method, "check_form_key('gallery')");
		$mutation = strpos($method, 'image->move_image(');

		$this->assertStringContainsString("add_form_key('gallery')", $method);
		$this->assertStringContainsString("is_set_post('moving_target')", $method);
		$this->assertStringContainsString('request_interface::POST', $method);
		$this->assertStringNotContainsString("variable('moving_target', '')", $method);
		$this->assertNotFalse($csrf_check);
		$this->assertNotFalse($mutation);
		$this->assertLessThan($mutation, $csrf_check);
	}

	public function test_move_authorizes_the_real_source_and_destination_before_mutation(): void
	{
		$method = $this->move_method();
		$source_check = strpos($method, 'image_authorization->can_moderate_image(');
		$target_check = strpos($method, 'image_authorization->can_moderate_album(');
		$mutation = strpos($method, 'image->move_image(');

		$this->assertNotFalse($source_check);
		$this->assertNotFalse($target_check);
		$this->assertNotFalse($mutation);
		$this->assertSame(2, substr_count($method, "gallery_auth->acl_check('m_move'"));
		$this->assertSame(1, substr_count($method, "gallery_auth->acl_check('i_move'"));
		$this->assertSame(1, substr_count($method, "gallery_auth->acl_check('i_upload'"));
		$this->assertStringContainsString('image_authorization->can_manage_image(', $method);
		$this->assertStringContainsString('ALBUM_LOCKED', $method);
		$this->assertStringContainsString('TYPE_CAT', $method);
		$this->assertStringContainsString('STATUS_ORPHAN', $method);
		$this->assertLessThan($mutation, $source_check);
		$this->assertLessThan($mutation, $target_check);
	}

	public function test_owner_and_moderator_destination_selectors_have_distinct_permissions(): void
	{
		$method = $this->move_method();
		$album = (string) file_get_contents(dirname(__DIR__) . '/album/album.php');

		$this->assertStringContainsString("\$has_owner_source_permission ? 'i_move' : 'm_move'", $method);
		$this->assertStringContainsString("\$requested_permission == 'i_move'", $album);
		$this->assertStringContainsString("\$requested_permission == 'm_move'", $album);
		$this->assertStringContainsString("acl_check('i_upload'", $album);
		$this->assertStringContainsString("acl_check('m_move'", $album);
	}

	public function test_image_page_exposes_move_only_after_owner_or_moderator_authorization(): void
	{
		$controller = (string) file_get_contents(dirname(__DIR__) . '/controller/image.php');

		$this->assertStringContainsString("acl_check('i_move'", $controller);
		$this->assertStringContainsString("acl_check('m_move'", $controller);
		$this->assertStringContainsString("'S_QM_MOVE'    => \$s_allowed_move", $controller);
	}

	public function test_every_move_form_submits_a_phpbb_form_token(): void
	{
		$templates = glob(dirname(__DIR__) . '/styles/*/template/gallery/mcp_body.html');
		$this->assertCount(3, $templates);

		foreach ($templates as $template_path)
		{
			$template = file_get_contents($template_path);
			$mcp_action = str_contains($template, '{{ S_MCP_ACTION }}') ? '{{ S_MCP_ACTION }}' : '{S_MCP_ACTION}';
			$form_token = str_contains($template, '{{ S_FORM_TOKEN }}') ? '{{ S_FORM_TOKEN }}' : '{S_FORM_TOKEN}';
			$form_start = strrpos($template, '<form method="post" id="mcp" action="' . $mcp_action . '">');
			$this->assertNotFalse($form_start);
			$form_end = strpos($template, '</form>', $form_start);
			$this->assertNotFalse($form_end);
			$form = substr($template, $form_start, $form_end - $form_start);

			$this->assertStringContainsString($form_token, $form, $template_path);
		}
	}

	private function move_method(): string
	{
		$controller = file_get_contents(dirname(__DIR__) . '/controller/moderate.php');

		return $this->extract_section($controller, 'public function move(', "\n\t/**");
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
