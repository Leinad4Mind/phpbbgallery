<?php
/**
 * phpBB Gallery - Favorite privacy tests
 *
 * @package   phpbbgallery/favorite
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\favorite\tests;

use PHPUnit\Framework\TestCase;

final class privacy_test extends TestCase
{
	public function test_favorite_rows_use_the_core_contest_identity_policy(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/ucp/main_module.php');

		$this->assertStringContainsString('contest::hides_private_data(', $source);
		$this->assertStringContainsString('$hide_contest_private_data', $source);
		$this->assertStringContainsString('CONTEST_USERNAME', $source);
	}
}
