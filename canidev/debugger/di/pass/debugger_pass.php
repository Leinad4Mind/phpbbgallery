<?php
/**
 * @package cBB Debugger
 * @version 1.0.1 20/09/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\debugger\di\pass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class debugger_pass implements CompilerPassInterface
{
	/**
	 * {@inheritDoc}
	*/
    public function process(ContainerBuilder $container)
    {
		if(!defined('PHPBB_VERSION'))
		{
			return;
		}

		$config = \canidev\debugger\libraries\config::instance();
		$params = [];

    	if($config->get('debug_enable'))
    	{
			if(phpbb_version_compare(PHPBB_VERSION, '3.3.0', '>='))
			{
				$params = array_merge($params, [
					'core.debug',
					'debug.show_errors',
					'session.log_errors'
				]);
			}

			$params = array_merge($params, [
				'debug.exceptions',
				'twig.debug',
				'twig.auto_reload',
				'twig.enable_debug_extension',
			]);
		}

		if($config->get('show_stats') && phpbb_version_compare(PHPBB_VERSION, '3.3.0', '>='))
		{
			$params = array_merge($params, [
				'debug.load_time',
				'debug.memory',
				'debug.sql_explain',
			]);
		}

		foreach($params as $key)
		{
			$container->setParameter($key, true);
		}
    }
}
