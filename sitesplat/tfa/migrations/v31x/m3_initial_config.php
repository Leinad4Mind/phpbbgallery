<?php
/**
*
* @package Two Factor Authentication
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\tfa\migrations\v31x;

/**
* Migration stage 3: Initial data changes to the files
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
		return array('\sitesplat\tfa\migrations\v31x\m2_initial_module');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('tfa_setting', 0)),
		);
	}
}
