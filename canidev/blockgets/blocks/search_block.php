<?php
/**
* @package cBB Blockgets
 * @version 2.0.7 01/07/2024
 *
 * @copyright (c) 2024 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
*
*/

namespace canidev\blockgets\blocks;

class search_block extends base
{
	static $icon = 'fa-search';

	/**
	 * {@inheritDoc}
	 */
	public function init()
	{
		$this->tpl_name = 'search_block';
		
		$this->template->assign_var('S_BLOCK_HIDDEN_FIELDS', build_hidden_fields([
			'sf'	=> 'all',
			'sr'	=> 'topics',
		]));

		return true;
	}
}
