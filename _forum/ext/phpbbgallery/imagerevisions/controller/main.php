<?php
/**
 * phpBB Gallery - Image Revisions Extension
 *
 * @package   phpbbgallery/imagerevisions
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\imagerevisions\controller;

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class main
{
	protected \phpbbgallery\imagerevisions\policy $policy;
	protected \phpbb\controller\helper $helper;
	protected \phpbb\language\language $language;
	protected \phpbb\user $user;
	protected \phpbbgallery\core\album\album $album;
	protected \phpbbgallery\core\image\image $image;
	protected \phpbbgallery\core\auth\auth $gallery_auth;
	protected \phpbbgallery\core\auth\image_authorization $image_authorization;
	protected \phpbbgallery\core\file\file $file;
	protected \phpbbgallery\imagerevisions\revision $revisions;
	protected \phpbbgallery\core\storage\workspace $storage_workspace;

	public function __construct(\phpbbgallery\imagerevisions\policy $policy, \phpbb\controller\helper $helper,
		\phpbb\language\language $language, \phpbb\user $user, \phpbbgallery\core\album\album $album,
		\phpbbgallery\core\image\image $image, \phpbbgallery\core\auth\auth $gallery_auth,
		\phpbbgallery\core\auth\image_authorization $image_authorization, \phpbbgallery\core\file\file $file,
		\phpbbgallery\imagerevisions\revision $revisions, \phpbbgallery\core\storage\workspace $storage_workspace)
	{
		$this->policy = $policy;
		$this->helper = $helper;
		$this->language = $language;
		$this->user = $user;
		$this->album = $album;
		$this->image = $image;
		$this->gallery_auth = $gallery_auth;
		$this->image_authorization = $image_authorization;
		$this->file = $file;
		$this->revisions = $revisions;
		$this->storage_workspace = $storage_workspace;
	}

	public function preview(int $image_id, int $revision_id): BinaryFileResponse
	{
		$this->authorize($image_id);
		$revision = $this->revisions->get_revision($image_id, $revision_id);
		if ($revision === false)
		{
			throw new \phpbb\exception\http_exception(404, 'IMAGE_REVISION_NOT_AVAILABLE');
		}
		try
		{
			$source = $this->storage_workspace->materialize(
				\phpbbgallery\core\storage\provider_interface::SOURCE,
				(string) $revision['revision_filename']
			);
		}
		catch (\RuntimeException)
		{
			throw new \phpbb\exception\http_exception(404, 'IMAGE_REVISION_NOT_AVAILABLE');
		}

		$content_type = $this->file->mimetype_by_filename((string) $revision['revision_filename']) ?: 'application/octet-stream';
		$response = new BinaryFileResponse($source->get_path());
		$response->headers->set('Content-Type', $content_type);
		$response->headers->set('X-Content-Type-Options', 'nosniff');
		$response->headers->set('Cache-Control', 'private, no-store, max-age=0');
		$response->headers->set('Content-Disposition', $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, basename((string) $revision['revision_filename'])));
		if ($source->is_temporary())
		{
			$source->detach();
			$response->deleteFileAfterSend(true);
		}

		return $response;
	}

	public function restore(int $image_id, int $revision_id): ?Response
	{
		$image_data = $this->authorize($image_id);
		if (!check_form_key('gallery'))
		{
			trigger_error('FORM_INVALID');
		}
		$settings = $this->policy->resolve((int) $image_data['image_album_id']);
		if (!$this->revisions->restore($image_id, $revision_id, $settings['revision_limit']))
		{
			trigger_error($this->language->lang('IMAGE_REVISION_NOT_AVAILABLE'));
		}

		$image_backlink = $this->helper->route('phpbbgallery_core_image', ['image_id' => $image_id]);
		$message = $this->language->lang('IMAGE_REVISION_RESTORED');
		$message .= '<br /><br />' . sprintf($this->language->lang('CLICK_RETURN_IMAGE'), '<a href="' . $image_backlink . '">', '</a>');
		meta_refresh(3, $image_backlink);
		trigger_error($message);
	}

	private function authorize(int $image_id): array
	{
		$this->language->add_lang(['gallery'], 'phpbbgallery/core');
		$this->language->add_lang('imagerevisions', 'phpbbgallery/imagerevisions');
		$image_data = $this->image->get_image_data_or_fail($image_id);
		$album_id = (int) $image_data['image_album_id'];
		try
		{
			$settings = $this->policy->resolve($album_id);
		}
		catch (\OutOfBoundsException)
		{
			throw new \phpbb\exception\http_exception(404, 'IMAGE_REVISION_NOT_AVAILABLE');
		}
		if (!$settings['enabled'])
		{
			throw new \phpbb\exception\http_exception(404, 'IMAGE_REVISION_NOT_AVAILABLE');
		}
		$album_data = $this->album->get_info($album_id);
		$this->gallery_auth->load_user_permissions($this->user->data['user_id']);
		$has_image_permission = $this->gallery_auth->acl_check('i_edit', $album_id, $album_data['album_user_id']);
		$has_moderator_permission = $this->gallery_auth->acl_check('m_edit', $album_id, $album_data['album_user_id']);
		$is_orphan = in_array((int) $image_data['image_status'], [
			\phpbbgallery\core\block::STATUS_ORPHAN,
			\phpbbgallery\core\block::STATUS_DELETE_REQUESTED,
		], true);
		if (!$this->image_authorization->can_manage_image((int) $this->user->data['user_id'], $image_data, $has_image_permission, $has_moderator_permission, $is_orphan))
		{
			throw new \phpbb\exception\http_exception(403, 'NOT_AUTHORISED');
		}

		return $image_data;
	}
}
