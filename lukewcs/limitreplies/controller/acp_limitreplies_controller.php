<?php
/**
*
* Limit Multiple Replies. An extension for the phpBB Forum Software package.
*
* @copyright (c) 2024, LukeWCS, https://github.com/LukeWCS
* @license GNU General Public License, version 2 (GPL-2.0-only)
*
* Note: This extension is 100% genuine handcraft and consists of selected
*       natural raw materials. There was no AI involved in making it.
*
*/

namespace lukewcs\limitreplies\controller;

class acp_limitreplies_controller
{
	protected object $language;
	protected object $template;
	protected object $config;
	protected object $request;
	protected object $ext_manager;

	protected string $u_action;
	private   array  $metadata;

	public function __construct(
		\phpbb\language\language $language,
		\phpbb\template\template $template,
		\phpbb\config\config $config,
		\phpbb\request\request $request,
		\phpbb\extension\manager $ext_manager
	)
	{
		$this->language		= $language;
		$this->template		= $template;
		$this->config		= $config;
		$this->request		= $request;
		$this->ext_manager	= $ext_manager;

		$this->metadata		= $this->ext_manager->create_extension_metadata_manager('lukewcs/limitreplies')->get_metadata('all');
	}

	public function module_settings(): void
	{
		$notes = [];

		$this->language->add_lang(['acp_limitreplies', 'limitreplies_lang_author'], 'lukewcs/limitreplies');
		$this->set_meta_template_vars('LIMITREPLIES', 'LukeWCS');

		if ($this->request->is_set_post('submit'))
		{
			if (!check_form_key('lukewcs_limitreplies'))
			{
				trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			$this->config->set('limitreplies_switch_enable'		, $this->request->variable('limitreplies_switch_enable'		, 0));
			$this->config->set('limitreplies_number_wait_time'	, $this->request->variable('limitreplies_number_wait_time'	, 60));
			$this->config->set('limitreplies_select_hint_mode'	, $this->request->variable('limitreplies_select_hint_mode'	, 1));

			trigger_error($this->language->lang('LIMITREPLIES_MSG_SETTINGS_SAVED') . adm_back_link($this->u_action));
		}

		$lang_outdated_msg = $this->lang_ver_check_msg('LIMITREPLIES_LANG_VER', 'LIMITREPLIES_MSG_LANGUAGEPACK_OUTDATED');
		if ($lang_outdated_msg)
		{
			$notes[] = $lang_outdated_msg;
		}

		$this->template->assign_vars([
			'LIMITREPLIES_NOTES'					=> $notes,

			'LIMITREPLIES_SWITCH_ENABLE'			=> (bool) $this->config['limitreplies_switch_enable'],
			'LIMITREPLIES_NUMBER_WAIT_TIME'			=> (int) $this->config['limitreplies_number_wait_time'],
			'LIMITREPLIES_SELECT_HINT_MODE_OPTS'	=> $this->select_struct((int) $this->config['limitreplies_select_hint_mode'], [
				'LIMITREPLIES_HINT_MODE_ONCLICK'	=> 1,
				'LIMITREPLIES_HINT_MODE_ALWAYS'		=> 2,
			]),
		]);

		add_form_key('lukewcs_limitreplies');
	}

	public function set_page_url($u_action): void
	{
		$this->u_action = $u_action;
	}

	private function set_meta_template_vars(string $tpl_prefix, string $copyright): void
	{
		$template_vars = [
			'ext_name'		=> $this->metadata['extra']['display-name'],
			'ext_ver'		=> $this->language->lang($tpl_prefix . '_VERSION_STRING', $this->metadata['version']),
			'ext_copyright'	=> $copyright,
			'class'			=> strtolower($tpl_prefix) . '_footer',
		];
		$template_vars += $this->language->is_set($tpl_prefix . '_LANG_VER') ? [
			'lang_desc'		=> $this->language->lang($tpl_prefix . '_LANG_DESC'),
			'lang_ver'		=> $this->language->lang($tpl_prefix . '_VERSION_STRING', $this->language->lang($tpl_prefix . '_LANG_VER')),
			'lang_author'	=> $this->language->lang($tpl_prefix . '_LANG_AUTHOR'),
		] : [];

		$this->template->assign_vars([$tpl_prefix . '_METADATA' => $template_vars]);
	}

	/*
		Determine the version of the language pack with fallback to 0.0.0
	*/
	private function get_lang_ver(string $lang_ext_ver): string
	{
		preg_match('/^([0-9]+\.[0-9]+\.[0-9]+.*)/', $this->language->lang($lang_ext_ver), $matches);
		return ($matches[1] ?? '0.0.0');
	}

	/*
		Check the language pack version for the minimum version and generate notice if outdated
	*/
	private function lang_ver_check_msg(string $lang_version_var, string $lang_outdated_var): string
	{
		$lang_outdated_msg = '';
		$ext_lang_ver = $this->get_lang_ver($lang_version_var);
		$ext_lang_min_ver = $this->metadata['extra']['lang-min-ver'];

		if (phpbb_version_compare($ext_lang_ver, $ext_lang_min_ver, '<'))
		{
			if ($this->language->is_set($lang_outdated_var))
			{
				$lang_outdated_msg = $this->language->lang($lang_outdated_var);
			}
			else /* Fallback if the current language package does not yet have the required variable. */
			{
				$lang_outdated_msg = 'Note: The language pack for the extension <strong>%1$s</strong> is no longer up-to-date. (installed: %2$s / needed: %3$s)';
			}
			$lang_outdated_msg = sprintf($lang_outdated_msg, $this->metadata['extra']['display-name'], $ext_lang_ver, $ext_lang_min_ver);
		}

		return $lang_outdated_msg;
	}

	private function select_struct($cfg_value, array $options): array
	{
		$options_tpl = [];

		foreach ($options as $opt_key => $opt_value)
		{
			if (!is_array($opt_value))
			{
				$opt_value = [$opt_value];
			}
			$options_tpl[] = [
				'label'		=> $opt_key,
				'value'		=> $opt_value[0],
				'bold'		=> $opt_value[1] ?? false,
				'selected'	=> is_array($cfg_value) ? in_array($opt_value[0], $cfg_value) : $opt_value[0] == $cfg_value,
			];
		}

		return $options_tpl;
	}
}
