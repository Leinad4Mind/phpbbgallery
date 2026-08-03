<?php
/**
 * phpBB Gallery Contest presentation integration.
 *
 * @package   phpbbgallery/contest
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\contest\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class presentation_listener implements EventSubscriberInterface
{
	private \phpbb\language\language $language;
	private \phpbb\user $user;

	public function __construct(\phpbb\language\language $language, \phpbb\user $user)
	{
		$this->language = $language;
		$this->user = $user;
	}

	public static function getSubscribedEvents(): array
	{
		return [
			'phpbbgallery.core.album.enrich_template_vars' => 'enrich_album_template_vars',
			'phpbbgallery.core.image_visibility.private_data_label' => 'private_data_label',
			'phpbbgallery.core.image_visibility.private_data_description' => 'private_data_description',
			'phpbbgallery.core.image_visibility.award' => 'image_award',
			'phpbbgallery.core.album_operation.message' => 'album_operation_message',
		];
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
			|| (int) ($album_data['album_type'] ?? -1) !== (int) \phpbbgallery\core\block::TYPE_CONTEST)
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
		if ((string) $event['context'] !== 'navigation'
			|| (int) ($album_data['album_type'] ?? -1) !== (int) \phpbbgallery\core\block::TYPE_CONTEST
			|| !isset($album_data['contest_start'], $album_data['contest_rating'], $album_data['contest_end']))
		{
			return;
		}

		$start = (int) $album_data['contest_start'];
		$rating_start = $start + (int) $album_data['contest_rating'];
		$end = $start + (int) $album_data['contest_end'];
		$now = time();
		$template_vars = (array) $event['template_vars'];
		$template_vars += [
			'ALBUM_CONTEST_START' => $this->phase_text('CONTEST_START', $start, $now),
			'ALBUM_CONTEST_RATING' => $this->phase_text('CONTEST_RATING_START', $rating_start, $now),
			'ALBUM_CONTEST_END' => $this->phase_text('CONTEST_END', $end, $now),
		];
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
