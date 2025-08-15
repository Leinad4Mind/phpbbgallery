<?php
/**
*
* BBmembership extension for the phpBB Forum Software package.
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbmembership\migrations\v20x;

/**
 * Migration stage 1: Update schema
 */
class m1_update_schema extends \phpbb\db\migration\migration
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
		return array('\sitesplat\bbmembership\migrations\v10x\m3_initial_config');
	}

	public function update_schema()
	{
		return array(
			'add_columns'	=> array(
			  $this->table_prefix . 'bbmembership'		=> array(
					'membership'		=> array('INT:1', 0),
				),
			)
		);
	}

	/**
	 * Drop collumns from the database
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function revert_schema()
	{
		return array(
			'drop_columns'	=> array(
				$this->table_prefix . 'bbmembership'	=> array(
					'membership'
				),
			)
		);
	}
}
