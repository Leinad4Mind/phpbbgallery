<?php
/**
*
* @package phpBB Extension - Basic Stats
* @copyright (c) 2025 Stoker
* @copyright (c) 2015 OXPUS - www.oxpus.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

declare(strict_types=1);

namespace stoker\basicstats;

/**
* @ignore
*/
class ext extends \phpbb\extension\base
{
	/**
	 * Enable extension if minimum requirements are met.
	 *
	 * - Requires phpBB >= 3.3.0
	 * - Requires PHP  >= 7.4.0
	 *
	 * @return bool
	 * @access public
	 */
	public function is_enableable()
	{
		$config = $this->container->get('config');
		$user = $this->container->get('user');

		$required_phpbb = '3.3.0';
		$required_php = '7.4.0';

		$phpbb_ok = phpbb_version_compare($config['version'], $required_phpbb, '>=');
		$php_ok = version_compare(PHP_VERSION, $required_php, '>=');

		if (method_exists($user, 'add_lang_ext')) {
			$user->add_lang_ext('stoker/basicstats', 'common');
		}

		if (!$phpbb_ok) {
			trigger_error($user->lang('BS_REQUIRE_PHPBB', $required_phpbb, $config['version']), E_USER_WARNING);
		}

		if (!$php_ok) {
			trigger_error($user->lang('BS_REQUIRE_PHP', $required_php, PHP_VERSION), E_USER_WARNING);
		}

		return $phpbb_ok && $php_ok;
	}
}
