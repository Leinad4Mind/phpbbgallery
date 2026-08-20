<?php
/**
 * phpBB Gallery Contest album lifecycle.
 *
 * @package   phpbbgallery/contest
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\contest\event;

use phpbbgallery\contest\manager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class album_lifecycle_listener implements EventSubscriberInterface
{
	public function __construct(
		private \phpbb\db\driver\driver_interface $db,
		private \phpbb\db\tools\tools_interface $db_tools,
		private \phpbb\language\language $language,
		private \phpbb\user $user,
		private \phpbbgallery\contest\manager $contest,
		private string $albums_table,
		private string $images_table,
		private string $contests_table
	)
	{
	}

	public static function getSubscribedEvents(): array
	{
		return [
			'phpbbgallery.core.album.manage.validate_type_data' => 'validate',
			'phpbbgallery.core.album.manage.created' => 'created',
			'phpbbgallery.core.album.manage.prepare_update' => 'prepare_update',
			'phpbbgallery.core.album.manage.updated' => 'updated',
			'phpbbgallery.core.album.manage.prepare_move_album_content' => 'prepare_move_album_content',
			'phpbbgallery.core.album.manage.move_album_content' => 'moved_album_content',
			'phpbbgallery.core.album.manage.delete_album_content' => 'deleted_album_content',
		];
	}

	public function validate(\phpbb\event\data $event): void
	{
		$album_data = (array) $event['album_data'];
		if ((int) ($album_data['album_type'] ?? -1) !== (int) manager::ALBUM_TYPE)
		{
			return;
		}

		$this->language->add_lang('contest_acp', 'phpbbgallery/contest');
		$errors = (array) $event['errors'];
		$data = (array) $event['album_type_data'];
		if (!$this->schema_ready())
		{
			$errors[] = $this->language->lang('CONTEST_SCHEMA_OUTDATED');
			$event['errors'] = $errors;
			return;
		}

		if (!isset($album_data['album_id']) && !$this->contest->can_create())
		{
			$errors[] = $this->language->lang('CONTEST_CREATION_DISABLED');
		}

		$start = $this->parse_date((string) ($data['contest_start'] ?? ''));
		$rating = $this->parse_date((string) ($data['contest_rating'] ?? ''));
		$end = $this->parse_date((string) ($data['contest_end'] ?? ''));
		$existing_dates = $this->existing_dates($album_data);
		$now = time();
		foreach ([
			[$start, 'CONTEST_START_INVALID', 'contest_start', 'CONTEST_START'],
			[$rating, 'CONTEST_RATING_INVALID', 'contest_rating', 'CONTEST_RATING'],
			[$end, 'CONTEST_END_INVALID', 'contest_end', 'CONTEST_END'],
		] as [$timestamp, $lang, $field, $label])
		{
			if ($timestamp === false)
			{
				$errors[] = $this->language->lang($lang, $data[$field] ?? '');
			}
			else if ($timestamp <= $now && !$this->is_existing_date($timestamp, $existing_dates[$field] ?? null))
			{
				$errors[] = $this->language->lang(
					'CONTEST_DATE_MUST_BE_FUTURE',
					$this->language->lang($label)
				);
			}
		}

		if ($start !== false && $rating !== false && $end !== false)
		{
			$data['contest_start'] = $start;
			$data['contest_rating'] = $rating - $start;
			$data['contest_end'] = $end - $start;
			if ($data['contest_end'] < $data['contest_rating'])
			{
				$errors[] = $this->language->lang('CONTEST_END_BEFORE_RATING');
			}
			if ($data['contest_rating'] < 0)
			{
				$errors[] = $this->language->lang('CONTEST_RATING_BEFORE_START');
			}
			if ($data['contest_end'] < 0)
			{
				$errors[] = $this->language->lang('CONTEST_END_BEFORE_START');
			}
		}

		$event['album_type_data'] = $data;
		$event['errors'] = $errors;
	}

	public function created(\phpbb\event\data $event): void
	{
		$album_data = (array) $event['album_data'];
		if ((int) $album_data['album_type'] !== (int) manager::ALBUM_TYPE)
		{
			return;
		}

		$data = (array) $event['album_type_data'];
		$data['contest_album_id'] = (int) $album_data['album_id'];
		$data['contest_marked'] = (int) manager::STATE_ACTIVE;
		$this->db->sql_query('INSERT INTO ' . $this->contests_table . ' ' . $this->db->sql_build_array('INSERT', $data));
		$contest_id = (int) $this->db->sql_nextid();
		$this->db->sql_query('UPDATE ' . $this->albums_table . '
			SET album_contest = ' . $contest_id . '
			WHERE album_id = ' . (int) $album_data['album_id']);
		$album_data['album_contest'] = $contest_id;
		$event['album_data'] = $album_data;
	}

	public function prepare_update(\phpbb\event\data $event): void
	{
		$this->language->add_lang('contest_acp', 'phpbbgallery/contest');
		$row = (array) $event['row'];
		$album_data = (array) $event['album_data_sql'];
		$old_type = (int) $row['album_type'];
		$new_type = (int) $album_data['album_type'];
		$errors = (array) $event['errors'];
		if (($old_type === (int) manager::ALBUM_TYPE) !==
			($new_type === (int) manager::ALBUM_TYPE))
		{
			$errors[] = $this->language->lang(
				$old_type === (int) manager::ALBUM_TYPE
					? 'ALBUM_WITH_CONTEST_NO_TYPE_CHANGE'
					: 'ALBUM_NO_TYPE_CHANGE_TO_CONTEST'
			);
			$event['errors'] = $errors;
			return;
		}
		if ($new_type !== (int) manager::ALBUM_TYPE)
		{
			return;
		}

		$data = (array) $event['album_type_data'];
		$existing = $this->contest->get_contest((int) $row['album_id'], 'album');
		$data['contest_id'] = (int) $existing['contest_id'];
		$state = (array) $event['album_type_state'];
		if ((int) $existing['contest_marked'] === (int) manager::STATE_INACTIVE
			&& (int) $data['contest_start'] + (int) $data['contest_end'] > time())
		{
			$data['contest_marked'] = (int) manager::STATE_ACTIVE;
			$state['reset_marked_images'] = true;
		}
		$event['album_type_data'] = $data;
		$event['album_type_state'] = $state;
	}

	public function updated(\phpbb\event\data $event): void
	{
		$album_data = (array) $event['album_data_sql'];
		if ((int) $album_data['album_type'] !== (int) manager::ALBUM_TYPE)
		{
			return;
		}

		$data = (array) $event['album_type_data'];
		$fields = [
			'contest_start' => (int) $data['contest_start'],
			'contest_rating' => (int) $data['contest_rating'],
			'contest_end' => (int) $data['contest_end'],
			'contest_winner_thumbnail' => manager::normalize_thumbnail_policy(
				(int) ($data['contest_winner_thumbnail'] ?? manager::THUMBNAIL_INHERIT)
			),
		];
		if (isset($data['contest_marked']))
		{
			$fields['contest_marked'] = (int) $data['contest_marked'];
		}
		$this->db->sql_query('UPDATE ' . $this->contests_table . '
			SET ' . $this->db->sql_build_array('UPDATE', $fields) . '
			WHERE contest_id = ' . (int) $data['contest_id']);

		$state = (array) $event['album_type_state'];
		if (!empty($state['reset_marked_images']))
		{
			$this->db->sql_query('UPDATE ' . $this->images_table . '
				SET image_contest_rank = 0,
					image_contest_end = 0,
					image_contest = ' . (int) manager::STATE_ACTIVE . '
				WHERE image_album_id = ' . (int) $event['album_id']);
		}
	}

	public function prepare_move_album_content(\phpbb\event\data $event): void
	{
		$data = (array) $event['image_move_data'];
		$data['image_contest_rank'] = 0;
		$data['image_contest_end'] = 0;
		$data['image_contest'] = (int) manager::STATE_INACTIVE;
		$event['image_move_data'] = $data;
	}

	public function moved_album_content(\phpbb\event\data $event): void
	{
		if (!empty($event['preserve_album_state']))
		{
			return;
		}

		$this->delete_contest((int) $event['from_id']);
	}

	public function deleted_album_content(\phpbb\event\data $event): void
	{
		if (!empty($event['preserve_album_state']))
		{
			return;
		}

		$this->delete_contest((int) $event['album_id']);
	}

	private function delete_contest(int $album_id): void
	{
		$this->db->sql_query('DELETE FROM ' . $this->contests_table . '
			WHERE contest_album_id = ' . (int) $album_id);
	}

	private function schema_ready(): bool
	{
		return $this->db_tools->sql_table_exists($this->contests_table)
			&& $this->db_tools->sql_column_exists($this->contests_table, 'contest_winner_thumbnail');
	}

	private function parse_date(string $value): int|false
	{
		if (!preg_match('#\A\d{4}-\d{1,2}-\d{1,2}[T ]\d{1,2}:\d{2}\z#', $value))
		{
			return false;
		}
		$value = str_replace('T', ' ', $value);
		try
		{
			$timezone = new \DateTimeZone($this->user->data['user_timezone'] ?: 'UTC');
		}
		catch (\Exception)
		{
			$timezone = new \DateTimeZone('UTC');
		}
		$date = \DateTimeImmutable::createFromFormat('!Y-n-j G:i', $value, $timezone);
		$errors = \DateTimeImmutable::getLastErrors();
		return $date !== false && ($errors === false || (!$errors['warning_count'] && !$errors['error_count']))
			? $date->getTimestamp()
			: false;
	}

	/**
	 * Return the absolute dates already stored for an existing contest.
	 *
	 * @param array $album_data Album data being validated
	 * @return array<string, int>
	 */
	private function existing_dates(array $album_data): array
	{
		$album_id = (int) ($album_data['album_id'] ?? 0);
		if ($album_id <= 0)
		{
			return [];
		}

		$contest = $this->contest->get_contest($album_id, 'album', false);
		if (!$contest)
		{
			return [];
		}

		$start = (int) ($contest['contest_start'] ?? 0);
		return [
			'contest_start' => $start,
			'contest_rating' => $start + (int) ($contest['contest_rating'] ?? 0),
			'contest_end' => $start + (int) ($contest['contest_end'] ?? 0),
		];
	}

	private function is_existing_date(int $timestamp, ?int $existing): bool
	{
		return $existing !== null && intdiv($timestamp, 60) === intdiv($existing, 60);
	}
}
