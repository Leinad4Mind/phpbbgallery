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
use wolfsblvt\advancedpolls\core\advancedpolls;
use wolfsblvt\advancedpolls\core\poll_options;

class advancedpolls_core_test extends TestCase
{
	public function test_invalid_visibility_or_vote_mode_is_rejected()
	{
		$core = $this->create_core(array(
			'wolfsblvt_poll_visibility' => 99,
			'wolfsblvt_poll_vote_mode' => poll_options::VOTE_MODE_NO_CHANGE,
		));
		$poll = array('poll_max_options' => 1);

		$this->assertSame(array('Invalid form'), $core->check_config_for_polls($poll));
	}

	public function test_scoring_limits_are_validated_and_single_scores_expand_total()
	{
		$request = $this->createMock(\phpbb\request\request::class);
		$request->method('variable')->willReturnCallback(function ($name, $default) {
			$values = array(
				'wolfsblvt_poll_visibility' => poll_options::VISIBILITY_DEFAULT,
				'wolfsblvt_poll_vote_mode' => poll_options::VOTE_MODE_NO_CHANGE,
				'wolfsblvt_poll_max_value' => 1,
				'wolfsblvt_poll_total_value' => 1,
			);
			return isset($values[$name]) ? $values[$name] : $default;
		});
		$request->expects($this->once())
			->method('overwrite')
			->with('wolfsblvt_poll_total_value', 3);
		$core = $this->create_core(array(), array(
			'wolfsblvt.advancedpolls.activate_poll_scoring' => 1,
		), null, $request);
		$poll = array('poll_max_options' => 3);

		$this->assertSame(array(), $core->check_config_for_polls($poll));

		$core = $this->create_core(array(
			'wolfsblvt_poll_visibility' => poll_options::VISIBILITY_DEFAULT,
			'wolfsblvt_poll_vote_mode' => poll_options::VOTE_MODE_NO_CHANGE,
			'wolfsblvt_poll_max_value' => 4,
			'wolfsblvt_poll_total_value' => 3,
		), array('wolfsblvt.advancedpolls.activate_poll_scoring' => 1));
		$poll = array('poll_max_options' => 1);
		$this->assertSame(array('Maximum exceeds total'), $core->check_config_for_polls($poll));
	}

	public function test_save_maps_new_modes_to_legacy_fields_and_rearms_future_notification()
	{
		$future = time() + 3600;
		$core = $this->create_core(array(
			'wolfsblvt_poll_visibility' => poll_options::VISIBILITY_PRIVATE,
			'wolfsblvt_poll_vote_mode' => poll_options::VOTE_MODE_CHANGE,
		));
		$sql_data = array(
			TOPICS_TABLE => array('sql' => array(
				'poll_start' => $future,
				'poll_length' => 86400,
			)),
		);

		$core->save_config_for_polls($sql_data);

		$this->assertSame(poll_options::VISIBILITY_PRIVATE, $sql_data[TOPICS_TABLE]['sql']['wolfsblvt_poll_visibility']);
		$this->assertSame(poll_options::VOTE_MODE_CHANGE, $sql_data[TOPICS_TABLE]['sql']['wolfsblvt_poll_vote_mode']);
		$this->assertSame(1, $sql_data[TOPICS_TABLE]['sql']['wolfsblvt_poll_votes_hide']);
		$this->assertSame(1, $sql_data[TOPICS_TABLE]['sql']['poll_vote_change']);
		$this->assertSame(0, $sql_data[TOPICS_TABLE]['sql']['wolfsblvt_poll_notified']);
	}

	public function test_posting_template_uses_single_visibility_and_vote_mode_controls()
	{
		$core = $this->create_core(array(), array(
			'wolfsblvt.advancedpolls.default_poll_visibility' => poll_options::VISIBILITY_PRIVATE,
			'wolfsblvt.advancedpolls.default_poll_vote_mode' => poll_options::VOTE_MODE_CHANGE,
		));
		$post_data = array(
			'poll_length' => 0,
			'poll_title' => '',
			'poll_options' => array(),
		);
		$page_data = array('S_POLL_VOTE_CHANGE' => true);

		$core->config_for_polls_to_template($post_data, $page_data);

		$this->assertFalse($page_data['S_POLL_VOTE_CHANGE']);
		$this->assertSame(poll_options::VISIBILITY_PRIVATE, $page_data['WOLFSBLVT_POLL_VISIBILITY']);
		$this->assertSame(poll_options::VOTE_MODE_CHANGE, $page_data['WOLFSBLVT_POLL_VOTE_MODE']);
		$this->assertStringContainsString('<option value="3" selected="selected">Private</option>', $page_data['AP_POLL_VISIBILITY_OPTIONS']);
		$this->assertStringContainsString('<option value="2" selected="selected">Change</option>', $page_data['AP_POLL_VOTE_MODE_OPTIONS']);
	}

	public function test_ajax_private_results_are_redacted_without_removing_own_votes()
	{
		$core = $this->create_core(array(), array(), true);
		$topic = $this->topic_data(poll_options::VISIBILITY_PRIVATE, poll_options::VOTE_MODE_CHANGE);
		$data = array(
			'user_votes' => array(4),
			'vote_counts' => array(4 => 7, 5 => 2),
			'total_votes' => 9,
		);

		$core->do_poll_ajax_modifications($topic, $data);

		$this->assertTrue($data['can_vote']);
		$this->assertSame(array(4), $data['user_votes']);
		$this->assertSame(array(4 => 0, 5 => 0), $data['vote_counts']);
		$this->assertSame(0, $data['total_votes']);
		$this->assertTrue($data['results_hidden']);
	}

	public function test_ajax_visibility_and_vote_modes_follow_policy()
	{
		$core = $this->create_core();
		$topic = $this->topic_data(poll_options::VISIBILITY_PUBLIC, poll_options::VOTE_MODE_NO_CHANGE);
		$data = array('user_votes' => array(), 'vote_counts' => array(4 => 7), 'total_votes' => 7);
		$core->do_poll_ajax_modifications($topic, $data);
		$this->assertFalse($data['can_vote']);
		$this->assertSame(7, $data['total_votes']);
		$this->assertArrayNotHasKey('results_hidden', $data);

		$topic = $this->topic_data(poll_options::VISIBILITY_VOTE_COMPLETED, poll_options::VOTE_MODE_INCREMENTAL);
		$data = array('user_votes' => array(4), 'vote_counts' => array(4 => 7), 'total_votes' => 7);
		$core->do_poll_ajax_modifications($topic, $data);
		$this->assertTrue($data['can_vote']);
		$this->assertTrue($data['results_hidden']);

		$data['user_votes'] = array(4, 5);
		$data['vote_counts'] = array(4 => 7, 5 => 3);
		$data['total_votes'] = 10;
		unset($data['results_hidden']);
		$core->do_poll_ajax_modifications($topic, $data);
		$this->assertFalse($data['can_vote']);
		$this->assertSame(10, $data['total_votes']);
		$this->assertArrayNotHasKey('results_hidden', $data);
	}

	public function test_ended_private_poll_releases_ajax_results()
	{
		$core = $this->create_core();
		$topic = $this->topic_data(poll_options::VISIBILITY_PRIVATE, poll_options::VOTE_MODE_NO_CHANGE);
		$topic['poll_start'] = time() - 7200;
		$topic['poll_length'] = 3600;
		$data = array('user_votes' => array(), 'vote_counts' => array(4 => 7), 'total_votes' => 7);

		$core->do_poll_ajax_modifications($topic, $data);

		$this->assertSame(7, $data['total_votes']);
		$this->assertArrayNotHasKey('results_hidden', $data);
	}

	private function topic_data($visibility, $vote_mode)
	{
		return array(
			'forum_id' => 2,
			'poll_max_options' => 2,
			'poll_start' => time() - 60,
			'poll_length' => 86400,
			'wolfsblvt_poll_visibility' => $visibility,
			'wolfsblvt_poll_vote_mode' => $vote_mode,
		);
	}

	private function create_core(array $request_values = array(), array $config_values = array(), $acl = false, $request = null)
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$config = new \phpbb\config\config(array_merge(array(
			'wolfsblvt.advancedpolls.default_poll_visibility' => poll_options::VISIBILITY_DEFAULT,
			'wolfsblvt.advancedpolls.default_poll_vote_mode' => poll_options::VOTE_MODE_NO_CHANGE,
			'wolfsblvt.advancedpolls.activate_poll_scoring' => 0,
			'wolfsblvt.advancedpolls.activate_poll_end' => 0,
		), $config_values));
		$template = $this->createMock(\phpbb\template\template::class);
		$user = $this->createMock(\phpbb\user::class);
		$user->lang = array(
			'FORM_INVALID' => 'Invalid form',
			'AP_POLL_TOTAL_LOWER_MAX_VOTES' => 'Maximum exceeds total',
			'AP_POLL_TOTAL_LOWER_MAX_OPTS' => 'Options exceed total',
			'AP_POLL_END_INVALID' => 'Invalid end',
			'AP_VISIBILITY_PUBLIC' => 'Public',
			'AP_VISIBILITY_DEFAULT' => 'Default',
			'AP_VISIBILITY_VOTE_COMPLETED' => 'Completed',
			'AP_VISIBILITY_PRIVATE' => 'Private',
			'AP_VOTE_MODE_NO_CHANGE' => 'No change',
			'AP_VOTE_MODE_INCREMENTAL' => 'Incremental',
			'AP_VOTE_MODE_CHANGE' => 'Change',
		);
		$auth = $this->createMock(\phpbb\auth\auth::class);
		$auth->method('acl_get')->willReturn((bool) $acl);
		if ($request === null)
		{
			$request = $this->createMock(\phpbb\request\request::class);
			$request->method('variable')->willReturnCallback(function ($name, $default) use ($request_values) {
				return array_key_exists($name, $request_values) ? $request_values[$name] : $default;
			});
		}
		$dispatcher = $this->createMock(\phpbb\event\dispatcher_interface::class);

		return new advancedpolls($db, $config, $template, $user, $auth, $request, $dispatcher);
	}
}
