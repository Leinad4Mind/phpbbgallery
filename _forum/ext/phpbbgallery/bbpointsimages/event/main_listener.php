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
use phpbb\config\config;
use phpbb\event\data;
use phpbb\language\language;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;
use phpbbgallery\bbpointsimages\purchase_manager;
use phpbbgallery\bbpointsimages\reward_manager;
use phpbbgallery\bbpointsimages\contributor_manager;
use phpbbgallery\bbpointsimages\notification\helper as notification_helper;
use phpbbgallery\core\url;
use sitesplat\bbpoints\exception\insufficient_funds;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class main_listener implements EventSubscriberInterface
{
	public function __construct(
		private reward_manager $rewards,
		private purchase_manager $purchases,
		private contributor_manager $contributors,
		private notification_helper $notifications,
		private request_interface $request,
		private user $user,
		private language $language,
		private helper $helper,
		private template $template,
		private config $config,
		private url $gallery_url
	)
	{
	}

	public static function getSubscribedEvents(): array
	{
		return [
			'core.user_setup' => 'load_language_on_setup',
			'phpbbgallery.core.upload.update_image_after' => 'uploaded',
			'phpbbgallery.core.upload.review_validate' => 'validate_upload_review',
			'phpbbgallery.core.upload.review_display' => 'display_upload_review',
			'phpbbgallery.core.image_edit_file' => 'validate_image_edit',
			'phpbbgallery.core.image_edit_display' => 'display_image_edit',
			'phpbbgallery.core.image_edit_after' => 'save_image_edit',
			'phpbbgallery.core.image.approve_after' => 'approved',
			'phpbbgallery.core.image.change_author_after' => 'author_changed',
			'phpbbgallery.core.image.delete_images' => 'images_deleted',
			'phpbbgallery.acpimport.insert_image_after' => 'imported',
			'phpbbgallery.core.file.source_access' => 'source_access',
			'phpbbgallery.core.viewimage' => 'viewimage',
		];
	}

	private array $validated_contributors = [];

	public function load_language_on_setup(data $event): void
	{
		$lang_set_ext = (array) $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name' => 'phpbbgallery/bbpointsimages',
			'lang_set' => 'info_acp_bbpointsimages',
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function uploaded(data $event): void
	{
		$image_data = (array) $event['image_data'];
		$this->save_contributors(
			(int) $event['image_id'],
			(int) $image_data['image_user_id'],
			(int) $event['image_index']
		);
		$this->reward_and_notify((array) $event['image_data'], (string) $event['file_link']);
	}

	public function validate_upload_review(data $event): void
	{
		if (!$this->assignment_enabled() || (string) $event['validation_error'] !== '')
		{
			return;
		}
		foreach (array_keys((array) $event['image_ids']) as $image_index)
		{
			$error = $this->validate_contributors((int) $image_index);
			if ($error !== '')
			{
				$event['validation_error'] = $error;
				return;
			}
		}
	}

	public function display_upload_review(data $event): void
	{
		$template_vars = (array) $event['image_template_vars'];
		$this->assign_contributor_field($template_vars, (int) $event['image_id'], (int) $event['image_index']);
		$event['image_template_vars'] = $template_vars;
	}

	public function validate_image_edit(data $event): void
	{
		if (!$this->assignment_enabled())
		{
			return;
		}
		$error = $this->validate_contributors(0);
		if ($error !== '')
		{
			$errors = (array) $event['errors'];
			$errors[] = $error;
			$event['errors'] = $errors;
		}
	}

	public function display_image_edit(data $event): void
	{
		$template_vars = (array) $event['template_vars'];
		$this->assign_contributor_field($template_vars, (int) $event['image_id'], 0);
		$event['template_vars'] = $template_vars;
	}

	public function save_image_edit(data $event): void
	{
		$updated = (array) $event['updated_image_data'];
		$this->save_contributors((int) $event['image_id'], (int) $updated['image_user_id'], 0);
	}

	public function approved(data $event): void
	{
		foreach ((array) $event['approved_images'] as $image_data)
		{
			$this->reward_and_notify((array) $image_data, (string) $image_data['source_path']);
		}
	}

	public function imported(data $event): void
	{
		$this->reward_and_notify((array) $event['image_data'], (string) $event['file_link']);
	}

	public function author_changed(data $event): void
	{
		$author = (array) $event['author'];
		$author_id = (int) ($author['user_id'] ?? 0);
		$changed = $this->rewards->reassign((array) $event['image_ids'], $author_id);
		$this->contributors->remove_author((array) $event['image_ids'], $author_id);
		if ($changed > 0)
		{
			foreach ((array) $event['image_data'] as $image_data)
			{
				$reward = $this->rewards->get_reward((int) $image_data['image_id']);
				if ($reward && (int) $reward['user_id'] === $author_id)
				{
					$image_data['image_user_id'] = $author_id;
					$this->notifications->reward($image_data, (int) $reward['amount']);
				}
			}
		}
	}

	public function images_deleted(data $event): void
	{
		$this->contributors->delete_for_images((array) $event['images']);
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
				$purchase = $this->purchases->purchase($image_data, $buyer_id);
				if ($purchase)
				{
					$this->notifications->source_purchase($image_data, $buyer_id, $purchase['recipients']);
				}
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
		if (!empty($event['hide_contest_private_data']))
		{
			return;
		}
		foreach ($this->contributors->get_for_image($image_id) as $contributor)
		{
			$this->template->assign_block_vars('bbpointsimages_contributors', [
				'FULL' => get_username_string(
					'full',
					(int) $contributor['user_id'],
					(string) $contributor['username'],
					(string) $contributor['user_colour']
				),
			]);
		}
	}

	private function assign_contributor_field(array &$template_vars, int $image_id, int $image_index): void
	{
		$template_vars['BBPOINTSIMAGES_CAN_ASSIGN_CONTRIBUTORS'] = $this->assignment_enabled();
		if (!$template_vars['BBPOINTSIMAGES_CAN_ASSIGN_CONTRIBUTORS'])
		{
			return;
		}
		$template_vars['BBPOINTSIMAGES_CONTRIBUTORS'] = $this->request->is_set_post('bbpointsimages_contributors_' . $image_index)
			? $this->submitted_value($image_index)
			: $this->contributors->format_for_image($image_id);
		$template_vars['U_BBPOINTSIMAGES_FIND_CONTRIBUTORS'] = $this->gallery_url->append_sid(
			'phpbb',
			'memberlist',
			'mode=searchuser&amp;form=postform&amp;field=bbpointsimages_contributors_' . $image_index
		);
		$this->template->assign_var('BBPOINTSIMAGES_MAX_CONTRIBUTORS', contributor_manager::MAX_CONTRIBUTORS);
	}

	private function validate_contributors(int $image_index): string
	{
		try
		{
			$this->validated_contributors[$image_index] = $this->contributors->resolve($this->submitted_value($image_index));
		}
		catch (\LengthException $exception)
		{
			return $this->language->lang('BBPOINTSIMAGES_CONTRIBUTORS_TOO_MANY', contributor_manager::MAX_CONTRIBUTORS);
		}
		catch (\InvalidArgumentException $exception)
		{
			return $this->language->lang('BBPOINTSIMAGES_CONTRIBUTORS_UNKNOWN', $exception->getMessage());
		}

		return '';
	}

	private function save_contributors(int $image_id, int $author_id, int $image_index): void
	{
		if (!$this->assignment_enabled())
		{
			return;
		}
		if (!array_key_exists($image_index, $this->validated_contributors))
		{
			$this->validated_contributors[$image_index] = $this->contributors->resolve($this->submitted_value($image_index));
		}
		$this->contributors->replace($image_id, $author_id, $this->validated_contributors[$image_index]);
	}

	private function submitted_value(int $image_index): string
	{
		return $this->request->variable(
			'bbpointsimages_contributors_' . $image_index,
			'',
			true,
			request_interface::POST
		);
	}

	private function assignment_enabled(): bool
	{
		return !empty($this->config['phpbb_gallery_bbpoints_contributors_enabled']);
	}

	private function reward_and_notify(array $image_data, string $source_path): void
	{
		if (!$this->rewards->reward($image_data, $source_path))
		{
			return;
		}
		$reward = $this->rewards->get_reward((int) $image_data['image_id']);
		if ($reward)
		{
			$this->notifications->reward($image_data, (int) $reward['amount']);
		}
	}
}
