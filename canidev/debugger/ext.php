<?php
/**
 * @package cBB Debugger
 * @version 1.0.1 20/09/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\debugger;

class ext extends \phpbb\extension\base
{
	const REQUIRED_PHPBB	= '3.2.0';
	const REQUIRED_CORE		= '1.1.1';
	
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
			$language = $this->container->get('language');
			$language->add_lang('info_acp_debugger', 'canidev/debugger');
			
			trigger_error($language->lang('CORE_INSTALL_ERROR'), E_USER_WARNING);
		}
		
		return true;
	}

	/**
	 * {@inheritDoc}
	 */
	public function purge_step($old_state)
	{
		switch($old_state)
		{
			case '':
				// Remove config file
				\canidev\debugger\libraries\config::instance()->destroy();
				
				return 'debugger';

			default:
				// Run parent disable step method
				return parent::disable_step($old_state);
		}
	}
}
