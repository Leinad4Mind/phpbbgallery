<?php
/**
 *
* @package BBprefix
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
 *
 */

namespace sitesplat\bbprefix\migrations\v31x;

class m5_prefix_suffix extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return ['\sitesplat\bbprefix\migrations\v31x\m4_prefix_categories'];
	}

	/**
	 * @inheritdoc
	 */
	public function update_schema()
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'bbprefix' => [
					'is_suffix' => ['BOOL', 0],
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
				$this->table_prefix . 'bbprefix' => ['is_suffix'],
			],
		];
	}
}
