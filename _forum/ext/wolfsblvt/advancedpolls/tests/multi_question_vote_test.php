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
use wolfsblvt\advancedpolls\core\multi_question_vote;
use wolfsblvt\advancedpolls\core\poll_options;

class multi_question_vote_test extends TestCase
{
	private $questions = array(
		array('id' => 'primary', 'required' => true, 'option_ids' => array(1, 2, 3)),
		array('id' => '7', 'required' => false, 'option_ids' => array(10, 11, 12)),
	);

	public function test_optional_question_may_be_skipped_but_required_question_may_not()
	{
		$rules = $this->rules(poll_options::TYPE_CHOICE);
		$result = multi_question_vote::validate($this->questions, array('primary' => array(1 => 1)), $rules);
		$this->assertFalse($result['error']);
		$this->assertSame(array(), $result['answers']['7']);

		$result = multi_question_vote::validate($this->questions, array('7' => array(10 => 1)), $rules);
		$this->assertSame('AP_REQUIRED_QUESTION_MISSING', $result['error']);

		$result = multi_question_vote::validate($this->questions, array('primary' => array(1 => 2)), $rules);
		$this->assertSame('FORM_INVALID', $result['error']);
	}

	public function test_scoring_limits_are_applied_separately_to_every_question()
	{
		$rules = $this->rules(poll_options::TYPE_SCORING);
		$rules['max_options'] = 2;
		$rules['max_value'] = 3;
		$rules['total_value'] = 4;
		$result = multi_question_vote::validate($this->questions, array(
			'primary' => array(1 => 3, 2 => 1),
			'7' => array(10 => 3, 11 => 1),
		), $rules);
		$this->assertFalse($result['error']);

		$result = multi_question_vote::validate($this->questions, array(
			'primary' => array(1 => 2, 2 => 1, 3 => 1),
		), $rules);
		$this->assertSame('TOO_MANY_VOTE_OPTIONS', $result['error']);
	}

	public function test_ranking_requires_the_point_pattern_on_each_answered_page()
	{
		$rules = $this->rules(poll_options::TYPE_RANKING);
		$rules['max_options'] = 3;
		$rules['rank_points'] = array(5, 3, 1);
		$result = multi_question_vote::validate($this->questions, array(
			'primary' => array(1 => 5, 2 => 3, 3 => 1),
			'7' => array(10 => 5, 11 => 3, 12 => 1),
		), $rules);
		$this->assertFalse($result['error']);

		$result = multi_question_vote::validate($this->questions, array(
			'primary' => array(1 => 5, 2 => 3),
		), $rules);
		$this->assertSame('AP_RANK_SELECTION_INCOMPLETE', $result['error']);
	}

	public function test_completed_no_change_ballot_cannot_be_repeated_even_if_empty()
	{
		$questions = array(
			array('id' => 'primary', 'required' => false, 'option_ids' => array(1, 2)),
		);
		$current = array('_completed' => true, 'primary' => array());
		$result = multi_question_vote::validate($questions, array(), $this->rules(poll_options::TYPE_CHOICE), $current);
		$this->assertSame('AP_VOTE_CHANGED', $result['error']);
	}

	public function test_incremental_mode_cannot_remove_an_optional_answer()
	{
		$rules = $this->rules(poll_options::TYPE_CHOICE);
		$rules['vote_mode'] = poll_options::VOTE_MODE_INCREMENTAL;
		$current = array('primary' => array(1 => 1), '7' => array(10 => 1));
		$result = multi_question_vote::validate($this->questions, array(
			'primary' => array(1 => 1),
			'7' => array(),
		), $rules, $current);
		$this->assertSame('AP_VOTE_CHANGED', $result['error']);
	}

	public function test_unknown_questions_and_non_integer_scores_are_rejected()
	{
		$rules = $this->rules(poll_options::TYPE_SCORING);
		$result = multi_question_vote::validate($this->questions, array(
			'primary' => array(1 => 2),
			'unknown' => array(10 => 2),
		), $rules);
		$this->assertSame('FORM_INVALID', $result['error']);

		$result = multi_question_vote::validate($this->questions, array(
			'primary' => array(1 => '2'),
		), $rules);
		$this->assertSame('FORM_INVALID', $result['error']);

		$result = multi_question_vote::validate($this->questions, array(
			'primary' => array(1 => 2),
			'7' => 'not-an-answer-map',
		), $rules);
		$this->assertSame('FORM_INVALID', $result['error']);

		$result = multi_question_vote::validate($this->questions, array(
			'primary' => array('01' => 2, 1 => 3),
		), $rules);
		$this->assertSame('FORM_INVALID', $result['error']);
	}

	public function test_incremental_capacity_is_calculated_per_question()
	{
		$rules = $this->rules(poll_options::TYPE_CHOICE);
		$rules['vote_mode'] = poll_options::VOTE_MODE_INCREMENTAL;
		$this->assertTrue(multi_question_vote::can_add_votes($this->questions, array(
			'primary' => array(1 => 1, 2 => 1),
			'7' => array(10 => 1),
		), $rules));
		$this->assertFalse(multi_question_vote::can_add_votes($this->questions, array(
			'primary' => array(1 => 1, 2 => 1),
			'7' => array(10 => 1, 11 => 1),
		), $rules));

		$rules = $this->rules(poll_options::TYPE_SCORING);
		$rules['total_value'] = 4;
		$this->assertTrue(multi_question_vote::can_add_votes($this->questions, array(
			'primary' => array(1 => 3, 2 => 1),
			'7' => array(10 => 2),
		), $rules));
		$this->assertFalse(multi_question_vote::can_add_votes($this->questions, array(
			'primary' => array(1 => 3, 2 => 1),
			'7' => array(10 => 3, 11 => 1),
		), $rules));
	}

	public function test_unanswered_optional_ranking_page_remains_available_incrementally()
	{
		$rules = $this->rules(poll_options::TYPE_RANKING);
		$rules['vote_mode'] = poll_options::VOTE_MODE_INCREMENTAL;
		$rules['max_options'] = 2;
		$this->assertTrue(multi_question_vote::can_add_votes($this->questions, array(
			'primary' => array(1 => 3, 2 => 1),
			'7' => array(),
		), $rules));
		$this->assertFalse(multi_question_vote::can_add_votes($this->questions, array(
			'primary' => array(1 => 3, 2 => 1),
			'7' => array(10 => 3, 11 => 1),
		), $rules));
	}

	private function rules($type)
	{
		return array(
			'type' => $type,
			'vote_mode' => poll_options::VOTE_MODE_NO_CHANGE,
			'max_options' => 2,
			'min_value' => 1,
			'max_value' => 3,
			'total_value' => 5,
			'rank_points' => array(),
		);
	}
}
