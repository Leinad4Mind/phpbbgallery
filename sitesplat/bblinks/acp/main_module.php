<?php
/**
*
* @package sitesplat BBlinks
* @copyright (c) 2017 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bblinks\acp;

class main_module
{
	public $page_title;
	public $tpl_name;
	public $u_action;

	public function main($id, $mode)
	{
		global $config, $request, $template, $user, $phpbb_container;
		$config_text = $phpbb_container->get('config_text');

		$this->tpl_name = 'acp_bblinks';
		$this->page_title = $user->lang('BBLINKS_TITLE');
		add_form_key('sitesplat/bblinks');

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('sitesplat/bblinks'))
			{
				trigger_error('FORM_INVALID');
			}

			$config->set('bblinks_enable', $request->variable('bblinks_enable', false));
			$config->set('bblinks_enable_modal', $request->variable('bblinks_enable_modal', true));
			$config->set('bblinks_skip_link_types', $request->variable('bblinks_skip_link_types', ''));
			$config->set('bblinks_internal_link_types', $request->variable('bblinks_internal_link_types', ''));
			$config->set('bblinks_external_link_types', $request->variable('bblinks_external_link_types', ''));
			$config_text->set('bblinks_forbidden_domains', $request->variable('bblinks_forbidden_domains', ''));
			$config->set('bblinks_forbidden_new_url', $request->variable('bblinks_forbidden_new_url', ''));
			$config->set('bblinks_internal_link_class', $request->variable('bblinks_internal_link_class', ''));
			$config->set('bblinks_external_link_class', $request->variable('bblinks_external_link_class', ''));
			$config->set('bblinks_internal_link_target', $request->variable('bblinks_internal_link_target', ''));
			$config->set('bblinks_external_link_target', $request->variable('bblinks_external_link_target', ''));
			$config->set('bblinks_internal_link_rel', $request->variable('bblinks_internal_link_rel', ''));
			$config->set('bblinks_external_link_rel', $request->variable('bblinks_external_link_rel', ''));
			$config->set('bblinks_hide_links_from_guests', $request->variable('bblinks_hide_links_from_guests', ''));
			$config_text->set('bblinks_hide_links_from_guests_text', $request->variable('bblinks_hide_links_from_guests_text', ''));
			$config->set('bblinks_external_prefix', $request->variable('bblinks_external_prefix', ''));
			$config->set('bblinks_skip_prefix_types', $request->variable('bblinks_skip_prefix_types', ''));
			$config_text->set('bblinks_internal_link_domains', $request->variable('bblinks_internal_link_domains', ''));

			$config->set('bblinks_urltotext_forum',	$request->variable('bblinks_urltotext_forum', '', true));
			$config->set('bblinks_urltotext_topic',	$request->variable('bblinks_urltotext_topic', '', true));
			$config->set('bblinks_urltotext_post',	$request->variable('bblinks_urltotext_post', '', true));
			$config->set('bblinks_urltotext_user',	$request->variable('bblinks_urltotext_user', '', true));
			$config->set('bblinks_urltotext_page',	$request->variable('bblinks_urltotext_page', '', true));
			$config->set('bblinks_urltotext_cpf',	$request->variable('bblinks_urltotext_cpf', 0));
			
			$config->set('bblinks_cpf_link_new_window',	$request->variable('bblinks_cpf_link_new_window', false));
			$config->set('bblinks_signature',	$request->variable('bblinks_signature', false));

			trigger_error($user->lang('BBLINKS_SETTING_SAVED') . adm_back_link($this->u_action));
		}

		$template->assign_vars(array(
			'U_ACTION'								=> $this->u_action,
			'BBLINKS_ENABLE'						=> $config['bblinks_enable'],
			'BBLINKS_ENABLE_MODAL'					=> $config['bblinks_enable_modal'],
			'BBLINKS_SKIP_LINK_TYPES'				=> $config['bblinks_skip_link_types'],
			'BBLINKS_INTERNAL_LINK_TYPES'			=> $config['bblinks_internal_link_types'],
			'BBLINKS_EXTERNAL_LINK_TYPES'			=> $config['bblinks_external_link_types'],
			'BBLINKS_FORBIDDEN_DOMAINS'				=> $config_text->get('bblinks_forbidden_domains'),
			'BBLINKS_FORBIDDEN_NEW_URL'				=> $config['bblinks_forbidden_new_url'],
			'BBLINKS_INTERNAL_LINK_CLASS'			=> $config['bblinks_internal_link_class'],
			'BBLINKS_EXTERNAL_LINK_CLASS'			=> $config['bblinks_external_link_class'],
			'BBLINKS_INTERNAL_LINK_TARGET'			=> $config['bblinks_internal_link_target'],
			'BBLINKS_EXTERNAL_LINK_TARGET'			=> $config['bblinks_external_link_target'],
			'BBLINKS_INTERNAL_LINK_REL'				=> $config['bblinks_internal_link_rel'],
			'BBLINKS_EXTERNAL_LINK_REL'				=> $config['bblinks_external_link_rel'],
			'BBLINKS_HIDE_LINKS_FROM_GUESTS'		=> $config['bblinks_hide_links_from_guests'],
			'BBLINKS_HIDE_LINKS_FROM_GUESTS_TEXT'	=> $config_text->get('bblinks_hide_links_from_guests_text'),
			'BBLINKS_SKIP_PREFIX_TYPES'				=> $config['bblinks_skip_prefix_types'],
			'BBLINKS_EXTERNAL_PREFIX'				=> $config['bblinks_external_prefix'],
			'BBLINKS_INTERNAL_LINK_DOMAINS'			=> $config_text->get('bblinks_internal_link_domains'),

			'BBLINKS_URLTOTEXT_FORUM'	=> $config['bblinks_urltotext_forum'],
			'BBLINKS_URLTOTEXT_TOPIC'	=> $config['bblinks_urltotext_topic'],
			'BBLINKS_URLTOTEXT_POST'	=> $config['bblinks_urltotext_post'],
			'BBLINKS_URLTOTEXT_USER'	=> $config['bblinks_urltotext_user'],
			'BBLINKS_URLTOTEXT_PAGE'	=> $config['bblinks_urltotext_page'],
			'BBLINKS_URLTOTEXT_CPF'		=> $config['bblinks_urltotext_cpf'],

			'BBLINKS_CPF_LINK_NEW_WINDOW'		=> $config['bblinks_cpf_link_new_window'],
			'BBLINKS_SIGNATURE'		=> $config['bblinks_signature'],
		));
	}
}
