<?php
/**
 * phpBB Gallery - Featured Images controller.
 *
 * @package   phpbbgallery/featured
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\featured\controller;

use Symfony\Component\HttpFoundation\Response;

class main
{
	public function __construct(
		protected \phpbb\controller\helper $helper,
		protected \phpbb\language\language $language,
		protected \phpbb\request\request $request,
		protected \phpbb\user $user,
		protected \phpbbgallery\core\auth\auth $gallery_auth,
		protected \phpbbgallery\core\image\image $image,
		protected \phpbbgallery\core\album\album $album,
		protected \phpbbgallery\featured\manager $manager
	)
	{
	}

	public function add(int $image_id): Response
	{
		return $this->toggle($image_id, true);
	}

	public function remove(int $image_id): Response
	{
		return $this->toggle($image_id, false);
	}

	private function toggle(int $image_id, bool $featured): Response
	{
		$this->language->add_lang(['gallery'], 'phpbbgallery/core');
		$this->language->add_lang('featured', 'phpbbgallery/featured');
		$user_id = (int) $this->user->data['user_id'];
		if ($user_id === ANONYMOUS)
		{
			login_box();
		}
		$mode = $featured ? 'feature' : 'unfeature';
		if (!check_link_hash($this->request->variable('hash', ''), $mode . '_' . $image_id))
		{
			throw new \phpbb\exception\http_exception(Response::HTTP_FORBIDDEN, 'FORM_INVALID');
		}

		$image_data = $this->image->get_image_data_or_fail($image_id);
		$album_data = $this->album->get_info((int) $image_data['image_album_id'], false);
		$this->gallery_auth->load_user_permissions($user_id);
		if (!$this->gallery_auth->acl_check('m_edit', (int) $image_data['image_album_id'], (int) $album_data['album_user_id']))
		{
			throw new \phpbb\exception\http_exception(Response::HTTP_FORBIDDEN, 'FEATURED_NOT_AUTHORISED');
		}
		if ($featured && (int) $image_data['image_status'] !== (int) \phpbbgallery\core\block::STATUS_APPROVED)
		{
			throw new \phpbb\exception\http_exception(Response::HTTP_CONFLICT, 'FEATURED_APPROVED_ONLY');
		}

		if ($featured)
		{
			$this->manager->feature($image_id, $user_id);
			$message = 'FEATURED_IMAGE_ADDED';
		}
		else
		{
			$this->manager->unfeature($image_id);
			$message = 'FEATURED_IMAGE_REMOVED';
		}
		return $this->helper->message($message);
	}
}
