<?php
/**
 * phpBB Gallery - Reusable image block contest privacy tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\block;
use phpbbgallery\core\image\image;
use PHPUnit\Framework\TestCase;

final class image_block_contest_privacy_test extends TestCase
{
	public function test_active_contest_block_hides_identity_ratings_comments_and_ip(): void
	{
		$reflection = new \ReflectionClass(image::class);
		$service = $reflection->newInstanceWithoutConstructor();
		$assigned = [];
		$template = $this->createMock(\phpbb\template\template::class);
		$template->expects($this->once())
			->method('assign_block_vars')
			->with('recent', $this->callback(function (array $row) use (&$assigned): bool
			{
				$assigned = $row;
				return true;
			}));
		$gallery_auth = $this->createStub(\phpbbgallery\core\auth\auth::class);
		$gallery_auth->method('acl_check')->willReturn(false);
		$helper = $this->createStub(\phpbb\controller\helper::class);
		$helper->method('route')->willReturnCallback(static function (string $route): string
		{
			return $route;
		});
		$gallery_config = $this->createStub(\phpbbgallery\core\config::class);
		$gallery_config->method('get')->willReturn(true);
		$image_visibility = $this->createStub(\phpbbgallery\core\policy\image_visibility::class);
		$image_visibility->method('hides_private_data')->willReturn(true);
		$image_visibility->method('private_data_label')->willReturn('Contest');
		$image_visibility->method('hides_results')->willReturn(true);
		$language = $this->createStub(\phpbb\language\language::class);
		$language->method('lang')->willReturnCallback(static function (string $key): string
		{
			return $key === 'GALLERY_PRIVATE_USER' ? 'Hidden user' : $key;
		});
		$user = new \phpbb\user();
		$user->data = ['user_id' => 8];

		foreach ([
			'template' => $template,
			'gallery_auth' => $gallery_auth,
			'helper' => $helper,
			'gallery_config' => $gallery_config,
			'image_visibility' => $image_visibility,
			'language' => $language,
			'user' => $user,
		] as $property => $value)
		{
			$reflection->getProperty($property)->setValue($service, $value);
		}

		$service->assign_block('recent', [
			'image_id' => 12,
			'image_album_id' => 4,
			'album_id' => 4,
			'album_user_id' => 0,
			'album_name' => 'Contest album',
			'image_name' => 'Entry',
			'image_view_count' => 10,
			'image_status' => block::STATUS_APPROVED,
			'image_reported' => 0,
			'image_user_id' => 7,
			'image_username' => 'Entrant',
			'image_user_colour' => 'abcdef',
			'image_time' => 100,
			'image_contest' => block::IN_CONTEST,
			'image_rates' => 4,
			'image_rate_avg' => 450,
			'image_comments' => 3,
			'image_user_ip' => '192.0.2.1',
		], image::IMAGE_SHOW_IP | image::IMAGE_SHOW_RATINGS | image::IMAGE_SHOW_USERNAME | image::IMAGE_SHOW_COMMENTS);

		$this->assertSame('Contest', $assigned['POSTER']);
		$this->assertFalse($assigned['S_RATINGS']);
		$this->assertFalse($assigned['U_RATINGS']);
		$this->assertFalse($assigned['L_COMMENTS']);
		$this->assertFalse($assigned['S_COMMENTS']);
		$this->assertFalse($assigned['U_COMMENTS']);
		$this->assertFalse($assigned['U_USER_IP']);
	}
}
