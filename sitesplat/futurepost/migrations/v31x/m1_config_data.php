<?php
/**
*
* BBpostdated
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\futurepost\migrations\v31x;

/**
 * Migration stage 2: Config data
 */
class m1_config_data extends \phpbb\db\migration\migration
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
		return array('\phpbb\db\migration\data\v310\gold');
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
			array('config.add', array('future_posts_gc', 86400)),
			array('config.add', array('future_posts_last_gc', 0, 1)),
		);
	}
}
