<?php
/**
*
* BBlightbox
* @copyright (c) 2017 sitesplat.com All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bblightbox\migrations\v31x;

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
		return array('\sitesplat\bblightbox\migrations\v31x\m1_initial_config');
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
				'acp', 'ACP_MESSAGES', array(
					'module_basename'	=> '\sitesplat\bblightbox\acp\bblightbox_module',
					'modes'				=> array('settings'),
				),
			)),
		);
	}
}
