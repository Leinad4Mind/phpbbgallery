<?php
/**
 * phpBB Gallery - Favorite Extension
 *
 * @package   phpbbgallery/favorite
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\favorite\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Puts the favourite toggle on the image page and keeps the stored favourites
 * in step with the images and members they point at.
 */
class favorite_listener implements EventSubscriberInterface
{
	/* @var \phpbb\controller\helper */
	protected \phpbb\controller\helper $helper;

	/* @var \phpbb\language\language */
	protected \phpbb\language\language $language;

	/* @var \phpbb\request\request */
	protected \phpbb\request\request $request;

	/* @var \phpbb\template\template */
	protected \phpbb\template\template $template;

	/* @var \phpbb\user */
	protected \phpbb\user $user;

	/* @var \phpbbgallery\core\auth\auth */
	protected \phpbbgallery\core\auth\auth $gallery_auth;

	/* @var \phpbbgallery\core\user */
	protected \phpbbgallery\core\user $gallery_user;

	/* @var \phpbbgallery\favorite\favorite */
	protected \phpbbgallery\favorite\favorite $favorite;

	/**
	 * Constructor
	 *
	 * @param \phpbb\controller\helper        $helper       Controller helper object
	 * @param \phpbb\language\language        $language     Language object
	 * @param \phpbb\request\request          $request      Request object
	 * @param \phpbb\template\template        $template     Template object
	 * @param \phpbb\user                     $user         User object
	 * @param \phpbbgallery\core\auth\auth    $gallery_auth Gallery auth object
	 * @param \phpbbgallery\core\user         $gallery_user Gallery user object
	 * @param \phpbbgallery\favorite\favorite $favorite     Gallery favorite object
	 */
	public function __construct(\phpbb\controller\helper $helper, \phpbb\language\language $language, \phpbb\request\request $request,
		\phpbb\template\template $template, \phpbb\user $user, \phpbbgallery\core\auth\auth $gallery_auth,
		\phpbbgallery\core\user $gallery_user, \phpbbgallery\favorite\favorite $favorite)
	{
		$this->helper = $helper;
		$this->language = $language;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->gallery_auth = $gallery_auth;
		$this->gallery_user = $gallery_user;
		$this->favorite = $favorite;
	}

	/**
	 * {@inheritdoc}
	 */
	public static function getSubscribedEvents(): array
	{
		return [
			'core.delete_user_after'							=> 'delete_user_after',
			'phpbbgallery.acpcleanup.cleanup_finished'			=> 'cleanup_finished',
			'phpbbgallery.core.image.delete_images'				=> 'image_delete_images',
			'phpbbgallery.core.viewimage'						=> 'viewimage',
			'phpbbgallery.core.ucp.set_settings_nosubmit'		=> 'ucp_set_settings_nosubmit',
			'phpbbgallery.core.ucp.set_settings_submit'			=> 'ucp_set_settings_submit',
			'phpbbgallery.core.user.get_default_values'			=> 'user_get_default_values',
			'phpbbgallery.core.user.validate_data'				=> 'user_validate_data',
		];
	}

	/**
	 * Offer the favourite toggle on the image page.
	 *
	 * @param \phpbb\event\data $event Event object
	 * @return void
	 */
	public function viewimage(\phpbb\event\data $event): void
	{
		$user_id = (int) $this->user->data['user_id'];

		if ($user_id === ANONYMOUS)
		{
			return;
		}

		$image_id = (int) $event['image_id'];
		$album_id = (int) $event['image_data']['image_album_id'];
		$album_user_id = (int) $event['album_data']['album_user_id'];

		if (!$this->gallery_auth->acl_check('i_favorite', $album_id, $album_user_id))
		{
			return;
		}

		$this->language->add_lang('info_favorite', 'phpbbgallery/favorite');

		// The state is read here rather than joined onto the image query, so the
		// toggle always reflects what is actually stored.
		$favorited = $this->favorite->is_favorited($image_id, $user_id);

		$this->template->assign_vars([
			'S_IMAGE_FAVORITED'		=> $favorited,
			'S_FAVORITE_NAME'		=> $this->language->lang($favorited ? 'UNFAVORITE_IMAGE' : 'FAVORITE_IMAGE'),
			'S_FAVORITE_NAME_TOGGLE'=> $this->language->lang($favorited ? 'FAVORITE_IMAGE' : 'UNFAVORITE_IMAGE'),
			'U_FAVORITE_IMAGE'		=> $this->favorite_route($image_id, !$favorited),
			'U_FAVORITE_IMAGE_TOGGLE'=> $this->favorite_route($image_id, $favorited),
		]);
	}

	/**
	 * Rebuild the favourite counters after the gallery has been cleaned up.
	 *
	 * @return void
	 */
	public function cleanup_finished(): void
	{
		$this->favorite->resync_counters();
	}

	/**
	 * Drop the favourites pointing at images that are being deleted.
	 *
	 * @param \phpbb\event\data $event Event object
	 * @return void
	 */
	public function image_delete_images(\phpbb\event\data $event): void
	{
		$this->favorite->delete_images((array) $event['images']);
	}

	/**
	 * Drop the favourites of members that are being deleted.
	 *
	 * @param \phpbb\event\data $event Event object
	 * @return void
	 */
	public function delete_user_after(\phpbb\event\data $event): void
	{
		$this->favorite->delete_users((array) $event['user_ids']);
	}

	/**
	 * Show the subscribe-on-favourite preference in the UCP.
	 *
	 * @return void
	 */
	public function ucp_set_settings_nosubmit(): void
	{
		$this->language->add_lang('info_favorite', 'phpbbgallery/favorite');

		$this->template->assign_var('S_WATCH_FAVO', (bool) $this->gallery_user->get_data('watch_favo'));
	}

	/**
	 * Store the subscribe-on-favourite preference.
	 *
	 * @param \phpbb\event\data $event Event object
	 * @return void
	 */
	public function ucp_set_settings_submit(\phpbb\event\data $event): void
	{
		$additional_settings = $event['additional_settings'];

		if (!array_key_exists('watch_favo', $additional_settings))
		{
			$additional_settings['watch_favo'] = $this->request->variable('watch_favo', false);
			$event['additional_settings'] = $additional_settings;
		}
	}

	/**
	 * Give new gallery members a default for the preference.
	 *
	 * @param \phpbb\event\data $event Event object
	 * @return void
	 */
	public function user_get_default_values(\phpbb\event\data $event): void
	{
		$default_values = $event['default_values'];

		if (!array_key_exists('watch_favo', $default_values))
		{
			$default_values['watch_favo'] = (bool) \phpbbgallery\favorite\favorite::DEFAULT_SUBSCRIBE;
			$event['default_values'] = $default_values;
		}
	}

	/**
	 * Let the core store the preference it does not know about.
	 *
	 * @param \phpbb\event\data $event Event object
	 * @return void
	 */
	public function user_validate_data(\phpbb\event\data $event): void
	{
		if ($event['name'] === 'watch_favo')
		{
			$event['value'] = (bool) $event['value'];
			$event['is_validated'] = true;
		}
	}

	/**
	 * Build a CSRF-protected favourite toggle URL.
	 *
	 * @param int  $image_id Image the link acts on
	 * @param bool $favorite Whether the link adds the favourite
	 * @return string
	 */
	protected function favorite_route(int $image_id, bool $favorite): string
	{
		$mode = $favorite ? 'favorite' : 'unfavorite';
		$route = $favorite ? 'phpbbgallery_favorite_add' : 'phpbbgallery_favorite_remove';

		return $this->helper->route($route, [
			'image_id'	=> $image_id,
			'hash'		=> generate_link_hash($mode . '_' . $image_id),
		]);
	}
}
