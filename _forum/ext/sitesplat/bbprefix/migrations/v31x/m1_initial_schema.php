<?php
/**
 *
* @package BBprefix
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
 *
 */

namespace sitesplat\bbprefix\migrations\v31x;

/**
 * Initial schema changes needed for Extension installation
 */
class m1_initial_schema extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\sitesplat\BBCore\migrations\v31x\m1_initial_file');
	}

	/**
	 * @inheritdoc
	 */
	public function update_schema()
	{
		return [
			'add_tables'	=> [
				$this->table_prefix . 'bbprefix'	=> [
					'COLUMNS'	=> [
						'id'				=> ['UINT', NULL, 'auto_increment'],
						'name'				=> ['VCHAR_UNI', ''],
						'prefix'			=> ['VCHAR_UNI', ''],
						'forums'			=> ['VCHAR_UNI', ''],
						'groups'			=> ['VCHAR_UNI', ''],
						'on_index'			=> ['BOOL', 1],
						'bbcode_uid'		=> ['VCHAR_UNI', ''],
						'bbcode_bitfield'	=> ['VCHAR_UNI', ''],
					],
					'PRIMARY_KEY'	=> 'id',
					'KEYS'		=> [
						'name'		=> ['UNIQUE', 'name'],
						'prefix'	=> ['INDEX', 'prefix'],
					],
				],

				$this->table_prefix . 'bbprefix_instances' => [
					'COLUMNS'	=> [
						'id'			=> ['UINT', NULL, 'auto_increment'],
						'prefix'		=> ['UINT', 0],
						'topic'			=> ['UINT', 0],
						'ordered'		=> ['UINT', 0],
						'token_data'	=> ['TEXT', ''],
					],
					'PRIMARY_KEY'	=> 'id',
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
				$this->table_prefix . 'bbprefix',
				$this->table_prefix . 'bbprefix_instances',
			],
		];
	}
}
