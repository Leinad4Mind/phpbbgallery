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

class release_1_2_4 extends \phpbb\db\migration\migration
{
	protected $version = "1.2.4-DEV";

	public function effectively_installed()
	{
		return version_compare($this->config[prefixes::CONFIG.'_version'], $this->version, '>=');
	}

	static public function depends_on()
	{
		return array(
			'\leinad4mind\specialactivitystats\migrations\release_1_2_3',
		);
	}

	public function update_data()
	{
		return array(
			array('config.add', array(prefixes::CONFIG.'_del_time_d', 0)),
			// update version
			array('config.update', array(prefixes::CONFIG.'_version', $this->version)),
		);
	}
}
