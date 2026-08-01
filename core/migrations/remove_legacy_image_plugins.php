<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\migration;

/**
 * Replace link modes owned by obsolete third-party image plugins.
 */
class remove_legacy_image_plugins extends migration
{
	private const LEGACY_MODES = [
		'highslide',
		'lytebox',
		'lytebox_slide_show',
		'shadowbox',
		'shadowbox_slide_show',
	];

	private const LINK_DEFAULTS = [
		'phpbb_gallery_link_thumbnail' => 'image_page',
		'phpbb_gallery_link_imagepage' => 'image',
		'phpbb_gallery_link_image_name' => 'image_page',
		'phpbb_gallery_link_image_icon' => 'image_page',
	];

	public static function depends_on(): array
	{
		return ['\\phpbbgallery\\core\\migrations\\ajax_image_navigation'];
	}

	public function update_data(): array
	{
		return [
			['custom', [[$this, 'normalize_legacy_link_modes']]],
		];
	}

	public function revert_data(): array
	{
		// Removed integrations cannot safely be restored without their third-party assets.
		return [];
	}

	public function normalize_legacy_link_modes(): void
	{
		foreach (self::LINK_DEFAULTS as $config_name => $default)
		{
			if (in_array((string) $this->config[$config_name], self::LEGACY_MODES, true))
			{
				$this->config->set($config_name, $default);
			}
		}
	}
}
