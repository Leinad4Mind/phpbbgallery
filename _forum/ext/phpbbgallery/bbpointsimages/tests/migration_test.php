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
}
