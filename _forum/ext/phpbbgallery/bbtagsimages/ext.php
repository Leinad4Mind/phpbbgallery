<?php
/**
 * phpBB Gallery - BBTags Images Extension
 *
 * @package   phpbbgallery/bbtagsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbtagsimages;

class ext extends \phpbb\extension\base
{
	private const DEPENDENCIES = [
		'phpbbgallery/core',
		'sitesplat/bbtags',
	];

	public function is_enableable(): bool
	{
		$manager = $this->container->get('ext.manager');
		$user = $this->container->get('user');
		foreach (self::DEPENDENCIES as $dependency)
		{
			if (!$manager->is_enabled($dependency) && $manager->is_available($dependency))
			{
				$manager->enable($dependency);
			}
		}

		$missing = array_values(array_filter(self::DEPENDENCIES, static function (string $dependency) use ($manager): bool
		{
			return !$manager->is_enabled($dependency);
		}));
		if (!empty($missing))
		{
			$user->add_lang_ext('phpbbgallery/bbtagsimages', 'info_acp_bbtagsimages');
			trigger_error($user->lang('BBTAGSIMAGES_DEPENDENCIES_MISSING', implode(', ', $missing)), E_USER_WARNING);
			return false;
		}

		return true;
	}

	public function enable_step(mixed $old_state): mixed
	{
		if (empty($old_state))
		{
			$this->container->get('user')->add_lang_ext('phpbbgallery/bbtagsimages', 'info_acp_bbtagsimages');
			$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS']);
		}

		return parent::enable_step($old_state);
	}
}
