<?php
/**
*
* @package BBgdpr
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*/

namespace sitesplat\bbgdpr\acp;

class main_module
{
	public $page_title;
	public $tpl_name;
	public $u_action;

	protected $language;
	protected $request;
	protected $config_text;
	protected $template;
	protected $config;
	protected $db;
	protected $users_table;
	public function __construct()
	{
		global $phpbb_container;

		$this->language = $phpbb_container->get('language');
		$this->request = $phpbb_container->get('request');
		$this->config_text = $phpbb_container->get('config_text');
		$this->template = $phpbb_container->get('template');
		$this->config = $phpbb_container->get('config');
		$this->db = $phpbb_container->get('dbal.conn');
		$this->users_table = $phpbb_container->getParameter('tables.users');
	}

	public function main($id, $mode)
	{
		$this->language->add_lang('common', 'sitesplat/bbgdpr');
		$this->tpl_name = 'acp_gdpr';
		$this->page_title = $this->language->lang('ACP_BBGDPR');
		add_form_key('sitesplat/bbgdpr');

		if ($this->request->is_set_post('submit'))
		{
			if (!check_form_key('sitesplat/bbgdpr'))
			{
				trigger_error('FORM_INVALID', E_USER_WARNING);
			}

			$this->config_text->set('sitesplat_bbgdpr_js', $this->request->variable('sitesplat_bbgdpr_js', '', true));
			$this->config_text->set('sitesplat_bbgdpr_adsense', $this->request->variable('sitesplat_bbgdpr_adsense', '', true));

			$sitesplat_bbgdpr_privacy_policy = $this->request->variable('sitesplat_bbgdpr_privacy_policy', '', true);
			if ($sitesplat_bbgdpr_privacy_policy != $this->config_text->get('sitesplat_bbgdpr_privacy_policy'))
			{
				$sql = 'UPDATE ' . $this->users_table . '
						SET user_privacy_accept_date = 0
						WHERE user_privacy_accept_date <> 0';
				$this->db->sql_query($sql);
			}
			$this->config_text->set('sitesplat_bbgdpr_privacy_policy', $sitesplat_bbgdpr_privacy_policy);
			$this->config->set('sitesplat_bbgdpr_geoip', $this->request->variable('sitesplat_bbgdpr_geoip', false));
			$this->config->set('sitesplat_bbgdpr_delete_keep_username', $this->request->variable('sitesplat_bbgdpr_delete_keep_username', false));

			trigger_error($this->language->lang('ACP_GDPR_SETTINGS_SAVED') . adm_back_link($this->u_action));
		}

		$this->template->assign_vars(array(
			'U_ACTION'							=> $this->u_action,
			'SITESPLAT_BBGDPR_JS'				=> $this->config_text->get('sitesplat_bbgdpr_js'),
			'SITESPLAT_BBGDPR_ADSENSE'			=> $this->config_text->get('sitesplat_bbgdpr_adsense'),
			'SITESPLAT_BBGDPR_PRIVACY_POLICY'	=> $this->config_text->get('sitesplat_bbgdpr_privacy_policy'),
			'SITESPLAT_BBGDPR_GEOIP'			=> $this->config['sitesplat_bbgdpr_geoip'],
			'SITESPLAT_BBGDPR_DELETED'			=> $this->config['sitesplat_bbgdpr_deleted'],
			'SITESPLAT_BBGDPR_DELETE_KEEP_USERNAME' => $this->config['sitesplat_bbgdpr_delete_keep_username'],
		));
	}
}
