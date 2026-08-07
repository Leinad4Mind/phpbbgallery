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

use wolfsblvt\advancedpolls\core\poll_option_appender;

class testable_poll_option_appender extends poll_option_appender
{
	public $state = array();

	protected function load_state($topic_id)
	{
		return $this->state;
	}
}
