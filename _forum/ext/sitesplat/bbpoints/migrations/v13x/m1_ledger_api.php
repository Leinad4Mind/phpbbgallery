<?php
/**
 *
 * BBPoints extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2015-2026 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\bbpoints\migrations\v13x;

use phpbb\db\migration\migration;

/**
 * Add idempotency keys for the public ledger API.
 */
class m1_ledger_api extends migration
{
	public static function depends_on(): array
	{
		return [
			'\sitesplat\bbpoints\migrations\v11x\m1_initial_schema',
			'\sitesplat\bbpoints\migrations\v12x\m1_initial_permission',
		];
	}

	public function update_schema(): array
	{
		return [
			'add_tables' => [
				$this->table_prefix . 'bbpoints_operations' => [
					'COLUMNS' => [
						'operation_key' => ['VCHAR:191', ''],
						'movement_id'   => ['UINT', 0],
					],
					'PRIMARY_KEY' => 'operation_key',
					'KEYS' => [
						'movement_id' => ['INDEX', ['movement_id']],
					],
				],
			],
		];
	}

	public function revert_schema(): array
	{
		return [
			'drop_tables' => [
				$this->table_prefix . 'bbpoints_operations',
			],
		];
	}
}
