<?php
/**
 * phpBB Gallery - Featured Images display controls.
 *
 * @package   phpbbgallery/featured
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\featured\migrations;

use phpbb\db\migration\migration;

class m2_display_controls extends migration
{
	public static function depends_on(): array
	{
		return ['\\phpbbgallery\\featured\\migrations\\m1_init'];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_featured_location', 1]],
			['custom', [[$this, 'inherit_enabled_state']]],
			['config.add', ['phpbb_gallery_featured_position', 1]],
		];
	}

	public function revert_data(): array
	{
		return [
			['config.remove', ['phpbb_gallery_featured_position']],
			['config.remove', ['phpbb_gallery_featured_location']],
		];
	}

	/** Preserve the previous enabled/disabled choice while adopting the selector. */
	public function inherit_enabled_state(): bool
	{
		$this->config->set(
			'phpbb_gallery_featured_location',
			!empty($this->config['phpbb_gallery_featured_enable']) ? 1 : 0
		);

		return true;
	}
}
