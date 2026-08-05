<?php
/**
 * phpBB Gallery - TIFF Extension
 *
 * @package   phpbbgallery/tiff
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\tiff\migrations;

class m1_init extends \phpbb\db\migration\migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\avif_support'];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_tiff_enabled', 0]],
			['config.add', ['phpbb_gallery_tiff_webp_quality', 82]],
			['module.add', ['acp', 'PHPBB_GALLERY', [
				'module_basename' => '\phpbbgallery\tiff\acp\main_module',
				'modes' => ['settings'],
			]]],
		];
	}

	public function revert_data(): array
	{
		return [
			['module.remove', ['acp', 'PHPBB_GALLERY', [
				'module_basename' => '\phpbbgallery\tiff\acp\main_module',
				'modes' => ['settings'],
			]]],
			['config.remove', ['phpbb_gallery_tiff_webp_quality']],
			['config.remove', ['phpbb_gallery_tiff_enabled']],
		];
	}
}
