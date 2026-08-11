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
			'phpbbgallery.core.album.enrich_rows' => 'enrich_album_rows',
			'phpbbgallery.core.album.prepare_display' => 'finalize_expired_contest',
			'phpbbgallery.core.album_operation' => 'restrict_album_operation',
			'phpbbgallery.core.upload.update_image_before' => 'mark_contest_upload',
			'phpbbgallery.core.image.prepare_move' => 'prepare_image_move',
			'phpbbgallery.core.image.state_changed' => 'resync_contest_results',
			'phpbbgallery.core.image_visibility.private_data' => 'hide_private_data',
			'phpbbgallery.core.image_visibility.results' => 'hide_results',
			'phpbbgallery.core.image_visibility.restricted_sort_keys' => 'restrict_sort_keys',
			'phpbbgallery.core.image_visibility.private_data_sql' => 'restrict_private_data_sql',
			'phpbbgallery.core.image_visibility.results_sql' => 'restrict_results_sql',
		];
	}

	public function finalize_expired_contest(\phpbb\event\data $event): void
	{
		$album_data = (array) $event['album_data'];
		if ((int) ($album_data['album_type'] ?? -1) !== (int) manager::ALBUM_TYPE
			|| (int) ($album_data['contest_id'] ?? 0) <= 0
			|| (int) ($album_data['contest_marked'] ?? manager::STATE_INACTIVE)
				!== (int) manager::STATE_ACTIVE)
		{
			return;
		}

		$contest_end_time = (int) ($album_data['contest_start'] ?? 0)
			+ (int) ($album_data['contest_end'] ?? 0);
		$now = (int) $event['now'];
		if ($contest_end_time <= 0 || $contest_end_time > $now)
		{
			return;
		}

		if ($this->contest->end(
			(int) $event['album_id'],
			(int) $album_data['contest_id'],
			$contest_end_time,
			$now
		))
		{
			$album_data['contest_marked'] = manager::STATE_INACTIVE;
			$event['album_data'] = $album_data;
		}
	}

	public function enrich_album_data(\phpbb\event\data $event): void
	{
		$album_data = (array) $event['album_data'];
		if ((int) ($album_data['album_type'] ?? -1) !== (int) manager::ALBUM_TYPE
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

	public function enrich_album_rows(\phpbb\event\data $event): void
	{
		$album_rows = (array) $event['album_rows'];
		$contest_album_ids = [];
		foreach ($album_rows as $row)
		{
			if ((int) ($row['album_type'] ?? -1) === (int) manager::ALBUM_TYPE)
			{
				$contest_album_ids[] = (int) ($row['album_id'] ?? 0);
			}
		}

		$contest_rows = $this->contest->get_contests_by_album_ids($contest_album_ids);
		$winner_thumbnails = $this->contest->get_winner_thumbnails($contest_rows);
		foreach ($album_rows as $index => $row)
		{
			$album_id = (int) ($row['album_id'] ?? 0);
			if (isset($contest_rows[$album_id]))
			{
				$album_rows[$index] = array_merge($row, $contest_rows[$album_id]);
				if (isset($winner_thumbnails[$album_id]))
				{
					$album_rows[$index]['contest_thumbnail_image_id'] = $winner_thumbnails[$album_id];
				}
			}
			else if ((int) ($row['album_type'] ?? -1) === (int) manager::ALBUM_TYPE)
			{
				$album_rows[$index]['contest_marked'] = manager::STATE_ACTIVE;
			}
		}
		$event['album_rows'] = $album_rows;
	}

	public function restrict_album_operation(\phpbb\event\data $event): void
	{
		$album_data = (array) $event['album_data'];
		if ((int) ($album_data['album_type'] ?? -1) !== (int) manager::ALBUM_TYPE)
		{
			return;
		}

		$operation = (string) $event['operation'];
		if ($operation === 'move_in')
		{
			$contest_id = (int) ($album_data['contest_id'] ?? 0);
			$completed = isset($album_data['contest_marked'])
				&& (int) $album_data['contest_marked'] === (int) manager::STATE_INACTIVE;
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
		if ((int) ($album_data['album_type'] ?? -1) !== (int) manager::ALBUM_TYPE
			|| (int) ($album_data['contest_id'] ?? $album_data['album_contest'] ?? 0) <= 0)
		{
			return;
		}

		$additional_sql_data = (array) $event['additional_sql_data'];
		$additional_sql_data['image_contest'] = (int) manager::STATE_ACTIVE;
		$event['additional_sql_data'] = $additional_sql_data;
	}

	public function prepare_image_move(\phpbb\event\data $event): void
	{
		$target_data = (array) $event['target_data'];
		$image_move_data = (array) $event['image_move_data'];
		$image_move_data['image_contest'] = (int) manager::STATE_INACTIVE;
		$image_move_data['image_contest_end'] = 0;
		$image_move_data['image_contest_rank'] = 0;

		if ((int) ($target_data['album_type'] ?? -1) !== (int) manager::ALBUM_TYPE
			|| (int) ($target_data['contest_marked'] ?? manager::STATE_INACTIVE)
				!== (int) manager::STATE_ACTIVE)
		{
			$event['image_move_data'] = $image_move_data;
			return;
		}

		$image_move_data['image_contest'] = (int) manager::STATE_ACTIVE;
		$event['image_move_data'] = $image_move_data;
	}

	public function resync_contest_results(\phpbb\event\data $event): void
	{
		$album_ids = (array) $event['album_ids'];
		if ($album_ids)
		{
			$this->contest->resync_albums($album_ids);
		}
	}

	public function register_album_type(\phpbb\event\data $event): void
	{
		$types = (array) $event['types'];
		$context = (array) $event['context'];
		if ((string) ($context['action'] ?? '') === 'edit'
			&& isset($context['original_type'])
			&& (int) $context['original_type'] !== (int) manager::ALBUM_TYPE)
		{
			$event['types'] = $types;
			return;
		}
		$types[(int) manager::ALBUM_TYPE] = [
			'lang' => 'CONTEST',
			'accepts_images' => true,
			'can_create' => $this->contest->can_create(),
			'immutable' => true,
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

	public function restrict_sort_keys(\phpbb\event\data $event): void
	{
		$album_data = (array) $event['album_data'];
		if (!empty($album_data['contest_marked']) && !(bool) $event['can_moderate'])
		{
			$event['sort_keys'] = array_merge(
				(array) $event['sort_keys'],
				['u', 'ra', 'r', 'c', 'lc']
			);
		}
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
