<?php
/*
* @name search_block.php
* @package cBB Blockgets
* @version v2.0.0 30/05/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

namespace canidev\blockgets\blocks;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

class search_block extends base
{
	static $icon = 'blg-icon-search';

	public function init()
	{
		$this->tpl_name = 'search_block';
		
		$this->template->assign_var('S_BLOCK_HIDDEN_FIELDS', build_hidden_fields(array(
			'sf'		=> 'titleonly',
			'sr'		=> 'topics',
		)));

		return true;
	}
}
