<?php
/*
* @package cBB Blockgets
* @version v2.0.4 30/08/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\libraries;

class migration_base extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['blg_version']) && version_compare($this->config['blg_version'], $this->version, '>=');
	}

	public function update_data()
	{
		$this->prepare();

		$actions = array(
			array('config.update',	array('blg_version', $this->version)),
		);

		if(method_exists($this, '_update_data'))
		{
			$actions = array_merge($actions, $this->_update_data());
		}

		return $actions;
	}

	public function prepare()
	{
		if(!defined('BLG_BLOCK_TABLE'))
		{
			$table_prefix = $this->table_prefix;
			include($this->phpbb_root_path . 'ext/canidev/blockgets/libraries/constants.' . $this->php_ext);
		}
	}
}
