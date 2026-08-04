<?php
/**
 * phpBB Gallery - Image revision album settings listener.
 *
 * @package   phpbbgallery/imagerevisions
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\imagerevisions\event;

use phpbb\event\data;
use phpbb\language\language;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbbgallery\imagerevisions\policy;
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
			'phpbbgallery.core.album.manage.created' => 'save_created_album_settings',
			'phpbbgallery.core.album.manage.updated' => 'save_updated_album_settings',
			'phpbbgallery.core.album.manage.delete_album_content' => 'delete_album_settings',
		];
	}

	public function display_album_settings(data $event): void
	{
		$this->language->add_lang('info_acp_imagerevisions', 'phpbbgallery/imagerevisions');
		$album_data = (array) $event['album_data'];
		$album_id = (int) ($album_data['album_id'] ?? 0);
		$parent_id = (int) ($album_data['parent_id'] ?? 0);
		$direct = ['enabled' => policy::INHERIT, 'revision_limit' => policy::INHERIT];
		if ($album_id > 0)
		{
			try
			{
				$stored = $this->policy->get_album_rule($album_id);
				$direct['enabled'] = $stored['enabled'] === null ? policy::INHERIT : (int) $stored['enabled'];
				$direct['revision_limit'] = $stored['revision_limit'] === null ? policy::INHERIT : (int) $stored['revision_limit'];
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
				// A concurrently removed parent falls back to the globals.
			}
		}
		$this->template->assign_vars([
			'IMAGEREVISIONS_ALBUM_ENABLED' => $direct['enabled'],
			'IMAGEREVISIONS_ALBUM_LIMIT' => $direct['revision_limit'],
			'IMAGEREVISIONS_EFFECTIVE_ENABLED' => $direct['enabled'] >= 0 ? $direct['enabled'] : $inherited['enabled'],
			'IMAGEREVISIONS_EFFECTIVE_LIMIT' => $direct['revision_limit'] >= policy::MIN_LIMIT
				? $direct['revision_limit'] : $inherited['revision_limit'],
		]);
	}

	public function save_created_album_settings(data $event): void
	{
		$album_data = (array) $event['album_data'];
		$this->save_album_settings((int) ($album_data['album_id'] ?? 0));
	}

	public function save_updated_album_settings(data $event): void
	{
		$this->save_album_settings((int) $event['album_id']);
	}

	private function save_album_settings(int $album_id): void
	{
		if ($album_id > 0)
		{
			$this->policy->save_album_rule($album_id, $this->requested_rule());
		}
	}

	public function delete_album_settings(data $event): void
	{
		$this->policy->delete_for_albums([(int) $event['album_id']]);
	}

	/** @return array{enabled: int, revision_limit: int} */
	private function requested_rule(): array
	{
		return [
			'enabled' => policy::normalize_toggle_override($this->request->variable(
				'imagerevisions_enabled', policy::INHERIT, false, request_interface::POST
			)),
			'revision_limit' => policy::normalize_limit_override($this->request->variable(
				'imagerevisions_limit', policy::INHERIT, false, request_interface::POST
			)),
		];
	}
}
