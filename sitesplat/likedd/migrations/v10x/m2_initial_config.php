<?php
/**
*
* phpBB Ajax likeBB.
*
* @copyright (c) 2015 SiteSplat All rights reserved
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
		return array('\sitesplat\likedd\migrations\v10x\m1_initial_schema');
	}

	/**
	 * Add or update data in the database
	 *
	 * @return array Array of table data
	 * @access public
	 */
	public function update_data()
	{
		return array(
			array('config.add', array('like_icon', 'fa-thumbs-up')),
			array('config.add', array('dislike_icon', 'fa-thumbs-down')),
			array('config.add', array('like_style', 'btn-default')),
			array('config.add', array('dislike_style', 'btn-default')),
			array('config.add', array('like_list', 1)),
			array('config.add', array('dislike_off', 0)),
			array('config.add', array('max_dislikes', 10)),
			array('config.add', array('like_locked', 0)),
			array('config.add', array('like_global', 0)),
		);
	}
}
