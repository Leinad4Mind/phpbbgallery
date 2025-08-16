<?php
/**
 * @package cBB Blockgets
 * @version 2.0.5 15/01/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets;

class ext extends \phpbb\extension\base
{
	const REQUIRED_PHPBB	= '3.2.0';
	const REQUIRED_CORE		= '1.1.1';
	
	/**
	 * {@inheritDoc}
	 */
	public function is_enableable()
	{
		$config	= $this->container->get('config');
		
		// Check phpBB version
		if(phpbb_version_compare($config['version'], self::REQUIRED_PHPBB, '<'))
		{
			return false;
		}

		// Check Core version
		if(!class_exists('\canidev\core\constants') || phpbb_version_compare(\canidev\core\constants::VERSION, self::REQUIRED_CORE, '<'))
		{
			$language = $this->container->get('language');
			$language->add_lang('installer', 'canidev/blockgets');

			trigger_error($language->lang('CORE_INSTALL_ERROR'), E_USER_WARNING);
		}
		
		return true;
	}

	/**
	 * {@inheritDoc}
	 */
	public function enable_step($old_state)
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
			$context = stream_context_create([
				'http' => [
					'ignore_errors'  => true,
				]
			]);

			$file = @file_get_contents($test_url, false, $context);
		}

		// if return phpBB page, rewrite is available
		$this->container->get('config')->set('blg_rewrite', (preg_match('#\<body.*?id="phpbb"#', $file) ? 1 : 0));

		// Create upload folder
		\canidev\core\tools::mkdir($this->container->getParameter('core.root_path') . 'files/blockgets/', true);

		// Run parent enable step method
		return parent::enable_step($old_state);
	}
}
