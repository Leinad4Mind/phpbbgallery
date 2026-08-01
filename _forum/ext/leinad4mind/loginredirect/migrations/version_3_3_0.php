<?php
/**
 * @package User Login Redirect
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace leinad4mind\loginredirect\migrations;

use phpbb\db\migration\migration;

class version_3_3_0 extends migration
{
	public static function depends_on()
	{
		return '\\leinad4mind\\loginredirect\\migrations\\version_2_1_0';
	}

	public function update_data()
	{
		$data = array(array('custom', array(array($this, 'migrate_legacy_config'))));
		foreach ($this->legacy_keys() as $key)
		{
			$data[] = array('config.remove', array('redirect_' . $key));
		}
		$data[] = array('config.remove', array('version_loginredirect'));
		return $data;
	}

	public function migrate_legacy_config()
	{
		foreach ($this->legacy_keys() as $key)
		{
			$old_key = 'redirect_' . $key;
			if (isset($this->config[$old_key]))
			{
				$this->config->set('loginredirect_' . $key, $this->config[$old_key]);
			}
		}
	}

	protected function legacy_keys()
	{
		return array(
			'always', 'announce', 'announce_priority', 'announce_refresh', 'announce_topic_id',
			'any_announce', 'enabled', 'global', 'group', 'group_all', 'group_id',
			'group_refresh', 'group_topic_id', 'welcome', 'welcome_refresh', 'welcome_topic_id',
		);
	}
}
