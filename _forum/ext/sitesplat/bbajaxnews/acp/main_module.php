<?php
/**
*
* @package BBajaxnews
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbajaxnews\acp;

/**
 * BBajaxnews ACP module.
 */
class main_module
{
	const FORM_KEY = 'sitesplat/bbajaxnews';

	public $page_title;
	public $tpl_name;
	public $u_action;

	protected $language;
	protected $request;
	protected $config;
	protected $template;
	protected $ajaxnews_manager;
	public function __construct()
	{
		global $phpbb_container;

		$this->language = $phpbb_container->get('language');
		$this->request = $phpbb_container->get('request');
		$this->config = $phpbb_container->get('config');
		$this->template = $phpbb_container->get('template');
		$this->ajaxnews_manager = $phpbb_container->get('sitesplat.bbajaxnews.ajaxnews.manager');

		$this->tpl_name = 'acp_bbajaxnews';
		$this->page_title = $this->language->lang('ACP_BBAJAXNEWS_TITLE');
		add_form_key(self::FORM_KEY);
	}

	public function main($id, $mode)
	{
		if ($this->request->is_set_post('submit'))
		{
			if (!check_form_key(self::FORM_KEY))
			{
				trigger_error('FORM_INVALID', E_USER_WARNING);
			}

			$this->config->set('sitesplat_bbajaxnews_driver', $this->request->variable('sitesplat_bbajaxnews_driver', ''));
			$this->config->set('sitesplat_bbajaxnews_pubnub_pub', $this->request->variable('sitesplat_bbajaxnews_pubnub_pub', ''));
			$this->config->set('sitesplat_bbajaxnews_pubnub_sub', $this->request->variable('sitesplat_bbajaxnews_pubnub_sub', ''));
			$this->config->set('sitesplat_bbajaxnews_pusher_app_key', $this->request->variable('sitesplat_bbajaxnews_pusher_app_key', ''));
			$this->config->set('sitesplat_bbajaxnews_pusher_app_sec', $this->request->variable('sitesplat_bbajaxnews_pusher_app_sec', ''));
			$this->config->set('sitesplat_bbajaxnews_pusher_app_id', $this->request->variable('sitesplat_bbajaxnews_pusher_app_id', ''));
			$this->config->set('sitesplat_bbajaxnews_pusher_app_cluster', $this->request->variable('sitesplat_bbajaxnews_pusher_app_cluster', ''));
			$this->config->set('sitesplat_bbajaxnews_interval', $this->request->variable('sitesplat_bbajaxnews_interval', 30));
			$this->config->set('sitesplat_bbajaxnews_noty_visibility_control', $this->request->variable('sitesplat_bbajaxnews_noty_visibility_control', true));
			$this->config->set('sitesplat_bbajaxnews_noty_timeout', $this->request->variable('sitesplat_bbajaxnews_noty_timeout', 5000));
			$this->config->set('sitesplat_bbajaxnews_noty_progress_bar', $this->request->variable('sitesplat_bbajaxnews_noty_progress_bar', true));
			$this->config->set('sitesplat_bbajaxnews_noty_layout', $this->request->variable('sitesplat_bbajaxnews_noty_layout', 'bottomRight'));
			$this->config->set('sitesplat_bbajaxnews_noty_mo', $this->request->variable('sitesplat_bbajaxnews_noty_mo', false));
			foreach ($this->ajaxnews_manager->get_ajaxnews_types() as $type_name => $type)
			{
				$this->config->set('sitesplat_bbajaxnews_' . $type->get_db_type(), $this->request->variable('sitesplat_bbajaxnews_' . $type->get_db_type(), true));
			}

			trigger_error($this->language->lang('ACP_BBAJAXNEWS_SETTING_SAVED') . adm_back_link($this->u_action));
		}

		foreach ($this->ajaxnews_manager->get_ajaxnews_types() as $type_name => $type)
		{
			$this->template->assign_block_vars($type->is_special() ? 'special' : 'casual', [
				'TYPE'	=> $type->get_db_type(),
				'VALUE'	=> $this->config['sitesplat_bbajaxnews_' . $type->get_db_type()],
			]);
		}

		$this->template->assign_vars(array(
			'U_ACTION'										=> $this->u_action,
			'SITESPLAT_BBAJAXNEWS_DRIVER'					=> $this->config['sitesplat_bbajaxnews_driver'],
			'SITESPLAT_BBAJAXNEWS_PUBNUB_PUB'				=> $this->config['sitesplat_bbajaxnews_pubnub_pub'],
			'SITESPLAT_BBAJAXNEWS_PUBNUB_SUB'				=> $this->config['sitesplat_bbajaxnews_pubnub_sub'],
			'SITESPLAT_BBAJAXNEWS_PUSHER_APP_KEY'			=> $this->config['sitesplat_bbajaxnews_pusher_app_key'],
			'SITESPLAT_BBAJAXNEWS_PUSHER_APP_SEC'			=> $this->config['sitesplat_bbajaxnews_pusher_app_sec'],
			'SITESPLAT_BBAJAXNEWS_PUSHER_APP_ID'			=> $this->config['sitesplat_bbajaxnews_pusher_app_id'],
			'SITESPLAT_BBAJAXNEWS_PUSHER_APP_CLUSTER'		=> $this->config['sitesplat_bbajaxnews_pusher_app_cluster'],
			'SITESPLAT_BBAJAXNEWS_INTERVAL'					=> $this->config['sitesplat_bbajaxnews_interval'],
			'SITESPLAT_BBAJAXNEWS_NOTY_VISIBILITY_CONTROL'	=> $this->config['sitesplat_bbajaxnews_noty_visibility_control'],
			'SITESPLAT_BBAJAXNEWS_NOTY_TIMEOUT'				=> $this->config['sitesplat_bbajaxnews_noty_timeout'],
			'SITESPLAT_BBAJAXNEWS_NOTY_PROGRESS_BAR'		=> $this->config['sitesplat_bbajaxnews_noty_progress_bar'],
			'SITESPLAT_BBAJAXNEWS_NOTY_LAYOUT'				=> $this->config['sitesplat_bbajaxnews_noty_layout'],
			'SITESPLAT_BBAJAXNEWS_NOTY_MO'					=> $this->config['sitesplat_bbajaxnews_noty_mo'],
		));
	}
}
