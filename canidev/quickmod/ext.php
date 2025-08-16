<?php
/**
* @package cBB QuickMod
* @version 1.1.4 01/06/2022
*
* @copyright (c) 2022 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
*/

namespace canidev\quickmod;

class ext extends \phpbb\extension\base
{
	const REQUIRED_PHPBB	= '3.2.0';
	const REQUIRED_CORE		= '1.1.0';
	
	/**
	 * {@inheritDoc}
	 */
	public function is_enableable()
	{
		// Check phpBB version
		$config = $this->container->get('config');
		
		if(phpbb_version_compare($config['version'], self::REQUIRED_PHPBB, '<'))
		{
			return false;
		}

		// Check Core version
		if(!class_exists('\canidev\core\constants') || phpbb_version_compare(\canidev\core\constants::VERSION, self::REQUIRED_CORE, '<'))
		{
			$language = $this->container->get('language');
			$language->add_lang('main', 'canidev/quickmod');
			
			trigger_error($language->lang('CORE_INSTALL_ERROR'), E_USER_WARNING);
		}
		
		return true;
	}
}
