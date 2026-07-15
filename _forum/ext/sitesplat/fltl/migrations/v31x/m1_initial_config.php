<?php
/**
*
* Fancy Lazy Topics Loader
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\fltl\migrations\v31x;

/**
* Migration stage 1: Initial data changes to the files
*/
class m1_initial_config extends \phpbb\db\migration\migration
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
	  //return array('\sitesplat\BBCore\migrations\v31x\m1_initial_file');
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
			array('config.add', array('fltl_limit', 4)),
			array('config.add', array('fltl_time', 20)),
			array('config.add', array('fltl_type', 'last')),
			array('config.add', array('fltl_excluded_forums', '[]')),
		);
	}
}
