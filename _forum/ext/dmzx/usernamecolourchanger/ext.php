<?php
/**
 *
 * @package phpBB Extension - User Colour Changer
 * @copyright (c) 2015 dmzx - https://www.dmzx-web.net
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

namespace dmzx\usernamecolourchanger;

class ext extends \phpbb\extension\base
{
	/**
	 * Enable the extension only on supported phpBB and PHP versions.
	 *
	 * @return bool
	 */
	public function is_enableable()
	{
		$config = $this->container->get('config');

		return PHP_VERSION_ID >= 70200
			&& version_compare($config['version'], '3.3.0', '>=')
			&& version_compare($config['version'], '4.0.0-dev', '<');
	}
}
