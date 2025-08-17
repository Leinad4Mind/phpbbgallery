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
class m1_add_imgur_quickreply extends migration
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
			array('config.add', array('imgur_quickreply', true)),
		);
	}
}
