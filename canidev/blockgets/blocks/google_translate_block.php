<?php
/*
* @package cBB Blockgets
* @version v2.0.2 12/01/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\blocks;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class google_translate_block extends base
{
	static $icon = 'fa-google';

	public function init()
	{
		$this->tpl_name = 'google_translate_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}

		// Delete the array in the template if exists, prevent errors between blocks
		$this->template->destroy_block_vars('translate');

		$flags_path	= $this->helper->get_ext_path(true) . 'images/flags/';

		foreach($data['langs'] as $iso)
		{
			if($iso != $this->user->lang_name)
			{
				$lang = $this->helper->locale_lang($iso);

				$this->template->assign_block_vars('translate', array(
					'S_ISO'			=> $iso,
					'S_NAME'		=> ($data['show_names']) ? $lang['name_eng'] : '',
					'S_TITLE'		=> ($data['show_names']) ? $lang['name'] : $lang['name'] . ' - ' . $lang['name_eng'],
					'S_IMAGE_SRC'	=> $flags_path . $iso . '.svg',
				));
			}
		}

		$this->template->assign_vars(array(
			'GOOGLE_TRANSLATE_URL'	=> $this->helper->current_url(),
			'GOOGLE_USER_LANG'		=> $this->user->lang_name,
			'GOOGLE_BUTTONS_INLINE'	=> ($this->view_is_small() && $data['show_names']) ? false : true,
		));

		return true;
	}

	public function configure($mode, $block_row, &$new, &$submit)
	{
		if($mode == 'submit')
		{
			$new['langs'] = $this->request->variable('langs', array(0 => ''));
			return;
		}

		$langs 		= isset($new['langs']) ? $new['langs'] : array();
		$flags_path	= $this->helper->get_ext_path() . 'images/flags/';
		$lang_ary 	= $this->helper->locale_lang('raw');

		foreach($lang_ary as $iso => $row)
		{
			$this->template->assign_block_vars('translate', array(
				'S_ISO'			=> $iso,
				'S_LANG'		=> '<img src="' . $flags_path . $iso . '.svg" alt="" />' . $row['name'],
				'S_LANG_EN'		=> $row['name_eng'],
				'S_SELECTED'	=> in_array($iso, $langs) ? true : false,
			));
		}

		return true;
	}

	function get_config()
	{
		$this->display_vars = array(
			'show_names'	=> array('lang' => 'GOOGLE_SHOW_NAMES',	'validate' => 'bool',	'type' => 'radio:yes_no',	'default' => 1),
			'langs'			=> false,
		);

		$this->tpl_name = 'acp_google_translate_block';

		return true;
	}
}
