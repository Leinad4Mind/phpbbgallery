<?php
/**
 * phpBB Gallery - Message editor selector close behaviour test
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;

final class editor_selector_close_test extends TestCase
{
	public function test_successful_image_insertion_closes_the_selector_dialog(): void
	{
		$javascript = file_get_contents(dirname(__DIR__) . '/styles/all/template/js/editor_selector.js');
		$this->assertIsString($javascript);

		$this->assertMatchesRegularExpression(
			'/textarea\.dispatchEvent\([^;]+;\s*setStatus\([^;]+;\s*closeDialog\(\);/',
			$javascript
		);
	}
}
