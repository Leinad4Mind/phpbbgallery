<?php
/**
*
* BBreaction
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbreaction\migrations\v10x;

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
		return array('\sitesplat\bbreaction\migrations\v10x\m1_initial_schema');
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
					'module_basename'	=> '\sitesplat\bbreaction\acp\bbreaction_module',
					'modes'				=> array('settings'),
				),
				),
			),
			array('module.add', array(
				'ucp', 'UCP_PROFILE', array(
					'module_basename'	=> '\sitesplat\bbreaction\ucp\bbreaction_module',
					'auth'				=> 'ext_sitesplat/bbreaction',
					'modes'				=> array('bbreaction'),
				),
			)),
		);
	}
}
