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

class Kraken implements \sitesplat\bbcompress\optimizers\driver\driver_interface
{
	protected $config;
	protected $log;
	protected $user;
	protected $kraken;

	public function __construct(\phpbb\config\config $config, \phpbb\log\log $log, \phpbb\user $user)
	{
		$this->config = $config;
		$this->log = $log;
		$this->user = $user;

		$this->kraken = new \Kraken($this->config['kraken_api_key'], $this->config['kraken_api_secret']);
	}

	public function optimize_image($img_src)
	{
		$params = array(
			"file" => $img_src,
			"wait" => true,
			"lossy" => true,
		);
		$data = $this->kraken->upload($params);

		if ($data['success'])
		{
			file_put_contents($img_src, file_get_contents($data['kraked_url']));
		}
		else
		{
			$this->log->add('user', $this->user->data['user_id'], $this->user->ip, 'LOG_KRAKEN_PROBLEM', false, array($data['error'], 'reportee_id' => 0));
			return false;
		}

		return true;
	}
}