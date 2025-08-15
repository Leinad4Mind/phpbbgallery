<?php
/**
*
* BBPoints extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbpoints\migrations\v10x;

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
	 * Add collums to the database:
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function update_schema()
	{
		return array(
			'add_tables'	=> array(
				$this->table_prefix . 'bbpoints'	=> array(
					'COLUMNS'			=> array(
						'id'			=> array('UINT', null, 'auto_increment'),
						'from_id'		=> array('UINT', 0),
						'to_id'			=> array('UINT', 0),
						'bbpoints'		=> array('INT:11', 0),
						'reason'		=> array('VCHAR:255', ''),
						'timestamp'		=> array('INT:11', 0),
					),
					'PRIMARY_KEY'	=> 'id',
					'KEYS'			=> array(
						'from_id'	=> array('INDEX', array('from_id')),
						'to_id'		=> array('INDEX', array('to_id')),
					),

				)
			),
			'add_columns'	=> array(
				$this->table_prefix . 'users'		=> array(
					'bbpoints_birthday'	=> array('INT:11', '0'),
				),
				$this->table_prefix . 'posts'		=> array(
					'bbpoints'			=> array('UINT', '0'),
				),
				$this->table_prefix . 'topics'	=> array(
					'bbpoints'			=> array('UINT', '0'),
				),
				$this->table_prefix . 'forums'		=> array(
					'bbpoints_enabled'	=> array('TINT:1', 1),
					'bbpoints_per_topic'=> array('INT:20', 0),
					'bbpoints_per_post'	=> array('INT:20', 0),
					'bbpoints_per_word'	=> array('INT:20', 0),
				)
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
			'drop_tables' => array(
				$this->table_prefix . 'bbpoints'
			),
			'drop_columns'	=> array(
				$this->table_prefix . 'users'	=> array(
					'bbpoints_birthday',
				),
				$this->table_prefix . 'posts'	=> array(
					'bbpoints',
				),
				$this->table_prefix . 'topics'	=> array(
					'bbpoints',
				),
				$this->table_prefix . 'forums'	=> array(
					'bbpoints_enabled', 'bbpoints_per_topic', 'bbpoints_per_post', 'bbpoints_per_word'
				)
			)
		);
	}
}
