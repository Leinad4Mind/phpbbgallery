<?php
/**
 * @package Dropbox Upload
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace david63\dropboxupload\migrations;

use phpbb\db\migration\migration;

class version_3_3_0 extends migration
{
	public static function depends_on()
	{
		return '\\david63\\dropboxupload\\migrations\\version_2_1_0';
	}

	public function update_data()
	{
		return array(
			array('config_text.add', array('dropbox_app_key', '')),
			array('config_text.add', array('dropbox_app_secret', '')),
			array('config_text.add', array('dropbox_refresh_token', '')),
			array('config_text.add', array('dropbox_access_token', '')),
			array('custom', array(array($this, 'migrate_credentials'))),
			array('config.remove', array('dropbox_key')),
			array('config.remove', array('dropbox_secret')),
			array('config.remove', array('dropbox_token')),
		);
	}

	public function migrate_credentials()
	{
		$config_text = $this->container->get('config_text');
		$mapping = array(
			'dropbox_key' => 'dropbox_app_key',
			'dropbox_secret' => 'dropbox_app_secret',
			'dropbox_token' => 'dropbox_access_token',
		);
		foreach ($mapping as $old_key => $new_key)
		{
			$current = $config_text->get($new_key);
			if (($current === null || $current === '') && !empty($this->config[$old_key]))
			{
				$config_text->set($new_key, $this->config[$old_key]);
			}
		}
	}
}
