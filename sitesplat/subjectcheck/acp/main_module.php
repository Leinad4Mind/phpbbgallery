<?php
/**
 *
 * Subject Check. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2016, SiteSplat
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace sitesplat\subjectcheck\acp;

/**
 * Subject Check ACP module.
 */
class main_module
{
	public $u_action;
	private $options = array(
		'subject_check_enable'	=> true,
		'subject_check_bypass'	=> 1,
		'subject_check_strict'	=> false,
		'subject_check_ajax'	=> true,
		'subject_check_locked'	=> false,
		'subject_check_pop'		=> true,
		'subject_check_admin'	=> false,
		'subject_check_mod'		=> false,
		'subject_check_forums'	=> false,
		'subject_check_fnames'	=> false,
		'subject_check_limit'	=> 0,
		'subject_check_active'	=> 0,
		'subject_check_count'	=> 0,
	);

	public function main($id, $mode)
	{
		global $config, $request, $template, $user;

		$user->add_lang_ext('sitesplat/subjectcheck', 'common');
		$this->tpl_name = 'acp_subject_check_body';
		$this->page_title = $user->lang('ACP_SUBJECT_CHECK_TITLE');
		add_form_key('sitesplat/subject_check');

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('sitesplat/subject_check'))
			{
				trigger_error('FORM_INVALID');
			}

			foreach ($this->options as $option_name => $option_default)
			{
				$config->set($option_name, $request->variable($option_name, $option_default));
			}

			trigger_error($user->lang('ACP_SUBJECT_CHECK_SETTING_SAVED') . adm_back_link($this->u_action));
		}

		foreach ($this->options as $option_name => $option_default)
		{
			$template->assign_block_vars('options', array(
				'NAME'	=> $option_name,
				'VALUE'	=> $config[$option_name],
			));
		}

		$template->assign_vars(array(
			'U_ACTION'				=> $this->u_action,
		));
	}
}
