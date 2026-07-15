<?php
/**
 * @package cBB Blockgets
 * @version 2.0.6 20/09/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets;

use GuzzleHttp\Client;

class ext extends \phpbb\extension\base
{
	const REQUIRED_PHPBB	= '3.2.0';
	const REQUIRED_CORE		= '1.1.2';
	
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
		/** @var \phpbb\config\db */
		$config = $this->container->get('config');
		
		$writable = (int)$config['enable_mod_rewrite'];

		try
		{
			$client = new \GuzzleHttp\Client();
		
			$response = $client->get(generate_board_url() . '/blockgets.test', [
				'exceptions' 	=> false,
				'timeout' 		=> 10,
			]);

			// if return phpBB page, rewrite is available
			$writable = preg_match('#\<body.*?id="phpbb"#', $response->getBody()->getContents()) ? 1 : $writable;
		}
		catch(\Exception $e) {}

		$config->set('blg_rewrite', $writable);

		// Create upload folder
		\canidev\core\tools::mkdir($this->container->getParameter('core.root_path') . 'files/blockgets/', true);

		// Run parent enable step method
		return parent::enable_step($old_state);
	}
}
