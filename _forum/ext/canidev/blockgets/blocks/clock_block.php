<?php
/*
* @name clock_block.php
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

class clock_block extends base
{
	static $icon 		= 'blg-icon-clock-o';
	private $clock_dir	= 'swf/clocks/';

	public function init()
	{
		$this->tpl_name = 'clock_block';

		$this->template->assign_var('S_CLOCK_URL', $this->helper->get_ext_path(true) . $this->clock_dir . $this->data['block_content']);

		return true;
	}

	public function configure($mode, $block_row, &$new, &$submit)
	{
		$clock_url	= $this->request->variable('clock_url', $block_row['block_content']);
		$clocks		= array();
	
		if($mode == 'submit')
		{
			$new['block_content'] = $clock_url;
			return;
		}

		if($dir = @opendir($this->helper->get_ext_path() . $this->clock_dir))
		{
			while(($file = @readdir($dir)) !== false)
			{
				if(preg_match('#^([^&\'"<>]+)\.swf$#i', $file, $match))
				{
					$clocks[$file] = ucfirst(str_replace('_', ' ', $match[1]));
				}
			}
			closedir($dir);
			asort($clocks);
		}

		$this->template->assign_vars(array(
			'S_CLOCK_SELECT'		=> $this->manager->helper_acp->make_select($clocks, $clock_url),
			'S_CLOCK_PATH'			=> $this->helper->get_ext_path() . $this->clock_dir,
		));

		return true;
	}

	public function get_config()
	{
		$this->custom_config	= true;
		$this->tpl_name			= 'acp_clock_block';
		
		return true;
	}
}
