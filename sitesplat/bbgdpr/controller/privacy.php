<?php
/**
*
* @package BBgdpr
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*/

namespace sitesplat\bbgdpr\controller;

class privacy
{
	protected $config_text;
	protected $helper;
	protected $template;
	protected $user;
	protected $request;
	protected $db;
	protected $users_table;
	protected $root_path;
	protected $php_ext;
	public function __construct(\phpbb\config\db_text $config_text, \phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\user $user, \phpbb\request\request $request, \phpbb\db\driver\driver_interface $db, $users_table, $root_path, $php_ext)
	{
		$this->config_text = $config_text;
		$this->helper = $helper;
		$this->template = $template;
		$this->user = $user;
		$this->request = $request;
		$this->db = $db;
		$this->users_table = $users_table;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	public function handle()
	{
		add_form_key('sitesplat/bbgdpr_privacy');

		if ($this->request->is_set_post('accept') || $this->request->is_set_post('reject'))
		{
			if (!check_form_key('sitesplat/bbgdpr_privacy'))
			{
				throw new http_exception(400, 'FORM_INVALID');
			}

			if ($this->request->is_set_post('accept'))
			{
				$sql = 'UPDATE ' . $this->users_table . '
					SET user_privacy_accept_date = ' . time() . '
					WHERE user_id = ' . $this->user->data['user_id'];
				$this->db->sql_query($sql);

				redirect(append_sid("{$this->root_path}index.$this->php_ext"));
			}

			if ($this->request->is_set_post('reject'))
			{
				// Log out
				redirect(append_sid("{$this->root_path}ucp.$this->php_ext", 'mode=logout', true, $this->user->session_id));
			}
		}

		$this->template->assign_vars(array(
			'U_ACTION'			=> $this->helper->route('sitesplat_bbgdpr_privacy'),
			'PRIVACY_POLICY'	=> htmlspecialchars_decode($this->config_text->get('sitesplat_bbgdpr_privacy_policy')),
		));

		$this->template->assign_block_vars('navlinks', array(
			'FORUM_NAME'	=> $this->user->lang('PRIVACY_POLICY'),
			'U_VIEW_FORUM'	=> $this->helper->route('sitesplat_bbgdpr_privacy'),
		));

		return $this->helper->render('privacy.html', $this->user->lang('PRIVACY_POLICY'));
	}
}
