<?php
/**
 *
 * @package phpBB Extension - Who Visited This Topic
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

namespace dmzx\whovisitedthistopic\tests\core;

use dmzx\whovisitedthistopic\core\visit_repository;
use phpbb\db\driver\driver_interface;
use PHPUnit\Framework\TestCase;

class visit_repository_test extends TestCase
{
	public function test_existing_visit_uses_portable_update_only()
	{
		$db = $this->createMock(driver_interface::class);
		$db->expects(self::once())->method('sql_query')->with(self::callback(function ($sql) {
			return strpos($sql, 'UPDATE phpbb_visits') !== false
				&& strpos($sql, 'ON DUPLICATE KEY') === false;
		}));
		$db->expects(self::once())->method('sql_affectedrows')->willReturn(1);

		$repository = new visit_repository($db, 'phpbb_visits');
		$repository->record(2, 7, 1234);
	}

	public function test_new_visit_falls_back_to_insert()
	{
		$db = $this->createMock(driver_interface::class);
		$db->expects(self::exactly(2))->method('sql_query')->with(self::callback(function ($sql) {
			return strpos($sql, 'ON DUPLICATE KEY') === false;
		}));
		$db->expects(self::once())->method('sql_affectedrows')->willReturn(0);
		$db->expects(self::once())->method('sql_build_array')->with('INSERT', self::isType('array'))->willReturn('(counter_user) VALUES (1)');
		$error_modes = [];
		$db->expects(self::exactly(2))->method('sql_return_on_error')->willReturnCallback(function ($mode) use (&$error_modes) {
			$error_modes[] = $mode;
		});
		$db->expects(self::once())->method('get_sql_error_triggered')->willReturn(false);

		$repository = new visit_repository($db, 'phpbb_visits');
		$repository->record(2, 7, 1234);
		self::assertSame([true, false], $error_modes);
	}

	public function test_invalid_identifiers_are_ignored()
	{
		$db = $this->createMock(driver_interface::class);
		$db->expects(self::never())->method('sql_query');

		$repository = new visit_repository($db, 'phpbb_visits');
		$repository->record(0, 7, 1234);
		$repository->record(2, 0, 1234);
	}
}
