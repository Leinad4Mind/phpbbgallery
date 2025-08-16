<?php

/**
*
* @package Double Account Preventer
* @copyright (c) 2014 www.phpbb-work.ru
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace shredder\dap\migrations;

class v_1_0_1 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['dap_version']) && version_compare($this->config['dap_version'], '1.0.1', '>=');
	}

	static public function depends_on()
	{
		return array('\shredder\dap\migrations\v_1_0_0');
	}

	public function update_data()
	{
		return array(
			// Current version
			array('config.update', array('dap_version', '1.0.1')),
		);
	}
}
