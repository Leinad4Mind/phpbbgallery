<?php
/**
*
* BBtags
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbtags\migrations\v31x;

/**
* Migration stage 4: Initial module
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
		return array('\sitesplat\bbtags\migrations\v31x\m1_initial_schema');
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
					'module_basename'	=> '\sitesplat\bbtags\acp\bbtags_module',
					'modes'				=> array('tag'),
				),
			)),
		);
	}
}
