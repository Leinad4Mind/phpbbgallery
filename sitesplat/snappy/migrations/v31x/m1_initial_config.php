<?php

/**
 *
 * Snappy Smart Reply
 *
 * @copyright (c) 2015-2022 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\snappy\migrations\v31x;

use \phpbb\db\migration\migration;

/**
 * Migration stage 1: Initial data changes to the files
 */
class m1_initial_config extends migration
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
