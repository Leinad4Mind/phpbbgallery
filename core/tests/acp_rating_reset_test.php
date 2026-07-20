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
use phpbbgallery\core\acp\main_module;

class acp_rating_reset_test extends TestCase
{
	public function test_reset_uses_the_rating_service_for_every_album_image(): void
	{
		$rating = new rating_spy();
		$this->reset_album_ratings($rating, array(12, 34));

		$this->assertSame(array(
			array(array(12, 34), true),
		), $rating->calls);
	}

	public function test_reset_skips_the_rating_service_for_an_empty_album(): void
	{
		$rating = new rating_spy();
		$this->reset_album_ratings($rating, array());

		$this->assertSame(array(), $rating->calls);
	}

	public function test_acp_resolves_the_registered_service_without_the_removed_legacy_class(): void
	{
		$module = file_get_contents(dirname(__DIR__) . '/acp/main_module.php');
		$services = file_get_contents(dirname(__DIR__) . '/config/services.yml');

		$this->assertStringContainsString("get('phpbbgallery.core.rating')", $module);
		$this->assertStringContainsString('$this->reset_album_ratings($phpbb_gallery_rating, $image_ids);', $module);
		$this->assertStringNotContainsString('phpbb_gallery_image_rating', $module);
		$this->assertStringContainsString('phpbbgallery.core.rating:', $services);
		$this->assertStringContainsString('class: phpbbgallery\\core\\rating', $services);
	}

	private function reset_album_ratings($rating, array $image_ids): void
	{
		$module = new main_module();
		$reset = \Closure::bind(function ($service, array $ids): void
		{
			$this->reset_album_ratings($service, $ids);
		}, $module, main_module::class);

		$reset($rating, $image_ids);
	}
}

class rating_spy
{
	/** @var array */
	public $calls = array();

	public function delete_ratings(array $image_ids, $reset_average): void
	{
		$this->calls[] = array($image_ids, $reset_average);
	}
}
