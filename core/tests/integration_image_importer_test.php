<?php
/**
 * phpBB Gallery - Integration image importer tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\album\album;
use phpbbgallery\core\auth\auth;
use phpbbgallery\core\config;
use phpbbgallery\core\image\image;
use phpbbgallery\core\integration\image_import_exception;
use phpbbgallery\core\integration\image_import_request;
use phpbbgallery\core\integration\image_importer;
use phpbbgallery\core\integration\image_importer_interface;
use phpbbgallery\core\policy\album_operation;
use phpbbgallery\core\upload;
use PHPUnit\Framework\TestCase;

final class integration_image_importer_test extends TestCase
{
	public function test_request_normalises_the_untrusted_original_filename(): void
	{
		$request = new image_import_request(
			'leinad4mind/mediatopicsgallery',
			'C:/private/poster.tmp',
			'../provider/poster.jpg',
			12,
			'Localized poster'
		);

		$this->assertSame('poster.jpg', $request->get_original_filename());
		$this->assertSame(12, $request->get_album_id());
	}

	public function test_request_rejects_a_non_extension_integration_identifier(): void
	{
		$this->expectException(\InvalidArgumentException::class);

		new image_import_request('Media Topics', 'poster.tmp', 'poster.jpg', 12, 'Poster');
	}

	public function test_capabilities_make_remote_fetch_and_file_ownership_explicit(): void
	{
		$importer = (new \ReflectionClass(image_importer::class))->newInstanceWithoutConstructor();
		$capabilities = $importer->get_capabilities();

		$this->assertSame(image_importer_interface::CONTRACT_VERSION, $capabilities['contract_version']);
		$this->assertSame(['local_file'], $capabilities['source_types']);
		$this->assertFalse($capabilities['remote_fetch']);
		$this->assertSame('transferred', $capabilities['source_ownership']);
		$this->assertContains('phpbbgallery.core.integration.image_imported', $capabilities['events']);
	}

	public function test_service_is_public_and_policy_runs_before_file_ownership_transfer(): void
	{
		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services.yml');
		$source = (string) file_get_contents(dirname(__DIR__) . '/integration/image_importer.php');
		$authorisation = strpos($source, '$this->assert_authorised(');
		$quota = strpos($source, '$this->assert_quota_available(');
		$upload = strpos($source, '$this->upload->upload_local_file(');

		$this->assertStringContainsString('phpbbgallery.core.integration.image_importer:', $services);
		$this->assertStringContainsString('class: phpbbgallery\\core\\integration\\image_importer', $services);
		$this->assertStringContainsString('public: true', $services);
		$this->assertNotFalse($authorisation);
		$this->assertNotFalse($quota);
		$this->assertNotFalse($upload);
		$this->assertLessThan($upload, $authorisation);
		$this->assertLessThan($upload, $quota);
	}

	public function test_successful_import_enforces_policy_and_synchronises_gallery_state(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())->method('sql_query')->willReturn(1);
		$db->expects($this->once())->method('sql_fetchfield')->with('image_count')->willReturn(0);
		$db->expects($this->once())->method('sql_freeresult')->with(1);

		$user = $this->createMock(\phpbb\user::class);
		$user->data = [
			'user_id' => 42,
			'username' => 'Importer',
			'user_colour' => 'AABBCC',
		];
		$dispatcher = $this->createMock(\phpbb\event\dispatcher_interface::class);
		$events = [];
		$dispatcher->expects($this->exactly(2))
			->method('trigger_event')
			->willReturnCallback(static function (string $event_name, array $data) use (&$events): array {
				$events[] = $event_name;
				return $data;
			});

		$gallery_auth = $this->createMock(auth::class);
		$gallery_auth->expects($this->once())->method('load_user_permissions')->with(42);
		$gallery_auth->method('acl_check')->willReturnMap([
			['i_upload', 12, 0, true],
			['i_unlimited', 12, 0, true],
			['i_count', 12, 0, 50],
			['i_approve', 12, 0, true],
		]);

		$album_data = [
			'album_id' => 12,
			'album_user_id' => 0,
			'album_status' => 0,
			'album_type' => 1,
		];
		$album = $this->createMock(album::class);
		$album->expects($this->once())->method('get_info')->with(12, false)->willReturn($album_data);
		$album->expects($this->once())->method('update_info')->with(12)->willReturn([]);

		$album_operation = $this->createMock(album_operation::class);
		$album_operation->expects($this->once())->method('allows')->with('upload', $album_data)->willReturn(true);
		$config = $this->createMock(config::class);
		$config->method('get')->willReturnMap([
			['description_length', null, 2000],
			['num_uploads', null, 10],
			['album_images', null, 2500],
		]);

		$upload = $this->createMock(upload::class);
		$upload->image_data = [77 => [
			'image_id' => 77,
			'image_album_id' => 12,
			'image_user_id' => 42,
			'image_status' => 1,
		]];
		$upload->expects($this->once())->method('reset_operation');
		$upload->expects($this->once())->method('set_up')->with(12, 1, false);
		$upload->expects($this->once())->method('set_operation_context')->with('integration', [
			'integration_name' => 'leinad4mind/mediatopicsgallery',
			'context' => ['operation_id' => 'poster-123'],
		]);
		$upload->expects($this->once())->method('set_author')->with(42, 'Importer', 'AABBCC');
		$upload->expects($this->once())->method('upload_local_file')->with('C:/private/poster.tmp', 'poster.jpg')->willReturn(77);
		$upload->expects($this->once())->method('update_image')->with(77, false, $album_data)->willReturn(true);
		$upload->expects($this->never())->method('discard_uploaded_images');

		$image = $this->createMock(image::class);
		$image->expects($this->once())->method('handle_counter')->with([77], true);
		$importer = new image_importer(
			$db,
			$user,
			$dispatcher,
			$gallery_auth,
			$album,
			$album_operation,
			$config,
			$upload,
			$image,
			'gallery_images',
			'users'
		);
		$request = new image_import_request(
			'leinad4mind/mediatopicsgallery',
			'C:/private/poster.tmp',
			'poster.jpg',
			12,
			'Localized poster',
			'Provider attribution',
			'pt-PT',
			false,
			42,
			['operation_id' => 'poster-123']
		);

		$result = $importer->import($request);

		$this->assertSame(77, $result->get_image_id());
		$this->assertSame(42, $result->get_actor_user_id());
		$this->assertSame(['operation_id' => 'poster-123'], $result->get_context());
		$this->assertSame([
			'phpbbgallery.core.integration.import_image_validate',
			'phpbbgallery.core.integration.image_imported',
		], $events);
	}

	public function test_post_processing_failure_returns_the_durable_image_reference(): void
	{
		$db = $this->createStub(\phpbb\db\driver\driver_interface::class);
		$db->method('sql_query')->willReturn(1);
		$db->method('sql_fetchfield')->willReturn(0);
		$user = $this->createStub(\phpbb\user::class);
		$user->data = [
			'user_id' => 42,
			'username' => 'Importer',
			'user_colour' => 'AABBCC',
		];
		$dispatcher = $this->createStub(\phpbb\event\dispatcher_interface::class);
		$dispatcher->method('trigger_event')->willReturnCallback(
			static function (string $event_name, array $data): array {
				if ($event_name === 'phpbbgallery.core.integration.image_imported')
				{
					throw new \RuntimeException('Listener failed after persistence.');
				}

				return $data;
			}
		);
		$gallery_auth = $this->createStub(auth::class);
		$gallery_auth->method('acl_check')->willReturnCallback(
			static fn(string $permission): bool|int => $permission === 'i_count' ? 50 : true
		);
		$album_data = [
			'album_id' => 12,
			'album_user_id' => 0,
			'album_status' => 0,
			'album_type' => 1,
		];
		$album = $this->createStub(album::class);
		$album->method('get_info')->willReturn($album_data);
		$album->method('update_info')->willReturn([]);
		$album_operation = $this->createStub(album_operation::class);
		$album_operation->method('allows')->willReturn(true);
		$config = $this->createStub(config::class);
		$config->method('get')->willReturnCallback(
			static fn(string $key): int => [
				'description_length' => 2000,
				'num_uploads' => 10,
				'album_images' => 2500,
			][$key] ?? 0
		);
		$upload = $this->createMock(upload::class);
		$upload->image_data = [88 => [
			'image_id' => 88,
			'image_album_id' => 12,
			'image_user_id' => 42,
			'image_status' => 1,
		]];
		$upload->method('upload_local_file')->willReturn(88);
		$upload->method('update_image')->willReturn(true);
		$upload->expects($this->never())->method('discard_uploaded_images');
		$image = $this->createStub(image::class);
		$importer = new image_importer(
			$db,
			$user,
			$dispatcher,
			$gallery_auth,
			$album,
			$album_operation,
			$config,
			$upload,
			$image,
			'gallery_images',
			'users'
		);
		$request = new image_import_request(
			'leinad4mind/mediatopicsgallery',
			'C:/private/poster.tmp',
			'poster.jpg',
			12,
			'Localized poster',
			'',
			'',
			false,
			42,
			['operation_id' => 'poster-456']
		);

		try
		{
			$importer->import($request);
			$this->fail('The post-processing listener failure was not reported.');
		}
		catch (image_import_exception $exception)
		{
			$this->assertSame(image_import_exception::POST_PROCESSING_FAILED, $exception->get_reason());
			$this->assertNotNull($exception->get_import_result());
			$this->assertSame(88, $exception->get_import_result()->get_image_id());
			$this->assertSame(['operation_id' => 'poster-456'], $exception->get_import_result()->get_context());
		}
	}
}
