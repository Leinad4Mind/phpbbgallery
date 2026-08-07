<?php
/**
 *
 * Advanced Polls
 *
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace wolfsblvt\advancedpolls\migrations;

use wolfsblvt\advancedpolls\core\poll_options;

class v1_6_0_data extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return array('\wolfsblvt\advancedpolls\migrations\v1_6_0_schema');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('wolfsblvt.advancedpolls.default_poll_score_result', poll_options::SCORE_RESULT_TOTAL)),
			array('config.add', array('wolfsblvt.advancedpolls.default_poll_show_percent', 1)),
			array('config.add', array('wolfsblvt.advancedpolls.show_poll_list_navbar', 1)),
		);
	}

	public function revert_data()
	{
		return array(
			array('config.remove', array('wolfsblvt.advancedpolls.default_poll_score_result')),
			array('config.remove', array('wolfsblvt.advancedpolls.default_poll_show_percent')),
			array('config.remove', array('wolfsblvt.advancedpolls.show_poll_list_navbar')),
		);
	}
}
