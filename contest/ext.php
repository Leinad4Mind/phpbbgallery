<?php
/**
 * phpBB Gallery - Contest Add-on.
 *
 * @package   phpbbgallery/contest
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\contest;

class ext extends \phpbb\extension\base
{
	/**
	 * Ensure that the Gallery Core is available before installing the add-on.
	 */
	public function is_enableable(): bool
	{
		$manager = $this->container->get('ext.manager');
		$user = $this->container->get('user');
		$core_extension = 'phpbbgallery/core';

		if (!$manager->is_enabled($core_extension) && $manager->is_available($core_extension))
		{
			$manager->enable($core_extension);
		}

		if (!$manager->is_enabled($core_extension))
		{
			$user->add_lang_ext('phpbbgallery/contest', 'info_contest');
			trigger_error($user->lang('GALLERY_CORE_NOT_FOUND'), E_USER_WARNING);
			return false;
		}

		return true;
	}
}
