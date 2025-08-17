<?php
/**
*
* @package phpBB Extension - Popup PM
* @copyright (c) 2016 Татьяна5
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
namespace tatiana5\popuppm\migrations;

class popuppm_0_0_2 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['popuppm_version']) && version_compare($this->config['popuppm_version'], '0.0.2', '>=');
	}

	static public function depends_on()
	{
		return array('\tatiana5\popuppm\migrations\popuppm_0_0_1');
	}

	public function update_data()
	{
		return array(
			// Current version
			array('config.update', array('popuppm_version', '0.0.2')),
		);
	}
}
