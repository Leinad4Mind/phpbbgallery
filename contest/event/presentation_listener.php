<?php
/**
 * phpBB Gallery Contest presentation integration.
 *
 * @package   phpbbgallery/contest
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\contest\event;

use phpbbgallery\contest\manager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class presentation_listener implements EventSubscriberInterface
{
	private \phpbb\language\language $language;
	private \phpbb\user $user;
	private \phpbb\controller\helper $helper;

	public function __construct(
		\phpbb\language\language $language,
		\phpbb\user $user,
		\phpbb\controller\helper $helper
	)
	{
		$this->language = $language;
		$this->user = $user;
		$this->helper = $helper;
		$this->language->add_lang('contest', 'phpbbgallery/contest');
	}

	public static function getSubscribedEvents(): array
	{
		return [
			'phpbbgallery.core.album.enrich_template_vars' => 'enrich_album_template_vars',
			'phpbbgallery.core.image_visibility.private_data_label' => 'private_data_label',
			'phpbbgallery.core.image_visibility.private_data_description' => 'private_data_description',
			'phpbbgallery.core.image_visibility.hidden_results_message' => 'hidden_results_message',
			'phpbbgallery.core.image_visibility.award' => 'image_award',
			'phpbbgallery.core.album_operation.message' => 'album_operation_message',
		];
	}

	public function hidden_results_message(\phpbb\event\data $event): void
	{
		if (!\phpbbgallery\contest\manager::hides_results(
			(array) $event['image_data'],
			(bool) $event['can_moderate']
		))
		{
			return;
		}

		if (!(bool) $event['detailed'])
		{
			$event['message'] = $this->language->lang('CONTEST_RATING_HIDDEN');
			return;
		}

		$album_data = (array) $event['album_data'];
		$end_time = (int) ($album_data['contest_start'] ?? 0) + (int) ($album_data['contest_end'] ?? 0);
		if ($end_time > 0)
		{
			$event['message'] = $this->language->lang(
				'CONTEST_RESULT_HIDDEN',
				$this->user->format_date($end_time, false, true)
			);
		}
	}

	public function image_award(\phpbb\event\data $event): void
	{
		$rank = (int) (((array) $event['image_data'])['image_contest_rank'] ?? 0);
		if ($rank < 1 || $rank > 3)
		{
			return;
		}

		$event['rank'] = $rank;
		$event['label'] = $this->language->lang('CONTEST_RESULT_' . $rank);
		$event['title'] = $this->language->lang('CONTEST_RESULT');
	}

	public function album_operation_message(\phpbb\event\data $event): void
	{
		$album_data = (array) $event['album_data'];
		if ((string) $event['operation'] !== 'comment'
			|| (int) ($album_data['album_type'] ?? -1) !== (int) manager::ALBUM_TYPE)
		{
			return;
		}

		$end_time = (int) ($album_data['contest_start'] ?? 0) + (int) ($album_data['contest_end'] ?? 0);
		if ($end_time > 0)
		{
			$event['message'] = $this->language->lang(
				'CONTEST_COMMENTS_STARTS',
				$this->user->format_date($end_time, false, true)
			);
		}
	}

	public function private_data_label(\phpbb\event\data $event): void
	{
		if (\phpbbgallery\contest\manager::hides_private_data(
			(array) $event['image_data'],
			(int) $event['viewer_id'],
			(bool) $event['can_moderate']
		))
		{
			$event['label'] = $this->language->lang('CONTEST_USERNAME');
		}
	}

	public function private_data_description(\phpbb\event\data $event): void
	{
		if (!\phpbbgallery\contest\manager::hides_private_data(
			(array) $event['image_data'],
			(int) $event['viewer_id'],
			(bool) $event['can_moderate']
		))
		{
			return;
		}

		$album_data = (array) $event['album_data'];
		$end_time = (int) ($album_data['contest_start'] ?? 0) + (int) ($album_data['contest_end'] ?? 0);
		if ($end_time > 0)
		{
			$event['description'] = $this->language->lang(
				'CONTEST_IMAGE_DESC',
				$this->user->format_date($end_time, false, true)
			);
		}
	}

	public function enrich_album_template_vars(\phpbb\event\data $event): void
	{
		$album_data = (array) $event['album_data'];
		if ((string) $event['context'] === 'album_list')
		{
			$this->use_winner_thumbnail($event, $album_data);
			return;
		}

		if ((string) $event['context'] !== 'navigation'
			|| (int) ($album_data['album_type'] ?? -1) !== (int) manager::ALBUM_TYPE
			|| !isset($album_data['contest_start'], $album_data['contest_rating'], $album_data['contest_end']))
		{
			return;
		}

		$start = (int) $album_data['contest_start'];
		$rating_start = $start + (int) $album_data['contest_rating'];
		$end = $start + (int) $album_data['contest_end'];
		$now = time();
		$phase = manager::phase($album_data, $now);
		if ($phase === manager::PHASE_INVALID)
		{
			return;
		}

		$phase_language_key = match ($phase)
		{
			manager::PHASE_UPCOMING => 'CONTEST_PHASE_UPCOMING',
			manager::PHASE_UPLOAD => 'CONTEST_PHASE_UPLOAD',
			manager::PHASE_RATING => 'CONTEST_PHASE_RATING',
			default => 'CONTEST_PHASE_FINISHED',
		};
		$phase_help_key = $phase_language_key . '_EXPLAIN';
		$phase_boundary = match ($phase)
		{
			manager::PHASE_UPCOMING => $start,
			manager::PHASE_UPLOAD => $rating_start,
			manager::PHASE_RATING => $end,
			default => 0,
		};
		$timezone = (string) ($this->user->data['user_timezone'] ?? 'UTC');
		$template_vars = (array) $event['template_vars'];
		$template_vars += [
			'S_ALBUM_TYPE_DETAILS' => true,
			'S_CONTEST_PHASE_UPCOMING' => $phase === manager::PHASE_UPCOMING,
			'S_CONTEST_PHASE_UPLOAD' => $phase === manager::PHASE_UPLOAD,
			'S_CONTEST_PHASE_RATING' => $phase === manager::PHASE_RATING,
			'S_CONTEST_PHASE_FINISHED' => $phase === manager::PHASE_FINISHED,
			'CONTEST_PHASE_LABEL' => $this->language->lang($phase_language_key),
			'CONTEST_PHASE_EXPLAIN' => $phase_boundary > 0
				? $this->language->lang(
					$phase_help_key,
					$this->user->format_date($phase_boundary, false, true)
				)
				: $this->language->lang($phase_help_key),
			'CONTEST_START_DATE' => $this->user->format_date($start, false, true),
			'CONTEST_RATING_DATE' => $this->user->format_date($rating_start, false, true),
			'CONTEST_END_DATE' => $this->user->format_date($end, false, true),
			'CONTEST_TIMEZONE' => $this->language->lang('CONTEST_SCHEDULE_TIMEZONE', $timezone),
			'ALBUM_CONTEST_START' => $this->phase_text('CONTEST_START', $start, $now),
			'ALBUM_CONTEST_RATING' => $this->phase_text('CONTEST_RATING_START', $rating_start, $now),
			'ALBUM_CONTEST_END' => $this->phase_text('CONTEST_END', $end, $now),
		];
		$event['template_vars'] = $template_vars;
	}

	private function use_winner_thumbnail(\phpbb\event\data $event, array $album_data): void
	{
		$image_id = (int) ($album_data['contest_thumbnail_image_id'] ?? 0);
		$template_vars = (array) $event['template_vars'];
		if ($image_id <= 0
			|| !empty($album_data['album_image'])
			|| empty($template_vars['UC_THUMBNAIL']))
		{
			return;
		}

		$thumbnail = $this->helper->route(
			'phpbbgallery_core_image_file_mini',
			['image_id' => $image_id]
		);
		$template_vars['UC_THUMBNAIL'] = $thumbnail;
		$template_vars['UC_FAKE_THUMBNAIL'] = $thumbnail;
		$template_vars['UC_IMAGE_URL'] = $this->helper->route(
			'phpbbgallery_core_image',
			['image_id' => $image_id]
		);
		$event['template_vars'] = $template_vars;
	}

	private function phase_text(string $language_prefix, int $timestamp, int $now): string
	{
		$language_key = $language_prefix . ($timestamp < $now ? 'ED' : 'S');

		return $this->language->lang(
			$language_key,
			$this->user->format_date($timestamp, false, true)
		);
	}
}
