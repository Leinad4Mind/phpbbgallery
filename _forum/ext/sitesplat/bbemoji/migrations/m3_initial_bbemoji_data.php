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
 * Migration stage 3: bbemoji acp icons data
 */
class m3_initial_bbemoji_data extends \phpbb\db\migration\migration
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
	public function update_data() {
        return array(
                array('custom', array(array($this, 'insert_initial_data'))),
        );
	}

	public function insert_initial_data() {
		// Set a constant to let m6 migration script know this is new
		define('BBEMOJI_NEW_M3', true);

		$this->db->sql_query("INSERT INTO {$this->table_prefix}emoji_icons VALUES
			(1, ':fire:', 1, 1),
			(2, ':blush:', 2, 1),
			(3, ':grin:', 3, 1),
			(4, ':heartpulse:', 4, 1),
			(5, ':star:', 5, 1),
			(6, ':boom:', 6, 1),
			(7, ':pensive:', 7, 1),
			(8, ':information_source:', 8, 1),
			(9, ':question:', 9, 1),
			(10, ':skull:', 10, 1)");
	}
}
