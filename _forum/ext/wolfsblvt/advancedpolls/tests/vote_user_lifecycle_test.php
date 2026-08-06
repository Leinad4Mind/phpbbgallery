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
use wolfsblvt\advancedpolls\core\vote_user_lifecycle;

class vote_user_lifecycle_test extends TestCase
{
	public function test_retaining_posts_keeps_unlinked_usernames_on_votes()
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->method('sql_escape')->willReturnCallback(function ($value) {
			return str_replace("'", "''", $value);
		});
		$db->expects($this->exactly(2))
			->method('sql_in_set')
			->with('vote_user_id', array(7, 9))
			->willReturn('vote_user_id IN (7, 9)');
		$db->expects($this->exactly(2))
			->method('sql_query')
			->with($this->callback(function ($sql) {
				return (strpos($sql, 'SET wolfsblvt_vote_user_name = CASE vote_user_id') !== false
					|| strpos($sql, 'SET vote_user_name = CASE vote_user_id') !== false)
					&& strpos($sql, "WHEN 7 THEN 'Former member'") !== false
					&& strpos($sql, "WHEN 9 THEN 'O''Brien'") !== false
					&& strpos($sql, 'vote_user_id IN (7, 9)') !== false;
			}));

		$lifecycle = new vote_user_lifecycle($db);
		$lifecycle->handle('retain', array(7, 9), 'Former member', array(
			7 => array('username' => 'Former member'),
			9 => array('username' => "O'Brien"),
		));
	}

	public function test_retaining_posts_without_username_does_not_store_a_name()
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->never())->method('sql_query');

		$lifecycle = new vote_user_lifecycle($db);
		$lifecycle->handle('retain', array(7), false, array(7 => array('username' => 'Former member')));
	}

	public function test_removing_posts_removes_votes_and_corrects_weighted_totals()
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->method('sql_in_set')->willReturnCallback(function ($field, $values) {
			return $field . ' IN (' . implode(', ', $values) . ')';
		});
		$queries = array();
		$db->expects($this->exactly(9))
			->method('sql_query')
			->willReturnCallback(function ($sql) use (&$queries) {
				$queries[] = $sql;
				if (strpos($sql, 'SELECT topic_id') !== false)
				{
					return 'removed_votes';
				}
				return strpos($sql, 'SELECT v.question_id') !== false ? 'extra_removed_votes' : true;
			});
		$rows = array(
			'removed_votes' => array(
				array('topic_id' => 12, 'poll_option_id' => 3, 'removed_value' => 1),
				array('topic_id' => 12, 'poll_option_id' => 4, 'removed_value' => 5),
			),
			'extra_removed_votes' => array(
				array('topic_id' => 12, 'question_id' => 6, 'option_id' => 8, 'removed_value' => 3),
			),
		);
		$db->method('sql_fetchrow')->willReturnCallback(function ($resource) use (&$rows) {
			return array_shift($rows[$resource]);
		});
		$db->expects($this->exactly(2))->method('sql_freeresult');

		$lifecycle = new vote_user_lifecycle($db);
		$lifecycle->handle('remove', array(7, 9, 7), true, array());

		$this->assertStringContainsString('vote_user_id IN (7, 9)', $queries[0]);
		$this->assertStringContainsString('poll_option_total - 1', $queries[1]);
		$this->assertStringContainsString('poll_option_id = 3', $queries[1]);
		$this->assertStringContainsString('poll_option_total - 5', $queries[2]);
		$this->assertStringContainsString('poll_option_id = 4', $queries[2]);
		$this->assertStringContainsString('DELETE FROM ' . POLL_VOTES_TABLE, $queries[3]);
		$this->assertStringContainsString('SELECT v.question_id', $queries[4]);
		$this->assertStringContainsString('option_total - 3', $queries[5]);
		$this->assertStringContainsString('DELETE FROM phpbb_advancedpolls_votes', $queries[6]);
		$this->assertStringContainsString('DELETE FROM phpbb_advancedpolls_ballots', $queries[7]);
		$this->assertStringContainsString('topic_id IN (12)', $queries[8]);
	}
}
