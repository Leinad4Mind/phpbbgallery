<?php
/**
*
* BBOAuth
*
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bboauth\auth\provider\oauth\service;

/**
* Battle.Net OAuth service
*/
class slack extends \phpbb\auth\provider\oauth\service\base
{
	/**
	* phpBB config
	*
	* @var \phpbb\config\config
	*/
	protected $config;

	/**
	* phpBB request
	*
	* @var \phpbb\request\request_interface
	*/
	protected $request;

	/**
	* phpBB user
	*
	* @var \phpbb\user
	*/
	protected $user;

	/**
	* Constructor
	*
	* @param	\phpbb\config\config				$config
	* @param	\phpbb\request\request_interface	$request
	* @param    \phpbb\user                         $user
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\request\request_interface $request, \phpbb\user $user)
	{
		$this->config = $config;
		$this->request = $request;
		$this->user = $user;

		$this->user->add_lang_ext('sitesplat/bboauth', 'common');
	}

	/**
	* {@inheritdoc}
	*/
	public function get_auth_scope()
	{
		return array(
			'identity.basic',
		);
	}

	/**
	* {@inheritdoc}
	*/
	public function get_service_credentials()
	{
		return array(
			'key'			=> $this->config['auth_oauth_slack_key'],
			'secret'		=> $this->config['auth_oauth_slack_secret'],
		);
	}

	/**
	* {@inheritdoc}
	*/
	public function perform_auth_login()
	{
		$this->verify_service_provider();

		$this->service_provider->requestAccessToken($this->request->variable('code', ''));

		return $this->fetch_unique_id();
	}

	/**
	* {@inheritdoc}
	*/
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
		if (!($this->service_provider instanceof \OAuth\OAuth2\Service\Slack))
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
		$extra_params = $this->service_provider->getStorage()->retrieveAccessToken($this->service_provider->service())->getExtraParams();
		return $extra_params['user']['id'];
	}
}
