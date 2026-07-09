<?php
/**
 *
 * CF Change Post Time
 *
 * @copyright (c) 2024 chris1278
 * @copyright (c) 2015 javiexin ( www.exincastillos.es )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Javier Lopez (javiexin)
 */


namespace chris1278\cptfork;

class ext extends \phpbb\extension\base
{
	public function is_enableable()
	{
		global $phpbb_extension_manager;
		if ($phpbb_extension_manager->is_enabled('javiexin/chgposttime'))
		{
			$phpbb_extension_manager->disable('javiexin/chgposttime');
		}

		$valid_phpbb = phpbb_version_compare(PHPBB_VERSION, '3.3.0', '>=') && phpbb_version_compare(PHPBB_VERSION, '4.0-dev', '<');
		$valid_php = phpbb_version_compare(PHP_VERSION, '7.0.0', '>=') && phpbb_version_compare(PHP_VERSION, '8.3.0-dev', '<');

		return $valid_phpbb && $valid_php;
	}
}
