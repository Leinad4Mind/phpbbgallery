<?php
/**
 *
 * @package phpBB Extension - Official Topic Index
 * @copyright (c) 2015-2022 Leinad4Mind - https://leinad4mind.top/forum
 * @copyright (c) 2015 dmzx - https://www.dmzx-web.net
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace leinad4mind\officialtopicindex\migrations;

class officialtopicindex_data extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['officialindex_overflow']);
	}

	public function update_data()
	{
		return [
			['custom', [[$this, 'migrate_overflow_setting']]],
		];
	}

	public function migrate_overflow_setting()
	{
		if (isset($this->config['officialindex_overflow']))
		{
			return;
		}

		$value = isset($this->config['oindex_overflow']) ? (int) $this->config['oindex_overflow'] : 0;
		$this->config->set('officialindex_overflow', $value ? 1 : 0);
	}
}
