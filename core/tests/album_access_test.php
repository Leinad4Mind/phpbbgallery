<?php
/**
 * phpBB Gallery accessible-album resolver tests.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\album_access;
use phpbbgallery\core\auth\auth;
use PHPUnit\Framework\TestCase;

final class album_access_test extends TestCase
{
	public function test_service_is_shared_by_the_header_and_unread_counter(): void
	{
		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services.yml');

		$this->assertStringContainsString('phpbbgallery.core.album_access:', $services);
		$this->assertStringContainsString('class: phpbbgallery\core\album_access', $services);
		$this->assertSame(2, substr_count($services, "- '@phpbbgallery.core.album_access'"));
	}

	public function test_resolution_uses_current_identity_excludes_zebra_and_is_cached(): void
	{
		$user = new \phpbb\user();
		$user->data = ['user_id' => 2, 'user_perm_from' => 42];
		$gallery_auth = $this->createMock(auth::class);
		$gallery_auth->expects($this->once())->method('load_user_permissions')->with(2);
		$gallery_auth->expects($this->once())->method('get_exclude_zebra')->willReturn([3, 9]);
		$gallery_auth->expects($this->exactly(2))
			->method('acl_album_ids')
			->willReturnCallback(static fn (string $permission): array => $permission === 'i_view'
				? [2, 3, 4, 4, 0]
				: [4, 6, 9]);
		$access = new album_access($gallery_auth, $user);

		$expected = [
			'viewable' => [2, 4],
			'moderated' => [4, 6],
			'visible' => [2, 4, 6],
		];
		$this->assertSame($expected, $access->resolve());
		$this->assertTrue($access->has_any());
		$this->assertSame($expected, $access->resolve());
	}

	public function test_no_viewable_or_moderated_album_fails_closed(): void
	{
		$user = new \phpbb\user();
		$user->data = ['user_id' => 7];
		$gallery_auth = $this->createMock(auth::class);
		$gallery_auth->method('get_exclude_zebra')->willReturn([11, 12]);
		$gallery_auth->method('acl_album_ids')->willReturnMap([
			['i_view', 'array', false, true, [11]],
			['m_status', 'array', false, true, [12]],
		]);

		$this->assertFalse((new album_access($gallery_auth, $user))->has_any());
	}
}
