<?php
/**
 * phpBB Gallery - navigation and administrator Whois tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;

final class navigation_and_whois_test extends TestCase
{
	public function test_denied_image_login_preserves_the_image_route(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/image.php');

		$this->assertStringContainsString("login_box(\$this->helper->route('phpbbgallery_core_image'", $source);
		$this->assertStringNotContainsString("redirect('gallery/album/'", $source);
		$this->assertStringNotContainsString('@todo Add "redirect after login" url', $source);
	}

	public function test_initial_upload_quota_errors_include_an_album_return_link(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/upload.php');
		$quota_section = substr(
			$source,
			(int) strpos($source, '// Upload Quota Check'),
			(int) strpos($source, 'if ($this->misc->display_captcha', strpos($source, '// Upload Quota Check'))
		);

		$this->assertSame(2, substr_count($quota_section, "lang('CLICK_RETURN_ALBUM'"));
		$this->assertStringNotContainsString('@todo: Add return link', $source);
	}

	public function test_whois_routes_use_server_side_ids_and_require_admin_access(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/image.php');
		$routes = (string) file_get_contents(dirname(__DIR__) . '/config/routing.yml');

		$this->assertStringContainsString("if (!\$this->auth->acl_get('a_'))", $source);
		$this->assertStringContainsString("http_exception(403, 'NOT_AUTHORISED')", $source);
		$this->assertStringContainsString("'phpbbgallery_core_image_whois'", $source);
		$this->assertStringContainsString("'phpbbgallery_core_comment_whois'", $source);
		$this->assertStringContainsString('phpbbgallery_core_image_whois:', $routes);
		$this->assertStringContainsString('phpbbgallery_core_comment_whois:', $routes);
		$this->assertStringNotContainsString('mode=whois&amp;ip=', $source);
	}

	public function test_all_gallery_styles_keep_the_whois_action(): void
	{
		foreach (\gallery_test_existing_styles(dirname(__DIR__)) as $style)
		{
			$template = (string) file_get_contents(dirname(__DIR__) . '/styles/' . $style . '/template/gallery/viewimage_body.html');
			$this->assertStringContainsString('commentrow.U_WHOIS', $template, $style);
		}
	}
}
