<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @copyright 2014 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\tests\core;

require_once __DIR__ . '/../../core/migrations/release_3_2_1_1.php';
require_once __DIR__ . '/../../core/migrations/release_3_3_0.php';
require_once __DIR__ . '/../../core/migrations/release_3_4_0.php';
require_once __DIR__ . '/../../core/migrations/remove_gallery_version.php';

class migration_order_test extends \phpbb_test_case
{
	public function test_version_migrations_are_ordered_before_version_removal()
	{
		$this->assertSame(
			array(
				'\phpbbgallery\core\migrations\release_1_2_0_db_create',
				'\phpbbgallery\core\migrations\release_3_2_1_0',
			),
			\phpbbgallery\core\migrations\release_3_2_1_1::depends_on()
		);
		$this->assertSame(
			array('\phpbbgallery\core\migrations\release_3_2_1_1'),
			\phpbbgallery\core\migrations\release_3_3_0::depends_on()
		);
		$this->assertSame(
			array('\phpbbgallery\core\migrations\release_3_3_0'),
			\phpbbgallery\core\migrations\release_3_4_0::depends_on()
		);
		$this->assertSame(
			array('\phpbbgallery\core\migrations\release_3_4_0'),
			\phpbbgallery\core\migrations\remove_gallery_version::depends_on()
		);
	}
}
