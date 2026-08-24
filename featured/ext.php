<?php
/**
 * phpBB Gallery - Featured Images Add-on.
 *
 * @package   phpbbgallery/featured
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\featured;

class ext extends \phpbb\extension\base
{
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
			$user->add_lang_ext('phpbbgallery/featured', 'featured');
			trigger_error($user->lang('GALLERY_CORE_NOT_FOUND'), E_USER_WARNING);
			return false;
		}

		return \phpbbgallery\core\dependency\version_validator::validate($manager, $user, [
			'phpbbgallery/core' => ['4.2.0', '5.0.0'],
		]);
	}

	public function enable_step(mixed $old_state): mixed
	{
		if ($old_state === 'reconcile')
		{
			$prefix = (string) $this->container->getParameter('core.table_prefix');
			$manager = new manager(
				$this->container->get('dbal.conn'),
				$prefix . 'gallery_featured',
				$prefix . 'gallery_images'
			);
			$manager->reconcile_orphans();
			return false;
		}

		return parent::enable_step($old_state) ? 'migrations' : 'reconcile';
	}
}
