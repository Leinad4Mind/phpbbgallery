<?php
/**
*
* @package BBSidebar
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\sidebar\migrations\v33x;

/**
 * Migration stage 3: Config data
 */
class m1_initial_data extends \phpbb\db\migration\migration
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
		return array('\sitesplat\sidebar\migrations\v32x\m3_config_data');
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
			array('custom', array(array($this, 'add_index'))),
		);
	}

	/**
	 * Alter the database
	 *
	 * @return null
	 * @access public
	 */
	public function add_index()
	{
		$sql = 'SHOW INDEX FROM ' . POSTS_TABLE . " WHERE Key_name = 'post_time'";
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		if (!$row)
		{
			$sql = 'ALTER TABLE ' . POSTS_TABLE . ' ADD INDEX post_time (post_time)';
			$this->db->sql_query($sql);
		}
	}
}
