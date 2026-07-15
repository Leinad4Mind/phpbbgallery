<?php

/**
 *
 * Special Topic Move. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\specialtopicmove\migrations;

use leinad4mind\specialtopicmove\ext;
use phpbb\db\migration\migration;

class m2_config extends migration
{
	/**
	 * @return bool
	 */
	public function effectively_installed()
	{
		return $this->db_tools->sql_column_exists($this->table_prefix . 'config', 'topic_moved_display');
	}

	/**
	 * @return array
	 */
	public static function depends_on()
	{
		return ['\leinad4mind\specialtopicmove\migrations\m1_topic_schema'];
	}

	/**
	 * @return array
	 */
	public function update_data()
	{
		return [
			['config.add', ['topic_moved_display', ext::SPECIAL_TOPIC_MOVED_BIT_MOVED]],
		];
	}
}
