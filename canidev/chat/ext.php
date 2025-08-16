<?php
/*
* @package cBB Chat
* @version v1.2.3 22/04/2022
*
* @copyright (c) 2022 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
*/

namespace canidev\chat;

class ext extends \phpbb\extension\base
{
	const REQUIRED_PHPBB	= '3.2.0';
	const REQUIRED_CORE		= '1.0.16';

	/**
	 * {@inheritDoc}
	 */
	public function is_enableable()
	{
		$config 	= $this->container->get('config');
		$language 	= $this->container->get('language');
		$language->add_lang('main', 'canidev/chat');

		// Check phpBB version
		if(phpbb_version_compare($config['version'], self::REQUIRED_PHPBB, '<'))
		{
			return false;
		}

		// Check Core version
		$core_lib_filename = $this->container->getParameter('core.root_path') . 'ext/canidev/core/lib.' . $this->container->getParameter('core.php_ext');
		
		if(!file_exists($core_lib_filename) || phpbb_version_compare(\canidev\core\lib::VERSION, self::REQUIRED_CORE, '<'))
		{
			trigger_error($language->lang('CORE_INSTALL_ERROR'), E_USER_WARNING);
		}

		return true;
	}
}
