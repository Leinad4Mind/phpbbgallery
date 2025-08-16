<?php
/**
 *
 * CF Change Post Time
 *
 * @copyright (c) 2024 chris1278
 * @copyright (c) 2015 javiexin ( www.exincastillos.es )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Javier Lopez (javiexin)
 */

namespace chris1278\cptfork\controller;

class acp_controller
{
	protected $config;
	protected $language;
	protected $request;
	protected $template;
	protected $u_action;

	public function __construct(
		\phpbb\config\config $config,
		\phpbb\language\language $language,
		\phpbb\request\request $request,
		\phpbb\template\template $template
	)
	{
		$this->config			= $config;
		$this->language			= $language;
		$this->request			= $request;
		$this->template			= $template;
	}

	public function general_modul()
	{
		add_form_key('chris1278_cptfork');
		$this->language->add_lang('acp_cptfork', 'chris1278/cptfork');
		$errors = [];

		if ($this->request->is_set_post('submit'))
		{
			if (!check_form_key('chris1278_cptfork'))
			{
				$errors[] = $this->language->lang('FORM_INVALID');
			}

			if (empty($errors))
			{
				$this->config->set('cf_cpt_option', $this->request->variable('cf_cpt_option', ''));

				trigger_error($this->language->lang('CF_CPT_SETTING_SAVED') . adm_back_link($this->u_action));
			}
		}

		$s_errors = !empty($errors);

		$this->template->assign_vars([
			'CF_CPT_S_ERROR'	=> $s_errors,
			'CF_CPT_ERROR_MSG'	=> $s_errors ? implode('<br>', $errors) : '',
			'CF_CPT_OPTION'		=> $this->config['cf_cpt_option'],
			'U_ACTION'			=> $this->u_action,
		]);
	}

	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}
