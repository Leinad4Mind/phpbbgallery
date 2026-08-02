<?php
/**
 * @package User Defaults
 * @copyright (c) 2016 David Wood
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace leinad4mind\userdefaults\migrations;

use phpbb\db\migration\migration;

class version_3_3_0 extends migration
{
	public static function depends_on()
	{
		return array('\\phpbb\\db\\migration\\data\\v330\\v330');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('ud_allow_massemail', 1)),
			array('config.add', array('ud_allow_pm', 1)),
			array('config.add', array('ud_allow_viewemail', 1)),
			array('config.add', array('ud_date_format', 'd M Y H:i')),
			array('config.add', array('ud_moderation_queue', 0)),
			array('config.add', array('ud_notify', 0)),
			array('config.add', array('ud_notify_pm', 1)),
			array('config.add', array('ud_options', 230271)),
			array('config.add', array('ud_post_sd', 'a')),
			array('config.add', array('ud_post_sk', 't')),
			array('config.add', array('ud_post_st', 0)),
			array('config.add', array('ud_topic_sd', 'd')),
			array('config.add', array('ud_topic_sk', 't')),
			array('config.add', array('ud_topic_st', 0)),
			array('config.add', array('ud_type_bookmark', 0)),
			array('config.add', array('ud_type_forum_post', 0)),
			array('config.add', array('ud_type_group', 0)),
			array('config.add', array('ud_type_needs_approval', 0)),
			array('config.add', array('ud_type_pm', 0)),
			array('config.add', array('ud_type_pm_close', 0)),
			array('config.add', array('ud_type_pm_report', 0)),
			array('config.add', array('ud_type_post', 1)),
			array('config.add', array('ud_type_quote', 0)),
			array('config.add', array('ud_type_report', 0)),
			array('config.add', array('ud_type_report_close', 0)),
			array('config.add', array('ud_type_topic', 1)),
			array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'USER_DEFAULTS')),
			array('module.add', array(
				'acp',
				'USER_DEFAULTS',
				array(
					'module_basename' => '\\leinad4mind\\userdefaults\\acp\\userdefaults_module',
					'modes' => array('manage'),
				),
			)),
		);
	}
}
