<?php
/**
*
* @package BBSwitch
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\accountswitch\migrations\v31x;

/**
* Migration stage 2: Initial module
*/
class m1_initial_module extends \phpbb\db\migration\migration
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
		return array('\phpbb\db\migration\data\v310\gold');
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
		array('module.add', array('ucp', 'UCP_PROFILE', 'ACCOUNTSWITCH')),
		array('module.add', array(
			'ucp', 'ACCOUNTSWITCH', array(
				'module_basename'	=> '\sitesplat\accountswitch\ucp\accountswitch_module',
				'auth'				=> 'ext_sitesplat/accountswitch',
				'modes'				=> array('accountswitch'),
			),
		)),
	);
	}
}
