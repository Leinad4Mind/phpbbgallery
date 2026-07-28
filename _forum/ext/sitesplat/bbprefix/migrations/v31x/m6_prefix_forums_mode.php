<?php
/**
 *
* @package BBprefix
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
 *
 */

namespace sitesplat\bbprefix\migrations\v31x;

class m6_prefix_forums_mode extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return ['\sitesplat\bbprefix\migrations\v31x\m5_prefix_suffix'];
	}

	/**
	 * @inheritdoc
	 */
	public function update_schema()
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'bbprefix' => [
					// Default true keeps today's only mode (exclude these forums)
					// the same for every prefix that already exists.
					'forums_exclude' => ['BOOL', 1],
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
				$this->table_prefix . 'bbprefix' => ['forums_exclude'],
			],
		];
	}
}
