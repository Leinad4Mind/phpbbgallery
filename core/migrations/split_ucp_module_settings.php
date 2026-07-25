<?php
/**
*
* @package phpBB Gallery Core
* @copyright (c) 2014 nickvergessen
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace phpbbgallery\core\migrations;

class split_ucp_module_settings extends \phpbb\db\migration\migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\release_1_2_0_create_filesystem'];
	}

	public function update_data(): array
	{
		return [
			['if', [
				['module.exists', ['ucp', 'UCP_GALLERY', 'UCP_GALLERY_SETTINGS']],
				['module.remove', ['ucp', 'UCP_GALLERY', 'UCP_GALLERY_SETTINGS']],
			]],
			['module.add', ['ucp', 'UCP_GALLERY', [
				'module_basename'	=> '\phpbbgallery\core\ucp\settings_module',
				'module_langname'	=> 'UCP_GALLERY_SETTINGS',
				'module_mode'		=> 'manage',
				'module_auth'		=> 'ext_phpbbgallery/core',
			]]],
		];
	}
}
