<?php
/**
*
* BBreaction
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbreaction\migrations\v10x;

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
		return array('\sitesplat\bbreaction\migrations\v10x\m1_initial_schema');
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
			array('custom', array(array($this, 'add_sample_data'))),
		);
	}
	
	public function add_sample_data()
	{
		// Load the insert buffer class to perform a buffered multi insert
		$insert_buffer = new \phpbb\db\sql_insert_buffer($this->db, $this->table_prefix . 'reward_type');

		// Icons array
		$icons = array(
			1 => array('type_id' => 1, 'weight' => 2, 'title' => 'Thumbs Up', 'symbol' => 'icon-bbreact-emo-thumbsup', 'positive' => 1, 'seperator' => 0, 'active' => 1, 'notify' => 1),
			2 => array('type_id' => 2, 'weight' => 3, 'title' => 'Hype', 'symbol' => 'icon-bbreact-crown', 'positive' => 1, 'seperator' => 0, 'active' => 1, 'notify' => 1),
			3 => array('type_id' => 3, 'weight' => 4, 'title' => 'Funny', 'symbol' => 'icon-bbreact-emo-laugh', 'positive' => 1, 'seperator' => 0, 'active' => 1, 'notify' => 1),
			4 => array('type_id' => 4, 'weight' => 1, 'title' => 'Cool', 'symbol' => 'icon-bbreact-emo-sunglasses', 'positive' => 1, 'seperator' => 0, 'active' => 1, 'notify' => 1),
			5 => array('type_id' => 5, 'weight' => 6, 'title' => 'Boring', 'symbol' => 'icon-bbreact-emo-sleep', 'positive' => 0, 'seperator' => 0, 'active' => 1, 'notify' => 1),
			6 => array('type_id' => 6, 'weight' => 7, 'title' => 'Rubbish', 'symbol' => 'icon-bbreact-emo-shoot', 'positive' => 0, 'seperator' => 0, 'active' => 1, 'notify' => 1),
			7 => array('type_id' => 7, 'weight' => 5, 'title' => 'Upsetting', 'symbol' => 'icon-bbreact-emo-angry', 'positive' => 0, 'seperator' => 0, 'active' => 1, 'notify' => 1),
		);

		// Insert data
		foreach ($icons as $icon)
		{
			$insert_buffer->insert($icon);
		}

		// Flush the buffer
		$insert_buffer->flush();
	}
}
