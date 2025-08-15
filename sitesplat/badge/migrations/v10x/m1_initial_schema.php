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
 * Migration stage 1: Initial schema
 */
class m1_initial_schema extends \phpbb\db\migration\migration
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
		return array('\phpbb\db\migration\data\v310\gold');
//		return array('\sitesplat\BBCore\migrations\v31x\m1_initial_file');
	}

	/**
	 * Add the badge table schema to the database:
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function update_schema()
	{
		return array(
			'add_columns'	=> array(
				$this->table_prefix . 'users'	=> array(
					'badge_route'	=> array('VCHAR:255', ''),
				),
			),
			'add_tables'	=> array(
				$this->table_prefix . 'badge_rules'	=> array(
					'COLUMNS'	=> array(
						'rule_id'			=> array('UINT', null, 'auto_increment'),
						'rule_name'			=> array('VCHAR:50', ''),
						'rule_description'	=> array('TEXT', ''),
						'rule_type_id'		=> array('USINT', 0),
						'rule_min_value'	=> array('INT:11', 0),
						'rule_max_value'	=> array('INT:11', 0),
						'options'			=> array('VCHAR:100', 0),
						'badge_id'			=> array('UINT', 0),
						'rule_notify'		=> array('BOOL', 0),
					),
					'PRIMARY_KEY'	=> 'rule_id',
				),
				$this->table_prefix . 'badge_lang'	=> array(
					'COLUMNS'	=> array(
						'id'				=> array('UINT', null, 'auto_increment'),
						'rule_name'			=> array('VCHAR:50', ''),
						'rule_description'	=> array('TEXT', ''),
						'rule_id'			=> array('INT:11', 0),
						'lang_id'			=> array('INT:11', 0),
					),
					'PRIMARY_KEY'	=> 'id',
					'KEYS'			=> array(
						'lang'		=> array('UNIQUE', array('rule_id', 'lang_id')),
					),
				),
				$this->table_prefix . 'badge_types'	=> array(
					'COLUMNS'		=> array(
						'rule_type_id'		=> array('USINT', null, 'auto_increment'),
						'rule_type_name'	=> array('VCHAR:255', ''),
					),
					'PRIMARY_KEY'	=> array('rule_type_id'),
					'KEYS'			=> array(
						'type'		=> array('UNIQUE', array('rule_type_name')),
					),
				),
				$this->table_prefix . 'badge_events' => array(
					'COLUMNS'		=> array(
						'user_id'	=> array('UINT', null),
						'rule_id'	=> array('USINT', 0),
						'date'		=> array('INT:11', 0),
					),
					'KEYS'			=> array(
						'type'		=> array('UNIQUE', array('user_id', 'rule_id')),
					),
				),
				$this->table_prefix . 'badge_badges' => array(
					'COLUMNS'		=> array(
						'badge_id'	=> array('USINT', null, 'auto_increment'),
						'badge'		=> array('VCHAR:255', ''),
					),
					'PRIMARY_KEY'	=> array('badge_id'),
					'KEYS'			=> array(
						'type'		=> array('UNIQUE', array('badge')),
					),
				),				
			),
		);
	}

	/**
	 * Drop the badge table schema from the database
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function revert_schema()
	{
		return array(
			'drop_columns'	=> array(
				$this->table_prefix . 'users'	=> array(
					'badge_route',
				),
			),
			'drop_tables'	=> array(
				$this->table_prefix . 'badge_rules',
				$this->table_prefix . 'badge_types',
				$this->table_prefix . 'badge_events',
				$this->table_prefix . 'badge_badges',
				$this->table_prefix . 'badge_lang',
			),
		);
	}
}
