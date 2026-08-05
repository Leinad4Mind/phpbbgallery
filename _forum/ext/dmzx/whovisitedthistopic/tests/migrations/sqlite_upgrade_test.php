<?php
/**
 *
 * @package phpBB Extension - Who Visited This Topic
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

namespace dmzx\whovisitedthistopic\tests\migrations;

use dmzx\whovisitedthistopic\core\visit_repository;
use dmzx\whovisitedthistopic\migrations\whovisitedthistopic_1_1_0_data;
use phpbb\config\config;
use phpbb\db\driver\sqlite3;
use phpbb\db\tools\tools;
use PHPUnit\Framework\TestCase;

class sqlite_upgrade_test extends TestCase
{
	public function test_legacy_data_is_upgraded_in_a_disposable_database()
	{
		if (!class_exists('SQLite3'))
		{
			self::markTestSkipped('SQLite3 is not available.');
		}

		$db = new sqlite3();
		self::assertTrue($db->sql_connect(':memory:', '', '', ''));
		$db->sql_query('CREATE TABLE phpbb_users (user_id INTEGER PRIMARY KEY)');
		$db->sql_query('CREATE TABLE phpbb_topics (topic_id INTEGER PRIMARY KEY)');
		$db->sql_query('CREATE TABLE phpbb_whovisitedthistopic (
			count_id INTEGER PRIMARY KEY AUTOINCREMENT,
			counter_user INTEGER NOT NULL,
			user_id INTEGER NOT NULL,
			topic_id INTEGER NOT NULL,
			date INTEGER NOT NULL
		)');
		$db->sql_query('INSERT INTO phpbb_users (user_id) VALUES (2)');
		$db->sql_query('INSERT INTO phpbb_topics (topic_id) VALUES (10)');
		$db->sql_query('INSERT INTO phpbb_whovisitedthistopic (counter_user, user_id, topic_id, date) VALUES
			(2, 2, 10, 100), (3, 2, 10, 200), (1, 999, 10, 300), (1, 2, 999, 400)');

		$db_tools = new tools($db);
		$migration = new whovisitedthistopic_1_1_0_data(new config([]), $db, $db_tools, '', 'php', 'phpbb_');
		$migration->remove_orphans();
		$state = 0;
		do
		{
			$state = $migration->deduplicate_visits($state);
		}
		while ($state !== null);

		$db_tools->sql_create_unique_index('phpbb_whovisitedthistopic', 'user_topic', ['user_id', 'topic_id']);
		$db_tools->sql_create_index('phpbb_whovisitedthistopic', 'topic_date', ['topic_id', 'date']);
		$db_tools->sql_create_index('phpbb_whovisitedthistopic', 'user_date', ['user_id', 'date']);

		$repository = new visit_repository($db, 'phpbb_whovisitedthistopic');
		$repository->record(2, 10, 500);
		$result = $db->sql_query('SELECT COUNT(*) AS rows, counter_user, date FROM phpbb_whovisitedthistopic WHERE user_id = 2 AND topic_id = 10');
		$row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		self::assertSame(1, (int) $row['rows']);
		self::assertSame(6, (int) $row['counter_user']);
		self::assertSame(500, (int) $row['date']);
		self::assertTrue($db_tools->sql_index_exists('phpbb_whovisitedthistopic', 'user_topic'));
		$db->sql_close();
	}
}
