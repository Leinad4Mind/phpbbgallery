<?php
/**
 * phpBB Gallery - BBPoints image lifecycle listener
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbpointsimages\event;

use phpbb\controller\helper;
use phpbb\event\data;
use phpbb\language\language;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;
use phpbbgallery\bbpointsimages\purchase_manager;
use phpbbgallery\bbpointsimages\reward_manager;
use sitesplat\bbpoints\exception\insufficient_funds;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class main_listener implements EventSubscriberInterface
{
	public function __construct(
		private reward_manager $rewards,
		private purchase_manager $purchases,
		private request_interface $request,
		private user $user,
		private language $language,
		private helper $helper,
		private template $template
	)
	{
	}

	public static function getSubscribedEvents(): array
	{
		return [
			'phpbbgallery.core.upload.update_image_after' => 'uploaded',
			'phpbbgallery.core.image.approve_after' => 'approved',
			'phpbbgallery.core.image.change_author_after' => 'author_changed',
			'phpbbgallery.acpimport.insert_image_after' => 'imported',
			'phpbbgallery.core.file.source_access' => 'source_access',
			'phpbbgallery.core.viewimage' => 'viewimage',
		];
	}

	public function uploaded(data $event): void
	{
		$this->rewards->reward((array) $event['image_data'], (string) $event['file_link']);
	}

	public function approved(data $event): void
	{
		foreach ((array) $event['approved_images'] as $image_data)
		{
			$this->rewards->reward((array) $image_data, (string) $image_data['source_path']);
		}
	}

	public function imported(data $event): void
	{
		$this->rewards->reward((array) $event['image_data'], (string) $event['file_link']);
	}

	public function author_changed(data $event): void
	{
		$author = (array) $event['author'];
		$this->rewards->reassign((array) $event['image_ids'], (int) ($author['user_id'] ?? 0));
	}

	public function source_access(data $event): void
	{
		$source_path = (string) $event['source_path'];
		if (!is_file($source_path))
		{
			return;
		}

		$this->language->add_lang('info_acp_bbpointsimages', 'phpbbgallery/bbpointsimages');
		$image_data = (array) $event['image_data'];
		$image_id = (int) $image_data['image_id'];
		$buyer_id = (int) $this->user->data['user_id'];
		$quote = $this->purchases->quote($image_data, $buyer_id);
		if ($quote['requires_purchase'])
		{
			$source_url = $this->helper->route('phpbbgallery_core_image_file_source', ['image_id' => $image_id]);
			if (empty($this->user->data['is_registered']))
			{
				login_box($source_url, $this->language->lang('BBPOINTSIMAGES_SOURCE_LOGIN'));
			}

			if (!confirm_box(true))
			{
				if ($this->request->is_set_post('cancel'))
				{
					redirect($this->helper->route('phpbbgallery_core_image', ['image_id' => $image_id]));
				}
				confirm_box(
					false,
					$this->language->lang('BBPOINTSIMAGES_SOURCE_PURCHASE_CONFIRM', $quote['cost']),
					'',
					'confirm_body.html',
					$source_url
				);
			}

			try
			{
				$this->purchases->purchase($image_data, $buyer_id);
			}
			catch (insufficient_funds $exception)
			{
				throw new \phpbb\exception\http_exception(403, 'BBPOINTSIMAGES_INSUFFICIENT_FUNDS', [
					$exception->get_available(),
					$exception->get_required(),
				]);
			}
			catch (\RuntimeException $exception)
			{
				throw new \phpbb\exception\http_exception(503, 'BBPOINTSIMAGES_SOURCE_UNAVAILABLE', [], $exception);
			}
		}

		$this->purchases->record_download($image_id, $buyer_id);
	}

	public function viewimage(data $event): void
	{
		$this->language->add_lang('info_acp_bbpointsimages', 'phpbbgallery/bbpointsimages');
		$image_id = (int) $event['image_id'];
		$this->template->assign_var(
			'BBPOINTSIMAGES_DOWNLOAD_COUNT',
			$this->purchases->get_download_count($image_id)
		);
	}
}
