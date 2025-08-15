<?php
/**
*
* BBpostdated
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\futurepost\migrations\v31x;

class m3_future_post extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return ['\sitesplat\futurepost\migrations\v31x\m1_config_data'];
	}

	public function update_schema()
	{
		return [
			'add_columns'	=> [
				$this->table_prefix . 'posts'	=> [
					'post_future'	=> ['BOOL', 0],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_columns'	=> [
				$this->table_prefix . 'posts'	=> [
					'post_future',
				],
			],
		];
	}

	public function update_data()
	{
		return [
			['config.remove', ['future_posts_gc']],
		];
	}
}
