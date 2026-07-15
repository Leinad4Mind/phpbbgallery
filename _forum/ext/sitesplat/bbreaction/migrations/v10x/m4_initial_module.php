<?php

/**
 *
 * BBReaction
 * @copyright (c) 2015-2022 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\bbreaction\migrations\v10x;

use \phpbb\db\migration\migration;

/**
 * Migration stage 4: Initial module
 */
class m4_initial_module extends migration
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
		return ['\sitesplat\bbreaction\migrations\v10x\m1_initial_schema'];
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
			[
				'module.add', [
					'acp', 'ACP_QUICK_ACCESS', [
						'module_basename'	=> '\sitesplat\bbreaction\acp\bbreaction_module',
						'modes'				=> ['settings'],
					],
				],
			],
			['module.add', [
				'ucp', 'UCP_PROFILE', [
					'module_basename'	=> '\sitesplat\bbreaction\ucp\bbreaction_module',
					'auth'				=> 'ext_sitesplat/bbreaction',
					'modes'				=> ['bbreaction'],
				],
			]],
		];
	}
}