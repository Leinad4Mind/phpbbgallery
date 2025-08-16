<?php
/*
* @package cBB QuickQuote
* @version v1.0.1 10/02/2019
*
* @copyright (c) 2019 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\quickquote\migrations;

class v101 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['quickquote_version']) && version_compare($this->config['quickquote_version'], '1.0.1', '>=');
	}

	static public function depends_on()
	{
		return array(
			'\canidev\quickquote\migrations\v100',
		);
	}

	public function update_data()
	{
		return array(
			array('config.add',		array('quickquote_reply_overwrite', 1)),
			array('config.update',	array('quickquote_version', '1.0.1')),
		);
	}
}
