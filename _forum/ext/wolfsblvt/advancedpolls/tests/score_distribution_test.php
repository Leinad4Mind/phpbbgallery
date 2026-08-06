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
use wolfsblvt\advancedpolls\core\score_distribution;

class score_distribution_test extends TestCase
{
	public function test_aggregated_rows_are_grouped_and_sorted_by_score()
	{
		$rows = array(
			array('poll_option_id' => 7, 'score_value' => 3, 'voter_count' => 10),
			array('poll_option_id' => 7, 'score_value' => 1, 'voter_count' => 2),
			array('poll_option_id' => 8, 'score_value' => 2, 'voter_count' => 4),
			array('poll_option_id' => 7, 'score_value' => 2, 'voter_count' => 5),
		);

		$this->assertSame(array(
			7 => array(1 => 2, 2 => 5, 3 => 10),
			8 => array(2 => 4),
		), score_distribution::from_rows($rows));
	}

	public function test_invalid_or_abstention_rows_are_ignored()
	{
		$rows = array(
			array('poll_option_id' => 0, 'score_value' => 3, 'voter_count' => 1),
			array('poll_option_id' => 4, 'score_value' => 0, 'voter_count' => 2),
			array('poll_option_id' => 4, 'score_value' => 2, 'voter_count' => 0),
		);

		$this->assertSame(array(), score_distribution::from_rows($rows));
	}
}
