<?php

/**
 *
 * phpBB Ajax likeBB.
 *
 * @copyright (c) 2015-2022 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\likedd\migrations\v10x;

/**
 * Migration stage 3: Initial module
 */
class m3_initial_module extends \phpbb\db\migration\migration
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
		return ['\sitesplat\likedd\migrations\v10x\m1_initial_schema'];
	}

	/**
	 * Add or update data in the database
	 *
	 * @return array Array of table data
	 * @access public
	 */
	public function update_data()
	{
		return [
			['module.add', ['ucp', 'UCP_PROFILE', 'UCP_LIKEDD_TITLE']],
			['module.add', [
				'ucp', 'UCP_LIKEDD_TITLE', [
					'module_basename'	=> '\sitesplat\likedd\ucp\likedd_module',
					'auth'				=> 'ext_sitesplat/likedd',
					'modes'				=> ['likedd'],
				],
			]],
		];
	}
}
