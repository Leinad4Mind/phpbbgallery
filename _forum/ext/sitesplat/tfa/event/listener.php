<?php
/**
*
* @package Two Factor Authentication
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\tfa\event;

use sitesplat\tfa\helper\session_helper_interface;
use phpbb\config\config;
use phpbb\db\driver\driver_interface;
use phpbb\request\request_interface;
use phpbb\user;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
	private $session_helper;
	private $user;
	private $request;
	private $db;
	private $config;
	private $php_ext;
	private $root_path;

	/**
	* Constructor
	*
	* @access public
	*/
	public function __construct(session_helper_interface $session_helper, user $user, request_interface $request, driver_interface $db, config $config, $registration_table, $php_ext, $root_path)
	{
		$this->session_helper		= $session_helper;
		$this->user					= $user;
		$this->request				= $request;
		$this->config				= $config;
		$this->db					= $db;
		$this->registration_table	= $registration_table;
		$this->php_ext				= $php_ext;
		$this->root_path			= $root_path;
	}

	/**
	 * Assign functions defined in this class to event listeners in the core
	 */
	public static function getSubscribedEvents()
	{
		return array(
			'core.auth_login_session_create_before'		=> 'auth_login_session_create_before',
			'core.user_setup_after'						=> 'user_setup_after',
			'core.ucp_activate_after'					=> 'user_reset',
			'core.delete_user_after'					=> 'delete_users',
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function user_setup_after($event)
	{
		if ($this->config['tfa_setting'] == session_helper_interface::MODE_DISABLED || defined('IN_LOGIN'))
		{
			return;
		}
		
		if ($this->user->data['is_bot'] == false && 
			$this->user->data['user_id'] != ANONYMOUS && 
			$this->session_helper->isTfaRequired($this->user->data['user_id'], false, $this->user->data) && 
			!$this->session_helper->isTfaRegistered($this->user->data['user_id']))
		{
			$sql = 'SELECT module_id FROM ' . MODULES_TABLE . " WHERE module_langname = 'UCP_TFA'";
			$result = $this->db->sql_query($sql, 3600);
			$allowed_i = array();

			while ($row = $this->db->sql_fetchrow($result))
			{
				$allowed_i[] = $row['module_id'];
			}
			$this->db->sql_freeresult($result);
			$ucp_mode = '-sitesplat-tfa-ucp-tfa_module';
			$allowed_i[] = $ucp_mode;
			if ($this->user->page['page_name'] === 'ucp.' . $this->php_ext && in_array($this->request->variable('i', ''), $allowed_i))
			{
				return;
			}
		
			$this->user->add_lang_ext('sitesplat/tfa', 'common');
			$url = append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=' . $ucp_mode);
			redirect(append_sid($url, false, true, $this->user->data['session_id']));
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function auth_login_session_create_before($event)
	{
		if ($this->config['tfa_setting'] == session_helper_interface::MODE_DISABLED)
		{
			return $event;
		}
		
		if (!$this->config['board_disable'] && isset($event['login'], $event['login']['status']) && $event['login']['status'] == LOGIN_SUCCESS)
		{
			if ($this->session_helper->isTfaRequired($event['login']['user_row']['user_id'], $event['admin'], $event['user_row']))
			{
				if (!$this->session_helper->isTfaRegistered($event['login']['user_row']['user_id']))
				{
					return $event;
				} else
				{
					$this->session_helper->generate_page($event['login']['user_row']['user_id'], 
														$event['admin'], $event['view_online'], 
														!$this->request->is_set_post('viewonline'), 
														$this->request->variable('redirect', 
														''));
				}
			}
		}
		
		return null;
	}

	/**
	 * {@inheritdoc}
	 */
	public function user_reset($event)
	{
		$sql = 'DELETE FROM ' . $this->registration_table . ' WHERE user_id = ' . $event['user_row']['user_id'];
		$this->db->sql_query($sql);
	}

	public function delete_users($event)
	{
		if (!empty($event['user_ids'])) {
			$user_id_in = is_array($event['user_ids']) ? 'IN (' . implode(',', $event['user_ids']) . ')' : "= {$event['user_ids']}";

			$this->db->sql_query("DELETE FROM {$this->registration_table } WHERE user_id $user_id_in");
		}
	}
}
