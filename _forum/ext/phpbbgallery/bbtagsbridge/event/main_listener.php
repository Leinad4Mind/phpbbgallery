<?php
/**
 * phpBB Gallery BBTags Bridge lifecycle listener.
 *
 * @package   phpbbgallery/bbtagsbridge
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbtagsbridge\event;

use phpbb\auth\auth;
use phpbb\event\data;
use phpbb\language\language;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;
use phpbbgallery\bbtagsbridge\album_scope_resolver;
use phpbbgallery\bbtagsbridge\image_tag_manager;
use phpbbgallery\bbtagsbridge\input_parser;
use sitesplat\bbtags\tags\manager;
use sitesplat\bbtags\tags\moderation;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class main_listener implements EventSubscriberInterface
{
	private auth $auth;
	private request_interface $request;
	private template $template;
	private language $language;
	private user $user;
	private image_tag_manager $image_tags;
	private input_parser $parser;
	private album_scope_resolver $scopes;
	private manager $tags;
	private moderation $moderation;

	public function __construct(
		auth $auth,
		request_interface $request,
		template $template,
		language $language,
		user $user,
		image_tag_manager $image_tags,
		input_parser $parser,
		album_scope_resolver $scopes,
		manager $tags,
		moderation $moderation
	)
	{
		$this->auth = $auth;
		$this->request = $request;
		$this->template = $template;
		$this->language = $language;
		$this->user = $user;
		$this->image_tags = $image_tags;
		$this->parser = $parser;
		$this->scopes = $scopes;
		$this->tags = $tags;
		$this->moderation = $moderation;
	}

	public static function getSubscribedEvents(): array
	{
		return [
			'core.user_setup' => 'load_language_on_setup',
			'phpbbgallery.core.viewimage' => 'display_image_tags',
			'phpbbgallery.core.image_edit_file' => 'validate_image_edit',
			'phpbbgallery.core.image_edit_display' => 'display_image_edit',
			'phpbbgallery.core.image_edit_after' => 'save_image_edit',
			'phpbbgallery.core.upload.review_validate' => 'validate_upload_review',
			'phpbbgallery.core.upload.review_display' => 'display_upload_review',
			'phpbbgallery.core.upload.update_image_after' => 'save_uploaded_image',
			'phpbbgallery.core.image.delete_images' => 'delete_image_tags',
		];
	}

	public function load_language_on_setup(data $event): void
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name' => 'phpbbgallery/bbtagsbridge',
			'lang_set' => 'bbtagsbridge',
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function display_image_tags(data $event): void
	{
		$album_data = (array) $event['album_data'];
		foreach ($this->get_available_image_tags((int) $event['image_id'], (int) $album_data['album_id']) as $tag)
		{
			$this->template->assign_block_vars('bbtagsbridge_tags', [
				'NAME' => $tag['tag'],
				'COUNT' => $tag['usage_count'],
			]);
		}
	}

	public function validate_image_edit(data $event): void
	{
		if (!$this->can_tag())
		{
			return;
		}
		$errors = (array) $event['errors'];
		$this->validate_input($this->submitted_value(0), $errors);
		$event['errors'] = $errors;
	}

	public function display_image_edit(data $event): void
	{
		$template_vars = (array) $event['template_vars'];
		$album_data = (array) $event['album_data'];
		$this->assign_edit_values($template_vars, (int) $event['image_id'], (int) $album_data['album_id'], 0);
		$event['template_vars'] = $template_vars;
	}

	public function save_image_edit(data $event): void
	{
		$updated = (array) $event['updated_image_data'];
		$this->save_tags(
			(int) $event['image_id'],
			(int) $updated['image_album_id'],
			$this->submitted_value(0)
		);
	}

	public function validate_upload_review(data $event): void
	{
		if (!$this->can_tag() || (string) $event['validation_error'] !== '')
		{
			return;
		}
		$errors = [];
		foreach (array_keys((array) $event['image_ids']) as $image_index)
		{
			$this->validate_input($this->submitted_value((int) $image_index), $errors);
		}
		if (!empty($errors))
		{
			$event['validation_error'] = implode('<br />', $errors);
		}
	}

	public function display_upload_review(data $event): void
	{
		$template_vars = (array) $event['image_template_vars'];
		$image_data = (array) $event['image_data'];
		$this->assign_edit_values(
			$template_vars,
			(int) $event['image_id'],
			(int) $image_data['image_album_id'],
			(int) $event['image_index']
		);
		$event['image_template_vars'] = $template_vars;
	}

	public function save_uploaded_image(data $event): void
	{
		$image_data = (array) $event['image_data'];
		$this->save_tags(
			(int) $event['image_id'],
			(int) $image_data['image_album_id'],
			$this->submitted_value((int) $event['image_index'])
		);
	}

	public function delete_image_tags(data $event): void
	{
		$image_ids = (array) $event['images'];
		$this->moderation->cancel_items(image_tag_manager::PROVIDER, $image_ids);
		$this->image_tags->delete_for_images($image_ids);
	}

	private function assign_edit_values(array &$template_vars, int $image_id, int $album_id, int $image_index): void
	{
		$can_tag = $this->can_tag();
		$pending = $can_tag ? $this->moderation->get_item_pending_tags(image_tag_manager::PROVIDER, $image_id) : [];
		if ($this->request->is_set_post('bbtagsbridge_tags'))
		{
			$value = $this->submitted_value($image_index);
		}
		else
		{
			$value = $this->parser->format(array_merge($this->get_available_image_tags($image_id, $album_id), $pending));
		}
		$template_vars['BBTAGSBRIDGE_CAN_TAG'] = $can_tag;
		$template_vars['BBTAGSBRIDGE_TAGS'] = $value;
		$template_vars['BBTAGSBRIDGE_HAS_PENDING'] = !empty($pending);
		$this->template->assign_vars([
			'BBTAGSBRIDGE_MAX_TAGS' => $this->parser->get_max_tags(),
			'BBTAGSBRIDGE_MIN_LENGTH' => $this->parser->get_min_length(),
			'BBTAGSBRIDGE_MAX_LENGTH' => $this->parser->get_max_length(),
		]);
	}

	private function validate_input(string $value, array &$errors): void
	{
		try
		{
			$this->parser->parse($value);
		}
		catch (\InvalidArgumentException $exception)
		{
			$errors[] = $this->language->lang(
				$exception->getMessage(),
				$this->parser->get_max_tags(),
				$this->parser->get_min_length(),
				$this->parser->get_max_length()
			);
		}
	}

	private function save_tags(int $image_id, int $album_id, string $value): void
	{
		if (!$this->can_tag())
		{
			return;
		}
		$tags = $this->parser->parse($value);
		$scope_path = $this->scopes->get_path($album_id);
		if (empty($scope_path))
		{
			throw new \RuntimeException($this->language->lang('BBTAGSBRIDGE_SAVE_FAILED'));
		}

		if ($this->auth->acl_get('m_bbtags_moderate'))
		{
			$tag_ids = [];
			foreach ($tags as $tag)
			{
				$tag_id = $this->tags->ensure_catalog_tag($tag, (int) $this->user->data['user_id']);
				if ($tag_id === false
					|| !$this->tags->ensure_provider_context($tag_id, image_tag_manager::PROVIDER, 'restricted')
					|| !$this->tags->set_scope_rule($tag_id, image_tag_manager::PROVIDER, $album_id, 'allow'))
				{
					throw new \RuntimeException($this->language->lang('BBTAGSBRIDGE_SAVE_FAILED'));
				}
				$tag_ids[] = $tag_id;
			}
			if (!$this->image_tags->replace_tags($image_id, $tag_ids)
				|| !$this->moderation->sync_item_suggestions([], image_tag_manager::PROVIDER, $album_id, $image_id, (int) $this->user->data['user_id']))
			{
				throw new \RuntimeException($this->language->lang('BBTAGSBRIDGE_SAVE_FAILED'));
			}
			return;
		}

		$classified = $this->tags->classify_tags($tags, image_tag_manager::PROVIDER, $scope_path);
		$tag_ids = $this->tags->get_existing_tags($classified['available'], true);
		if (!$this->image_tags->replace_tags($image_id, $tag_ids)
			|| !$this->moderation->sync_item_suggestions(
				$classified['suggestible'],
				image_tag_manager::PROVIDER,
				$album_id,
				$image_id,
				(int) $this->user->data['user_id']
			))
		{
			throw new \RuntimeException($this->language->lang('BBTAGSBRIDGE_SAVE_FAILED'));
		}
	}

	private function submitted_value(int $index): string
	{
		$values = $this->request->variable('bbtagsbridge_tags', [''], true, request_interface::POST);

		return isset($values[$index]) && is_string($values[$index]) ? $values[$index] : '';
	}

	/**
	 * Return only relations that remain enabled in the album's effective policy.
	 */
	private function get_available_image_tags(int $image_id, int $album_id): array
	{
		$scope_path = $this->scopes->get_path($album_id);
		if (empty($scope_path))
		{
			return [];
		}
		$tags = $this->image_tags->get_tags_for_image($image_id);
		$allowed_ids = $this->tags->filter_available_tag_ids(
			array_column($tags, 'id'),
			image_tag_manager::PROVIDER,
			$scope_path
		);

		return array_values(array_filter($tags, static function (array $tag) use ($allowed_ids): bool
		{
			return in_array((int) $tag['id'], $allowed_ids, true);
		}));
	}

	private function can_tag(): bool
	{
		return $this->auth->acl_get('u_bbtags') || $this->auth->acl_get('m_bbtags_moderate');
	}
}
