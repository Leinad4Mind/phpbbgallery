<?php
/*
* @package cBB Blockgets
* @version v2.0.3 26/07/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\blocks;

class empty_block extends base
{
	public function init()
	{
		$this->tpl_name = 'empty_block';

		if(!$this->data['block_content'])
		{
			return false;
		}

		$this->template->assign_var('BLOCK_CONTENT', $this->generate_text_display($this->data['block_content']));

		return true;
	}

	public function configure($mode, $block_row, &$new, &$submit)
	{
		switch($mode)
		{
			case 'validate':
				$bbcode = $this->bbcode('get');
				decode_message($new['block_content'], $bbcode['uid']);
			break;

			case 'submit':
				$this->lang->add_lang('posting');

				$new['block_content'] = \canidev\core\tools::html_truncate($new['block_content'], 8000, '', true);

				generate_text_for_storage($new['block_content'], $uid, $bitfield, $flags, true, false, true, true, false, true, true, 'blockgets');

				$this->bbcode('set', $uid, $bitfield);
			break;
		}
	}

	public function get_config()
	{
		$this->custom_config = true;

		$this->display_vars = array(
			'block_content'		=> array('lang' => 'BLOCK_CONTENT',	'type' => 'custom',	'method' => 'helper', 'params' => array('build_editor', '{CONFIG_VALUE}', '{KEY}', 20, 50)),
		);

		return true;
	}
}
