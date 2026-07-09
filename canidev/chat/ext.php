<?php
/**
 * @package cBB Chat
 * @version 1.2.7 07/03/2025
 *
 * @copyright (c) 2025 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\chat;

class ext extends \phpbb\extension\base
{
	const REQUIRED_PHPBB	= '3.2.0';
	const REQUIRED_CORE		= '1.1.10';

	/**
	 * {@inheritDoc}
	 */
	public function is_enableable()
	{
		$config = $this->container->get('config');

		// Check phpBB version
		if(phpbb_version_compare($config['version'], self::REQUIRED_PHPBB, '<'))
		{
			return false;
		}

		// Check Core version
		if(!class_exists('\canidev\core\constants') || phpbb_version_compare(\canidev\core\constants::VERSION, self::REQUIRED_CORE, '<'))
		{
			$language 	= $this->container->get('language');
			$language->add_lang('main', 'canidev/chat');
			
			trigger_error($language->lang('CORE_INSTALL_ERROR'), E_USER_WARNING);
		}

		return true;
	}
}
