<?php
/**
 *
 * @package phpBB Extension - Who Visited This Topic
 * @copyright (c) 2019 dmzx - https://www.dmzx-web.net
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

namespace dmzx\whovisitedthistopic;

use phpbb\extension\base;

class ext extends base
{
	public function is_enableable()
	{
		$version = $this->container->get('config')['version'];

		return PHP_VERSION_ID >= 70200
			&& phpbb_version_compare($version, '3.3.0', '>=')
			&& phpbb_version_compare($version, '4.0.0', '<');
	}
}
