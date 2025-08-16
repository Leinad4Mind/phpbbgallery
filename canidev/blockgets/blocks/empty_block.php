<?php
/**
 * @package cBB Blockgets
 * @version 2.0.5 15/01/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\blocks;

class empty_block extends base
{
	/**
	 * {@inheritDoc}
	 */
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

	/**
	 * {@inheritDoc}
	 */
	public function configure($mode, $block_row, &$new, &$submit)
	{
		switch($mode)
		{
			case 'validate':
				$bbcode = $this->bbcode('get');
				decode_message($new['block_content'], $bbcode['uid']);
			break;

			case 'submit':
				$this->language->add_lang('posting');

				$new['block_content'] = \canidev\core\tools::html_truncate($new['block_content'], 8000, '', true);

				generate_text_for_storage($new['block_content'], $uid, $bitfield, $flags, true, false, true, true, false, true, true, 'blockgets');

				$this->bbcode('set', $uid, $bitfield);
			break;
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_config()
	{
		$this->custom_config = true;

		$this->display_vars = array(
			'block_content'		=> array('lang' => 'BLOCK_CONTENT',	'type' => 'custom',	'method' => 'helper', 'params' => array('build_editor', '{CONFIG_VALUE}', '{KEY}', 20, 50)),
		);

		return true;
	}
}
