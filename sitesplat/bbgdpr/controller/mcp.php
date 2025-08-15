<?php
/**
*
* @package BBgdpr
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*/

namespace sitesplat\bbgdpr\controller;

use \sitesplat\bbgdpr\ext;

class mcp
{
	protected $user;
	protected $db;
	protected $auth;
	protected $request;
	protected $template;
	protected $helper;
	protected $users_table;
	protected $root_path;
	protected $php_ext;
	public function __construct(\phpbb\user $user, \phpbb\db\driver\driver_interface $db, \phpbb\auth\auth $auth, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\controller\helper $helper, $users_table, $root_path, $php_ext)
	{
		$this->user = $user;
		$this->db = $db;
		$this->auth = $auth;
		$this->request = $request;
		$this->template = $template;
		$this->helper = $helper;
		$this->users_table = $users_table;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	public function handle()
	{
		if (!$this->auth->acl_getf_global('m_'))
		{
			redirect(append_sid($this->root_path . 'index.' . $this->php_ext));
		}

		add_form_key('sitesplat/bbgdpr_mcp');

		if ($this->request->variable('accept', 0))
		{
			if (!check_form_key('sitesplat/bbgdpr_mcp'))
			{
				throw new http_exception(400, 'FORM_INVALID');
			}

			$sql = 'UPDATE ' . $this->users_table . '
					SET user_mcp_accept_date = ' . time() . '
					WHERE user_id = ' . $this->user->data['user_id'];
			$this->db->sql_query($sql);

			redirect(reapply_sid($this->root_path . $this->request->variable('redirect', '')));
		}

		$this->template->assign_vars(array(
			'U_ACTION'		=> $this->helper->route('sitesplat_bbgdpr_mcp'),
			'U_REDIRECT'	=> $this->request->variable('redirect', $this->user->data['session_page']),
		));

		return $this->helper->render('mcp.html', $this->user->lang('GDPR_REVIEW'));
	}
}
