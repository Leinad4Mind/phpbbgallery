<?php
/**
 * @package cBB QuickQuote
 * @version v1.0.3 15/01/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\quickquote\migrations;

class v103 extends \phpbb\db\migration\migration
{
	/**
	 * {@inheritDoc}
	 */
	public function effectively_installed()
	{
		return isset($this->config['quickquote_floatbtn']) &&
			(!isset($this->config['quickquote_version']) || version_compare($this->config['quickquote_version'], '1.0.3', '>='));
	}

	/**
	 * {@inheritDoc}
	 */
	static public function depends_on()
	{
		return [
			'\canidev\quickquote\migrations\v102',
		];
	}

	/**
	 * {@inheritDoc}
	 */
	public function update_data()
	{
		return [
			['config.update',	['quickquote_version', '1.0.3']],
		];
	}
}
