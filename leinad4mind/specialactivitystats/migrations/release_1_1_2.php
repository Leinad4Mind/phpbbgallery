<?php

/**
 *
 * Special Activity Stats. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\specialactivitystats\migrations;

/**
 * @ignore
 */
use leinad4mind\specialactivitystats\modes;
use leinad4mind\specialactivitystats\prefixes;

class release_1_1_2 extends \phpbb\db\migration\migration
{
	protected $version = "1.1.2-DEV";

	public function effectively_installed()
	{
		return version_compare($this->config[prefixes::CONFIG.'_version'], $this->version, '>=');
	}

	static public function depends_on()
	{
		return array(
			'\leinad4mind\specialactivitystats\migrations\release_1_1_0',
		);
	}

	public function update_data()
	{
		return array(
			array('config.add', array(prefixes::CONFIG.'_mode', modes::TODAY)),
			array('config.update', array(prefixes::CONFIG.'_version', $this->version)),
		);
	}
}
