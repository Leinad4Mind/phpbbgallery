<?php
/**
 * Temporary bridge between the generic Core policies and legacy contests.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Preserves existing contest behaviour while its domain moves to an add-on.
 */
class legacy_contest_policy_listener implements EventSubscriberInterface
{
	private \phpbbgallery\core\contest $contest;

	public function __construct(\phpbbgallery\core\contest $contest)
	{
		$this->contest = $contest;
	}

	public static function getSubscribedEvents(): array
	{
		return [
			'phpbbgallery.core.album.types' => 'register_album_type',
			'phpbbgallery.core.image_visibility.private_data' => 'hide_private_data',
			'phpbbgallery.core.image_visibility.results' => 'hide_results',
			'phpbbgallery.core.image_visibility.private_data_sql' => 'restrict_private_data_sql',
			'phpbbgallery.core.image_visibility.results_sql' => 'restrict_results_sql',
		];
	}

	public function register_album_type(\phpbb\event\data $event): void
	{
		$types = (array) $event['types'];
		$types[(int) \phpbbgallery\core\block::TYPE_CONTEST] = [
			'lang' => 'CONTEST',
			'accepts_images' => true,
			'can_create' => $this->contest->can_create(),
		];
		$event['types'] = $types;
	}

	public function hide_private_data(\phpbb\event\data $event): void
	{
		$event['hidden'] = (bool) $event['hidden'] || \phpbbgallery\core\contest::hides_private_data(
			(array) $event['image_data'],
			(int) $event['viewer_id'],
			(bool) $event['can_moderate']
		);
	}

	public function hide_results(\phpbb\event\data $event): void
	{
		$event['hidden'] = (bool) $event['hidden'] || \phpbbgallery\core\contest::hides_results(
			(array) $event['image_data'],
			(bool) $event['can_moderate']
		);
	}

	public function restrict_private_data_sql(\phpbb\event\data $event): void
	{
		$conditions = (array) $event['conditions'];
		$conditions[] = \phpbbgallery\core\contest::private_data_visibility_sql(
			(string) $event['alias'],
			(int) $event['viewer_id'],
			(array) $event['moderated_album_ids']
		);
		$event['conditions'] = $conditions;
	}

	public function restrict_results_sql(\phpbb\event\data $event): void
	{
		$conditions = (array) $event['conditions'];
		$conditions[] = \phpbbgallery\core\contest::results_visibility_sql(
			(string) $event['alias'],
			(array) $event['moderated_album_ids']
		);
		$event['conditions'] = $conditions;
	}
}
