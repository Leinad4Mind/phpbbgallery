<?php
/**
*
* @package sitesplat BBcore addon
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\BBCore\migrations\v32x;

class m1_initial_module extends \phpbb\db\migration\migration
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
					'module_basename'	=> '\sitesplat\BBCore\ucp\ir_module',
					'modes'				=> array('ir'),
				),
			)),
		);
	}
}
