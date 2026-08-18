<?php
/**
 * phpBB Gallery - independent album-list pagination.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\migration;

/** Add bounded album pages and optional progressive list navigation. */
class album_list_pagination extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\webp_quality'];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_albums_per_page', 15]],
			['custom', [[$this, 'inherit_existing_page_size']]],
			['config.add', ['phpbb_gallery_ajax_list_navigation', 0]],
		];
	}

	public function revert_data(): array
	{
		return [
			['config.remove', ['phpbb_gallery_ajax_list_navigation']],
			['config.remove', ['phpbb_gallery_albums_per_page']],
		];
	}

	/** Preserve the administrator's previous pagination preference on upgrade. */
	public function inherit_existing_page_size(): bool
	{
		$page_size = max(1, (int) ($this->config['phpbb_gallery_items_per_page'] ?? 15));
		$this->config->set('phpbb_gallery_albums_per_page', $page_size);

		return true;
	}
}
