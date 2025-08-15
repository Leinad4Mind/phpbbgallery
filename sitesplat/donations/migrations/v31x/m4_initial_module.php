<?php
/**
*
* @package BBdonations
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\donations\migrations\v31x;

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
		return array('\sitesplat\donations\migrations\v31x\m1_initial_schema');
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
					'module_basename'	=> '\sitesplat\donations\acp\donations_module',
					'modes'				=> array('manage'),
				),
				),
			),
			array('module.add', array('ucp', 'UCP_MAIN', 'UCP_DONATION_TITLE')),
			array('module.add', array(
				'ucp', 'UCP_DONATION_TITLE', array(
					'module_basename'	=> '\sitesplat\donations\ucp\donations_module',
					'auth'				=> 'ext_sitesplat/donations',
					'modes'				=> array('donation'),
				),
			)),
		);
	}
}
