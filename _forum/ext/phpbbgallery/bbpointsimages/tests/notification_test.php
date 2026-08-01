<?php
/**
 * BBPoints Images notification tests
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbpointsimages\tests;

use phpbb\controller\helper as controller_helper;
use phpbb\notification\manager;
use phpbb\user_loader;
use phpbbgallery\bbpointsimages\notification\helper;
use phpbbgallery\bbpointsimages\notification\type\reward;
use phpbbgallery\bbpointsimages\notification\type\source_purchase;
use PHPUnit\Framework\TestCase;

final class notification_test extends TestCase
{
	public function test_helper_emits_reward_only_for_a_valid_registered_recipient(): void
	{
		$manager = new manager();
		$helper = new helper($manager, new controller_helper());
		$helper->reward(['image_id' => 0], 10);
		$helper->reward($this->image(), 12);

		$this->assertCount(1, $manager->calls);
		$this->assertSame(helper::REWARD_TYPE, $manager->calls[0]['type']);
		$this->assertSame([3], $manager->calls[0]['data']['user_ids']);
		$this->assertSame(12, $manager->calls[0]['data']['amount']);
		$this->assertSame('/phpbbgallery_core_image/9', $manager->calls[0]['data']['image_url']);
	}

	public function test_source_notifications_use_each_actual_share_and_skip_invalid_recipients(): void
	{
		$manager = new manager();
		$helper = new helper($manager, new controller_helper());
		$helper->source_purchase($this->image(), 8, [3 => 4, 4 => 3, 1 => 2, 8 => 1, 5 => 0]);

		$this->assertCount(2, $manager->calls);
		$this->assertSame([[3], [4]], array_column(array_column($manager->calls, 'data'), 'user_ids'));
		$this->assertSame([4, 3], array_column(array_column($manager->calls, 'data'), 'amount'));
		$this->assertSame([8, 8], array_column(array_column($manager->calls, 'data'), 'buyer_id'));
	}

	public function test_notification_types_have_stable_item_keys_and_safe_display_data(): void
	{
		$reward = new reward();
		$reward->create_insert_array([
			'image_id' => 9,
			'album_id' => 7,
			'image_name' => '<script>',
			'amount' => 12,
			'image_url' => '/image/9',
		]);
		$this->assertSame(helper::REWARD_TYPE, $reward->get_type());
		$this->assertSame(9, reward::get_item_id(['image_id' => 9]));
		$this->assertSame(7, reward::get_item_parent_id(['album_id' => 7]));
		$this->assertStringContainsString('&lt;script&gt;', $reward->get_title());
		$this->assertSame('/image/9', $reward->get_url());

		$loader = new user_loader();
		$purchase = new source_purchase();
		$purchase->set_user_loader($loader);
		$purchase->create_insert_array([
			'image_id' => 9,
			'buyer_id' => 8,
			'image_name' => 'Cover',
			'amount' => 4,
			'image_url' => '/image/9',
		]);
		$this->assertSame(helper::SOURCE_PURCHASE_TYPE, $purchase->get_type());
		$this->assertSame(8, source_purchase::get_item_parent_id(['buyer_id' => 8]));
		$this->assertSame([8], $purchase->users_to_query());
		$this->assertSame('avatar:8', $purchase->get_avatar());
		$this->assertStringContainsString('User 8|4|Cover', $purchase->get_title());
	}

	private function image(): array
	{
		return [
			'image_id' => 9,
			'image_album_id' => 7,
			'image_user_id' => 3,
			'image_name' => 'Cover',
		];
	}
}
