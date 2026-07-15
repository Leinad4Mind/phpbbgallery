<?php
/**
*
* Badge Award extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\badge\migrations\v10x;

/**
* Migration stage 6: Initial module
*/
class m4_initial_module extends \phpbb\db\migration\migration
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
		return array('\sitesplat\badge\migrations\v10x\m1_initial_schema');
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
			array('module.add', array(
				'acp', 'ACP_CAT_USERS', array(
					'module_basename'	=> '\sitesplat\badge\acp\badge_module',
					'modes'				=> array('manage'),
				),
			)),
			array('module.add', array(
				'ucp', 'UCP_PROFILE', array(
					'module_basename'	=> '\sitesplat\badge\ucp\badge_module',
					'auth'				=> 'ext_sitesplat/badge',
					'modes'				=> array('badge'),
				),
			)),
		);
	}
}
