<?php

/**
*
* @package phpBB Extension - Personal notes
* @copyright (c) 2014 OXPUS - www.oxpus.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace oxpus\notes\migrations;

class release_3_0_4 extends \phpbb\db\migration\migration
{
	var $ext_version = '3.0.4';

	public function effectively_installed()
	{
		return isset($this->config['notes_version']) && version_compare($this->config['notes_version'], $this->ext_version, '>=');
	}

	static public function depends_on()
	{
		return ['\oxpus\notes\migrations\release_3_0_3'];
	}

	public function update_data()
	{
		return [
			// Set the current version
			['config.update', ['notes_version', $this->ext_version]],
		];
	}
}
