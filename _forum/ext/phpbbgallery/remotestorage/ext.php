<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage;

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
			$user->add_lang_ext('phpbbgallery/remotestorage', 'info_acp_remotestorage');
			trigger_error($user->lang('GALLERY_CORE_NOT_FOUND'), E_USER_WARNING);

			return false;
		}
		if (!class_exists(\GuzzleHttp\Client::class) || !function_exists('simplexml_load_string'))
		{
			$user->add_lang_ext('phpbbgallery/remotestorage', 'info_acp_remotestorage');
			trigger_error($user->lang('REMOTE_STORAGE_REQUIREMENTS_MISSING'), E_USER_WARNING);

			return false;
		}

		return true;
	}
}
