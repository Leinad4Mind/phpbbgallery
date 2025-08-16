<?php
/**
*
* @package User Login Redirect
* @copyright (c) 2014 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\loginredirect\controller;

use phpbb\config\config;
use phpbb\user;
use phpbb\request\request;
use phpbb\db\driver\driver_interface;
use phpbb\language\language;
use david63\loginredirect\core\functions;

/**
* Event listener
*/
class main_controller implements main_interface
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \david63\loginredirect\core\functions */
	protected $functions;

	/** @var string phpBB tables */
	protected $tables;

		/** @var string phpBB root path */
	protected $root_path;

	/** @var string PHP extension */
	protected $phpEx;

	/**
	* Constructor
	*
	* @param \phpbb\config\config 					$config		Config object
	* @param \phpbb\user 							$user		User object
	* @param \phpbb\request\request 				$request	Request object
	* @param \phpbb\db\driver\driver_interface		$db			Database object
	* @param string 								$root_path	phpBB root path
	* @param string 								$php_ext	pgpBB file extension
	* @param \phpbb\language\language				$language	Language object
	* @param \david63\loginredirect\core\functions	functions	Functions for the extension
	* @param array									$tables		phpBB db tables
	*
	* @access public
	*/
	public function __construct(config $config, user $user, request $request, driver_interface $db, language $language, functions $functions, $tables, $root_path, $php_ext)
	{
		$this->config		= $config;
		$this->user			= $user;
		$this->request		= $request;
		$this->db			= $db;
		$this->language		= $language;
		$this->functions	= $functions;
		$this->tables		= $tables;
		$this->root_path	= $root_path;
		$this->phpEx		= $php_ext;
	}

	/**
	* Controller for loginredirect
	*
	* @param string		$name
	* @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	*/
	public function loginredirect($event)
	{
		// No point going any further if the user is banned, but we have to allow founders to login
		if (defined('IN_CHECK_BAN') && $this->user->data['user_type'] != USER_FOUNDER)
		{
			return;
		}

		$redirect 	= $event['redirect'];
		$refresh 	= false;

		if ($this->config['redirect_enabled']== true)
		{
			$proceed = $latest_announce = $select_announce = $announce = false;

			// Redirect new member on first log in
			if (($this->config['redirect_welcome'] && !empty($this->config['redirect_welcome_topic_id']) && $this->user->data['user_lastvisit'] == 0) || $this->config['redirect_always'])
			{
				$sql = 'SELECT topic_id
					FROM ' . $this->tables['topics'] . '
						WHERE topic_id = ' . (int) $this->config['redirect_welcome_topic_id'];

				$result	= $this->db->sql_query($sql);
				$row	= $this->db->sql_fetchrow($result);

				$this->db->sql_freeresult($result);

				$redirect	= "{$this->root_path}viewtopic.$this->phpEx?t=" . $row['topic_id'];
				$message	= $this->language->lang('REDIRECT_LOGIN_WELCOME_TOPIC');
				$l_redirect	= $this->language->lang('REDIRECT_REFRESH_WELCOME');
				$refresh	= $this->config['redirect_welcome_refresh'];
			}
			else if ($this->config['redirect_announce'] || $this->config['redirect_group'])
			{
				// Redirect to an announcement
				if ($this->config['redirect_announce'])
				{
					$announce_type = ($this->config['redirect_global']) ? 'POST_GLOBAL' : 'POST_ANNOUNCE';

					// Redirect to latest announcement
					$sql = 'SELECT topic_id, topic_time
						FROM ' . $this->tables['topics'] . "
							WHERE topic_type = $announce_type
							ORDER BY topic_time DESC";

					$result	= $this->db->sql_query_limit($sql, 1);
					$row	= $this->db->sql_fetchrow($result);

					$this->db->sql_freeresult($result);

					$announce_redirect	= "{$this->root_path}viewtopic.$this->phpEx?t=" . $row['topic_id'];
					// Check that the member has not visited since this announcement was posted
					$latest_announce	= ($this->user->data['user_lastvisit'] < $row['topic_time']) ? true : false;

					// Redirect to selected announcement
					if (!empty($this->config['redirect_announce_topic_id']))
					{
						$sql = 'SELECT topic_id, topic_time
							FROM ' . $this->tables['topics'] . '
								WHERE topic_id = ' . (int) $this->config['redirect_announce_topic_id'];

						$result	= $this->db->sql_query($sql);
						$row	= $this->db->sql_fetchrow($result);

						$this->db->sql_freeresult($result);

						$select_redirect = "{$this->root_path}viewtopic.$this->phpEx?t=" . $row['topic_id'];
						// Check that the member has not visited since this announcement was posted
						$select_announce = ($this->user->data['user_lastvisit'] < $row['topic_time']) ? true : false;
					}

					// Which do we use?
					// Latest is priority and not visited
					if ($this->config['redirect_announce_priority'] && $latest_announce)
					{
						$redirect = $announce_redirect;
					}
					// Selected is priority and not visited
					else if (!$this->config['redirect_announce_priority'] && $select_announce)
					{
						$redirect = $select_redirect;
					}
					// Selected is priority and visited but latest has not been visited
					else if (!$this->config['redirect_announce_priority'] && $latest_announce)
					{
						$redirect = $announce_redirect;
					}

					if ($latest_announce || $select_announce)
					{
						$message	= $this->language->lang('REDIRECT_LOGIN_ANNOUNCE_TOPIC');
						$l_redirect	= $this->language->lang('REDIRECT_REFRESH_ANNOUNCE');
						$refresh	= $this->config['redirect_announce_refresh'];
					}
				}

				// Redirect to group message if already been to announcement
				if ($this->config['redirect_group'] && (!$latest_announce && !$select_announce))
				{
					if ($this->config['redirect_group_all'])
					{
						// No need to check group if all are being redirected
						$proceed = true;
					}
					else
					{
						// Is user in the selected group?
						$sql = 'SELECT group_id
						FROM ' . $this->tables['user_group'] . '
							WHERE group_id = ' . (int) $this->config['redirect_group_id'] . '
								AND user_id = ' . (int) $this->user->data['user_id'];

						$result	= $this->db->sql_query($sql);
						$row	= $this->db->sql_fetchrow($result);

						$this->db->sql_freeresult($result);

						// Check that the member is in the group
						if ($row && ($this->config['redirect_group_id'] == $row['group_id']))
						{
							$proceed = true;
						}
					}

					if ($proceed && !empty($this->config['redirect_group_topic_id']))
					{
						$sql = 'SELECT topic_id, topic_time
						FROM ' . $this->tables['topics'] . '
							WHERE topic_id = ' . (int) $this->config['redirect_group_topic_id'];

						$result	= $this->db->sql_query($sql);
						$row	= $this->db->sql_fetchrow($result);

						$this->db->sql_freeresult($result);

						// Check that the member has not visited since this topic was posted
						if ($this->user->data['user_lastvisit'] < $row['topic_time'])
						{
							$redirect	= "{$this->root_path}viewtopic.$this->phpEx?t=" . $row['topic_id'];
							$message	= $this->language->lang('REDIRECT_LOGIN_GROUP_TOPIC');
							$l_redirect	= $this->language->lang('REDIRECT_REFRESH_GROUP');
							$refresh	= $this->config['redirect_group_refresh'];
						}
					}
				}
			}
		}

		// append/replace SID (may change during the session for AOL users)
		$redirect = reapply_sid($redirect);

		if ($refresh)
		{
			// This is legacy code but is required if the user is to be informed of the redirection
			$redirect = meta_refresh(2, $redirect);
			trigger_error($message . '<br><br>' . sprintf($l_redirect, '<a href="' . $redirect . '">', '</a>'));
		}
		else
		{
			redirect($redirect);
		}
	}
}
