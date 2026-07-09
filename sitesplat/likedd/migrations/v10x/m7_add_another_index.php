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
 * Migration stage 7: Add another index
 */
class m7_add_another_index extends \phpbb\db\migration\migration
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
		return array('\sitesplat\likedd\migrations\v10x\m6_add_indices');
	}

	/**
	 * Add the like table index
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function update_schema()
	{
		return array(
			'add_index'	=> array(
				$this->table_prefix . 'likes'	=> array(
					'ld'	=> array('ld'),
				),
			),
		);
	}

	/**
	 * Drop the like table index
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function revert_schema()
	{
		return array(
			'drop_keys'	=> array(
				$this->table_prefix . 'likes'	=> array('ld'),
			),
		);
	}
}
