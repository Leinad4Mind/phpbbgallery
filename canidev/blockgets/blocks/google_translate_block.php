<?php
/*
* @name google_translate_block.php
* @package cBB Blockgets
* @version v2.0.0 30/05/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\blocks;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class google_translate_block extends base
{
	static $icon = 'blg-icon-google';

	public function init()
	{
		$this->tpl_name = 'google_translate_block';

		if(!$this->data['block_content'])
		{
			return false;
		}

		// Delete the array in the template if exists, prevent errors between blocks
		$this->template->destroy_block_vars('translate');

		$langs = explode(',', $this->data['block_content']);

		foreach($langs as $iso)
		{
			if($iso != $this->user->lang_name)
			{
				$this->template->assign_block_vars('translate', array(
					'S_ISO'		=> $iso,
					'S_LANG'	=> $this->helper->locale_lang($iso, 'name'),
				));
			}
		}

		$this->template->assign_vars(array(
			'S_GOOGLE_LOGO'			=> $this->helper->get_ext_path(true) . 'images/mini-google.png',
			'GOOGLE_TRANSLATE_URL'	=> $this->helper->current_url(),
			'GOOGLE_USER_LANG'		=> $this->user->lang_name,
		));

		return true;
	}

	public function configure($mode, $block_row, &$new, &$submit)
	{
		$flags_path	= $this->helper->get_ext_path() . 'images/flags/';

		if($mode == 'submit')
		{
			$new['block_content'] = implode(',', $this->request->variable('langs', array('' => '')));
			return;
		}

		$langs = explode(',', $block_row['block_content']);
		
		$lang_names = $this->helper->locale_lang('raw', 'name');

		foreach($lang_names as $iso => $langname)
		{
			if($langname)
			{
				$langname = explode(' * ', $langname);

				$this->template->assign_block_vars('translate', array(
					'S_ISO'			=> $iso,
					'S_LANG'		=> $langname[0] . (file_exists($flags_path . $iso . '.png') ? ' <img src="' . $flags_path . $iso . '.png" alt="" />' : ''),
					'S_LANG_EN'		=> (!empty($langname[1]) ? $langname[1] : ''),
					'S_SELECTED'	=> in_array($iso, $langs) ? true : false,
				));
			}
		}

		$this->template->assign_var('S_GOOGLE_LOGO', $this->helper->get_ext_path() . 'images/mini-google.png');

		return true;
	}

	function get_config()
	{
		$this->custom_config	= true;
		$this->tpl_name 		= 'acp_google_translate_block';

		return true;
	}
}
