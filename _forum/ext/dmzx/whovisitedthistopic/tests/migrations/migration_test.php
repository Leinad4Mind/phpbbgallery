<?php
/**
 *
 * @package phpBB Extension - Who Visited This Topic
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

namespace dmzx\whovisitedthistopic\tests\migrations;

use dmzx\whovisitedthistopic\migrations\whovisitedthistopic_1_1_0_data;
use dmzx\whovisitedthistopic\migrations\whovisitedthistopic_1_1_0_schema;
use phpbb\config\config;
use phpbb\db\driver\driver_interface;
use phpbb\db\tools\tools_interface;
use PHPUnit\Framework\TestCase;

class migration_test extends TestCase
{
	public function test_duplicate_rows_are_merged_before_schema_constraint()
	{
		$db = $this->createMock(driver_interface::class);
		$db->expects(self::once())->method('sql_query_limit')->with(self::stringContains('GROUP BY user_id, topic_id'), 250)->willReturn(77);
		$db->expects(self::exactly(2))->method('sql_fetchrow')->with(77)->willReturnOnConsecutiveCalls([
			'user_id' => 5,
			'topic_id' => 10,
			'keep_id' => 2,
			'visit_count' => 9,
			'last_visit' => 500,
			'row_count' => 3,
		], false);
		$db->expects(self::once())->method('sql_build_array')->with('UPDATE', ['counter_user' => 9, 'date' => 500])->willReturn('counter_user = 9, date = 500');
		$queries = [];
		$db->expects(self::exactly(2))->method('sql_query')->willReturnCallback(function ($sql) use (&$queries) {
			$queries[] = $sql;
		});
		$db->expects(self::once())->method('sql_freeresult')->with(77);

		$migration = new whovisitedthistopic_1_1_0_data(new config([]), $db, $this->createMock(tools_interface::class), '', 'php', 'phpbb_');
		self::assertNull($migration->deduplicate_visits(0));
		self::assertStringContainsString('WHERE count_id = 2', $queries[0]);
		self::assertStringContainsString('AND count_id <> 2', $queries[1]);
	}

	public function test_unique_and_lookup_indexes_are_declared()
	{
		$migration = new whovisitedthistopic_1_1_0_schema(new config([]), $this->createMock(driver_interface::class), $this->createMock(tools_interface::class), '', 'php', 'phpbb_');
		$schema = $migration->update_schema();

		self::assertSame(['user_id', 'topic_id'], $schema['add_unique_index']['phpbb_whovisitedthistopic']['user_topic']);
		self::assertArrayHasKey('topic_date', $schema['add_index']['phpbb_whovisitedthistopic']);
		self::assertArrayHasKey('user_date', $schema['add_index']['phpbb_whovisitedthistopic']);
	}
}
