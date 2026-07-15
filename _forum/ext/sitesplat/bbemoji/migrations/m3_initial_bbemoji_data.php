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
			$sql = "INSERT INTO {$this->table_prefix}emoji_icons VALUES
					(1, ':gem:', 1, 1),
					(2, ':fire:', 2, 1),
					(3, ':cactus:', 3, 1),
					(4, ':poop:', 4, 1),
					(5, ':koala:', 5, 1),
					(6, ':pushpin:', 6, 1),
					(7, ':dragon_face:', 7, 1),
					(8, ':speech_balloon:', 8, 1),
					(9, ':rocket:', 9, 1),
					(10, ':skull:', 10, 1)";

			$this->db->sql_query($sql);
	}
}
