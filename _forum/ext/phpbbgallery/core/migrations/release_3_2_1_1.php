<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\migration;

class release_3_2_1_1 extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\release_3_2_1_0'];
	}

	public function update_data(): array
	{
		return [
			['config.update', ['phpbb_gallery_version', '3.2.2']]
		];
	}

	public function update_schema(): array
	{
		return [
			'add_columns'	=> [
				$this->table_prefix . 'gallery_users'	=> [
					'rrc_zebra'		=> ['UINT:1', 0],
				],
			]
		];
	}

	public function revert_schema(): array
	{
		return [
			'drop_columns' => [
				$this->table_prefix . 'gallery_users' => [
					'rrc_zebra',
				],
			],
		];
	}

}
