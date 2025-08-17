<?php
/**
*
* Snappy Smart Reply
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\snappy\migrations\v31x;

/**
* Migration stage 1: Initial data changes to the files
*/
class m1_add_gyazo_quickreply extends \phpbb\db\migration\migration
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
		return array('\sitesplat\snappy\migrations\v31x\m1_initial_config');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('gyazo_quickreply', true)),
		);
	}
}
