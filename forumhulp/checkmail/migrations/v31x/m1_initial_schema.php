<?php
/**
*
* @package Check mail
* @copyright (c) 2016 ForumHulp.com <http://forumhulp.com>
* @license Proprietary
*
*/

namespace forumhulp\checkmail\migrations\v31x;

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
	}

	/**
	 * @inheritdoc
	 */
	public function update_schema()
	{
		return [
			'add_tables'	=> [
				$this->table_prefix . 'checkmail'	=> [
					'COLUMNS'	=> [
						'user_id'		=> ['UINT', 0],
						'email'			=> ['VCHAR:100', ''],
						'status'		=> ['BOOL', 1],
						'responce'		=> ['TEXT', ''],
						'timestamp'		=> ['INT:11', 0],
					],
					'PRIMARY_KEY'	=> 'user_id',
				],
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function revert_schema()
	{
		return [
			'drop_tables'	=> [
				$this->table_prefix . 'checkmail',
			],
		];
	}
}
