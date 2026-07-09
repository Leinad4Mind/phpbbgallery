<?php
/**
*
* @package Two Factor Authentication
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\tfa\helper;

use phpbb\auth\auth;
use phpbb\config\config;
use phpbb\controller\helper;
use phpbb\db\driver\driver_interface;
use phpbb\exception\http_exception;
use phpbb\template\template;
use phpbb\user;

/**
 * {@inheritdoc}
 */
class session_helper implements session_helper_interface
{
	private $db;
	private $config;
	private $user;
	private $modules = array();
	private $user_table;
	private $registration_table;
	private $user_array = array();
	private $template;
	private $controller_helper;

	/**
	 * Constructor
	 *
	 * @access public
	 *
	 */
	public function __construct(driver_interface $db, config $config, user $user, template $template, helper $controller_helper, $user_table, $registration_table)
	{
		$this->db					= $db;
		$this->user					= $user;
		$this->config				= $config;
		$this->template 			= $template;
		$this->controller_helper 	= $controller_helper;
		$this->user_table			= $user_table;
		$this->registration_table	= $registration_table;
	}

	/**
	 * {@inheritdoc}
	 */
	public function isTfaRequired($user_id, $admin = false, $userdata = array(), $try = false)
	{
		switch ($this->config['tfa_setting'])
		{
			case session_helper_interface::MODE_DISABLED:
				return false;
			case session_helper_interface::MODE_NOT_REQUIRED:
				return $this->isTfaRegistered($user_id);
			case session_helper_interface::MODE_REQUIRED_FOR_ACP_LOGIN:
				return $this->do_permission_check($user_id, $userdata, 'a_', $admin, $try);
			case session_helper_interface::MODE_REQUIRED_FOR_ADMIN:
				return $this->do_permission_check($user_id, $userdata, 'a_', true, $try);
			case session_helper_interface::MODE_REQUIRED_FOR_MODERATOR:
				return $this->do_permission_check($user_id, $userdata, array('m_', 'a_'), $admin, true);
			case session_helper_interface::MODE_REQUIRED:
				return true;
			default:
				return false;
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function isTfaRegistered($user_id)
	{
		if (isset($this->user_array[$user_id]))
		{
			return $this->user_array[$user_id];
		}

		$this->user_array[$user_id] = false;

		$sql = 'SELECT COUNT(registration_id) as reg_id FROM ' . $this->registration_table . ' WHERE user_id = ' . (int) $user_id;
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		$this->user_array[$user_id] = $this->user_array[$user_id] || $row && $row['reg_id'] > 0;
		return $this->user_array[$user_id];
	}

	/**
	 * {@inheritdoc}
	 */
	public function login($user_id, $key)
	{
		if (empty($key))
		{
			throw new http_exception(400, $this->user->lang['TFA_NO_KEY_PROVIDED']);
		}

		$sql = 'SELECT * FROM ' . $this->registration_table . ' WHERE user_id = ' . (int) $user_id;
		$result = $this->db->sql_query($sql);
		$registration = $this->db->sql_fetchrow($result);

		require_once './ext/sitesplat/tfa/helper/loader.php';
		\Loader::register('lib','RobThree\\Auth');
	
		$tfa = new \RobThree\Auth\TwoFactorAuth($this->config['server_name']);

		if ($tfa->verifyCode($registration['secret'], $key))
		{
			$sql_ary = array(
				'last_used'		=> time(),
				'ip_address'	=> $this->user->data['session_ip']
			);
			
			$sql = 'UPDATE ' . $this->registration_table . ' 
					SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . ' 
					WHERE registration_id = ' . (int) $registration['registration_id'];
			$this->db->sql_query($sql);
			return true;
		}
		
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function generate_page($user_id, $admin, $auto_login, $viewonline, $redirect)
	{
		$this->user->add_lang_ext('sitesplat/tfa', 'common');

		$this->template->assign_block_vars('tfa_options', array_merge(array(
			'ID'	=> 'otp',
			'NAME'	=> 'TFA_OTP',
			'U_SUBMIT_AUTH'	=> $this->controller_helper->route('sitesplat_tfa_read_controller_submit', array(
				'user_id'		=> (int) $user_id,
				'admin'			=> (int) $admin,
				'auto_login'	=> (int) $auto_login,
				'viewonline'	=> (int) $viewonline,
			)),
		), array('S_TFA_INCLUDE_HTML' => '@sitesplat_tfa/tfa_otp_authenticate.html')));

		add_form_key('tfa_login_page');

		$random = sha1(random_bytes(32));
		if (!empty($this->user->data['tfa_random']))
		{
//			throw new http_exception(400, 'TFA_SOMETHING_WENT_WRONG');
		}

		$sql_ary = array(
			'tfa_random' 	=> $random,
			'tfa_uid'		=> $user_id,
		);

		$sql = 'UPDATE ' . SESSIONS_TABLE . ' SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . "
				WHERE session_id = '" . $this->db->sql_escape($this->user->data['session_id']) . "' AND
				session_user_id = " . (int) $this->user->data['user_id'];
		$this->db->sql_query($sql);

		$this->template->assign_vars(array(
			'REDIRECT'		=> $redirect,
			'RANDOM'		=> $random,
		));

		page_header($this->user->lang['TFA_KEY_REQUIRED']);

		$this->template->set_filenames(array(
			'body' => '@sitesplat_tfa/authenticate_main.html'
		));
		page_footer(false);
	}

	/**
	 * {@inheritdoc}
	 */
	private function user_data($user_id, $userdata = array())
	{
		if (empty($userdata))
		{
			$sql = 'SELECT * FROM ' . $this->user_table . ' WHERE user_id = ' . (int) $user_id;
			$result = $this->db->sql_query($sql);
			$userdata = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);
		}
		return $userdata;
	}

	/**
	 * {@inheritdoc}
	 */
	private function do_permission_check($user_id, $userdata, $permission, $admin, $try)
	{
		if ($this->isTfaRegistered($user_id))
		{
			return true;
		}

		$userdata = $this->user_data($user_id, $userdata);
		$auth = new auth();
		$auth->acl($userdata);

		if (!is_array($permission))
		{
			$permission = array($permission);
		}

		foreach ($permission as $perm)
		{
			if ($auth->acl_get($perm) && ($admin || $try))
			{
				return true;
			}
		}

		return false;
	}
}
