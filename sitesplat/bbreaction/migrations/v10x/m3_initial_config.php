<?php
/**
*
* BBreaction
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbreaction\migrations\v10x;

/**
 * Migration stage 3: Initial data
 */
class m3_initial_config extends \phpbb\db\migration\migration
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
	 * Add or update data in the database
	 *
	 * @return array Array of table data
	 * @access public
	 */
	public function update_data()
	{
		return array(
			array('config.add', array('rewards_multivote', 1)),
			array('config.add',	array('rewards_percent', 1)),
			array('config.add',	array('rewards_memberlist', 1)),
			array('config.add',	array('rewards_progressbar', 0)),
		);
	}
}
