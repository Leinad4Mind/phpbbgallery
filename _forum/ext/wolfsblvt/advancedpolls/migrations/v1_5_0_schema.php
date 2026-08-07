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

class v1_5_0_schema extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return array('\wolfsblvt\advancedpolls\migrations\v1_4_0_data');
	}

	public function update_schema()
	{
		return array(
			'add_tables' => array(
				$this->table_prefix . 'advancedpolls_revisions' => array(
					'COLUMNS' => array(
						'revision_id' => array('UINT', null, 'auto_increment'),
						'topic_id' => array('UINT', 0),
						'added_by' => array('UINT', 0),
						'added_at' => array('TIMESTAMP', 0),
						'option_count' => array('UINT:2', 0),
					),
					'PRIMARY_KEY' => 'revision_id',
					'KEYS' => array(
						'topic_id' => array('INDEX', 'topic_id'),
					),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_tables' => array(
				$this->table_prefix . 'advancedpolls_revisions',
			),
		);
	}
}
