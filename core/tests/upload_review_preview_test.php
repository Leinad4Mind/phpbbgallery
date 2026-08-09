<?php
/**
 * phpBB Gallery - Upload review preview tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\image\image;
use PHPUnit\Framework\TestCase;

final class upload_review_preview_test extends TestCase
{
	public function test_pending_upload_uses_a_dedicated_private_preview_route(): void
	{
		$service = (string) file_get_contents(dirname(__DIR__) . '/image/image.php');
		$upload = (string) file_get_contents(dirname(__DIR__) . '/controller/upload.php');
		$routing = (string) file_get_contents(dirname(__DIR__) . '/config/routing.yml');

		$this->assertStringContainsString('function generate_upload_preview_url(', $service);
		$this->assertStringContainsString("'phpbbgallery_core_image_file_upload_preview'", $service);
		$this->assertStringContainsString('generate_upload_preview_url($image_id)', $upload);
		$this->assertStringNotContainsString('generate_review_preview_url($image_id', $upload);
		$this->assertStringContainsString('phpbbgallery_core_image_file_upload_preview:', $routing);
		$this->assertStringContainsString('phpbbgallery.core.controller.file:upload_preview', $routing);
	}

	public function test_published_edit_preview_preserves_source_permissions_and_uses_medium_as_fallback(): void
	{
		$service = (string) file_get_contents(dirname(__DIR__) . '/image/image.php');

		$this->assertStringContainsString('function generate_review_preview_url(', $service);
		$this->assertStringContainsString("acl_check('i_download'", $service);
		$this->assertStringContainsString("acl_check('i_download_free'", $service);
		$this->assertStringContainsString("'phpbbgallery_core_image_file_source'", $service);
		$this->assertStringContainsString("'phpbbgallery_core_image_file_medium'", $service);
	}

	public function test_pending_upload_preview_does_not_consult_download_permissions(): void
	{
		$service = $this->image_service(7, []);

		$this->assertSame(
			'/phpbbgallery_core_image_file_upload_preview/12',
			$service->generate_upload_preview_url(12)
		);
	}

	public function test_pending_preview_is_restricted_to_the_authenticated_orphan_owner(): void
	{
		$reflection = new \ReflectionClass(\phpbbgallery\core\controller\file::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$authorization = $reflection->getMethod('can_preview_pending_upload');
		$user = $this->createMock(\phpbb\user::class);
		$user->data = ['user_id' => 7, 'is_registered' => true];
		$reflection->getProperty('user')->setValue($controller, $user);
		$reflection->getProperty('error')->setValue($controller, '');
		$reflection->getProperty('data')->setValue($controller, [
			'image_user_id' => 7,
			'image_status' => \phpbbgallery\core\block::STATUS_ORPHAN,
		]);

		$this->assertTrue($authorization->invoke($controller));

		$reflection->getProperty('data')->setValue($controller, [
			'image_user_id' => 8,
			'image_status' => \phpbbgallery\core\block::STATUS_ORPHAN,
		]);
		$this->assertFalse($authorization->invoke($controller), 'Another user must not preview the orphan.');

		$reflection->getProperty('data')->setValue($controller, [
			'image_user_id' => 7,
			'image_status' => \phpbbgallery\core\block::STATUS_APPROVED,
		]);
		$this->assertFalse($authorization->invoke($controller), 'Published images must use normal source rules.');

		$user->data['is_registered'] = false;
		$reflection->getProperty('data')->setValue($controller, [
			'image_user_id' => 7,
			'image_status' => \phpbbgallery\core\block::STATUS_ORPHAN,
		]);
		$this->assertFalse($authorization->invoke($controller), 'Guests must never use the pending preview.');
	}

	public function test_pending_preview_bypasses_neither_identity_nor_lifecycle_but_skips_source_accounting(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/file.php');
		$start = strpos($source, 'public function upload_preview(');
		$end = strpos($source, 'public function authorize_source(', $start);
		$this->assertNotFalse($start);
		$this->assertNotFalse($end);
		$method = substr($source, $start, $end - $start);

		$this->assertStringContainsString('can_preview_pending_upload()', $method);
		$this->assertStringContainsString('source_requires_download', $method);
		$this->assertStringNotContainsString("acl_check('i_download'", $method);
		$this->assertStringNotContainsString('phpbbgallery.core.file.source_access', $method);
	}

	public function test_owner_receives_inline_source_and_unsafe_formats_use_medium(): void
	{
		$service = $this->image_service(7, ['i_download' => true]);

		$this->assertSame(
			'/phpbbgallery_core_image_file_source/12',
			$service->generate_review_preview_url(12, 'photo.jpg', 3, 7)
		);
		$this->assertSame(
			'/phpbbgallery_core_image_file_medium/12',
			$service->generate_review_preview_url(12, 'scan.tiff', 3, 7)
		);
	}

	public function test_other_author_requires_free_download_bypass_for_source_preview(): void
	{
		$paid = $this->image_service(9, ['i_download' => true, 'i_download_free' => false]);
		$free = $this->image_service(9, ['i_download' => true, 'i_download_free' => true]);

		$this->assertSame(
			'/phpbbgallery_core_image_file_medium/12',
			$paid->generate_review_preview_url(12, 'photo.webp', 3, 7)
		);
		$this->assertSame(
			'/phpbbgallery_core_image_file_source/12',
			$free->generate_review_preview_url(12, 'photo.webp', 3, 7)
		);
	}

	public function test_all_review_styles_open_the_preview_without_an_empty_legacy_link(): void
	{
		$root = dirname(__DIR__) . '/styles';
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$template = (string) file_get_contents($root . '/' . $style . '/template/gallery/posting_body.html');
			$this->assertStringContainsString('@phpbbgallery_core/js/upload_preview.js', $template, $style);
			$this->assertStringContainsString('data-gallery-upload-preview', $template, $style);
			$this->assertStringContainsString('image.U_IMAGE_PREVIEW', $template, $style);
			$this->assertStringNotContainsString('href="{{ U_IMAGE_ACTION }}"', $template, $style);
		}
	}

	public function test_native_dialog_has_a_normal_link_fallback(): void
	{
		$root = dirname(__DIR__);
		$javascript = (string) file_get_contents($root . '/styles/all/template/js/upload_preview.js');
		$css = (string) file_get_contents($root . '/styles/all/theme/gallery.css');

		$this->assertStringContainsString("typeof window.HTMLDialogElement === 'undefined'", $javascript);
		$this->assertStringContainsString("typeof dialog.showModal !== 'function'", $javascript);
		$this->assertStringContainsString('event.preventDefault();', $javascript);
		$this->assertStringNotContainsString('innerHTML', $javascript);
		$this->assertStringNotContainsString('jQuery', $javascript);
		$this->assertStringContainsString('.gallery-upload-preview-dialog::backdrop', $css);
	}

	private function image_service(int $user_id, array $permissions): image
	{
		$auth = $this->createMock(\phpbbgallery\core\auth\auth::class);
		$auth->method('acl_check')->willReturnCallback(
			static fn (string $permission): bool => (bool) ($permissions[$permission] ?? false)
		);
		$helper = $this->createMock(\phpbb\controller\helper::class);
		$helper->method('route')->willReturnCallback(
			static fn (string $route, array $parameters): string => '/' . $route . '/' . $parameters['image_id']
		);
		$user = $this->createMock(\phpbb\user::class);
		$user->data = ['user_id' => $user_id];
		$service = (new \ReflectionClass(image::class))->newInstanceWithoutConstructor();

		foreach (['gallery_auth' => $auth, 'helper' => $helper, 'user' => $user] as $property => $value)
		{
			(new \ReflectionProperty(image::class, $property))->setValue($service, $value);
		}

		return $service;
	}
}
