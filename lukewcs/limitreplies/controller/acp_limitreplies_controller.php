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
	protected $language;
	protected $template;
	protected $config;
	protected $request;
	protected $ext_manager;

	protected $u_action;

	private $metadata;

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
			$this->check_form_key_error('lukewcs_limitreplies');

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
			'LIMITREPLIES_SELECT_HINT_MODE_OPTS'	=> $this->select_struct($this->config['limitreplies_select_hint_mode'], [
				['LIMITREPLIES_HINT_MODE_ONCLICK'	, 1],
				['LIMITREPLIES_HINT_MODE_ALWAYS'	, 2],
			]),
		]);

		add_form_key('lukewcs_limitreplies');
	}

	public function set_page_url($u_action): void
	{
		$this->u_action = $u_action;
	}

	private function check_form_key_error(string $key): void
	{
		if (!check_form_key($key))
		{
			trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
		}
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

	// Check the language pack version for the minimum version and generate notice if outdated
	private function lang_ver_check_msg(string $lang_version_var, string $lang_outdated_var): string
	{
		$lang_outdated_msg = '';
		preg_match('/^([0-9]+\.[0-9]+\.[0-9]+)/', $this->language->lang($lang_version_var), $matches);
		$ext_lang_ver = $matches[1] ?? '0.0.0';
		$ext_lang_min_ver = $this->metadata['extra']['lang-min-ver'];

		if (phpbb_version_compare($ext_lang_ver, $ext_lang_min_ver, '<'))
		{
			if ($this->language->is_set($lang_outdated_var))
			{
				$lang_outdated_msg = $this->language->lang($lang_outdated_var);
			}
			// Fallback if the current language package does not yet have the required variable.
			else
			{
				$lang_outdated_msg = 'Note: The language pack for the extension <strong>%1$s</strong> is no longer up-to-date. (installed: %2$s / needed: %3$s)';
			}
			$lang_outdated_msg = sprintf($lang_outdated_msg, $this->metadata['extra']['display-name'], $ext_lang_ver, $ext_lang_min_ver);
		}

		return $lang_outdated_msg;
	}

	private function select_struct($value, array $options_params): array
	{
		$is_array_value = is_array($value);
		$options = [];
		foreach ($options_params as $params)
		{
			$options[] = [
				'label'		=> $params[0],
				'value'		=> $params[1],
				'bold'		=> $params[2] ?? false,
				'selected'	=> $is_array_value ? in_array($params[1], $value) : $params[1] == $value,
			];
		}

		return $options;
	}
}
