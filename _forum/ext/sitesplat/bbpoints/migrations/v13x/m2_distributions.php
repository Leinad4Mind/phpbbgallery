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
 * Add idempotency records for atomic multi-recipient distributions.
 */
class m2_distributions extends migration
{
	public static function depends_on(): array
	{
		return [
			'\sitesplat\bbpoints\migrations\v13x\m1_ledger_api',
		];
	}

	public function update_schema(): array
	{
		return [
			'add_tables' => [
				$this->table_prefix . 'bbpoints_distributions' => [
					'COLUMNS' => [
						'operation_key'   => ['VCHAR:191', ''],
						'from_id'         => ['UINT', 0],
						'total_amount'    => ['UINT:20', 0],
						'recipients_hash' => ['VCHAR:64', ''],
						'created_time'    => ['UINT:11', 0],
					],
					'PRIMARY_KEY' => 'operation_key',
					'KEYS' => [
						'from_id' => ['INDEX', ['from_id']],
					],
				],
			],
		];
	}

	public function revert_schema(): array
	{
		return [
			'drop_tables' => [
				$this->table_prefix . 'bbpoints_distributions',
			],
		];
	}
}
