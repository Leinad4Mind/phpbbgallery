<?php
/**
*
* BBOAuth
*
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bboauth\auth\provider\oauth\service;

class dropbox extends \phpbb\auth\provider\oauth\service\base
{
	protected $config;
	protected $request;
	protected $user;
	public function __construct(\phpbb\config\config $config, \phpbb\request\request_interface $request, \phpbb\user $user)
	{
		$this->config = $config;
		$this->request = $request;
		$this->user = $user;

		$this->user->add_lang_ext('sitesplat/bboauth', 'oauth_services');
	}

	public function get_service_credentials()
	{
		return array(
			'key'			=> $this->config['auth_oauth_dropbox_key'],
			'secret'		=> $this->config['auth_oauth_dropbox_secret'],
		);
	}

	public function perform_auth_login()
	{
		$this->verify_service_provider();

		$this->service_provider->requestAccessToken($this->request->variable('code', ''));

		return $this->fetch_unique_id();
	}

	public function perform_token_auth()
	{
		$this->verify_service_provider();

		return $this->fetch_unique_id();
	}

	/**
	* Make sure that service provider is of correct class
	*/
	private function verify_service_provider()
	{
		if (!($this->service_provider instanceof \OAuth\OAuth2\Service\Dropbox))
		{
			throw new \phpbb\auth\provider\oauth\service\exception('AUTH_PROVIDER_OAUTH_ERROR_INVALID_SERVICE_TYPE');
		}
	}

	/**
	* Fetch unique ID for currently logged in user
	*
	* @return	string	Unique ID
	*/
	private function fetch_unique_id()
	{
		$result = json_decode($this->service_provider->request('/2/users/get_current_account'), true);

		return $result['uid'];
	}
}
