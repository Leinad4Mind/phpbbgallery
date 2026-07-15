<?php

/**
 *
 * BBReaction
 * @copyright (c) 2015-2022 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\bbreaction\migrations\v11x;

use \phpbb\db\migration\migration;

/**
 * Migration stage 3: Add BBEmoji support
 */
class m3_add_bbemoji extends migration
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
		return ['\sitesplat\bbreaction\migrations\v10x\m1_initial_schema'];
	}

	/**
	 * Add the like table emoji column to the database:
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function update_schema()
	{
		return [
			'add_columns'	=> [
				$this->table_prefix . 'reward_type'	=> [
					'emoji'	=> ['VCHAR', ''],
				]
			]
		];
	}

	/**
	 * Drop the like table emoji column from the database
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function revert_schema()
	{
		return [
			'drop_columns'	=> [
				$this->table_prefix . 'reward_type' => [
					'emoji',
				],
			],
		];
	}
}