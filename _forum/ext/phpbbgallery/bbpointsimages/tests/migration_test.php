<?php
/**
 * BBPoints Images migration tests
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbpointsimages\tests;

use phpbbgallery\bbpointsimages\migrations\m1_init;
use phpbbgallery\bbpointsimages\migrations\m2_reward_lifecycle;
use phpbbgallery\bbpointsimages\migrations\m3_acp_settings;
use PHPUnit\Framework\TestCase;

final class migration_test extends TestCase
{
	public function test_schema_is_addon_owned_portable_and_reversible(): void
	{
		$migration = new m1_init();
		$schema = $migration->update_schema()['add_tables'];

		$this->assertSame([
			'phpbb_gallery_bbpoints_album_rules',
			'phpbb_gallery_bbpoints_contributors',
			'phpbb_gallery_bbpoints_rewards',
			'phpbb_gallery_bbpoints_purchases',
			'phpbb_gallery_bbpoints_image_stats',
		], array_keys($schema));
		$this->assertSame(['image_id', 'user_id'], $schema['phpbb_gallery_bbpoints_contributors']['PRIMARY_KEY']);
		$this->assertSame(['image_id', 'buyer_id'], $schema['phpbb_gallery_bbpoints_purchases']['PRIMARY_KEY']);
		$this->assertSame(['VCHAR:64', ''], $schema['phpbb_gallery_bbpoints_image_stats']['COLUMNS']['source_sha256']);
		$this->assertSame([
			'drop_tables' => array_reverse(array_keys($schema)),
		], $migration->revert_schema());
	}

	public function test_migration_requires_the_current_core_and_public_ledger_api(): void
	{
		$this->assertSame([
			'\phpbbgallery\core\migrations\remove_legacy_image_plugins',
			'\sitesplat\bbpoints\migrations\v13x\m2_distributions',
		], m1_init::depends_on());
	}

	public function test_global_policy_configuration_is_reversible_and_free_by_default(): void
	{
		$migration = new m1_init();

		$this->assertSame([
			['config.add', ['phpbb_gallery_bbpoints_upload_reward', 0]],
			['config.add', ['phpbb_gallery_bbpoints_source_cost', 0]],
			['config.add', ['phpbb_gallery_bbpoints_contributors_enabled', 1]],
		], $migration->update_data());
		$this->assertSame([
			['config.remove', ['phpbb_gallery_bbpoints_contributors_enabled']],
			['config.remove', ['phpbb_gallery_bbpoints_source_cost']],
			['config.remove', ['phpbb_gallery_bbpoints_upload_reward']],
		], $migration->revert_data());
	}

	public function test_reward_lifecycle_schema_prevents_duplicate_original_rewards(): void
	{
		$migration = new m2_reward_lifecycle();
		$schema = $migration->update_schema();
		$table = 'phpbb_gallery_bbpoints_rewards';

		$this->assertSame(['VCHAR:64', ''], $schema['add_columns'][$table]['source_sha256']);
		$this->assertSame(['UINT:11', 0], $schema['add_columns'][$table]['reassignment_count']);
		$this->assertSame(['source_sha256'], $schema['add_unique_index'][$table]['source_sha256']);
		$this->assertSame(['\phpbbgallery\bbpointsimages\migrations\m1_init'], m2_reward_lifecycle::depends_on());
		$this->assertSame(['source_sha256'], $migration->revert_schema()['drop_keys'][$table]);
	}

	public function test_acp_settings_module_is_permission_checked_and_reversible(): void
	{
		$migration = new m3_acp_settings();
		$module = $migration->update_data()[0][1][2];

		$this->assertSame(['\phpbbgallery\bbpointsimages\migrations\m2_reward_lifecycle'], m3_acp_settings::depends_on());
		$this->assertSame('settings', $module['module_mode']);
		$this->assertSame(
			'acl_a_gallery_albums && ext_phpbbgallery/bbpointsimages',
			$module['module_auth']
		);
		$this->assertSame([[
			'module.remove',
			['acp', 'PHPBB_GALLERY', 'ACP_BBPOINTSIMAGES_SETTINGS'],
		]], $migration->revert_data());
	}
}
