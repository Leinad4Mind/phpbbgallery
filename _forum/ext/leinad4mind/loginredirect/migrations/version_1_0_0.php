<?php
/**
 * @package User Login Redirect
 * @copyright (c) 2014 David Wood
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace leinad4mind\loginredirect\migrations;

use phpbb\db\migration\migration;

class version_1_0_0 extends migration
{
	public function update_data()
	{
		return array(
			array('config.add', array('loginredirect_announce', 0)),
			array('config.add', array('loginredirect_announce_refresh', 0)),
			array('config.add', array('loginredirect_enabled', 0)),
			array('config.add', array('loginredirect_group', 0)),
			array('config.add', array('loginredirect_group_all', 0)),
			array('config.add', array('loginredirect_group_id', 5)),
			array('config.add', array('loginredirect_group_refresh', 0)),
			array('config.add', array('loginredirect_group_topic_id', 0)),
			array('config.add', array('loginredirect_welcome', 0)),
			array('config.add', array('loginredirect_welcome_refresh', 0)),
			array('config.add', array('loginredirect_welcome_topic_id', 0)),
			array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'REDIRECT')),
			array('module.add', array(
				'acp', 'REDIRECT', array(
					'module_basename' => '\\leinad4mind\\loginredirect\\acp\\loginredirect_module',
					'modes' => array('manage'),
				),
			)),
		);
	}
}
