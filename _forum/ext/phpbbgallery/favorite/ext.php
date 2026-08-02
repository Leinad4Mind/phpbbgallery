<?php
/**
 * phpBB Gallery - Favorite Extension
 *
 * @package   phpbbgallery/favorite
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\favorite;

class ext extends \phpbb\extension\base
{
	/**
	 * Check whether or not the extension can be enabled.
	 * Checks dependencies and requirements.
	 *
	 * @return bool
	 */
	public function is_enableable(): bool
	{
		$manager = $this->container->get('ext.manager');
		$user = $this->container->get('user');

		$core_ext = 'phpbbgallery/core';

		if (!$manager->is_enabled($core_ext) && $manager->is_available($core_ext))
		{
			$manager->enable($core_ext);
		}

		if (!$manager->is_enabled($core_ext))
		{
			$user->add_lang_ext('phpbbgallery/favorite', 'info_favorite');
			trigger_error($user->lang('GALLERY_CORE_NOT_FOUND'), E_USER_WARNING);
			return false;
		}

		return true;
	}

	/**
	 * Perform additional tasks on extension enable
	 *
	 * @param mixed $old_state State returned by previous call of this method
	 * @return mixed Returns false after last step, otherwise temporary state
	 */
	public function enable_step(mixed $old_state): mixed
	{
		if ($old_state === 'reconcile')
		{
			$prefix = (string) $this->container->getParameter('core.table_prefix');
			$favorite = new favorite(
				$this->container->get('dbal.conn'),
				$prefix . 'gallery_favorites',
				$prefix . 'gallery_images'
			);
			$favorite->reconcile_orphans();

			return false;
		}
		if (empty($old_state))
		{
			$this->container->get('user')->add_lang_ext('phpbbgallery/favorite', 'info_favorite');
			$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS']);
		}

		return parent::enable_step($old_state) ? 'migrations' : 'reconcile';
	}
}
