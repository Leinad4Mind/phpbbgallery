<?php
/**
 *
 * Best Answer extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019-2026, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\bestanswer\migrations\v10x;

class release_0_2_0 extends \phpbb\db\migration\container_aware_migration
{
	public function effectively_installed()
	{
		return $this->config->offsetExists('bestanswer_lock_on_answer');
	}

	static public function depends_on()
	{
		return array('\leinad4mind\bestanswer\migrations\v10x\release_0_1_0');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('bestanswer_lock_on_answer', 0)),
		);
	}
}
