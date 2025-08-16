<?php
/*
* @package cBB Debugger
* @version v1.0.0 21/06/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\debugger\di\pass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class debugger_pass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
    	$config = \canidev\debugger\libraries\config::instance();
    	$params = array();

    	if($config->get('debug_enable'))
    	{
			if(phpbb_version_compare(PHPBB_VERSION, '3.3.0', '>='))
			{
				$params = array_merge($params, array(
					'core.debug',
					'debug.show_errors',
					'session.log_errors'
				));
			}

			$params = array_merge($params, array(
				'debug.exceptions',
				'twig.debug',
				'twig.auto_reload',
				'twig.enable_debug_extension',
			));
		}

		if($config->get('show_stats') && phpbb_version_compare(PHPBB_VERSION, '3.3.0', '>='))
		{
			$params = array_merge($params, array(
				'debug.load_time',
				'debug.memory',
				'debug.sql_explain',
			));
		}

		foreach($params as $key)
		{
			$container->setParameter($key, true);
		}
    }
}
