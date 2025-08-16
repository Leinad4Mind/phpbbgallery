<?php
/**
 * @package cBB Quickquote
 * @version 1.0.4 01/06/2024
 *
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\quickquote\migrations;

class v104 extends \phpbb\db\migration\migration
{
	/**
	 * {@inheritDoc}
	 */
	public function effectively_installed()
	{
		return isset($this->config['quickquote_floatbtn']) && !isset($this->config['quickquote_version']);
	}

	/**
	 * {@inheritDoc}
	 */
	static public function depends_on()
	{
		return [
			'\canidev\quickquote\migrations\v103',
		];
	}

	/**
	 * {@inheritDoc}
	 */
	public function update_data()
	{
		return [
			['config.remove',	['quickquote_version']],
		];
	}
}
