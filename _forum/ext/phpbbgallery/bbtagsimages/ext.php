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
		if ($old_state === 'reconcile')
		{
			$this->reconcile_orphans();
			return false;
		}
		if (empty($old_state))
		{
			$this->container->get('user')->add_lang_ext('phpbbgallery/bbtagsimages', 'info_acp_bbtagsimages');
			$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS']);
		}

		return parent::enable_step($old_state) ? 'migrations' : 'reconcile';
	}

	private function reconcile_orphans(): void
	{
		$prefix = (string) $this->container->getParameter('core.table_prefix');
		$db = $this->container->get('dbal.conn');
		$images_table = $prefix . 'gallery_images';
		$manager = new image_tag_manager(
			$db,
			$prefix . 'gallery_image_tags',
			$images_table,
			$prefix . 'bbtags',
			$prefix . 'bbtags_context'
		);
		$manager->reconcile_orphans();

		$sql = 'SELECT DISTINCT suggestion.item_id
			FROM ' . $prefix . 'bbtags_suggestions suggestion
			LEFT JOIN ' . $images_table . ' image
				ON image.image_id = suggestion.item_id
			WHERE suggestion.provider = \'gallery_images\'
				AND suggestion.status = \'pending\'
				AND image.image_id IS NULL';
		$result = $db->sql_query($sql);
		$image_ids = [];
		while ($row = $db->sql_fetchrow($result))
		{
			$image_ids[] = (int) $row['item_id'];
		}
		$db->sql_freeresult($result);
		if ($image_ids)
		{
			$this->container->get('sitesplat.bbtags.moderation')->cancel_items(image_tag_manager::PROVIDER, $image_ids);
		}

		$sql = 'SELECT DISTINCT scope.scope_id
			FROM ' . $prefix . 'bbtags_scope scope
			LEFT JOIN ' . $prefix . 'gallery_albums album
				ON album.album_id = scope.scope_id
			WHERE scope.provider = \'gallery_images\'
				AND scope.scope_id > 0
				AND album.album_id IS NULL';
		$result = $db->sql_query($sql);
		$album_ids = [];
		while ($row = $db->sql_fetchrow($result))
		{
			$album_ids[] = (int) $row['scope_id'];
		}
		$db->sql_freeresult($result);
		if ($album_ids)
		{
			$this->container->get('sitesplat.bbtags.manager')->delete_scope_rules(image_tag_manager::PROVIDER, $album_ids);
		}
	}
}
