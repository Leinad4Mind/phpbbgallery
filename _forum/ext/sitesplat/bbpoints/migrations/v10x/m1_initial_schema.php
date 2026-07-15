<?php

/**
 *
 * BBPoints extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2015-2022 SiteSplat All rights reserved
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
		//		return ['\sitesplat\BBCore\migrations\v31x\m1_initial_file'];
		return ['\phpbb\db\migration\data\v310\gold'];
	}

	/**
	 * Add columns to the database:
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function update_schema()
	{
		return [
			'add_tables'	=> [
				$this->table_prefix . 'bbpoints'	=> [
					'COLUMNS'			=> [
						'id'				=> ['UINT', null, 'auto_increment'],
						'from_id'		=> ['UINT', 0],
						'to_id'			=> ['UINT', 0],
						'bbpoints'		=> ['INT:11', 0],
						'reason'			=> ['VCHAR:255', ''],
						'timestamp'		=> ['INT:11', 0],
					],
					'PRIMARY_KEY'	=> 'id',
					'KEYS'			=> [
						'from_id'	=> ['INDEX', ['from_id']],
						'to_id'		=> ['INDEX', ['to_id']],
					],
				]
			],
			'add_columns'	=> [
				$this->table_prefix . 'users'		=> [
					'bbpoints_birthday'	=> ['INT:11', '0'],
				],
				$this->table_prefix . 'posts'		=> [
					'bbpoints'			=> ['UINT', '0'],
				],
				$this->table_prefix . 'topics'	=> [
					'bbpoints'			=> ['UINT', '0'],
				],
				$this->table_prefix . 'forums'		=> [
					'bbpoints_enabled'	=> ['TINT:1', 1],
					'bbpoints_per_topic' => ['INT:20', 0],
					'bbpoints_per_post'	=> ['INT:20', 0],
					'bbpoints_per_word'	=> ['INT:20', 0],
				]
			]
		];
	}

	/**
	 * Drop columns from the database
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function revert_schema()
	{
		return [
			'drop_tables' => [
				$this->table_prefix . 'bbpoints'
			],
			'drop_columns'	=> [
				$this->table_prefix . 'users'	=> [
					'bbpoints_birthday',
				],
				$this->table_prefix . 'posts'	=> [
					'bbpoints',
				],
				$this->table_prefix . 'topics'	=> [
					'bbpoints',
				],
				$this->table_prefix . 'forums'	=> [
					'bbpoints_enabled', 'bbpoints_per_topic', 'bbpoints_per_post', 'bbpoints_per_word'
				]
			]
		];
	}
}