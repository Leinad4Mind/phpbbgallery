<?php
/**
 *
 * HTML email extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2015 ForumHulp.com <http://forumhulp.com>
 * @copyright (c) 2026 Leinad4Mind <https://leinad4mind.top>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\htmlemail\migrations\v33x;

class m2_acp_module extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\leinad4mind\htmlemail\migrations\v33x\m1_initial_file'];
	}

	public function update_data()
	{
		return [
			['module.add', [
				'acp',
				'ACP_BOARD_CONFIGURATION',
				[
					'module_basename'	=> '\leinad4mind\htmlemail\acp\htmlemail_module',
					'modes'				=> ['overview'],
				],
			]],
		];
	}
}
