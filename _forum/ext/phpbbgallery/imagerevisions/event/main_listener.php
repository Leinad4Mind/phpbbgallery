<?php
/**
 * phpBB Gallery - Image Revisions Extension
 *
 * @package   phpbbgallery/imagerevisions
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\imagerevisions\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{
	protected \phpbb\config\config $config;
	protected \phpbb\request\request_interface $request;
	protected \phpbb\template\template $template;
	protected \phpbb\language\language $language;
	protected \phpbb\user $user;
	protected \phpbb\controller\helper $helper;
	protected \phpbbgallery\core\upload $upload;
	protected \phpbbgallery\imagerevisions\revision $revisions;

	public function __construct(\phpbb\config\config $config, \phpbb\request\request_interface $request,
		\phpbb\template\template $template, \phpbb\language\language $language, \phpbb\user $user,
		\phpbb\controller\helper $helper, \phpbbgallery\core\upload $upload,
		\phpbbgallery\imagerevisions\revision $revisions)
	{
		$this->config = $config;
		$this->request = $request;
		$this->template = $template;
		$this->language = $language;
		$this->user = $user;
		$this->helper = $helper;
		$this->upload = $upload;
		$this->revisions = $revisions;
	}

	public static function getSubscribedEvents(): array
	{
		return [
			'core.permissions' => 'add_permissions',
			'phpbbgallery.core.image_edit_file' => 'replace_file',
			'phpbbgallery.core.image_edit_display' => 'display_revisions',
			'phpbbgallery.core.image.delete_images' => 'delete_revisions',
		];
	}

	public function add_permissions(\phpbb\event\data $event): void
	{
		$this->language->add_lang('info_acp_imagerevisions', 'phpbbgallery/imagerevisions');
		$event->update_subarray('permissions', 'a_gallery_imagerevisions', [
			'lang' => 'ACL_A_GALLERY_IMAGEREVISIONS',
			'cat'  => 'misc',
		]);
	}

	public function replace_file(\phpbb\event\data $event): void
	{
		if (!$this->enabled() || $event['errors'])
		{
			return;
		}

		$files = $this->request->variable('files', [
			'name' => ['' => ''],
			'type' => ['' => ''],
			'tmp_name' => ['' => ''],
			'error' => ['' => ''],
			'size' => ['' => ''],
		], true, \phpbb\request\request_interface::FILES);
		$has_file = !empty(array_filter((array) ($files['name'] ?? []), static fn (string $filename): bool => trim($filename) !== ''));
		if (!$has_file)
		{
			return;
		}

		$this->language->add_lang('imagerevisions', 'phpbbgallery/imagerevisions');
		$errors = (array) $event['errors'];
		$this->upload->set_up((int) $event['image_data']['image_album_id'], 1, false);
		$this->upload->set_rotating([1 => (int) $event['rotate']]);
		$this->upload->upload_file(1);
		if ($this->upload->errors || count($this->upload->images) !== 1)
		{
			$errors = array_merge($errors, $this->upload->errors ?: [$this->language->lang('UPLOAD_NO_FILE')]);
			$this->upload->discard_uploaded_images();
			$event['errors'] = $errors;
			return;
		}

		$uploaded_image_id = (int) $this->upload->images[0];
		if (!$this->revisions->replace_file((int) $event['image_id'], $uploaded_image_id, $this->limit()))
		{
			$this->upload->discard_uploaded_images();
			$errors[] = $this->language->lang('IMAGE_REPLACE_FAILED');
			$event['errors'] = $errors;
			return;
		}

		$event['file_changed'] = true;
	}

	public function display_revisions(\phpbb\event\data $event): void
	{
		if (!$this->enabled())
		{
			return;
		}

		$this->language->add_lang('imagerevisions', 'phpbbgallery/imagerevisions');
		$image_id = (int) $event['image_id'];
		$album_id = (int) $event['image_data']['image_album_id'];
		$this->upload->set_up($album_id, 1, false);
		$allowed_extensions = $this->upload->get_allowed_types();
		$this->template->assign_vars([
			'S_IMAGE_REVISIONS' => true,
			'S_REPLACEMENT_FILETYPES_AVAILABLE' => !empty($allowed_extensions),
			'S_REPLACEMENT_FILETYPES_ACCEPT' => implode(',', array_map(static fn (string $extension): string => '.' . $extension, $allowed_extensions)),
		]);

		foreach ($this->revisions->get_revisions($image_id) as $revision)
		{
			$this->template->assign_block_vars('revision', [
				'ID'       => (int) $revision['revision_id'],
				'TIME'     => $this->user->format_date((int) $revision['revision_time']),
				'FILESIZE' => get_formatted_filesize((int) $revision['revision_filesize']),
				'EDITOR'   => get_username_string('full', (int) $revision['revision_user_id'], $revision['username'] ?? $this->language->lang('GUEST'), $revision['user_colour'] ?? ''),
				'U_PREVIEW' => $this->helper->route('phpbbgallery_imagerevisions_preview', ['image_id' => $image_id, 'revision_id' => (int) $revision['revision_id']]),
				'U_RESTORE' => $this->helper->route('phpbbgallery_imagerevisions_restore', ['image_id' => $image_id, 'revision_id' => (int) $revision['revision_id']]),
			]);
		}
	}

	public function delete_revisions(\phpbb\event\data $event): void
	{
		$this->revisions->delete_for_images((array) $event['images']);
	}

	private function enabled(): bool
	{
		return !empty($this->config['phpbb_gallery_imagerevisions_enabled']);
	}

	private function limit(): int
	{
		return max(1, min(50, (int) ($this->config['phpbb_gallery_imagerevisions_limit'] ?? 5)));
	}
}
