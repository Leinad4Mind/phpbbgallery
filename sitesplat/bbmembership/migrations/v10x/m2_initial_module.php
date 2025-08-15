<?php
/**
*
* BBmembership extension for the phpBB Forum Software package.
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbmembership\migrations\v10x;

/**
* Migration stage 2: Initial module
*/
class m2_initial_module extends \phpbb\db\migration\migration
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
		return array('\sitesplat\bbmembership\migrations\v10x\m1_initial_schema');
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
				'acp', 'ACP_QUICK_ACCESS', array(
					'module_basename'	=> '\sitesplat\bbmembership\acp\bbmembership_module',
					'modes'				=> array('settings'),
					)
				)
			)
		);
	}
}
