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

class clock_block extends base
{
	static $icon = 'fa-clock-o';

	public function init()
	{
		$this->tpl_name = 'clock_block';

		$this->template->assign_var('S_CLOCK', $this->data['block_content']);
		$this->template->append_asset('css', '@canidev_blockgets/../theme/clocks.css');

		return true;
	}

	public function configure($mode, $block_row, &$new, &$submit)
	{
		$clock = $this->request->variable('clock', $block_row['block_content']);
	
		if($mode == 'submit')
		{
			$new['block_content'] = $clock;
			return;
		}

		$this->template->assign_var('S_CLOCK_SELECT', $clock);
		$this->template->append_asset('css', '@canidev_blockgets/../theme/clocks.css');

		return true;
	}

	public function get_config()
	{
		$this->custom_config	= true;
		$this->tpl_name			= 'acp_clock_block';
		
		return true;
	}
}
