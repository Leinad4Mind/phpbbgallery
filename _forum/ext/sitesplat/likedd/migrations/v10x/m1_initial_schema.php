<?php

/**
 *
 * phpBB Ajax likeBB.
 *
 * @copyright (c) 2015-2022 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\likedd\migrations\v10x;

/**
 * Migration stage 1: Initial schema
 */
class m1_initial_schema extends \phpbb\db\migration\migration
{
	/**
	 * Assign migration file dependencies for this migration
	 *
	 * @return array Array of migration files
	 * @static
	 * @access public
	 */
	static public function depends_on()
	{
		//	return ['\sitesplat\BBCore\migrations\v31x\m1_initial_file'];
		return ['\phpbb\db\migration\data\v310\gold'];
	}

	/**
	 * Add the like table schema to the database:
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function update_schema()
	{
		return [
			'add_tables'	=> [
				$this->table_prefix . 'likes'	=> [
					'COLUMNS'	=> [
						'like_id'			=> ['UINT', NULL, 'auto_increment'],
						'post_id'			=> ['UINT', 0],
						'user_id'			=> ['UINT', 0],
						'ld'				=> ['TINT:1', 0],
						'like_time'			=> ['INT:11', 0]
					],
					'PRIMARY_KEY' => 'like_id',
					'KEYS' => [
						'lpost'		=> ['INDEX', 'post_id'],
					]
				],
			],
		];
	}

	/**
	 * Drop the like table schema from the database
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function revert_schema()
	{
		return [
			'drop_tables'	=> [
				$this->table_prefix . 'likes',
			],
		];
	}
}