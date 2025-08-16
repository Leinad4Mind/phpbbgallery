<?php
/**
*
* @package User Login Redirect
* @copyright (c) 2014 david63
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace david63\loginredirect\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var string phpBB root path */
	protected $root_path;

	/** @var string PHP extension */
	protected $phpEx;

	/**
	* Constructor
	*
	* @param \phpbb\config\config $config
	* @param \phpbb\user $user
	* @param \phpbb\request\request $request
	* @param \phpbb\db\driver\driver_interface $db
	* @param string $root_path
	* @param string $php_ext
	*
	* @access public
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\user $user, \phpbb\request\request $request, \phpbb\db\driver\driver_interface $db, $root_path, $php_ext)
	{
		$this->config		= $config;
		$this->user			= $user;
		$this->request		= $request;
		$this->db			= $db;
		$this->root_path	= $root_path;
		$this->phpEx		= $php_ext;
	}

	/**
	* Assign functions defined in this class to event listeners in the core
	*
	* @return array
	* @static
	* @access public
	*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'			=> 'load_language_on_setup',
			'core.login_box_redirect'	=> 'login_redirect',
		);
	}

	/**
	* Load common login redirect language files during user setup
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function load_language_on_setup($event)
	{
		$lang_set_ext	= $event['lang_set_ext'];
		$lang_set_ext[]	= array(
			'ext_name' => 'david63/loginredirect',
			'lang_set' => 'loginredirect_common',
		);

		$event['lang_set_ext'] = $lang_set_ext;
	}

	/**
	* Redirect the user after successful login
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function login_redirect($event)
	{
		// No point going any further if the user is banned, but we have to allow founders to login
		if (defined('IN_CHECK_BAN') && $this->user->data['user_type'] != USER_FOUNDER)
		{
			return;
		}

		$redirect = $event['redirect'];
		$refresh  = $proceed = $announce = false;

		if ($this->config['redirect_enabled'])
		{
			// Redirect new member on first log in
			if ($this->config['redirect_welcome'] && !empty($this->config['redirect_welcome_topic_id']) && $this->user->data['user_lastvisit'] == 0)
			{
				$sql = 'SELECT topic_id
					FROM ' . TOPICS_TABLE . '
						WHERE topic_id = ' . $this->config['redirect_welcome_topic_id'];

				$result	= $this->db->sql_query($sql);
				$row	= $this->db->sql_fetchrow($result);

				$this->db->sql_freeresult($result);

				// Check that the topic exists
				if ($row && $this->config['redirect_welcome_topic_id'] == $row['topic_id'])
				{
					$redirect	= "{$this->root_path}viewtopic.$this->phpEx?t=" . $row['topic_id'];
					$message	= $this->user->lang['REDIRECT_LOGIN_WELCOME_TOPIC'];
					$l_redirect	= $this->user->lang['REDIRECT_REFRESH_WELCOME'];
					$refresh	= $this->config['redirect_welcome_refresh'];
				}
			}
			else if ($this->config['redirect_announce'] || $this->config['redirect_group'])
			{
				// Redirect to announcement
				if ($this->config['redirect_announce'])
				{
					$sql = 'SELECT topic_id, topic_time
						FROM ' . TOPICS_TABLE . '
							WHERE topic_type = ' . POST_ANNOUNCE . '
							ORDER BY topic_time DESC';

					$result	= $this->db->sql_query_limit($sql, 1);
					$row	= $this->db->sql_fetchrow($result);
;
					$this->db->sql_freeresult($result);

					// Check that the member has not visited since this announcement was posted
					if ($this->user->data['user_lastvisit'] < $row['topic_time'])
					{
						$redirect	= "{$this->root_path}viewtopic.$this->phpEx?t=" . $row['topic_id'];
						$message	= $this->user->lang['REDIRECT_LOGIN_ANNOUNCE_TOPIC'];
						$l_redirect	= $this->user->lang['REDIRECT_REFRESH_ANNOUNCE'];
						$refresh	= $this->config['redirect_announce_refresh'];
						// Need to give announcement priority over a group message
						$announce	= true;
					}
				}

				// Redirect to group message if already been to announcement
				if ($this->config['redirect_group'] && !$announce)
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
						FROM ' . USER_GROUP_TABLE . '
							WHERE group_id = ' . (int)$this->config['redirect_group_id'] . '
								AND user_id = ' . (int)$this->user->data['user_id'];

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
						FROM ' . TOPICS_TABLE . '
							WHERE topic_id = ' . $this->config['redirect_group_topic_id'];

						$result	= $this->db->sql_query($sql);
						$row	= $this->db->sql_fetchrow($result);

						$this->db->sql_freeresult($result);

						// Check that the topic exists and that the member has not visited since this topic was posted
						if ($this->config['redirect_group_topic_id'] == $row['topic_id'] && $this->user->data['user_lastvisit'] < $row['topic_time'])
						{
							$redirect	= "{$this->root_path}viewtopic.$this->phpEx?t=" . $row['topic_id'];
							$message	= $this->user->lang['REDIRECT_LOGIN_GROUP_TOPIC'];
							$l_redirect	= $this->user->lang['REDIRECT_REFRESH_GROUP'];
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
			trigger_error($message . '<br /><br />' . sprintf($l_redirect, '<a href="' . $redirect . '">', '</a>'));
		}
		else
		{
			redirect($redirect);
		}
	}
}
