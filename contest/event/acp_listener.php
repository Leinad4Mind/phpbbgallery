<?php
/**
 * phpBB Gallery Contest ACP integration.
 *
 * @package   phpbbgallery/contest
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\contest\event;

use phpbbgallery\contest\manager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Adds contest-owned settings to the Gallery Core configuration form.
 */
class acp_listener implements EventSubscriberInterface
{
	private \phpbb\language\language $language;
	private \phpbb\request\request_interface $request;
	private \phpbb\template\template $template;
	private \phpbb\user $user;
	private \phpbbgallery\contest\manager $contest;

	public function __construct(
		\phpbb\language\language $language,
		\phpbb\request\request_interface $request,
		\phpbb\template\template $template,
		\phpbb\user $user,
		\phpbbgallery\contest\manager $contest
	)
	{
		$this->language = $language;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->contest = $contest;
	}

	public static function getSubscribedEvents(): array
	{
		return [
			'phpbbgallery.core.acp.config.get_display_vars' => 'add_config',
			'phpbbgallery.core.acp.album_ratings_reset' => 'resync_contest_results',
			'phpbbgallery.core.acp.albums.request_data' => 'request_album_type_data',
			'phpbbgallery.core.acp.albums.default_data' => 'default_album_type_data',
			'phpbbgallery.core.acp.albums.load_type_data' => 'load_album_type_data',
			'phpbbgallery.core.acp.albums.send_to_template' => 'send_album_type_to_template',
		];
	}

	public function resync_contest_results(\phpbb\event\data $event): void
	{
		$this->contest->resync((int) $event['album_id']);
	}

	public function add_config(\phpbb\event\data $event): void
	{
		if ((string) $event['mode'] !== 'main')
		{
			return;
		}

		$this->load_acp_language();
		$return_ary = (array) $event['return_ary'];
		$settings = (array) ($return_ary['vars']['GALLERY_CONFIG'] ?? []);
		$contest = [
			'allow_contests' => [
				'lang' => 'CONTEST_CREATION',
				'validate' => 'bool',
				'type' => 'radio:yes_no',
				'explain' => true,
				'addon' => ['id' => 'contest', 'name' => 'ALBUM_TYPE_CONTEST', 'accent' => '#c2410c'],
			],
			'contest_winner_thumbnail' => [
				'lang' => 'CONTEST_WINNER_THUMBNAIL',
				'validate' => 'bool',
				'type' => 'radio:yes_no',
				'explain' => true,
				'addon' => ['id' => 'contest', 'name' => 'ALBUM_TYPE_CONTEST', 'accent' => '#c2410c'],
			],
		];

		$position = array_search('items_per_page', array_keys($settings), true);
		if ($position === false)
		{
			$settings += $contest;
		}
		else
		{
			$position++;
			$settings = array_slice($settings, 0, $position, true)
				+ $contest
				+ array_slice($settings, $position, null, true);
		}

		$return_ary['vars']['GALLERY_CONFIG'] = $settings;
		$event['return_ary'] = $return_ary;
	}

	public function request_album_type_data(\phpbb\event\data $event): void
	{
		$this->load_acp_language();
		$event['album_type_data'] = [
			'contest_start' => $this->request->variable('contest_start', ''),
			'contest_rating' => $this->request->variable('contest_rating', ''),
			'contest_end' => $this->request->variable('contest_end', ''),
			'contest_winner_thumbnail' => manager::normalize_thumbnail_policy(
				$this->request->variable('contest_winner_thumbnail', manager::THUMBNAIL_INHERIT)
			),
		];
	}

	public function default_album_type_data(\phpbb\event\data $event): void
	{
		$this->load_acp_language();
		$event['album_type_data'] = [
			'contest_start' => time(),
			'contest_rating' => 3 * 86400,
			'contest_end' => 7 * 86400,
			'contest_winner_thumbnail' => manager::THUMBNAIL_INHERIT,
		];
	}

	public function load_album_type_data(\phpbb\event\data $event): void
	{
		$this->load_acp_language();
		$album_data = (array) $event['album_data'];
		if ((int) ($album_data['album_type'] ?? -1) === (int) manager::ALBUM_TYPE)
		{
			$event['album_type_data'] = $this->contest->get_contest((int) $album_data['album_id'], 'album');
			return;
		}

		$this->default_album_type_data($event);
	}

	public function send_album_type_to_template(\phpbb\event\data $event): void
	{
		$this->load_acp_language();
		$album_data = (array) $event['album_data'];
		$type_data = (array) $event['album_type_data'];
		$start = (int) ($type_data['contest_start'] ?? time());
		$this->template->assign_vars([
			'S_ALBUM_ORIG_CONTEST' => (int) ($event['old_album_type'] ?? -1) === (int) manager::ALBUM_TYPE,
			'S_ALBUM_CONTEST' => (int) ($album_data['album_type'] ?? -1) === (int) manager::ALBUM_TYPE,
			'ALBUM_CONTEST' => (int) manager::ALBUM_TYPE,
			'S_CONTEST_START' => $this->user->format_date($start, 'Y-m-d\TH:i'),
			'CONTEST_RATING' => $this->user->format_date($start + (int) ($type_data['contest_rating'] ?? 0), 'Y-m-d\TH:i'),
			'CONTEST_END' => $this->user->format_date($start + (int) ($type_data['contest_end'] ?? 0), 'Y-m-d\TH:i'),
			'CONTEST_WINNER_THUMBNAIL' => manager::normalize_thumbnail_policy(
				(int) ($type_data['contest_winner_thumbnail'] ?? manager::THUMBNAIL_INHERIT)
			),
			'CONTEST_THUMBNAIL_INHERIT' => manager::THUMBNAIL_INHERIT,
			'CONTEST_THUMBNAIL_LAST' => manager::THUMBNAIL_LAST,
			'CONTEST_THUMBNAIL_WINNER' => manager::THUMBNAIL_WINNER,
		]);
		$this->template->assign_block_vars('gallery_acp_addons', [
			'ID' => 'contest',
			'NAME' => $this->language->lang('ALBUM_TYPE_CONTEST'),
			'ACCENT' => '#c2410c',
		]);
	}

	private function load_acp_language(): void
	{
		$this->language->add_lang('contest_acp', 'phpbbgallery/contest');
	}
}
