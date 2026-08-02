<?php
/**
 * phpBB Gallery Contest album lifecycle.
 *
 * @package   phpbbgallery/contest
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\contest\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class album_lifecycle_listener implements EventSubscriberInterface
{
	public function __construct(
		private \phpbb\db\driver\driver_interface $db,
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
		];
	}

	public function validate(\phpbb\event\data $event): void
	{
		$album_data = (array) $event['album_data'];
		if ((int) ($album_data['album_type'] ?? -1) !== (int) \phpbbgallery\core\block::TYPE_CONTEST)
		{
			return;
		}

		$this->language->add_lang('contest_acp', 'phpbbgallery/contest');
		$errors = (array) $event['errors'];
		$data = (array) $event['album_type_data'];
		if (!isset($album_data['album_id']) && !$this->contest->can_create())
		{
			$errors[] = $this->language->lang('CONTEST_CREATION_DISABLED');
		}

		$start = $this->parse_date((string) ($data['contest_start'] ?? ''));
		$rating = $this->parse_date((string) ($data['contest_rating'] ?? ''));
		$end = $this->parse_date((string) ($data['contest_end'] ?? ''));
		foreach ([
			[$start, 'CONTEST_START_INVALID', 'contest_start'],
			[$rating, 'CONTEST_RATING_INVALID', 'contest_rating'],
			[$end, 'CONTEST_END_INVALID', 'contest_end'],
		] as [$timestamp, $lang, $field])
		{
			if ($timestamp === false)
			{
				$errors[] = $this->language->lang($lang, $data[$field] ?? '');
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
		if ((int) $album_data['album_type'] !== (int) \phpbbgallery\core\block::TYPE_CONTEST)
		{
			return;
		}

		$data = (array) $event['album_type_data'];
		$data['contest_album_id'] = (int) $album_data['album_id'];
		$data['contest_marked'] = (int) \phpbbgallery\core\block::IN_CONTEST;
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
		if (($old_type === (int) \phpbbgallery\core\block::TYPE_CONTEST) !==
			($new_type === (int) \phpbbgallery\core\block::TYPE_CONTEST))
		{
			$errors[] = $this->language->lang(
				$old_type === (int) \phpbbgallery\core\block::TYPE_CONTEST
					? 'ALBUM_WITH_CONTEST_NO_TYPE_CHANGE'
					: 'ALBUM_NO_TYPE_CHANGE_TO_CONTEST'
			);
			$event['errors'] = $errors;
			return;
		}
		if ($new_type !== (int) \phpbbgallery\core\block::TYPE_CONTEST)
		{
			return;
		}

		$data = (array) $event['album_type_data'];
		$existing = $this->contest->get_contest((int) $row['album_id'], 'album');
		$data['contest_id'] = (int) $existing['contest_id'];
		$state = (array) $event['album_type_state'];
		if ((int) $existing['contest_marked'] === (int) \phpbbgallery\core\block::NO_CONTEST
			&& (int) $data['contest_start'] + (int) $data['contest_end'] > time())
		{
			$data['contest_marked'] = (int) \phpbbgallery\core\block::IN_CONTEST;
			$state['reset_marked_images'] = true;
		}
		$event['album_type_data'] = $data;
		$event['album_type_state'] = $state;
	}

	public function updated(\phpbb\event\data $event): void
	{
		$album_data = (array) $event['album_data_sql'];
		if ((int) $album_data['album_type'] !== (int) \phpbbgallery\core\block::TYPE_CONTEST)
		{
			return;
		}

		$data = (array) $event['album_type_data'];
		$fields = [
			'contest_start' => (int) $data['contest_start'],
			'contest_rating' => (int) $data['contest_rating'],
			'contest_end' => (int) $data['contest_end'],
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
					image_contest = ' . (int) \phpbbgallery\core\block::IN_CONTEST . '
				WHERE image_album_id = ' . (int) $event['album_id']);
		}
	}

	private function parse_date(string $value): int|false
	{
		if (!preg_match('#\A\d{4}-\d{1,2}-\d{1,2} \d{1,2}:\d{2}\z#', $value))
		{
			return false;
		}
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
}
