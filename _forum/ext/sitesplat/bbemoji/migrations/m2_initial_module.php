<?php
/**
*
* @package BBemoji
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbemoji\migrations;

/**
* Migration stage 6: Initial module
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
		return array('\sitesplat\bbemoji\migrations\m1_initial_schema');
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
			array('module.remove', array(
				'acp', 'ACP_MESSAGES', array(
					'module_basename'	=> 'acp_icons',
					'modes'				=> array('icons'),
				),
				),
			),
			array('module.add', array(
				'acp', 'ACP_MESSAGES', array(
					'module_basename'	=> '\sitesplat\bbemoji\acp\bbemoji_module',
					'modes'				=> array('icons'),
				),
				),
			),
		);
	}
}
