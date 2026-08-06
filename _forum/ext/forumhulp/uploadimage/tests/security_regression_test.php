<?php

namespace forumhulp\uploadimage\tests;

use PHPUnit\Framework\TestCase;

class security_regression_test extends TestCase
{
	public function test_mutating_requests_require_csrf_and_post_scope(): void
	{
		$module = $this->read('/acp/uploadimage_module.php');
		$template = $this->read('/adm/style/acp_uploadimage.html');

		$this->assertStringContainsString('check_form_key(self::FORM_KEY)', $module);
		$this->assertGreaterThanOrEqual(2, substr_count($template, '{{ S_FORM_TOKEN }}'));
		$this->assertStringContainsString('request_interface::POST', $module);
		$this->assertStringContainsString("'image_id' => \$image_id", $module);
	}

	public function test_deletion_is_canonicalised_and_confined(): void
	{
		$controller = $this->read('/controller/admin_controller.php');

		$this->assertStringContainsString('$real_path = realpath($path)', $controller);
		$this->assertStringContainsString('is_link($path)', $controller);
		$this->assertStringContainsString('dirname($real_path)', $controller);
		$this->assertStringContainsString('$this->filesystem->remove($real_path)', $controller);
		$this->assertStringNotContainsString('unlink(', $controller);
	}

	public function test_upload_never_overwrites_and_checks_real_content(): void
	{
		$controller = $this->read('/controller/admin_controller.php');

		$this->assertMatchesRegularExpression('/move_file\(\s*[\s\S]*?false,\s*false,/m', $controller);
		$this->assertStringContainsString('valid_image_content($temporary_file, $filename)', $controller);
		$this->assertStringContainsString('getimagesize($path)', $controller);
		$this->assertStringContainsString('filesystem_interface::CHMOD_READ | filesystem_interface::CHMOD_WRITE', $controller);
		$this->assertStringContainsString('sanitise_attachment_data($attachment_data)', $controller);
		$this->assertStringContainsString("'data' => \$attachment_data", $controller);
		$this->assertStringNotContainsString("'data' => [\$entry]", $controller);
		$this->assertStringContainsString("extensions: 'gif,jpg,jpeg,png'", $controller);
	}

	public function test_obsolete_browser_libraries_are_not_shipped(): void
	{
		$root = dirname(__DIR__);
		$template = $this->read('/adm/style/event/acp_overall_footer_after.html');

		$this->assertFileDoesNotExist($root . '/adm/style/js/plupload.full.min.js');
		$this->assertFileDoesNotExist($root . '/adm/style/js/plupload.js');
		$this->assertFileDoesNotExist($root . '/adm/style/js/clipboard.min.js');
		$this->assertStringContainsString('assets/plupload/plupload.full.min.js', $template);
		$this->assertStringContainsString('assets/javascript/plupload.js', $template);
	}

	private function read(string $relative_path): string
	{
		return (string) file_get_contents(dirname(__DIR__) . $relative_path);
	}
}
