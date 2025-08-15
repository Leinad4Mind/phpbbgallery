<?php
/**
*
* Badge Award extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\badge\migrations\v10x;

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
		return array('\sitesplat\badge\migrations\v10x\m1_initial_schema');
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
			array('custom', array(array($this, 'add_badge_rule_data'))),
			array('custom', array(array($this, 'add_badge_type_data'))),
			array('custom', array(array($this, 'add_badge_badges_data'))),
			array('custom', array(array($this, 'add_slug_user_data'))),
		);
	}

	/**
	 * Add badge rules to the database
	 *
	 * @return null
	 * @access public
	 */
	public function add_badge_rule_data()
	{
		// Load the insert buffer class to perform a buffered multi insert
		$insert_buffer = new \phpbb\db\sql_insert_buffer($this->db, $this->table_prefix . 'badge_rules');

		// Badge rules array
		$rules = array(
			0 => array('rule_name' => 'Avatar', 'rule_description' => '', 'rule_type_id' => 12, 'rule_min_value' => 1, 'rule_max_value' => 0, 'options' => 0, 'badge_id' => 1, 'rule_notify' => 0),
			1 => array('rule_name' => 'Posts &gt; 10', 'rule_description' => '', 'rule_type_id' => 3, 'rule_min_value' => 10, 'rule_max_value' => 50, 'options' => 0, 'badge_id' => 2, 'rule_notify' => 0),
			2 => array('rule_name' => 'Posts &gt; 50', 'rule_description' => '', 'rule_type_id' => 3, 'rule_min_value' => 50, 'rule_max_value' => 100, 'options' => 0, 'badge_id' => 3, 'rule_notify' => 0),
			3 => array('rule_name' => 'Posts &gt; 100', 'rule_description' => '', 'rule_type_id' => 3, 'rule_min_value' => 100, 'rule_max_value' => 200, 'options' => 0, 'badge_id' => 4, 'rule_notify' => 0),
			4 => array('rule_name' => 'Posts &gt; 200', 'rule_description' => '', 'rule_type_id' => 3, 'rule_min_value' => 200, 'rule_max_value' => 500, 'options' => 0, 'badge_id' => 5, 'rule_notify' => 0)
		);

		// Insert data
		foreach ($rules as $rule)
		{
			$insert_buffer->insert($rule);
		}

		// Flush the buffer
		$insert_buffer->flush();
	}

	/**
	 * Add badge types to the database
	 *
	 * @return null
	 * @access public
	 */
	public function add_badge_type_data()
	{
		// Load the insert buffer class to perform a buffered multi insert
		$insert_buffer = new \phpbb\db\sql_insert_buffer($this->db, $this->table_prefix . 'badge_types');

		// Badge types array
		$types = array(
			'birthdays',
			'membership',
			'posts',
			'warnings',
			'zebra.friends',
			'zebra.foes',
			'custom',
			'signature',
			'badges',
			'donations',
			'likedd',
			'avatar',
			'subscribed',
			'topics'
		);

		// Insert data
		foreach ($types as $type)
		{
			$insert_buffer->insert(array(
				'rule_type_name'	=> 'sitesplat.badge.type.' . $type,
			));
		}

		// Flush the buffer
		$insert_buffer->flush();
	}

	/**
	 * Add badges to the database
	 *
	 * @return null
	 * @access public
	 */
	public function add_badge_badges_data()
	{
		// Load the insert buffer class to perform a buffered multi insert
		$insert_buffer = new \phpbb\db\sql_insert_buffer($this->db, $this->table_prefix . 'badge_badges');

		// Badges array
		$badges = array(
			'eye_1.png',
			'star_0.png',
			'star_1.png',
			'star_2.png',
			'star_3.png',
			'star_4.png',
			'star_5.png',
			'beta_tester.png',
			'commoders.png',
			'cravatta.png',
			'eye.png',
			'first.png',
			'football.png',
			'lambretta.png',
			'medicine.png',
			'money.png',
			'ninja.png',
			'popsico.png',
			'postser.png',
			'r2d2.png',
			'rocket.png',
			'skull.png'
		);

		// Insert data
		foreach ($badges as $badge)
		{
			$insert_buffer->insert(array(
				'badge'	=> $badge,
			));
		}

		// Flush the buffer
		$insert_buffer->flush();
	}

	/**
	 * Add route to user
	 *
	 * @return null
	 * @access public
	 */
	public function add_slug_user_data()
	{
		$sql = 'SELECT user_id, username FROM ' . USERS_TABLE . ' WHERE ' . $this->db->sql_in_set('user_type', array(USER_INACTIVE, USER_IGNORE), true);
		$result = $this->db->sql_query($sql);
		$rows = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		foreach ($rows as $key => $value)
		{
			$sql = 'UPDATE ' . USERS_TABLE . ' SET badge_route = "' . $this->Slug($value['username']) . '" WHERE user_id = ' . $value['user_id'];
			$this->db->sql_query($sql);
		}
	}

	protected function Slug($string)
	{
		return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
	}
}
