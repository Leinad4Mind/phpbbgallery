<?php

/**
*
* @package phpBB Extension - Personal notes
* @copyright (c) 2014 OXPUS - www.oxpus.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace oxpus\notes\migrations;

class release_3_1_8 extends \phpbb\db\migration\migration
{
	var $ext_version = '3.1.8';

	public function effectively_installed()
	{
		return isset($this->config['notes_version']) && version_compare($this->config['notes_version'], $this->ext_version, '>=');
	}

	static public function depends_on()
	{
		return ['\oxpus\notes\migrations\release_3_1_7'];
	}

	public function update_data()
	{
		return [
			// Set the current version
			['config.update', ['notes_version', $this->ext_version]],

			// Remove deprecated files
			['custom', [[$this, 'remove_deprecated_files']]],
		];
	}

	public function remove_deprecated_files()
	{
		global $phpbb_container, $phpEx, $phpbb_extension_manager;

		if ($phpbb_container->get('request')->variable('action', '') == 'delete_data')
		{
			return;
		}

		$ext_path = $phpbb_extension_manager->get_extension_path('oxpus/notes', true);

		@unlink($ext_path . 'styles/prosilver/template/event/overall_footer_after.html');
		@unlink($ext_path . 'styles/prosilver/template/event/simple_footer_after.html');
	}
}
