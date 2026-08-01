<?php
/**
 * phpBB Gallery - BBPoints Images notification helper
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbpointsimages\notification;

use phpbb\controller\helper as controller_helper;
use phpbb\notification\manager;

final class helper
{
	public const REWARD_TYPE = 'phpbbgallery.bbpointsimages.notification.reward';
	public const SOURCE_PURCHASE_TYPE = 'phpbbgallery.bbpointsimages.notification.source_purchase';

	public function __construct(
		private manager $notifications,
		private controller_helper $controller_helper
	)
	{
	}

	public function reward(array $image_data, int $amount): void
	{
		$image_id = (int) ($image_data['image_id'] ?? 0);
		$album_id = (int) ($image_data['image_album_id'] ?? 0);
		$user_id = (int) ($image_data['image_user_id'] ?? 0);
		if ($image_id < 1 || $album_id < 1 || !$this->is_registered_user($user_id) || $amount < 1)
		{
			return;
		}
		$this->add_safely(self::REWARD_TYPE, [
			'user_ids' => [$user_id],
			'image_id' => $image_id,
			'album_id' => $album_id,
			'image_name' => (string) ($image_data['image_name'] ?? ''),
			'amount' => $amount,
			'image_url' => $this->controller_helper->route('phpbbgallery_core_image', ['image_id' => $image_id]),
		]);
	}

	/**
	 * @param array<int, int> $recipients Recipient user ID => credited points
	 */
	public function source_purchase(array $image_data, int $buyer_id, array $recipients): void
	{
		$image_id = (int) ($image_data['image_id'] ?? 0);
		if ($image_id < 1 || !$this->is_registered_user($buyer_id))
		{
			return;
		}
		$image_url = $this->controller_helper->route('phpbbgallery_core_image', ['image_id' => $image_id]);
		foreach ($recipients as $recipient_id => $amount)
		{
			$recipient_id = (int) $recipient_id;
			$amount = (int) $amount;
			if (!$this->is_registered_user($recipient_id) || $recipient_id === $buyer_id || $amount < 1)
			{
				continue;
			}
			$this->add_safely(self::SOURCE_PURCHASE_TYPE, [
				'user_ids' => [$recipient_id],
				'image_id' => $image_id,
				'buyer_id' => $buyer_id,
				'image_name' => (string) ($image_data['image_name'] ?? ''),
				'amount' => $amount,
				'image_url' => $image_url,
			]);
		}
	}

	/**
	 * A disabled or not-yet-registered notification type must never undo an
	 * already completed reward or paid source purchase.
	 */
	private function add_safely(string $type, array $data): bool
	{
		try
		{
			$this->notifications->add_notifications($type, $data);
			return true;
		}
		catch (\phpbb\notification\exception $exception)
		{
			return false;
		}
	}

	private function is_registered_user(int $user_id): bool
	{
		$anonymous = defined('ANONYMOUS') ? (int) ANONYMOUS : 1;
		return $user_id > $anonymous;
	}
}
