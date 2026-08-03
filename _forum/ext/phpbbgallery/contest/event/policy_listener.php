<?php
/**
 * phpBB Gallery Contest policy integration.
 *
 * @package   phpbbgallery/contest
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\contest\event;

use phpbbgallery\contest\manager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Connects contest rules to the extension-neutral Gallery Core boundaries.
 */
class policy_listener implements EventSubscriberInterface
{
	private manager $contest;

	public function __construct(manager $contest)
	{
		$this->contest = $contest;
	}

	public static function getSubscribedEvents(): array
	{
		return [
			'phpbbgallery.core.album.types' => 'register_album_type',
			'phpbbgallery.core.album.enrich_data' => 'enrich_album_data',
			'phpbbgallery.core.album_operation' => 'restrict_album_operation',
			'phpbbgallery.core.upload.update_image_before' => 'mark_contest_upload',
			'phpbbgallery.core.image.prepare_move' => 'prepare_image_move',
			'phpbbgallery.core.image_visibility.private_data' => 'hide_private_data',
			'phpbbgallery.core.image_visibility.results' => 'hide_results',
			'phpbbgallery.core.image_visibility.private_data_sql' => 'restrict_private_data_sql',
			'phpbbgallery.core.image_visibility.results_sql' => 'restrict_results_sql',
		];
	}

	public function enrich_album_data(\phpbb\event\data $event): void
	{
		$album_data = (array) $event['album_data'];
		if ((int) ($album_data['album_type'] ?? -1) !== (int) \phpbbgallery\core\block::TYPE_CONTEST
			|| (int) ($album_data['album_id'] ?? 0) <= 0)
		{
			return;
		}

		$contest_data = $this->contest->get_contest((int) $album_data['album_id'], 'album', false);
		if ($contest_data !== false)
		{
			$event['album_data'] = array_merge($album_data, $contest_data);
		}
	}

	public function restrict_album_operation(\phpbb\event\data $event): void
	{
		$album_data = (array) $event['album_data'];
		if ((int) ($album_data['album_type'] ?? -1) !== (int) \phpbbgallery\core\block::TYPE_CONTEST)
		{
			return;
		}

		$operation = (string) $event['operation'];
		if ($operation === 'move_in')
		{
			$contest_id = (int) ($album_data['contest_id'] ?? 0);
			$completed = isset($album_data['contest_marked'])
				&& (int) $album_data['contest_marked'] === (int) \phpbbgallery\core\block::NO_CONTEST;
			$allowed_by_contest = $contest_id > 0
				&& ($completed || manager::is_step('upload', $album_data));
		}
		else
		{
			$allowed_by_contest = manager::is_step($operation, $album_data);
		}

		$event['allowed'] = (bool) $event['allowed'] && $allowed_by_contest;
	}

	public function mark_contest_upload(\phpbb\event\data $event): void
	{
		$album_data = (array) $event['album_data'];
		if ((int) ($album_data['album_type'] ?? -1) !== (int) \phpbbgallery\core\block::TYPE_CONTEST
			|| (int) ($album_data['contest_id'] ?? $album_data['album_contest'] ?? 0) <= 0)
		{
			return;
		}

		$additional_sql_data = (array) $event['additional_sql_data'];
		$additional_sql_data['image_contest'] = (int) \phpbbgallery\core\block::IN_CONTEST;
		$event['additional_sql_data'] = $additional_sql_data;
	}

	public function prepare_image_move(\phpbb\event\data $event): void
	{
		$target_data = (array) $event['target_data'];
		if ((int) ($target_data['album_type'] ?? -1) !== (int) \phpbbgallery\core\block::TYPE_CONTEST
			|| (int) ($target_data['contest_marked'] ?? \phpbbgallery\core\block::NO_CONTEST)
				!== (int) \phpbbgallery\core\block::IN_CONTEST)
		{
			return;
		}

		$image_move_data = (array) $event['image_move_data'];
		$image_move_data['image_contest'] = (int) \phpbbgallery\core\block::IN_CONTEST;
		$event['image_move_data'] = $image_move_data;
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
		$this->cover_contest_marker($event);
		$event['hidden'] = (bool) $event['hidden'] || manager::hides_private_data(
			(array) $event['image_data'],
			(int) $event['viewer_id'],
			(bool) $event['can_moderate']
		);
	}

	public function hide_results(\phpbb\event\data $event): void
	{
		$this->cover_contest_marker($event);
		$event['hidden'] = (bool) $event['hidden'] || manager::hides_results(
			(array) $event['image_data'],
			(bool) $event['can_moderate']
		);
	}

	public function restrict_private_data_sql(\phpbb\event\data $event): void
	{
		$this->cover_contest_marker($event);
		$conditions = (array) $event['conditions'];
		$conditions[] = manager::private_data_visibility_sql(
			(string) $event['alias'],
			(int) $event['viewer_id'],
			(array) $event['moderated_album_ids']
		);
		$event['conditions'] = $conditions;
	}

	public function restrict_results_sql(\phpbb\event\data $event): void
	{
		$this->cover_contest_marker($event);
		$conditions = (array) $event['conditions'];
		$conditions[] = manager::results_visibility_sql(
			(string) $event['alias'],
			(array) $event['moderated_album_ids']
		);
		$event['conditions'] = $conditions;
	}

	private function cover_contest_marker(\phpbb\event\data $event): void
	{
		$covered_markers = (array) $event['covered_markers'];
		$covered_markers[] = 'image_contest';
		$event['covered_markers'] = array_values(array_unique($covered_markers));
	}
}
