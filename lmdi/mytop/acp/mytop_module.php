<?php
/**
* @package phpBB Extension - LMDI My Topics
* @copyright (c) 2015-2017 Pierre Duhem - LMDI
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace lmdi\mytop\acp;

class mytop_module {

	public $u_action;

	public function main ($id, $mode)
	{
		global $user, $template, $request, $config;

		$user->add_lang_ext ('lmdi/mytop', 'mytop');
		$this->tpl_name = 'acp_mytop_body';
		$this->page_title = $user->lang('ACP_MYTOP_TITLE');

		$form_key = 'lmdi_mytop';

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key($form_key))
			{
				trigger_error('FORM_INVALID');
			}

			$down = $request->variable ('mytop_up', 0);
			$hidden = $request->variable ('myposts_no', 0);

			if ($down && $hidden)
			{
				$config->set ('lmdi_mytop', 3);
			}
			if (!$down && $hidden)
			{
				$config->set ('lmdi_mytop', 2);
			}
			if ($down && !$hidden)
			{
				$config->set ('lmdi_mytop', 1);
			}
			if (!$down && !$hidden)
			{
				$config->set ('lmdi_mytop', 0);
			}
			trigger_error($user->lang['ACP_MYTOP_UPDATED'] . adm_back_link($this->u_action));
		}

		add_form_key ($form_key);

		$options = $config['lmdi_mytop'];
		switch ($options)
		{
			case 0 :
				$down = 0;
				$hidden = 0;
			break;
			case 1 :
				$down = 1;
				$hidden = 0;
			break;
			case 2 :
				$down = 0;
				$hidden = 1;
			break;
			case 3 :
				$down = 1;
				$hidden = 1;
			break;
		}
		$template->assign_vars(array(
			'R_ACTION'		=> $this->u_action,
			'S_CONFIG_PAGE'	=> true,
			'MYTOP_UP'		=> $down == 0 ? 'checked="checked"' : '',
			'MYTOP_DOWN'		=> $down == 1 ? 'checked="checked"' : '',
			'MYPOSTS_YES'		=> $hidden == 1 ? 'checked="checked"' : '',
			'MYPOSTS_NO'		=> $hidden == 0 ? 'checked="checked"' : '',
			));
	}
}
