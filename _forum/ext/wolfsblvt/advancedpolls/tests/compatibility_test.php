<?php
/**
 *
 * Advanced Polls tests
 *
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace wolfsblvt\advancedpolls\tests;

use PHPUnit\Framework\TestCase;
use wolfsblvt\advancedpolls\core\compatibility;

class compatibility_test extends TestCase
{
	public function test_php_minimum_boundary()
	{
		$this->assertFalse(compatibility::supports('7.1.2', '3.3.0'));
		$this->assertTrue(compatibility::supports('7.1.3', '3.3.0'));
		$this->assertTrue(compatibility::supports('8.5.0', '3.3.0'));
	}

	public function test_phpbb_supported_line()
	{
		$this->assertFalse(compatibility::supports('8.1.0', '3.2.11'));
		$this->assertTrue(compatibility::supports('8.1.0', '3.3.0'));
		$this->assertTrue(compatibility::supports('8.1.0', '3.3.99'));
	}

	public function test_phpbb_four_is_not_accepted_without_compatibility_work()
	{
		$this->assertFalse(compatibility::supports('8.1.0', '4.0.0-dev'));
		$this->assertFalse(compatibility::supports('8.1.0', '4.0.0-alpha1'));
		$this->assertFalse(compatibility::supports('8.1.0', '4.0.0'));
	}
}
