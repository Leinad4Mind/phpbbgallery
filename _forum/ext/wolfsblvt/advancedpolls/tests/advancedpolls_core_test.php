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
				'wolfsblvt_poll_type' => poll_options::TYPE_SCORING,
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
			'wolfsblvt_poll_type' => poll_options::TYPE_SCORING,
			'wolfsblvt_poll_max_value' => 4,
			'wolfsblvt_poll_total_value' => 3,
		), array('wolfsblvt.advancedpolls.activate_poll_scoring' => 1));
		$poll = array('poll_max_options' => 1);
		$this->assertSame(array('Maximum exceeds total'), $core->check_config_for_polls($poll));
	}

	public function test_ranking_configuration_sets_weighted_limits_and_rejects_incremental_mode()
	{
		$request = $this->createMock(\phpbb\request\request::class);
		$request->method('variable')->willReturnCallback(function ($name, $default) {
			$values = array(
				'wolfsblvt_poll_visibility' => poll_options::VISIBILITY_DEFAULT,
				'wolfsblvt_poll_vote_mode' => poll_options::VOTE_MODE_NO_CHANGE,
				'wolfsblvt_poll_type' => poll_options::TYPE_RANKING,
				'wolfsblvt_poll_rank_points' => array(3, 2, 1),
			);
			return array_key_exists($name, $values) ? $values[$name] : $default;
		});
		$overwrites = array();
		$request->expects($this->exactly(2))->method('overwrite')->willReturnCallback(function ($name, $value) use (&$overwrites) {
			$overwrites[$name] = $value;
		});
		$core = $this->create_core(array(), array('wolfsblvt.advancedpolls.activate_poll_scoring' => 1), null, $request);
		$poll = array('poll_max_options' => 3, 'poll_options' => array('A', 'B', 'C', 'D'));
		$this->assertSame(array(), $core->check_config_for_polls($poll));
		$this->assertSame(array(
			'wolfsblvt_poll_max_value' => 3,
			'wolfsblvt_poll_total_value' => 6,
		), $overwrites);

		$core = $this->create_core(array(
			'wolfsblvt_poll_visibility' => poll_options::VISIBILITY_DEFAULT,
			'wolfsblvt_poll_vote_mode' => poll_options::VOTE_MODE_INCREMENTAL,
			'wolfsblvt_poll_type' => poll_options::TYPE_RANKING,
		), array('wolfsblvt.advancedpolls.activate_poll_scoring' => 1));
		$this->assertSame(array('Ranking cannot be incremental'), $core->check_config_for_polls($poll));
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

	public function test_ranking_configuration_is_serialised_without_storing_frontend_positions()
	{
		$core = $this->create_core(array(
			'wolfsblvt_poll_visibility' => poll_options::VISIBILITY_DEFAULT,
			'wolfsblvt_poll_vote_mode' => poll_options::VOTE_MODE_CHANGE,
			'wolfsblvt_poll_type' => poll_options::TYPE_RANKING,
			'wolfsblvt_poll_rank_points' => array(5, 3, 1),
			'wolfsblvt_poll_max_value' => 5,
			'wolfsblvt_poll_total_value' => 9,
		), array('wolfsblvt.advancedpolls.activate_poll_scoring' => 1));
		$sql_data = array(TOPICS_TABLE => array('sql' => array()));

		$core->save_config_for_polls($sql_data);

		$topic = $sql_data[TOPICS_TABLE]['sql'];
		$this->assertSame(poll_options::TYPE_RANKING, $topic['wolfsblvt_poll_type']);
		$this->assertSame('5,3,1', $topic['wolfsblvt_poll_rank_points']);
		$this->assertSame(5, $topic['wolfsblvt_poll_max_value']);
		$this->assertSame(9, $topic['wolfsblvt_poll_total_value']);
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

	public function test_posting_template_restores_ranking_type_and_point_controls()
	{
		$core = $this->create_core(array(), array('wolfsblvt.advancedpolls.activate_poll_scoring' => 1));
		$post_data = array(
			'poll_length' => 0,
			'poll_title' => 'Rank these',
			'poll_options' => array('A', 'B', 'C'),
			'wolfsblvt_poll_type' => poll_options::TYPE_RANKING,
			'wolfsblvt_poll_max_value' => 3,
			'wolfsblvt_poll_total_value' => 6,
			'wolfsblvt_poll_rank_points' => '3,2,1',
		);
		$page_data = array();

		$core->config_for_polls_to_template($post_data, $page_data);

		$this->assertTrue($page_data['AP_IS_RANKING']);
		$this->assertFalse($page_data['AP_IS_SCORING']);
		$this->assertStringContainsString('<option value="2" selected="selected">Ranking</option>', $page_data['AP_POLL_TYPE_OPTIONS']);
		$this->assertSame(3, substr_count($page_data['AP_RANK_POINT_INPUTS'], 'wolfsblvt_poll_rank_points[]'));
		$this->assertStringContainsString('value="3"', $page_data['AP_RANK_POINT_INPUTS']);
		$this->assertStringContainsString('value="1"', $page_data['AP_RANK_POINT_INPUTS']);
	}

	public function test_ajax_private_results_are_redacted_without_removing_own_votes()
	{
		$core = $this->create_core(array(), array(), true);
		$topic = $this->topic_data(poll_options::VISIBILITY_PRIVATE, poll_options::VOTE_MODE_CHANGE);
		$data = array(
			'user_votes' => array(4),
			'vote_counts' => array(4 => 7, 5 => 2),
			'total_votes' => 9,
			'score_breakdowns' => array(4 => array('total' => '7 votes', 'detail' => 'secret')),
		);

		$core->do_poll_ajax_modifications($topic, $data);

		$this->assertTrue($data['can_vote']);
		$this->assertSame(array(4), $data['user_votes']);
		$this->assertSame(array(4 => 0, 5 => 0), $data['vote_counts']);
		$this->assertSame(0, $data['total_votes']);
		$this->assertArrayNotHasKey('score_breakdowns', $data);
		$this->assertTrue($data['results_hidden']);
	}

	public function test_scoring_distribution_query_and_formatting()
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())
			->method('sql_query')
			->with($this->stringContains('GROUP BY poll_option_id, wolfsblvt_poll_option_value'))
			->willReturn(true);
		$db->method('sql_fetchrow')->willReturnOnConsecutiveCalls(
			array('poll_option_id' => 4, 'score_value' => 1, 'voter_count' => 2),
			array('poll_option_id' => 4, 'score_value' => 2, 'voter_count' => 5),
			array('poll_option_id' => 4, 'score_value' => 3, 'voter_count' => 10),
			false
		);
		$db->expects($this->once())->method('sql_freeresult')->with(true);
		$core = $this->create_core(array(), array(), false, null, $db);

		$load = new \ReflectionMethod($core, 'get_score_distribution');
		$load->setAccessible(true);
		$distribution = $load->invoke($core, 12);
		$this->assertSame(array(4 => array(1 => 2, 2 => 5, 3 => 10)), $distribution);

		$format = new \ReflectionMethod($core, 'format_score_breakdowns');
		$format->setAccessible(true);
		$breakdowns = $format->invoke($core, $distribution, array(4 => 42));
		$this->assertSame('42 votes', $breakdowns[4]['total']);
		$this->assertStringContainsString('2 votes of 1 point', $breakdowns[4]['detail']);
		$this->assertStringContainsString('5 votes of 2 points', $breakdowns[4]['detail']);
		$this->assertStringContainsString('10 votes of 3 points', $breakdowns[4]['detail']);
		$this->assertSame('Vote breakdown', $breakdowns[4]['label']);

		$ranked = $format->invoke($core, $distribution, array(4 => 42), array(3, 2, 1));
		$this->assertSame('42 points', $ranked[4]['total']);
		$this->assertStringContainsString('10 votes in position 1', $ranked[4]['detail']);
		$this->assertStringContainsString('5 votes in position 2', $ranked[4]['detail']);
		$this->assertStringContainsString('2 votes in position 3', $ranked[4]['detail']);
		$this->assertSame('Ranking breakdown', $ranked[4]['label']);
	}

	public function test_missing_voters_use_retained_name_or_deleted_user_fallback()
	{
		$core = $this->create_core();
		$retained_names = new \ReflectionProperty($core, 'retained_voter_names');
		$retained_names->setAccessible(true);
		$retained_names->setValue($core, array(7 => 'Former member'));
		$complete = new \ReflectionMethod($core, 'complete_voter_cache');
		$complete->setAccessible(true);

		$cache = $complete->invoke($core, array(
			7 => null,
			8 => null,
			9 => array('username' => 'Active', 'total_user_votes' => 2),
		));

		$this->assertSame('Former member', $cache[7]['username']);
		$this->assertSame('Deleted user', $cache[8]['username']);
		$this->assertTrue($cache[7]['is_deleted']);
		$this->assertSame(0, $cache[7]['total_user_votes']);
		$this->assertSame(array('username' => 'Active', 'total_user_votes' => 2), $cache[9]);
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

	private function create_core(array $request_values = array(), array $config_values = array(), $acl = false, $request = null, $db = null)
	{
		$db = $db ?: $this->createMock(\phpbb\db\driver\driver_interface::class);
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
			'AP_DELETED_USER' => 'Deleted user',
			'AP_RANK_INCREMENTAL_UNSUPPORTED' => 'Ranking cannot be incremental',
			'AP_RANK_POSITIONS_INVALID' => 'Invalid ranking positions',
			'AP_RANK_POINTS_INCOMPLETE' => 'Incomplete ranking points',
			'AP_RANK_POINTS_INVALID' => 'Invalid ranking points',
			'AP_RANK_POINTS_ORDER' => 'Ranking points out of order',
			'AP_POLL_VALUES_INVALID' => 'Invalid scoring values',
			'AP_POLL_TYPE_CHOICE' => 'Choice',
			'AP_POLL_TYPE_SCORING' => 'Scoring',
			'AP_POLL_TYPE_RANKING' => 'Ranking',
			'AP_SCORE_BREAKDOWN' => 'Vote breakdown',
			'AP_RANK_BREAKDOWN' => 'Ranking breakdown',
			'AP_RANK_POSITION' => 'Position %d',
		);
		$user->method('lang')->willReturnCallback(function ($key) use ($user) {
			$args = func_get_args();
			if ($key === 'AP_SCORE_TOTAL')
			{
				return $args[1] . ($args[1] === 1 ? ' vote' : ' votes');
			}
			if ($key === 'AP_SCORE_DISTRIBUTION_ENTRY')
			{
				return $args[1] . ($args[1] === 1 ? ' vote' : ' votes') . ' of '
					. $args[2] . ($args[2] === 1 ? ' point' : ' points');
			}
			if ($key === 'AP_RANK_TOTAL')
			{
				return $args[1] . ($args[1] === 1 ? ' point' : ' points');
			}
			if ($key === 'AP_RANK_DISTRIBUTION_ENTRY')
			{
				return $args[1] . ($args[1] === 1 ? ' vote' : ' votes') . ' in position ' . $args[2];
			}
			if ($key === 'AP_RANK_POSITION')
			{
				return 'Position ' . $args[1];
			}
			return isset($user->lang[$key]) ? $user->lang[$key] : $key;
		});
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
		$controller_helper = $this->createMock(\phpbb\controller\helper::class);
		$controller_helper->method('route')->willReturn('/app.php/advancedpolls/infopoll/12');

		return new advancedpolls($db, $config, $template, $user, $auth, $request, $dispatcher, $controller_helper);
	}
}
