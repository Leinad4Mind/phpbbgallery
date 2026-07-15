<?php
/*
* @package cBB QuickMod
* @version v1.1.3 16/04/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\quickmod;

class ext extends \phpbb\extension\base
{
	const REQUIRED_PHPBB	= '3.2.0';
	const REQUIRED_CORE		= '1.0.9';
	
	public function is_enableable()
	{
		// Check phpBB version
		$config = $this->container->get('config');
		
		if(phpbb_version_compare($config['version'], self::REQUIRED_PHPBB, '<'))
		{
			return false;
		}

		// Check Core version
		$core_lib_filename = $this->container->getParameter('core.root_path') . 'ext/canidev/core/lib.' . $this->container->getParameter('core.php_ext');
		
		if(!file_exists($core_lib_filename) || phpbb_version_compare(\canidev\core\lib::VERSION, self::REQUIRED_CORE, '<'))
		{
			$language = $this->container->get('language');
			$language->add_lang('main', 'canidev/quickmod');
			
			trigger_error($language->lang('CORE_INSTALL_ERROR'), E_USER_WARNING);
		}
		
		return true;
	}
}
