<?php
/**
*
* @package Two Factor Authentication
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\tfa\controller;

use sitesplat\tfa\helper\session_helper_interface;
use phpbb\config\config;
use phpbb\controller\helper;
use phpbb\db\driver\driver_interface;
use phpbb\exception\http_exception;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;

/**
 * Controller
 */
class main_controller
{
	private $controller_helper;
	private $template;
	private $db;
	private $user;
	private $request;
	private $config;
	private $session_helper;
	private $root_path;
	private $php_ext;

	/**
	* Constructor
	*
	* @access public
	*/
	public function __construct(helper $controller_helper, driver_interface $db, template $template, user $user, request_interface $request, config $config, session_helper_interface $session_helper, $root_path, $php_ext)
	{
		$this->controller_helper 	= $controller_helper;
		$this->template 			= $template;
		$this->db					= $db;
		$this->user					= $user;
		$this->request				= $request;
		$this->config				= $config;
		$this->session_helper		= $session_helper;
		$this->root_path			= $root_path;
		$this->php_ext				= $php_ext;

	}

	/**
	 * {@inheritdoc}
	 */
	public function submit($user_id, $admin, $auto_login, $viewonline)
	{
		$this->user->add_lang_ext('sitesplat/tfa', 'common');

		if (!check_form_key('tfa_login_page'))
		{
			throw new http_exception(403, 'FORM_INVALID');
		}

		if (empty($this->user->data['tfa_random']) || $user_id != $this->user->data['tfa_uid'])
		{
			throw new http_exception(400, 'TFA_SOMETHING_WENT_WRONG');
		}
		
		$random = $this->request->variable('random', '');
		if ($this->user->data['tfa_random'] !== $random || strlen($random) !== 40)
		{
			throw new http_exception(400, 'TFA_SOMETHING_WENT_WRONG');
		}
		
		$sql_ary = array(
			'tfa_random' => '',
			'tfa_uid'    => 0,
		);
		$sql = 'UPDATE ' . SESSIONS_TABLE . ' SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . "
				WHERE session_id = '" . $this->db->sql_escape($this->user->data['session_id']) . "' AND
				session_user_id = '" . (int) $this->user->data['user_id'] . "'";
		$this->db->sql_query($sql);

		$redirect = $this->request->variable('redirect', $this->root_path . '/index.' . $this->php_ext);

		try
		{
			if (!$this->session_helper->login($user_id, $this->request->variable('authenticate', '')))
			{
				$this->template->assign_var('S_ERROR', $this->user->lang('TFA_INCORRECT_KEY'));
				$this->session_helper->generate_page($user_id, $admin, $auto_login, $viewonline, $redirect);
			}
		}
		catch (http_exception $ex) // @TODO: Replace exception with own exception
		{
			if ($ex->getStatusCode() == 400)
			{
				$this->template->assign_var('S_ERROR', $ex->getMessage());
				$this->session_helper->generate_page($user_id, $admin, $auto_login, $viewonline, $redirect);
			}
		}

		$old_session_id = $this->user->session_id;

		if ($admin)
		{
			$cookie_expire = time() - 31536000;
			$this->user->set_cookie('u', '', $cookie_expire);
			$this->user->set_cookie('sid', '', $cookie_expire);
		}

		$result = $this->user->session_create($user_id, $admin, $auto_login, $viewonline);
		if ($result === true)
		{
			if ($admin)
			{
				$sql = 'DELETE FROM ' . SESSIONS_TABLE . "
						WHERE session_id = '" . $this->db->sql_escape($old_session_id) . "'
						AND session_user_id = " . (int) $user_id;
				$this->db->sql_query($sql);

				redirect(append_sid($this->root_path . 'adm/index.' . $this->php_ext, false, true, $this->user->data['session_id']));
			}

			redirect(append_sid($redirect, false, true, $this->user->data['session_id']));
		}
		throw new http_exception(400, 'TFA_SOMETHING_WENT_WRONG');
	}
}
