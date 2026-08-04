<?php
/**
 * phpBB Gallery - BBPoints Images album settings listener.
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbpointsimages\event;

use phpbb\event\data;
use phpbb\language\language;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbbgallery\bbpointsimages\policy;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class acp_listener implements EventSubscriberInterface
{
	public function __construct(
		private policy $policy,
		private request_interface $request,
		private template $template,
		private language $language
	)
	{
	}

	public static function getSubscribedEvents(): array
	{
		return [
			'phpbbgallery.core.acp.albums.send_to_template' => 'display_album_settings',
			'phpbbgallery.core.album.manage.created' => 'save_album_settings',
			'phpbbgallery.core.album.manage.updated' => 'save_album_settings',
		];
	}

	public function display_album_settings(data $event): void
	{
		$this->language->add_lang('info_acp_bbpointsimages', 'phpbbgallery/bbpointsimages');
		$album_data = (array) $event['album_data'];
		$album_id = (int) ($album_data['album_id'] ?? 0);
		$parent_id = (int) ($album_data['parent_id'] ?? 0);
		$direct = [
			'upload_reward' => policy::INHERIT,
			'source_cost' => policy::INHERIT,
			'contributors_enabled' => policy::INHERIT,
		];

		if ($album_id > 0)
		{
			try
			{
				$stored = $this->policy->get_album_rule($album_id);
				foreach (array_keys($direct) as $setting)
				{
					$direct[$setting] = $stored[$setting] === null
						? policy::INHERIT
						: (int) $stored[$setting];
				}
			}
			catch (\OutOfBoundsException)
			{
				// Only public albums are editable in this ACP module.
			}
		}

		if ($this->request->is_set_post('update'))
		{
			$direct = $this->requested_rule();
		}

		$inherited = $this->policy->get_global_rule();
		if ($parent_id > 0)
		{
			try
			{
				$inherited = $this->policy->resolve($parent_id);
			}
			catch (\OutOfBoundsException)
			{
				// A concurrently removed parent falls back safely to the globals.
			}
		}
		$effective = [];
		foreach ($direct as $setting => $value)
		{
			$effective[$setting] = $value >= 0 ? $value : $inherited[$setting];
		}

		$this->template->assign_vars([
			'BBPOINTSIMAGES_ALBUM_UPLOAD_REWARD' => $direct['upload_reward'],
			'BBPOINTSIMAGES_ALBUM_SOURCE_COST' => $direct['source_cost'],
			'BBPOINTSIMAGES_ALBUM_CONTRIBUTORS' => $direct['contributors_enabled'],
			'BBPOINTSIMAGES_EFFECTIVE_UPLOAD_REWARD' => $effective['upload_reward'],
			'BBPOINTSIMAGES_EFFECTIVE_SOURCE_COST' => $effective['source_cost'],
			'BBPOINTSIMAGES_EFFECTIVE_CONTRIBUTORS' => $effective['contributors_enabled'],
		]);
	}

	public function save_album_settings(data $event): void
	{
		$album_id = (int) $event['album_id'];
		if ($album_id > 0)
		{
			$this->policy->save_album_rule($album_id, $this->requested_rule());
		}
	}

	/**
	 * @return array{upload_reward: int, source_cost: int, contributors_enabled: int}
	 */
	private function requested_rule(): array
	{
		return [
			'upload_reward' => policy::normalize_override($this->request->variable(
				'bbpointsimages_upload_reward', policy::INHERIT, false, request_interface::POST
			)),
			'source_cost' => policy::normalize_override($this->request->variable(
				'bbpointsimages_source_cost', policy::INHERIT, false, request_interface::POST
			)),
			'contributors_enabled' => policy::normalize_toggle_override($this->request->variable(
				'bbpointsimages_contributors_enabled', policy::INHERIT, false, request_interface::POST
			)),
		];
	}
}
