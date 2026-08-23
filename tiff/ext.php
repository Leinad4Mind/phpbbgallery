<?php
/**
 * phpBB Gallery - TIFF Extension
 *
 * @package   phpbbgallery/tiff
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\tiff;

class ext extends \phpbb\extension\base
{
	public function is_enableable(): bool
	{
		$manager = $this->container->get('ext.manager');
		$user = $this->container->get('user');
		if (!$manager->is_enabled('phpbbgallery/core') && $manager->is_available('phpbbgallery/core'))
		{
			$manager->enable('phpbbgallery/core');
		}
		if (!$manager->is_enabled('phpbbgallery/core'))
		{
			$user->add_lang_ext('phpbbgallery/tiff', 'info_tiff');
			trigger_error($user->lang('GALLERY_CORE_NOT_FOUND'), E_USER_WARNING);
			return false;
		}
		if (!processor::is_supported())
		{
			$user->add_lang_ext('phpbbgallery/tiff', 'info_tiff');
			trigger_error($user->lang('GALLERY_TIFF_IMAGICK_REQUIRED'), E_USER_WARNING);
			return false;
		}

		return \phpbbgallery\core\dependency\version_validator::validate($manager, $user, [
			'phpbbgallery/core' => ['4.1.0', '5.0.0'],
		]);
	}
}
