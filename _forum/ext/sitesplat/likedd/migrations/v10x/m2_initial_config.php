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
 * Migration stage 2: Initial data
 */
class m2_initial_config extends \phpbb\db\migration\migration
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
		return ['\sitesplat\likedd\migrations\v10x\m1_initial_schema'];
	}

	/**
	 * Add or update data in the database
	 *
	 * @return array Array of table data
	 * @access public
	 */
	public function update_data()
	{
		return [
			['config.add', ['like_icon', 'fa-thumbs-up']],
			['config.add', ['dislike_icon', 'fa-thumbs-down']],
			['config.add', ['like_style', 'btn-default']],
			['config.add', ['dislike_style', 'btn-default']],
			['config.add', ['like_list', 1]],
			['config.add', ['dislike_off', 0]],
			['config.add', ['max_dislikes', 10]],
			['config.add', ['like_locked', 0]],
			['config.add', ['like_global', 0]],
		];
	}
}