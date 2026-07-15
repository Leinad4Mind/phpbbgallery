<?php
/**
*
* BBadblock extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbadblock\controller;

/**
* Main controller
*/
class controller
{
	protected $db;
	protected $request;
	protected $user;
	protected $config;
	
	/**
	* Constructor
	*
	* @access public
	*/
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\request\request $request, \phpbb\user $user, \phpbb\config\config $config)
	{
		$this->db = $db;
		$this->request = $request;
		$this->user = $user;
		$this->config = $config;
	}

	/**
	* Display the page
	*
	* @access public
	*/
	public function display()
	{
		$u = $this->request->variable('u', 0);
		$b = $this->request->variable('b', 0);
		//$b = (!$this->config['bbadblock_autoreset'] && $b <= 0) ? 0 : $b;
		
		if ($this->user->data['user_id'] == ANONYMOUS)
		{
			$bbadblock = explode('~', $this->request->variable($this->config['cookie_name'] . '_bbadblock', '', false, \phpbb\request\request_interface::COOKIE));
		} else
		{	$sql = 'SELECT bbadblock FROM ' . USERS_TABLE . ' WHERE user_id = ' . $u;
			$result = $this->db->sql_query($sql);
			$bbadblock =  explode('~', $this->db->sql_fetchfield('bbadblock'));
		}
			
		$bbadblock[0] = (isset($bbadblock[0]) && $bbadblock[0] > 0) ? $bbadblock[0] : time();
		$bbadblock[1] = (isset($bbadblock[1]) && $bbadblock[1] >= 0) ? $bbadblock[1] : 1;
		$bbadblock[1] = ($b) ? ((!$this->config['bbadblock_autoreset'] && $b <= 0) ? 0 : $bbadblock[1] + $b) : $bbadblock[1];
		$bbadblock = implode('~', $bbadblock); 
	
		if ($this->user->data['user_id'] == ANONYMOUS)
		{
			$this->user->set_cookie('bbadblock', $bbadblock, time() + 31536000);
		} else
		{
			$sql = 'UPDATE ' . USERS_TABLE . ' SET bbadblock = "' . $bbadblock . '" WHERE user_id = ' . $u;
			$this->db->sql_query($sql);
		}
		exit();
	}
}
