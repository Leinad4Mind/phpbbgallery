<?php
/**
 * BBPoints ledger migration tests.
 *
 * @package sitesplat/bbpoints
 * @copyright (c) 2015-2026 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbpoints\tests;

use PHPUnit\Framework\TestCase;
use sitesplat\bbpoints\migrations\v13x\m1_ledger_api;
use sitesplat\bbpoints\migrations\v13x\m2_distributions;

final class migration_test extends TestCase
{
	public function test_operation_reference_table_is_portable_and_reversible(): void
	{
		$migration = new m1_ledger_api();
		$schema = $migration->update_schema();
		$table = $schema['add_tables']['phpbb_bbpoints_operations'];

		$this->assertSame(['VCHAR:191', ''], $table['COLUMNS']['operation_key']);
		$this->assertSame(['UINT', 0], $table['COLUMNS']['movement_id']);
		$this->assertSame('operation_key', $table['PRIMARY_KEY']);
		$this->assertSame(['INDEX', ['movement_id']], $table['KEYS']['movement_id']);
		$this->assertSame([
			'drop_tables' => ['phpbb_bbpoints_operations'],
		], $migration->revert_schema());
	}

	public function test_migration_serializes_both_legacy_branches(): void
	{
		$this->assertSame([
			'\sitesplat\bbpoints\migrations\v11x\m1_initial_schema',
			'\sitesplat\bbpoints\migrations\v12x\m1_initial_permission',
		], m1_ledger_api::depends_on());
	}

	public function test_distribution_reference_table_is_portable_and_reversible(): void
	{
		$migration = new m2_distributions();
		$schema = $migration->update_schema();
		$table = $schema['add_tables']['phpbb_bbpoints_distributions'];

		$this->assertSame(['VCHAR:191', ''], $table['COLUMNS']['operation_key']);
		$this->assertSame(['UINT', 0], $table['COLUMNS']['from_id']);
		$this->assertSame(['UINT:20', 0], $table['COLUMNS']['total_amount']);
		$this->assertSame(['VCHAR:64', ''], $table['COLUMNS']['recipients_hash']);
		$this->assertSame('operation_key', $table['PRIMARY_KEY']);
		$this->assertSame(['INDEX', ['from_id']], $table['KEYS']['from_id']);
		$this->assertSame([
			'drop_tables' => ['phpbb_bbpoints_distributions'],
		], $migration->revert_schema());
		$this->assertSame([
			'\sitesplat\bbpoints\migrations\v13x\m1_ledger_api',
		], m2_distributions::depends_on());
	}
}
