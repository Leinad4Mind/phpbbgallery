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
use wolfsblvt\advancedpolls\core\poll_options;

class poll_option_appender_test extends TestCase
{
	public function test_append_validation_preserves_definition_and_collects_only_new_options()
	{
		$appender = $this->create_appender();
		$result = $appender->validate(42, $this->submitted_poll(), $this->submitted_questions(), poll_options::VOTE_MODE_CHANGE);

		$this->assertFalse($result['error']);
		$this->assertSame(array('First', 'Second'), $result['existing_primary']);
		$this->assertSame(array('Third'), $result['primary_additions']);
		$this->assertSame(array(20 => array('Gamma')), $result['additional_additions']);
		$this->assertSame(2, $result['option_count']);
	}

	public function test_append_requires_change_mode_and_an_open_poll()
	{
		$appender = $this->create_appender();
		$result = $appender->validate(42, $this->submitted_poll(), $this->submitted_questions(), poll_options::VOTE_MODE_NO_CHANGE);
		$this->assertSame('AP_APPEND_REQUIRES_CHANGES', $result['error']);

		$state = $this->stored_state();
		$state['topic']['poll_start'] = time() - 3600;
		$state['topic']['poll_length'] = 60;
		$appender->state = $state;
		$result = $appender->validate(42, $this->submitted_poll(), $this->submitted_questions(), poll_options::VOTE_MODE_CHANGE);
		$this->assertSame('AP_APPEND_POLL_ENDED', $result['error']);
	}

	public function test_append_rejects_changes_removals_reordering_and_new_pages()
	{
		$appender = $this->create_appender();
		$poll = $this->submitted_poll();
		$poll['poll_options'][0] = 'Renamed';
		$this->assertSame(
			'AP_APPEND_STRUCTURE_CHANGED',
			$appender->validate(42, $poll, $this->submitted_questions(), poll_options::VOTE_MODE_CHANGE)['error']
		);

		$questions = $this->submitted_questions();
		$questions[0]['options'] = array_reverse($questions[0]['options']);
		$this->assertSame(
			'AP_APPEND_STRUCTURE_CHANGED',
			$appender->validate(42, $this->submitted_poll(), $questions, poll_options::VOTE_MODE_CHANGE)['error']
		);

		$questions = $this->submitted_questions();
		$questions[0]['required'] = false;
		$this->assertSame(
			'AP_APPEND_STRUCTURE_CHANGED',
			$appender->validate(42, $this->submitted_poll(), $questions, poll_options::VOTE_MODE_CHANGE)['error']
		);

		$questions = $this->submitted_questions();
		$questions[] = array(
			'id' => 0,
			'order' => 3,
			'text' => 'New page',
			'required' => false,
			'options' => array(array('id' => 0, 'text' => 'One'), array('id' => 0, 'text' => 'Two')),
		);
		$this->assertSame(
			'AP_APPEND_STRUCTURE_CHANGED',
			$appender->validate(42, $this->submitted_poll(), $questions, poll_options::VOTE_MODE_CHANGE)['error']
		);
	}

	public function test_append_rejects_submission_without_new_options()
	{
		$appender = $this->create_appender();
		$poll = $this->submitted_poll();
		array_pop($poll['poll_options']);
		$questions = $this->submitted_questions();
		array_pop($questions[0]['options']);

		$result = $appender->validate(42, $poll, $questions, poll_options::VOTE_MODE_CHANGE);

		$this->assertSame('AP_APPEND_NONE', $result['error']);
	}

	public function test_commit_inserts_zero_total_options_then_one_revision_notification_and_log()
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$transactions = array();
		$db->expects($this->exactly(2))->method('sql_transaction')
			->willReturnCallback(function ($action) use (&$transactions) {
				$transactions[] = $action;
			});
		$inserts = array();
		$db->expects($this->exactly(2))->method('sql_multi_insert')
			->willReturnCallback(function ($table, $rows) use (&$inserts) {
				$inserts[$table] = $rows;
			});
		$db->expects($this->once())->method('sql_build_array')->with('INSERT', $this->isType('array'))->willReturn('(revision)');
		$db->expects($this->once())->method('sql_query')->with($this->stringContains('phpbb_advancedpolls_revisions'));
		$db->expects($this->once())->method('sql_nextid')->willReturn(91);

		$notifications = $this->createMock(\phpbb\notification\manager::class);
		$notifications->expects($this->once())->method('add_notifications')
			->with('wolfsblvt.advancedpolls.notification.type.optionsadded', $this->callback(function ($data) {
				return $data['revision_id'] === 91 && $data['topic_id'] === 42 && $data['option_count'] === 2;
			}));
		$log = $this->createMock(\phpbb\log\log_interface::class);
		$log->expects($this->once())->method('add')
			->with('mod', 7, '127.0.0.1', 'LOG_AP_POLL_OPTIONS_ADDED', false, $this->callback(function ($data) {
				return $data['forum_id'] === 5 && $data['topic_id'] === 42 && $data[0] === 2;
			}));
		$user = $this->createMock(\phpbb\user::class);
		$user->data = array('user_id' => 7);
		$user->ip = '127.0.0.1';
		$appender = $this->create_appender($db, $notifications, $log, $user);

		$result = $appender->prepare(42, $this->submitted_poll(), $this->submitted_questions(), poll_options::VOTE_MODE_CHANGE);
		$this->assertFalse($result['error']);
		$this->assertTrue($appender->has_pending());
		$appender->commit();

		$this->assertSame(array('begin', 'commit'), $transactions);
		$this->assertFalse($appender->has_pending());
		$this->assertSame(array(
			'poll_option_id' => 3,
			'topic_id' => 42,
			'poll_option_text' => 'Third',
			'poll_option_total' => 0,
		), $inserts[POLL_OPTIONS_TABLE][0]);
		$this->assertSame(array(
			'question_id' => 20,
			'option_order' => 3,
			'option_text' => 'Gamma',
			'option_total' => 0,
		), $inserts['phpbb_advancedpolls_options'][0]);
	}

	public function test_commit_rolls_back_option_inserts_after_a_database_error()
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$transactions = array();
		$db->expects($this->exactly(2))->method('sql_transaction')
			->willReturnCallback(function ($action) use (&$transactions) {
				$transactions[] = $action;
			});
		$db->expects($this->once())->method('sql_multi_insert')
			->willThrowException(new \RuntimeException('insert failed'));
		$notifications = $this->createMock(\phpbb\notification\manager::class);
		$notifications->expects($this->never())->method('add_notifications');
		$log = $this->createMock(\phpbb\log\log_interface::class);
		$log->expects($this->never())->method('add');
		$appender = $this->create_appender($db, $notifications, $log);
		$appender->prepare(42, $this->submitted_poll(), $this->submitted_questions(), poll_options::VOTE_MODE_CHANGE);

		try
		{
			$appender->commit();
			$this->fail('The insert exception should have been propagated.');
		}
		catch (\RuntimeException $exception)
		{
			$this->assertSame('insert failed', $exception->getMessage());
		}

		$this->assertSame(array('begin', 'rollback'), $transactions);
		$this->assertFalse($appender->has_pending());
	}

	public function test_topic_deletion_removes_revision_notifications_and_rows()
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->method('sql_in_set')->with('topic_id', array(42))->willReturn('topic_id IN (42)');
		$queries = array();
		$db->expects($this->exactly(2))->method('sql_query')
			->willReturnCallback(function ($sql) use (&$queries) {
				$queries[] = $sql;
				return count($queries) === 1 ? 'revisions' : true;
			});
		$rows = array(array('revision_id' => 91), array('revision_id' => 92), false);
		$db->method('sql_fetchrow')->with('revisions')->willReturnCallback(function () use (&$rows) {
			return array_shift($rows);
		});
		$db->expects($this->once())->method('sql_freeresult')->with('revisions');
		$notifications = $this->createMock(\phpbb\notification\manager::class);
		$notifications->expects($this->once())->method('delete_notifications')
			->with('wolfsblvt.advancedpolls.notification.type.optionsadded', array(91, 92));
		$appender = $this->create_appender($db, $notifications);

		$appender->delete_topics(array(42, '42', 0));

		$this->assertStringContainsString('SELECT revision_id', $queries[0]);
		$this->assertStringContainsString('DELETE FROM phpbb_advancedpolls_revisions', $queries[1]);
	}

	public function test_global_acp_setting_can_disable_voter_notifications()
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->method('sql_transaction');
		$db->expects($this->exactly(2))->method('sql_multi_insert');
		$db->method('sql_build_array')->willReturn('(revision)');
		$db->expects($this->once())->method('sql_query');
		$db->method('sql_nextid')->willReturn(91);
		$notifications = $this->createMock(\phpbb\notification\manager::class);
		$notifications->expects($this->never())->method('add_notifications');
		$user = $this->createMock(\phpbb\user::class);
		$user->data = array('user_id' => 7);
		$user->ip = '127.0.0.1';
		$appender = $this->create_appender(
			$db,
			$notifications,
			$this->createMock(\phpbb\log\log_interface::class),
			$user,
			0
		);
		$appender->prepare(42, $this->submitted_poll(), $this->submitted_questions(), poll_options::VOTE_MODE_CHANGE);

		$appender->commit();
	}

	private function create_appender($db = null, $notifications = null, $log = null, $user = null, $notifications_enabled = 1)
	{
		$db = $db ?: $this->createMock(\phpbb\db\driver\driver_interface::class);
		$notifications = $notifications ?: $this->createMock(\phpbb\notification\manager::class);
		$log = $log ?: $this->createMock(\phpbb\log\log_interface::class);
		$user = $user ?: $this->createMock(\phpbb\user::class);
		$appender = new testable_poll_option_appender(
			$db,
			new \phpbb\config\config(array(
				'max_poll_options' => 10,
				'wolfsblvt.advancedpolls.activate_notifications' => $notifications_enabled,
			)),
			$notifications,
			$log,
			$user,
			$this->createMock(\wolfsblvt\advancedpolls\core\multi_question_manager::class),
			'phpbb_'
		);
		$appender->state = $this->stored_state();
		return $appender;
	}

	private function stored_state()
	{
		return array(
			'topic' => array(
				'topic_id' => 42,
				'forum_id' => 5,
				'topic_title' => 'Topic',
				'poll_title' => 'Question',
				'poll_start' => time() - 60,
				'poll_length' => 0,
			),
			'primary' => array(
				array('id' => 1, 'text' => 'First'),
				array('id' => 2, 'text' => 'Second'),
			),
			'questions' => array(
				array(
					'id' => 20,
					'order' => 2,
					'text' => 'Second question',
					'required' => true,
					'options' => array(
						array('id' => 30, 'order' => 1, 'text' => 'Alpha', 'total' => 4),
						array('id' => 31, 'order' => 2, 'text' => 'Beta', 'total' => 2),
					),
				),
			),
		);
	}

	private function submitted_poll()
	{
		return array(
			'poll_title' => 'Question',
			'poll_options' => array('First', 'Second', 'Third'),
			'poll_max_options' => 2,
		);
	}

	private function submitted_questions()
	{
		return array(
			array(
				'id' => 20,
				'order' => 2,
				'text' => 'Second question',
				'required' => true,
				'options' => array(
					array('id' => 30, 'text' => 'Alpha'),
					array('id' => 31, 'text' => 'Beta'),
					array('id' => 0, 'text' => 'Gamma'),
				),
			),
		);
	}
}
