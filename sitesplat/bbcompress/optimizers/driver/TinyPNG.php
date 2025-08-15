<?php
/**
*
* BBcompress
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbcompress\optimizers\driver;

class TinyPNG implements \sitesplat\bbcompress\optimizers\driver\driver_interface
{
	protected $config;
	protected $log;
	protected $user;

	public function __construct(\phpbb\config\config $config, \phpbb\log\log $log, \phpbb\user $user)
	{
		$this->config = $config;
		$this->log = $log;
		$this->user = $user;

		\Tinify\setKey($this->config['tinify_api_key']);		
	}

	public function optimize_image($img_src)
	{
		try
		{
			$source = \Tinify\fromFile($img_src);
			$source->toFile($img_src);
		}
		catch(\Tinify\AccountException $e)
		{
			$this->log->add('user', $this->user->data['user_id'], $this->user->ip, 'LOG_TINIFY_ACCOUNT_PROBLEM', false, array($e->getMessage(), 'reportee_id' => 0));
			return false;
		}
		catch(\Tinify\ClientException $e)
		{
			$this->log->add('user', $this->user->data['user_id'], $this->user->ip, 'LOG_TINIFY_SOURCE_IMAGE_PROBLEM', false, array($e->getMessage(), 'reportee_id' => 0));
			return false;
		}
		catch(\Tinify\ServerException $e)
		{
			// Temporary issue with the Tinify API.
			return false;
		}
		catch(\Tinify\ConnectionException $e)
		{
			// A network connection error occurred.
			return false;
		}
		catch(Exception $e) {
			// Something else went wrong, unrelated to the Tinify API.
			return false;
		}

		return true;
	}
}