<?php

/**
 * Debrider extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace leinad4mind\debrider\acp;

class main_module
{
  public $u_action;
  public $tpl_name;
  public $page_title;

  public function main()
  {
    global $phpbb_container;
    $config = $phpbb_container->get('config');
    $request = $phpbb_container->get('request');
    $template = $phpbb_container->get('template');
    $language = $phpbb_container->get('language');

    $this->tpl_name = 'main_module';
    $this->page_title = $language->lang('ACP_MAIN_MODULE_TITLE');

    add_form_key('debrider_settings');

    if ($request->is_set_post('submit')) {
      if (!check_form_key('debrider_settings')) {
        trigger_error('FORM_INVALID');
      }

      $api_key = $request->variable('api_key', '');
      $acp_enable = $request->variable('acp_enable', false);
      $acp_provider = $request->variable('acp_provider', '');
      $use_proxy = $request->variable('use_proxy', false);
      $proxy_host = $request->variable('proxy_host', '');
      $proxy_credentials = $request->variable('proxy_credentials', '');
      $proxy_type = $request->variable('proxy_type', '');
      if ($api_key) {
        $config->set('debrider_api_key', $api_key);
      }
      if (!is_null($acp_enable)) {
        $config->set('debrider_enabled', $acp_enable);
      }
      if ($acp_provider) {
        $config->set('debrider_provider', $acp_provider);
      }
      if (!is_null($use_proxy)) {
        $config->set('debrider_use_proxy', $use_proxy);
      }
      if ($proxy_host) {
        $config->set('debrider_proxy_host', $proxy_host);
      }
      if ($proxy_credentials) {
        $config->set('debrider_proxy_credentials', $proxy_credentials);
      }
      if ($proxy_type) {
        $config->set('debrider_proxy_type', $proxy_type);
      }

      trigger_error($language->lang('ACP_DEBRIDER_SETTING_SAVED') . adm_back_link($this->u_action));
    }

    $template->assign_vars([
      'ACP_ENABLE' => $config['debrider_enabled'],
      'ACP_API_KEY' => $config['debrider_api_key'],
      'ACP_PROVIDER' => $config['debrider_provider'],
      'ACP_USE_PROXY' => $config['debrider_use_proxy'],
      'ACP_PROXY_HOST' => $config['debrider_proxy_host'],
      'ACP_PROXY_CREDENTIALS' => $config['debrider_proxy_credentials'],
      'ACP_PROXY_TYPE' => $config['debrider_proxy_type'],
      'U_ACTION' => $this->u_action,
    ]);
  }
}
