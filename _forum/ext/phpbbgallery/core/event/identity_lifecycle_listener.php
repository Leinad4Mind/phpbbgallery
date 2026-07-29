<?php
/**
 * phpBB Gallery - Identity lifecycle listener
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Synchronize Gallery identity snapshots with phpBB lifecycle changes.
 */
class identity_lifecycle_listener implements EventSubscriberInterface
{
	/** @var \phpbbgallery\core\identity_sync Identity synchronization service */
	protected \phpbbgallery\core\identity_sync $identity_sync;

	/**
	 * @param \phpbbgallery\core\identity_sync $identity_sync Identity synchronization service
	 */
	public function __construct(\phpbbgallery\core\identity_sync $identity_sync)
	{
		$this->identity_sync = $identity_sync;
	}

	/**
	 * {@inheritdoc}
	 */
	public static function getSubscribedEvents(): array
	{
		return [
			'core.update_username'       => 'rename_user',
			'core.user_set_default_group' => 'recolour_users',
			'core.delete_user_after'      => 'delete_users',
			'core.delete_group_after'     => 'delete_group',
		];
	}

	/**
	 * Synchronize a renamed phpBB account across Gallery records.
	 *
	 * @param \phpbb\event\data $event Username update event
	 * @return void
	 */
	public function rename_user(\phpbb\event\data $event): void
	{
		$this->identity_sync->rename_user((string) ($event['old_name'] ?? ''), (string) ($event['new_name'] ?? ''));
	}

	/**
	 * Synchronize the colour inherited from a user's default group.
	 *
	 * @param \phpbb\event\data $event Default-group update event
	 * @return void
	 */
	public function recolour_users(\phpbb\event\data $event): void
	{
		$sql_ary = $event['sql_ary'] ?? [];
		if (!is_array($sql_ary) || !array_key_exists('user_colour', $sql_ary))
		{
			return;
		}

		$user_ids = $event['user_id_ary'] ?? [];
		$this->identity_sync->recolour_users(is_array($user_ids) ? $user_ids : [(int) $user_ids], (string) $sql_ary['user_colour']);
	}

	/**
	 * Remove cached identity rows for deleted phpBB users.
	 *
	 * @param \phpbb\event\data $event User deletion event
	 * @return void
	 */
	public function delete_users(\phpbb\event\data $event): void
	{
		$user_ids = $event['user_ids'] ?? [];
		$this->identity_sync->delete_users(is_array($user_ids) ? $user_ids : [(int) $user_ids]);
	}

	/**
	 * Remove cached identity rows for a deleted phpBB group.
	 *
	 * @param \phpbb\event\data $event Group deletion event
	 * @return void
	 */
	public function delete_group(\phpbb\event\data $event): void
	{
		$this->identity_sync->delete_group((int) ($event['group_id'] ?? 0));
	}
}
