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

class v1_4_0_schema extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return array('\wolfsblvt\advancedpolls\migrations\v1_3_0_data');
	}

	public function update_schema()
	{
		return array(
			'add_tables' => array(
				$this->table_prefix . 'advancedpolls_ballots' => array(
					'COLUMNS' => array(
						'ballot_id' => array('UINT', null, 'auto_increment'),
						'topic_id' => array('UINT', 0),
						'vote_user_id' => array('UINT', 0),
						'vote_guest_token' => array('VCHAR:64', ''),
						'submitted_at' => array('TIMESTAMP', 0),
					),
					'PRIMARY_KEY' => 'ballot_id',
					'KEYS' => array(
						'topic_voter' => array('UNIQUE', array('topic_id', 'vote_user_id', 'vote_guest_token')),
					),
				),
				$this->table_prefix . 'advancedpolls_questions' => array(
					'COLUMNS' => array(
						'question_id' => array('UINT', null, 'auto_increment'),
						'topic_id' => array('UINT', 0),
						'question_order' => array('UINT:2', 0),
						'question_text' => array('VCHAR_UNI:255', ''),
						'question_required' => array('BOOL', 0),
					),
					'PRIMARY_KEY' => 'question_id',
					'KEYS' => array(
						'topic_order' => array('INDEX', array('topic_id', 'question_order')),
					),
				),
				$this->table_prefix . 'advancedpolls_options' => array(
					'COLUMNS' => array(
						'option_id' => array('UINT', null, 'auto_increment'),
						'question_id' => array('UINT', 0),
						'option_order' => array('UINT:2', 0),
						'option_text' => array('VCHAR_UNI:255', ''),
						'option_total' => array('UINT:8', 0),
					),
					'PRIMARY_KEY' => 'option_id',
					'KEYS' => array(
						'question_order' => array('INDEX', array('question_id', 'option_order')),
					),
				),
				$this->table_prefix . 'advancedpolls_votes' => array(
					'COLUMNS' => array(
						'vote_id' => array('UINT', null, 'auto_increment'),
						'question_id' => array('UINT', 0),
						'option_id' => array('UINT', 0),
						'vote_user_id' => array('UINT', 0),
						'vote_user_ip' => array('VCHAR:40', ''),
						'vote_user_name' => array('VCHAR_UNI:255', ''),
						'vote_guest_token' => array('VCHAR:64', ''),
						'vote_value' => array('UINT:4', 1),
					),
					'PRIMARY_KEY' => 'vote_id',
					'KEYS' => array(
						'question_user' => array('INDEX', array('question_id', 'vote_user_id')),
						'question_guest' => array('INDEX', array('question_id', 'vote_guest_token')),
						'option_id' => array('INDEX', 'option_id'),
					),
				),
			),
			'add_columns' => array(
				$this->table_prefix . 'topics' => array(
					'wolfsblvt_poll_min_value' => array('UINT:4', 1),
					'wolfsblvt_poll_required' => array('BOOL', 1),
					'wolfsblvt_poll_collapsible' => array('BOOL', 0),
				),
				$this->table_prefix . 'poll_votes' => array(
					'wolfsblvt_vote_guest_token' => array('VCHAR:64', ''),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_tables' => array(
				$this->table_prefix . 'advancedpolls_votes',
				$this->table_prefix . 'advancedpolls_options',
				$this->table_prefix . 'advancedpolls_questions',
				$this->table_prefix . 'advancedpolls_ballots',
			),
			'drop_columns' => array(
				$this->table_prefix . 'topics' => array(
					'wolfsblvt_poll_min_value',
					'wolfsblvt_poll_required',
					'wolfsblvt_poll_collapsible',
				),
				$this->table_prefix . 'poll_votes' => array(
					'wolfsblvt_vote_guest_token',
				),
			),
		);
	}
}
