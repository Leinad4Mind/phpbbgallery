<?php
/*
* @name ext.php
* @package cBB Blockgets
* @version v2.0.0 30/05/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class ext extends \phpbb\extension\base
{
	function enable_step($old_state)
	{
		if(empty($old_state))
		{
			// Get real Rewrite status
			$test_url = generate_board_url() . '/blockgets.test';
			
			if(function_exists('curl_init'))
			{
				$ch = curl_init($test_url);

				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);

				$file= curl_exec($ch);

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
			$upload_dir		= $this->container->getParameter('core.root_path') . 'files/blockgets/';
			$htaccess_str	= "<Files *>\nOrder Allow,Deny\nAllow from All\n</Files>";
			
			if(!file_exists($upload_dir))
			{
				@mkdir($upload_dir);
				@file_put_contents($upload_dir . '.htaccess', $htaccess_str);
			}
		}

		// Run parent enable step method
		return parent::enable_step($old_state);
	}
}
