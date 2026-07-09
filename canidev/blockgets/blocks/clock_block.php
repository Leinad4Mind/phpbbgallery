<?php
/**
 * @package cBB Blockgets
 * @version 2.0.7 01/07/2024
 *
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\blocks;

class clock_block extends base
{
	static $icon = 'fa-clock-o';

	/**
	 * {@inheritDoc}
	 */
	public function init()
	{
		$this->tpl_name = 'clock_block';

		$this->template->assign_var('S_CLOCK', $this->data['block_content']);
		$this->template->append_asset('css', '@canidev_blockgets/clocks.css');

		return true;
	}

	/**
	 * {@inheritDoc}
	 */
	public function configure($mode, $block_row, &$new, &$submit)
	{
		$clock = $this->request->variable('clock', $block_row['block_content']);
	
		if($mode == 'submit')
		{
			$new['block_content'] = $clock;
			return;
		}

		$this->template->assign_var('S_CLOCK_SELECT', $clock);
		$this->template->append_asset('css', '@canidev_blockgets/clocks.css');

		return true;
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_config()
	{
		$this->custom_config	= true;
		$this->tpl_name			= 'acp_clock_block';
		
		return true;
	}
}
