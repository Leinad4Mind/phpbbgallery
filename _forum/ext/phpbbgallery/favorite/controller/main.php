<?php
/**
 * phpBB Gallery - Favorite Extension
 *
 * @package   phpbbgallery/favorite
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\favorite\controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Adds and removes favourites from the image page.
 */
class main
{
	/* @var \phpbb\controller\helper */
	protected \phpbb\controller\helper $helper;

	/* @var \phpbb\language\language */
	protected \phpbb\language\language $language;

	/* @var \phpbb\request\request */
	protected \phpbb\request\request $request;

	/* @var \phpbb\user */
	protected \phpbb\user $user;

	/* @var \phpbbgallery\core\auth\auth */
	protected \phpbbgallery\core\auth\auth $gallery_auth;

	/* @var \phpbbgallery\core\image\image */
	protected \phpbbgallery\core\image\image $image;

	/* @var \phpbbgallery\core\album\album */
	protected \phpbbgallery\core\album\album $album;

	/* @var \phpbbgallery\core\notification */
	protected \phpbbgallery\core\notification $notification;

	/* @var \phpbbgallery\core\user */
	protected \phpbbgallery\core\user $gallery_user;

	/* @var \phpbbgallery\favorite\favorite */
	protected \phpbbgallery\favorite\favorite $favorite;

	/**
	 * Constructor
	 *
	 * @param \phpbb\controller\helper          $helper       Controller helper object
	 * @param \phpbb\language\language          $language     Language object
	 * @param \phpbb\request\request            $request      Request object
	 * @param \phpbb\user                       $user         User object
	 * @param \phpbbgallery\core\auth\auth      $gallery_auth Gallery auth object
	 * @param \phpbbgallery\core\image\image    $image        Gallery image object
	 * @param \phpbbgallery\core\album\album    $album        Gallery album object
	 * @param \phpbbgallery\core\notification   $notification Gallery notification object
	 * @param \phpbbgallery\core\user           $gallery_user Gallery user object
	 * @param \phpbbgallery\favorite\favorite   $favorite     Gallery favorite object
	 */
	public function __construct(\phpbb\controller\helper $helper, \phpbb\language\language $language, \phpbb\request\request $request,
		\phpbb\user $user, \phpbbgallery\core\auth\auth $gallery_auth, \phpbbgallery\core\image\image $image,
		\phpbbgallery\core\album\album $album, \phpbbgallery\core\notification $notification,
		\phpbbgallery\core\user $gallery_user, \phpbbgallery\favorite\favorite $favorite)
	{
		$this->helper = $helper;
		$this->language = $language;
		$this->request = $request;
		$this->user = $user;
		$this->gallery_auth = $gallery_auth;
		$this->image = $image;
		$this->album = $album;
		$this->notification = $notification;
		$this->gallery_user = $gallery_user;
		$this->favorite = $favorite;
	}

	/**
	 * Add an image to the current member's favourites.
	 *
	 * @param int $image_id Image to favourite
	 * @return Response
	 */
	public function add(int $image_id): Response
	{
		return $this->toggle($image_id, true);
	}

	/**
	 * Remove an image from the current member's favourites.
	 *
	 * @param int $image_id Image to unfavourite
	 * @return Response
	 */
	public function remove(int $image_id): Response
	{
		return $this->toggle($image_id, false);
	}

	/**
	 * Apply a favourite change once the request has been vouched for.
	 *
	 * @param int  $image_id Image being changed
	 * @param bool $favorite Whether the image is being added
	 * @return Response
	 */
	protected function toggle(int $image_id, bool $favorite): Response
	{
		$this->language->add_lang(['gallery'], 'phpbbgallery/core');
		$this->language->add_lang(['info_favorite'], 'phpbbgallery/favorite');

		$user_id = (int) $this->user->data['user_id'];

		if ($user_id === ANONYMOUS)
		{
			login_box('', $this->language->lang('LOGIN_EXPLAIN_FAVORITE'));
		}

		$mode = $favorite ? 'favorite' : 'unfavorite';

		if (!check_link_hash($this->request->variable('hash', ''), $mode . '_' . $image_id))
		{
			throw new \phpbb\exception\http_exception(Response::HTTP_FORBIDDEN, 'FORM_INVALID');
		}

		$image_data = $this->image->get_image_data_or_fail($image_id);
		$album_data = $this->album->get_info((int) $image_data['image_album_id'], false);

		$this->gallery_auth->load_user_permissions($user_id);
		$this->assert_may_favorite($image_data, $album_data, $user_id);

		if ($favorite)
		{
			$added = $this->favorite->add($image_id, $user_id);

			// Honour the "subscribe to images I favorite" preference, which the
			// preference existed for but nothing ever acted on.
			if ($added && $this->gallery_user->get_data('watch_favo'))
			{
				$this->notification->add($image_id, $user_id);
			}

			$message = 'FAVORITED_IMAGE';
		}
		else
		{
			$this->favorite->remove($image_id, $user_id);
			$message = 'UNFAVORITED_IMAGE';
		}

		// message() answers with JSON when the toggle link was followed over
		// AJAX, and with a normal page otherwise.
		return $this->helper->message($message);
	}

	/**
	 * Stop the request unless the member may favourite this image.
	 *
	 * @param array $image_data Image row
	 * @param array $album_data Album the image lives in
	 * @param int   $user_id    Member making the request
	 * @return void
	 */
	protected function assert_may_favorite(array $image_data, array $album_data, int $user_id): void
	{
		$album_id = (int) $image_data['image_album_id'];
		$album_user_id = (int) $album_data['album_user_id'];

		$may_view = $this->gallery_auth->acl_check('i_view', $album_id, $album_user_id)
			&& $this->gallery_auth->acl_check('i_favorite', $album_id, $album_user_id);

		// Images still waiting for approval are only visible to their uploader
		// and to the moderators of the album.
		$status = (int) $image_data['image_status'];
		$is_hidden = $status === (int) \phpbbgallery\core\block::STATUS_ORPHAN
			|| ($status === (int) \phpbbgallery\core\block::STATUS_UNAPPROVED
				&& (int) $image_data['image_user_id'] !== $user_id
				&& !$this->gallery_auth->acl_check('m_status', $album_id, $album_user_id));

		if (!$may_view || $is_hidden)
		{
			throw new \phpbb\exception\http_exception(Response::HTTP_FORBIDDEN, 'FAVORITE_NOT_AUTHORISED');
		}
	}

}
