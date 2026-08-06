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
use wolfsblvt\advancedpolls\core\vote_validator;

class vote_validator_test extends TestCase
{
	public function test_valid_scoring_vote()
	{
		$this->assertFalse(vote_validator::validate_scoring(array(10 => 2, 11 => 1), array(10, 11), 3, 4, false, array()));
	}

	public function test_empty_vote_is_rejected()
	{
		$this->assertSame('NO_VOTE_OPTION', vote_validator::validate_scoring(array(), array(10), 3, 3, false, array()));
	}

	public function test_unknown_option_is_rejected()
	{
		$this->assertSame('FORM_INVALID', vote_validator::validate_scoring(array(99 => 1), array(10), 3, 3, false, array()));
	}

	public function test_negative_and_oversized_values_are_rejected()
	{
		$this->assertSame('AP_VOTE_OUTSIDE_RANGE', vote_validator::validate_scoring(array(10 => -1), array(10), 3, 3, false, array()));
		$this->assertSame('AP_VOTE_OUTSIDE_RANGE', vote_validator::validate_scoring(array(10 => 4), array(10), 3, 4, false, array()));
		$this->assertSame('AP_VOTE_OUTSIDE_RANGE', vote_validator::validate_scoring(array(10 => 1), array(10), 4, 4, false, array(), 2));
	}

	public function test_total_limit_is_enforced()
	{
		$this->assertSame('AP_TOO_MANY_VOTES', vote_validator::validate_scoring(array(10 => 2, 11 => 2), array(10, 11), 3, 3, false, array()));
	}

	public function test_incremental_vote_cannot_reduce_or_remove_existing_values()
	{
		$this->assertSame('AP_VOTE_CHANGED', vote_validator::validate_scoring(array(10 => 1), array(10, 11), 3, 4, false, array(10 => 2)));
		$this->assertSame('AP_VOTE_CHANGED', vote_validator::validate_scoring(array(11 => 1), array(10, 11), 3, 4, false, array(10 => 1)));
	}

	public function test_change_mode_may_reduce_existing_values()
	{
		$this->assertFalse(vote_validator::validate_scoring(array(10 => 1), array(10), 3, 3, true, array(10 => 2)));
	}
}
