<?php
/**
 *
 * @package User Defaults Extension
 * @copyright (c) 2016 david63
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace david63\userdefaults\migrations;

use phpbb\db\migration\migration;

class version_2_1_0 extends migration
{
	/**
	 * Assign migration file dependencies for this migration
	 *
	 * @return array Array of migration files
	 * @static
	 * @access public
	 */
	public static function depends_on()
	{
		return ['\phpbb\db\migration\data\v330\v330'];
	}

	public function update_data()
	{
		/**
		 * Add or update data in the database
		 *
		 * @return array Array of table data
		 * @access public
		 */
		return [
			['config.add', ['ud_allow_pm', 1]],
			['config.add', ['ud_allow_massemail', 1]],
			['config.add', ['ud_allow_viewemail', 1]],
			['config.add', ['ud_allow_viewonline', 0]],
			['config.add', ['ud_date_format', 'd M Y H:i']],
			['config.add', ['ud_moderation_queue', 0]],
			['config.add', ['ud_notifications', 0]],
			['config.add', ['ud_notify', 0]],
			['config.add', ['ud_notify_pm', 1]],
			['config.add', ['ud_options', 230271]],
			['config.add', ['ud_post_sd', 'a']],
			['config.add', ['ud_post_sk', 't']],
			['config.add', ['ud_post_st', 0]],
			['config.add', ['ud_topic_sd', 'd']],
			['config.add', ['ud_topic_sk', 't']],
			['config.add', ['ud_topic_st', 0]],
			['config.add', ['ud_type_bookmark', 0]],
			['config.add', ['ud_type_group', 0]],
			['config.add', ['ud_type_needs_approval', 0]],
			['config.add', ['ud_type_pm', 0]],
			['config.add', ['ud_type_post', 1]],
			['config.add', ['ud_type_quote', 0]],
			['config.add', ['ud_type_report', 0]],
			['config.add', ['ud_type_topic', 1]],

			// Add the ACP module
			['module.add', ['acp', 'ACP_CAT_DOT_MODS', 'USER_DEFAULTS']],

			['module.add', [
				'acp', 'USER_DEFAULTS', [
					'module_basename' => '\david63\userdefaults\acp\userdefaults_module',
					'modes' => ['manage'],
				],
			]],
		];
	}
}
