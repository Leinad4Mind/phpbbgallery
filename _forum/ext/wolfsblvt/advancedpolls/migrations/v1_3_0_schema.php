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

class v1_3_0_schema extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return array(
			'\wolfsblvt\advancedpolls\migrations\v1_2_0_schema',
			'\wolfsblvt\advancedpolls\migrations\v1_2_1_data_permissions',
		);
	}

	public function update_schema()
	{
		return array(
			'add_columns' => array(
				$this->table_prefix . 'topics' => array(
					'wolfsblvt_poll_visibility' => array('UINT:1', 1),
					'wolfsblvt_poll_vote_mode' => array('UINT:1', 0),
					'wolfsblvt_poll_type' => array('UINT:1', 0),
					'wolfsblvt_poll_rank_points' => array('VCHAR:255', ''),
					'wolfsblvt_poll_notified' => array('BOOL', 0),
				),
				$this->table_prefix . 'poll_votes' => array(
					'wolfsblvt_vote_user_name' => array('VCHAR_UNI:255', ''),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns' => array(
				$this->table_prefix . 'topics' => array(
					'wolfsblvt_poll_visibility',
					'wolfsblvt_poll_vote_mode',
					'wolfsblvt_poll_type',
					'wolfsblvt_poll_rank_points',
					'wolfsblvt_poll_notified',
				),
				$this->table_prefix . 'poll_votes' => array(
					'wolfsblvt_vote_user_name',
				),
			),
		);
	}
}
