<?php
/**
 *
 * @package Friends & Foes Extension
 * @copyright (c) 2022 devspace
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace devspace\friendsandfoes\migrations\v_3_3_0;

use phpbb\db\migration\migration;

class install_module extends migration
{
	/**
	 * {@inheritdoc
	 */
	public static function depends_on()
	{
		return ['\devspace\friendsandfoes\migrations\v_3_3_0\install_cat'];
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
					'module_basename' => '\devspace\friendsandfoes\acp\friendsandfoes_module',
					'modes' => ['main'],
				],
			]],
		];
	}
}
