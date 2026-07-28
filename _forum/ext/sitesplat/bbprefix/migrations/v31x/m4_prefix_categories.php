<?php
/**
 *
* @package BBprefix
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
 *
 */

namespace sitesplat\bbprefix\migrations\v31x;

class m4_prefix_categories extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return ['\sitesplat\bbprefix\migrations\v31x\m3_prefix_weight'];
	}

	/**
	 * @inheritdoc
	 */
	public function update_schema()
	{
		return [
			'add_tables' => [
				$this->table_prefix . 'bbprefix_categories' => [
					'COLUMNS' => [
						'category_id'	=> ['UINT', NULL, 'auto_increment'],
						'category_name'	=> ['VCHAR_UNI', ''],
					],
					'PRIMARY_KEY' => 'category_id',
					'KEYS' => [
						'category_name' => ['UNIQUE', 'category_name'],
					],
				],
			],
			'add_columns' => [
				$this->table_prefix . 'bbprefix' => [
					'category_id' => ['UINT', 0],
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
			'drop_columns' => [
				$this->table_prefix . 'bbprefix' => ['category_id'],
			],
			'drop_tables' => [
				$this->table_prefix . 'bbprefix_categories',
			],
		];
	}
}
