<?php
/**
*
* @package Two Factor Authentication
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\tfa\migrations\v31x;

class m2_initial_module extends \phpbb\db\migration\migration
{
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
				'ucp', 'UCP_PROFILE', array(
					'module_basename'	=> '\sitesplat\tfa\ucp\tfa_module',
					'modes'				=> array('tfa'),
				),
			)),
		);
	}
}
