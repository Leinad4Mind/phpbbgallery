<?php
/**
 * phpBB Gallery - Permission lifecycle listener
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Keep cached Gallery permissions aligned with phpBB group membership.
 */
class permission_lifecycle_listener implements EventSubscriberInterface
{
	/** @var \phpbbgallery\core\auth\auth Gallery authorization service */
	protected \phpbbgallery\core\auth\auth $gallery_auth;

	/**
	 * @param \phpbbgallery\core\auth\auth $gallery_auth Gallery authorization service
	 */
	public function __construct(\phpbbgallery\core\auth\auth $gallery_auth)
	{
		$this->gallery_auth = $gallery_auth;
	}

	/**
	 * {@inheritdoc}
	 */
	public static function getSubscribedEvents(): array
	{
		return [
			'core.group_add_user_after'       => 'invalidate_group_members',
			'core.group_delete_user_after'    => 'invalidate_group_members',
			'core.user_set_group_attributes' => 'invalidate_group_members',
		];
	}

	/**
	 * Clear Gallery ACL snapshots for every user affected by a group change.
	 *
	 * This covers direct additions and removals, approval of pending members,
	 * and changes to group attributes such as the default group.
	 *
	 * @param \phpbb\event\data $event phpBB group lifecycle event
	 * @return void
	 */
	public function invalidate_group_members(\phpbb\event\data $event): void
	{
		$user_ids = $event['user_id_ary'] ?? [];
		$this->gallery_auth->invalidate_user_permissions(is_array($user_ids) ? $user_ids : [(int) $user_ids]);
	}
}
