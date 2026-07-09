<?php
/**
 *
 * @package User Details Extension
 * @copyright (c) 2022 devspace
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace devspace\userdetails\migrations\v_3_3_0;

use phpbb\db\migration\migration;

class install_module extends migration
{
	/**
	 * {@inheritdoc
	 */
	public static function depends_on()
	{
		return ['\devspace\userdetails\migrations\v_3_3_0\install_cat'];
	}

	/**
	 * {@inheritdoc
	 */
	public function update_data()
	{
		return [
			// Add the ACP module
			['module.add', [
				'acp', 'ACP_USER_UTILS', [
					'module_basename' => '\devspace\userdetails\acp\userdetails_module',
					'modes' => ['main'],
				],
			]],

			['config.add', ['user_details_save_flag', false, true]],
			['config_text.add', ['user_details_opts', '["s0"]']],
		];
	}
}
