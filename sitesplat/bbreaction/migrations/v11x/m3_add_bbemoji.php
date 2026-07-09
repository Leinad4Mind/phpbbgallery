<?php
/**
*
* BBreaction
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbreaction\migrations\v11x;

/**
 * Migration stage 3: Add BBemoji support
 */
class m3_add_bbemoji extends \phpbb\db\migration\migration
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
		return array('\sitesplat\bbreaction\migrations\v10x\m1_initial_schema');
	}

	/**
	 * Add the like table emoji column to the database:
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function update_schema()
	{
		return array(
			'add_columns'	=> array(
				$this->table_prefix . 'reward_type'	=> array(
                    'emoji'	=> array('VCHAR', ''),
				)
			)
		);
	}

	/**
	 * Drop the like table emoji column from the database
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function revert_schema()
	{
		return array(
			'drop_columns'	=> array(
                $this->table_prefix . 'reward_type' => array(
                    'emoji',
                ),
			),
		);
	}
}
