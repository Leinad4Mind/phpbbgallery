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
use leinad4mind\specialactivitystats\prefixes;

class release_1_2_2 extends \phpbb\db\migration\migration
{
	protected $version = "1.2.2-DEV";

	public function effectively_installed()
	{
		return version_compare($this->config[prefixes::CONFIG.'_version'], $this->version, '>=');
	}

	static public function depends_on()
	{
		return array(
			'\leinad4mind\specialactivitystats\migrations\release_1_2_0',
		);
	}

	public function update_data()
	{
		return array(
			// update version
			array('config.update', array(prefixes::CONFIG.'_version', $this->version)),
		);
	}
}
