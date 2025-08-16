<?php
/**
*
* BBtags
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbtags\migrations\v31x;

/**
* Migration stage 2: Initial data changes to the files
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
		return array('\phpbb\db\migration\data\v310\gold');
//		return array('sitesplat\bbtags\migrations\v31x\m1_initial_schema');
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
			array('config.add', array('bbtags_min_length', 5)),
			array('config.add', array('bbtags_max_tags', 5)),
			array('config.add', array('bbtags_on_index', 1)),
			array('config_text.add', array('bbtags_pre_tags', '{"0":"themesplat","1":"bboots","2":"flatboots","3":"sitesplat"}')),
		);
	}
}
