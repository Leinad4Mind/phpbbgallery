<?php
/**
 * phpBB Gallery - Image Revisions Extension
 *
 * @package   phpbbgallery/imagerevisions
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\imagerevisions;

class ext extends \phpbb\extension\base
{
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
			$user->add_lang_ext('phpbbgallery/imagerevisions', 'info_imagerevisions');
			trigger_error($user->lang('GALLERY_CORE_NOT_FOUND'), E_USER_WARNING);
			return false;
		}

		return true;
	}

	public function enable_step(mixed $old_state): mixed
	{
		if (empty($old_state))
		{
			$this->container->get('user')->add_lang_ext('phpbbgallery/imagerevisions', 'info_imagerevisions');
			$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS']);
		}

		return parent::enable_step($old_state);
	}
}
