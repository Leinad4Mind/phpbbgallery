<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

// this file is not really needed, when empty it can be omitted
// however you can override the default methods and add custom
// installation logic

namespace phpbbgallery\core;

class ext extends \phpbb\extension\base
{
	private const NOTIFICATION_TYPES = [
		'phpbbgallery.core.notification.image_for_approval',
		'phpbbgallery.core.notification.image_approved',
		'phpbbgallery.core.notification.image_not_approved',
		'phpbbgallery.core.notification.image_moderated',
		'phpbbgallery.core.notification.image_removed',
		'phpbbgallery.core.notification.new_comment',
		'phpbbgallery.core.notification.new_image',
		'phpbbgallery.core.notification.new_report',
	];

	protected array $sub_extensions = [
		'phpbbgallery/acpcleanup',
		'phpbbgallery/acpimport',
		'phpbbgallery/exif',
		'phpbbgallery/export',
		'phpbbgallery/favorite',
		'phpbbgallery/featured',
		'phpbbgallery/feed',
		'phpbbgallery/imagefields',
		'phpbbgallery/imagerevisions',
		'phpbbgallery/bbtagsimages',
		'phpbbgallery/bbpointsimages',
		'phpbbgallery/contest',
		'phpbbgallery/remotestorage',
		'phpbbgallery/tiff',
	];

	/**
	 * Check the extension metadata and required PHP runtime components.
	 *
	 * @return bool
	 */
	public function is_enableable(): bool
	{
		if (!parent::is_enableable())
		{
			return false;
		}

		$environment = new \phpbbgallery\core\acp\environment();
		$missing = $environment->missing_required_components($environment->runtime_checks());
		if (!empty($missing))
		{
			$user = $this->container->get('user');
			$user->add_lang_ext('phpbbgallery/core', 'install_gallery');
			trigger_error($user->lang('GALLERY_REQUIREMENTS_MISSING', implode(', ', $missing)), E_USER_WARNING);
			return false;
		}

		return true;
	}

	/**
	* Single enable step that installs any included migrations
	*
	* @param mixed $old_state State returned by previous call of this method
	* @return mixed Returns false after last step, otherwise temporary state
	*/
	public function enable_step(mixed $old_state): mixed
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet
				$user = $this->container->get('user');
				$user->add_lang_ext('phpbbgallery/core', 'install_gallery');
				$this->container->get('template')->assign_var(
					'L_EXTENSION_ENABLE_SUCCESS',
					$user->lang('GALLERY_CORE_ENABLE_SUCCESS')
				);
				$this->update_notification_types('enable_notifications');
				return 'notifications';
			break;

			default:
				// Run parent enable step method
				$next_state = parent::enable_step($old_state);
				if ($next_state === false)
				{
					$config = $this->container->get('config');
					$image_fallback = ($config['phpbb_gallery_bbcode_tag'] ?? 'image') === 'galleryimage';
					$album_fallback = ($config['phpbb_gallery_album_bbcode_tag'] ?? 'album') === 'galleryalbum';
					if ($image_fallback || $album_fallback)
					{
						$user = $this->container->get('user');
						$user->add_lang_ext('phpbbgallery/core', 'install_gallery');
						$key = $image_fallback && $album_fallback
							? 'GALLERY_CORE_ENABLE_BBCODE_FALLBACK_BOTH'
							: ($image_fallback
								? 'GALLERY_CORE_ENABLE_IMAGE_BBCODE_FALLBACK'
								: 'GALLERY_CORE_ENABLE_ALBUM_BBCODE_FALLBACK');
						$this->container->get('template')->assign_var(
							'L_EXTENSION_ENABLE_SUCCESS',
							$user->lang($key)
						);
					}
				}
				return $next_state;
			break;
		}
	}

	/**
	* Single disable step that does nothing
	*
	* @param mixed $old_state State returned by previous call of this method
	* @return mixed Returns false after last step, otherwise temporary state
	*/
	public function disable_step(mixed $old_state): mixed
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet
				// Disable list of official extensions
				$extensions = $this->container->get('ext.manager');
				foreach ($this->sub_extensions as $sub_ext)
				{
					$extensions->disable($sub_ext);
				}

				$this->update_notification_types('disable_notifications');
				return 'notifications';

			break;
			default:
				// Run parent disable step method
				return parent::disable_step($old_state);
			break;
		}
	}

	/**
	* Single purge step that reverts any included and installed migrations
	*
	* @param mixed $old_state State returned by previous call of this method
	* @return mixed Returns false after last step, otherwise temporary state
	*/
	public function purge_step(mixed $old_state): mixed
	{
		$extensions = $this->container->get('ext.manager');
		$configured = $extensions->all_disabled();

		$disabled_sub_exts = [];

		foreach ($this->sub_extensions as $sub_ext)
		{
			if (isset($configured[$sub_ext]))
			{
				$disabled_sub_exts[] = '» ' . $sub_ext;
			}
		}

		if (!empty($disabled_sub_exts))
		{
			$this->container->get('user')->add_lang_ext('phpbbgallery/core', 'install_gallery');
			$error_msg = sprintf($this->container->get('user')->lang(
				'GALLERY_SUB_EXT_UNINSTALL', implode('<br />', $disabled_sub_exts), count($disabled_sub_exts)));
			trigger_error($error_msg, E_USER_WARNING);
		}

		switch ($old_state)
		{
			case '': // Empty means nothing has run yet
				$this->update_notification_types('purge_notifications', true);
				return 'notifications';
			break;
			default:
				// Run parent purge step method
				return parent::purge_step($old_state);
			break;
		}
	}

	/**
	 * Apply a notification-manager lifecycle method to every registered Gallery type.
	 * Purging is best-effort per type because older phpBB versions may throw when a type
	 * was registered by the extension but never persisted in the database.
	 *
	 * @param string $method
	 * @param bool   $ignore_missing
	 * @return void
	 */
	private function update_notification_types(string $method, bool $ignore_missing = false): void
	{
		$notification_manager = $this->container->get('notification_manager');
		foreach (self::NOTIFICATION_TYPES as $notification_type)
		{
			try
			{
				$notification_manager->{$method}($notification_type);
			}
			catch (\phpbb\notification\exception $e)
			{
				if (!$ignore_missing)
				{
					throw $e;
				}
			}
		}
	}
}
