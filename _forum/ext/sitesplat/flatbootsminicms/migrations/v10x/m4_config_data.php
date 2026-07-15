<?php
/**
*
* FLATBOOTS Mini CMS extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat <http://www.sitesplat.com>
* @license SiteSplat 2015 all rights reserved
*
*/

namespace sitesplat\flatbootsminicms\migrations\v10x;

/**
* Migration stage 2: Initial module
*/
class m4_config_data extends \phpbb\db\migration\migration
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
		return array('\sitesplat\flatbootsminicms\migrations\v10x\m3_initial_data');
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
			array('config.add', array('flatboots_avatar_effect', 'none', '0')),
		);
	}
}
