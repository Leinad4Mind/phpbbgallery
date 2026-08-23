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

/** Remove the redundant Gallery version configuration before closing the 4.1.0 chain. */
class remove_legacy_version_config extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\disp_image_type'];
	}

	public function update_data(): array
	{
		return [
			['config.remove', ['phpbb_gallery_version']],
		];
	}
}
