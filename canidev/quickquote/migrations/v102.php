<?php
/**
* @package cBB QuickQuote
* @version v1.0.2 21/04/2021
*
* @copyright (c) 2021 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
*/

namespace canidev\quickquote\migrations;

class v102 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['quickquote_floatbtn']) &&
			(!isset($this->config['quickquote_version']) || version_compare($this->config['quickquote_version'], '1.0.2', '>='));
	}

	static public function depends_on()
	{
		return array(
			'\canidev\quickquote\migrations\v101',
		);
	}

	public function update_data()
	{
		return array(
			array('config.update',	array('quickquote_version', '1.0.2')),
		);
	}
}
