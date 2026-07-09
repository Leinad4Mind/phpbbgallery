<?php
/**
*
* @package BBSidebar
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\sidebar\migrations\v31x;

/**
 * Migration stage 2: Initial data
 */
class m2_initial_data extends \phpbb\db\migration\migration
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
		return array('\sitesplat\sidebar\migrations\v31x\m1_initial_schema');
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
			array('custom', array(array($this, 'set_autoincrement'))),
		);
	}

	/**
	 * Alter the database
	 *
	 * @return null
	 * @access public
	 */
	public function set_autoincrement()
	{
		$sql = 'ALTER TABLE ' . $this->table_prefix . 'sidebar_types' . ' AUTO_INCREMENT = 10';
		$this->db->sql_query($sql);		
	}
}
