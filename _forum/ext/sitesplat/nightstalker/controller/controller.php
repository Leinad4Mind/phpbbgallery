<?php
/**
*
* Nightstalker
*
* @copyright (c) 2015 sitesplat.com <http://sitesplat.com>
* @license Proprietary
*
*/

namespace sitesplat\nightstalker\controller;

/**
* Main controller
*/
class controller
{
	protected $config;
	protected $request;
	protected $template;
	protected $user;
	protected $helper;
	
	/**
	* Constructor
	*
	* @access public
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user, \phpbb\controller\helper $helper)
	{
		$this->config = $config;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->helper = $helper;
	}

	/**
	* Nightstalker setup
	*
	* @return json
	* @access public
	*/
	public function nightstalker()
	{
		$response = $this->set_nightstalker_cookie();

		// Send a JSON response if an AJAX request was used
		if ($this->request->is_ajax())
		{
			$json_response = new \phpbb\json_response;
			$json_response->send(array(
				'success' => $response,
				'REFRESH_DATA'	=> array(
					'time'	=> 0,
					'url'	=> ''
				)
			));
		}
		exit();
	}

	/**
	* Set a cookie to keep nightstalker view
	*
	* @return bool True
	* @access protected
	*/
	protected function set_nightstalker_cookie()
	{
		$cooky = $this->request->variable($this->config['cookie_name'] . '_nightstalker', 0, false, \phpbb\request\request_interface::COOKIE);

		if (!$cooky)
		{
			$this->user->set_cookie('nightstalker', 1, time() + 31536000);
		} else
		{
			$this->user->set_cookie('nightstalker', 0, time() + 31536000);
		}

		return $cooky;
	}
}
