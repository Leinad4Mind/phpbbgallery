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

class poll_options_test extends TestCase
{
	public function test_option_values_are_validated()
	{
		$this->assertTrue(poll_options::is_valid_visibility(poll_options::VISIBILITY_PUBLIC));
		$this->assertTrue(poll_options::is_valid_visibility(poll_options::VISIBILITY_PRIVATE));
		$this->assertFalse(poll_options::is_valid_visibility(4));
		$this->assertTrue(poll_options::is_valid_vote_mode(poll_options::VOTE_MODE_INCREMENTAL));
		$this->assertFalse(poll_options::is_valid_vote_mode(-1));
	}

	public function test_public_results_are_always_visible()
	{
		$this->assertFalse(poll_options::results_are_hidden(poll_options::VISIBILITY_PUBLIC, false, false, false));
	}

	public function test_default_results_require_a_first_vote()
	{
		$this->assertTrue(poll_options::results_are_hidden(poll_options::VISIBILITY_DEFAULT, false, false, false));
		$this->assertFalse(poll_options::results_are_hidden(poll_options::VISIBILITY_DEFAULT, false, true, false));
	}

	public function test_vote_completed_results_require_all_votes()
	{
		$this->assertTrue(poll_options::results_are_hidden(poll_options::VISIBILITY_VOTE_COMPLETED, false, true, false));
		$this->assertFalse(poll_options::results_are_hidden(poll_options::VISIBILITY_VOTE_COMPLETED, false, true, true));
	}

	public function test_private_results_are_released_at_end_or_to_moderator()
	{
		$this->assertTrue(poll_options::results_are_hidden(poll_options::VISIBILITY_PRIVATE, false, true, true));
		$this->assertFalse(poll_options::results_are_hidden(poll_options::VISIBILITY_PRIVATE, true, false, false));
		$this->assertFalse(poll_options::results_are_hidden(poll_options::VISIBILITY_PRIVATE, false, false, false, true));
	}
}
