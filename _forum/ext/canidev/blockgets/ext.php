<?php
/*
* @package cBB Blockgets
* @version v2.0.2 12/01/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class ext extends \phpbb\extension\base
{
	const REQUIRED_PHPBB	= '3.2.0';
	const REQUIRED_CORE		= '1.0.8';
	
	public function is_enableable()
	{
		$config		= $this->container->get('config');
		$language	= $this->container->get('language');
		
		$language->add_lang('installer', 'canidev/blockgets');
		
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

	function enable_step($old_state)
	{
		// Get real Rewrite status
		$test_url = generate_board_url() . '/blockgets.test';
		
		if(function_exists('curl_init'))
		{
			$ch = curl_init($test_url);

			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

			$file = curl_exec($ch);

			curl_close($ch);
		}
		else
		{
			$context = stream_context_create(array(
				'http' => array(
					'ignore_errors'  => true,
				)
			));

			$file = @file_get_contents($test_url, false, $context);
		}

		// if return phpBB page, rewrite is enabled
		$this->container->get('config')->set('blg_rewrite', (preg_match('#\<body.*?id="phpbb"#', $file) ? 1 : 0));

		// Create upload folder
		\canidev\core\tools::mkdir($this->container->getParameter('core.root_path') . 'files/blockgets/', true);

		// Run parent enable step method
		return parent::enable_step($old_state);
	}
}
