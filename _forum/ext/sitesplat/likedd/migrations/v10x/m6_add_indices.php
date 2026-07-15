<?php
/**
*
* phpBB Ajax likeBB.
*
* @copyright (c) 2019 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\likedd\migrations\v10x;

/**
 * Migration stage 6: Add Indices
 */
class m6_add_indices extends \phpbb\db\migration\migration
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
	 * Add the like table indices:
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function update_schema()
	{
		return array(
			'add_index'	=> array(
				$this->table_prefix . 'likes'	=> array(
					'time'	=> array('like_time'),
					'user'	=> array('user_id'),
				),
			),
		);
	}

	/**
	 * Drop the like table indices:
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function revert_schema()
	{
		return array(
			'drop_keys'	=> array(
				$this->table_prefix . 'likes'	=> array(
					'user',
					'time',
				),
			),
		);
	}
}
