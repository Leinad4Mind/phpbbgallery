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
use wolfsblvt\advancedpolls\core\ranked_vote;

class ranked_vote_test extends TestCase
{
	public function test_points_are_normalised_from_storage_and_request()
	{
		$this->assertSame(array(5, 3, 1), ranked_vote::normalise_points('5,3,1'));
		$this->assertSame(array(5, 3, 1), ranked_vote::normalise_points(array('5', 3, '1')));
	}

	public function test_configuration_requires_complete_descending_points()
	{
		$this->assertFalse(ranked_vote::validate_configuration(3, array(5, 3, 1), 5));
		$this->assertSame('AP_RANK_POSITIONS_INVALID', ranked_vote::validate_configuration(4, array(5, 3, 2, 1), 3));
		$this->assertSame('AP_RANK_POINTS_INCOMPLETE', ranked_vote::validate_configuration(3, array(5, 3), 5));
		$this->assertSame('AP_RANK_POINTS_INVALID', ranked_vote::validate_configuration(2, array(5, 0), 5));
		$this->assertSame('AP_RANK_POINTS_ORDER', ranked_vote::validate_configuration(3, array(5, 5, 1), 5));
		$this->assertSame('AP_RANK_POINTS_ORDER', ranked_vote::validate_configuration(3, array(1, 2, 3), 5));
	}

	public function test_option_point_map_is_accepted_regardless_of_option_order()
	{
		$this->assertFalse(ranked_vote::validate_vote(
			array(12 => 1, 10 => 2, 14 => 3),
			array(10, 11, 12, 13, 14),
			array(1, 2, 3),
			3
		));
	}

	public function test_vote_rejects_incomplete_foreign_and_invented_values()
	{
		$this->assertSame('AP_RANK_SELECTION_INCOMPLETE', ranked_vote::validate_vote(array(10 => 1), array(10, 11), array(1, 2), 2));
		$this->assertSame('FORM_INVALID', ranked_vote::validate_vote(array(10 => 1, 99 => 2), array(10, 11), array(1, 2), 2));
		$this->assertSame('FORM_INVALID', ranked_vote::validate_vote(array(10 => 1, 11 => 9), array(10, 11), array(1, 2), 2));
	}
}
