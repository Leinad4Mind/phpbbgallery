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
	protected \phpbb\config\config $config;
	protected \phpbb\controller\helper $helper;
	protected \phpbb\language\language $language;
	protected \phpbb\user $user;
	protected \phpbbgallery\core\album\album $album;
	protected \phpbbgallery\core\image\image $image;
	protected \phpbbgallery\core\auth\auth $gallery_auth;
	protected \phpbbgallery\core\auth\image_authorization $image_authorization;
	protected \phpbbgallery\core\file\file $file;
	protected \phpbbgallery\imagerevisions\revision $revisions;

	public function __construct(\phpbb\config\config $config, \phpbb\controller\helper $helper,
		\phpbb\language\language $language, \phpbb\user $user, \phpbbgallery\core\album\album $album,
		\phpbbgallery\core\image\image $image, \phpbbgallery\core\auth\auth $gallery_auth,
		\phpbbgallery\core\auth\image_authorization $image_authorization, \phpbbgallery\core\file\file $file,
		\phpbbgallery\imagerevisions\revision $revisions)
	{
		$this->config = $config;
		$this->helper = $helper;
		$this->language = $language;
		$this->user = $user;
		$this->album = $album;
		$this->image = $image;
		$this->gallery_auth = $gallery_auth;
		$this->image_authorization = $image_authorization;
		$this->file = $file;
		$this->revisions = $revisions;
	}

	public function preview(int $image_id, int $revision_id): BinaryFileResponse
	{
		$this->authorize($image_id);
		$revision = $this->revisions->get_revision($image_id, $revision_id);
		$source = $revision === false ? false : $this->revisions->resolve_source_file((string) $revision['revision_filename']);
		if ($source === false)
		{
			throw new \phpbb\exception\http_exception(404, 'IMAGE_REVISION_NOT_AVAILABLE');
		}

		$content_type = $this->file->mimetype_by_filename($source) ?: 'application/octet-stream';
		$response = new BinaryFileResponse($source);
		$response->headers->set('Content-Type', $content_type);
		$response->headers->set('X-Content-Type-Options', 'nosniff');
		$response->headers->set('Cache-Control', 'private, no-store, max-age=0');
		$response->headers->set('Content-Disposition', $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, basename($source)));

		return $response;
	}

	public function restore(int $image_id, int $revision_id): ?Response
	{
		$this->authorize($image_id);
		if (!check_form_key('gallery'))
		{
			trigger_error('FORM_INVALID');
		}
		if (!$this->revisions->restore($image_id, $revision_id, $this->limit()))
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
		if (empty($this->config['phpbb_gallery_imagerevisions_enabled']))
		{
			throw new \phpbb\exception\http_exception(404, 'IMAGE_REVISION_NOT_AVAILABLE');
		}

		$image_data = $this->image->get_image_data_or_fail($image_id);
		$album_id = (int) $image_data['image_album_id'];
		$album_data = $this->album->get_info($album_id);
		$this->gallery_auth->load_user_permissions($this->user->data['user_id']);
		$has_image_permission = $this->gallery_auth->acl_check('i_edit', $album_id, $album_data['album_user_id']);
		$has_moderator_permission = $this->gallery_auth->acl_check('m_edit', $album_id, $album_data['album_user_id']);
		$is_orphan = (int) $image_data['image_status'] === (int) \phpbbgallery\core\block::STATUS_ORPHAN;
		if (!$this->image_authorization->can_manage_image((int) $this->user->data['user_id'], $image_data, $has_image_permission, $has_moderator_permission, $is_orphan))
		{
			throw new \phpbb\exception\http_exception(403, 'NOT_AUTHORISED');
		}

		return $image_data;
	}

	private function limit(): int
	{
		return max(1, min(50, (int) ($this->config['phpbb_gallery_imagerevisions_limit'] ?? 5)));
	}
}
