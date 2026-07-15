<?php

/**
*
* @package Ban Hammer
* @copyright (c) 2015 phpBB Modders <https://phpbbmodders.net/>
* @author Rich McGirr
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace phpbbmodders\banhammer;

/**
* Extension class for banhammer
*/

class ext extends \phpbb\extension\base
{
	/** @var string Require phpBB 3.3.0 */
	const PHPBB_MIN_VERSION = '3.3.0';
	/**
	* Enable extension if phpBB version requirement is met
	*
	* @return bool
	* @access public
	*/
	public function is_enableable()
	{
		$config = $this->container->get('config');

		$enableable = (phpbb_version_compare($config['version'], self::PHPBB_MIN_VERSION, '>='));
		if (!$enableable)
		{
			$language = $this->container->get('language');
			$language->add_lang('banhammer', 'phpbbmodders/banhammer');

			trigger_error($language->lang('EXTENSION_REQUIREMENTS', self::PHPBB_MIN_VERSION), E_USER_WARNING);
		}

		return $enableable;
	}
}