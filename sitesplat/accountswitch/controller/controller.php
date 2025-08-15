<?php
/**
*
* @package BBSwitch
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\accountswitch\controller;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
* Main controller
*/
class controller
{
	protected $db;
	protected $user;
	protected $config;
	protected $log;
	protected $php_ext;

	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbb\config\config $config, \phpbb\log\log $log, $php_ext)
	{
		$this->db = $db;
		$this->user = $user;
		$this->config = $config;
		$this->log = $log;
		$this->php_ext = $php_ext;
	}

	/**
	* Display the page
	*
	* @param string $route The route name for a page
	* @return Redirect
	* @access public
	*/
	public function usr_switch($route)
	{
		if ($this->config['allow_emailreuse'])
		{
			$route = preg_replace('/\\.[^.\\s]{3,4}$/', '', $route);
	
			$sql = 'SELECT user_id, username, user_email_hash FROM ' . USERS_TABLE . ' WHERE username_clean = "' . utf8_clean_string($route) . '"';
			$result = $this->db->sql_query($sql);
			$row = $this->db->sql_fetchrow($result);
			
			if ($this->user->data['user_email_hash'] == $row['user_email_hash'])
			{
				$sql = 'UPDATE ' . SESSIONS_TABLE . ' 
						SET session_user_id = ' . $row['user_id'] . ' 
						WHERE session_id = "' . $this->user->data['session_id'] . '" AND session_user_id = ' . $this->user->data['user_id'];
				$this->db->sql_query($sql);
				if ($this->db->sql_affectedrows())
				{
					$this->log->add('user', $this->user->data['user_id'], $this->user->ip, 'LOG_ACCOUNTSWITCH', false, array(
						'reportee_id' => $this->user->data['user_id'],
						$row['username']
					));
	
					$ref_url = $this->user->referer;
					if (strpos($ref_url, 'sid=') !== false)
					{
						$ref_url = preg_replace('/(\?)?(&amp;|&)?sid=[a-z0-9]+/', '', $ref_url);
						$ref_url = preg_replace("/$this->php_ext(&amp;|&)+?/", "$this->php_ext?", $ref_url);
					}
		
					$refresh_data = array(
						'time'	=> 0,
						'url'	=> str_replace('&amp;', '&', $ref_url),
					);
					$json_response = new \phpbb\json_response();
					$json_response->send(array(
						'success' 		=> true,
						'REFRESH_DATA'	=> (!empty($refresh_data)) ? $refresh_data : null
					));
				}
			}
		}
	}
}
