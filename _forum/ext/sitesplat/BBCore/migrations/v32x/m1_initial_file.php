<?php
/**
*
* @package sitesplat BBcore
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\BBCore\migrations\v32x;

use phpbb\db\migration\container_aware_migration;

/**
* Migration stage 1: Initial data changes to the files
*/
class m1_initial_file extends container_aware_migration
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
		return array('\sitesplat\BBCore\migrations\v31x\m1_initial_file');
	}
}