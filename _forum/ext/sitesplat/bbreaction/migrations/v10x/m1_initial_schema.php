<?php

/**
 *
 * BBReaction
 * @copyright (c) 2015-2022 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\bbreaction\migrations\v10x;

use \phpbb\db\migration\migration;

/**
 * Migration stage 1: Initial schema
 */
class m1_initial_schema extends migration
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
				$this->table_prefix . 'reward'	=> [
					'COLUMNS'	=> [
						'like_id'			=> ['UINT', NULL, 'auto_increment'],
						'post_id'			=> ['UINT', 0],
						'user_id'			=> ['UINT', 0],
						'like_type'			=> ['UINT', 0],
						'like_time'			=> ['INT:11', 0]
					],
					'PRIMARY_KEY'	=> 'like_id',
				],
				$this->table_prefix . 'reward_type'	=> [
					'COLUMNS'		=> [
						'type_id'			=> ['UINT', NULL, 'auto_increment'],
						'weight'			=> ['UINT', 0],
						'title'				=> ['VCHAR:50', ''],
						'description'		=> ['VCHAR:50',],
						'symbol'			=> ['VCHAR:50', ''],
						'positive'			=> ['TINT:1', 1],
						'seperator'			=> ['TINT:1', 0],
						'active'			=> ['TINT:1', 1],
						'notify'			=> ['TINT:1', 0]
					],
					'PRIMARY_KEY'	=> 'type_id',
				]
			]
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
				$this->table_prefix . 'reward',
				$this->table_prefix . 'reward_type',
			],
		];
	}
}