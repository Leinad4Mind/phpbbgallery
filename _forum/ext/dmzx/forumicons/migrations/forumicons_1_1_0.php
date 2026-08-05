<?php
/**
 *
 * @package phpBB Extension - Forum Icons
 * @copyright (c) 2015 dmzx - https://www.dmzx-web.net
 * @license https://opensource.org/license/gpl-2-0 GNU General Public License v2
 *
 */

namespace dmzx\forumicons\migrations;

class forumicons_1_1_0 extends forumicons_install
{
	public static function depends_on()
	{
		return [
			'\dmzx\forumicons\migrations\forumicons_install',
		];
	}

	public function update_data()
	{
		return [
			['config.remove', ['forumicons_version']],
			['custom', [[$this, 'create_icon_directory']]],
		];
	}
}
