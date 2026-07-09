<?php
/**
 * @package cBB Blockgets
 * @version 2.0.7 01/07/2024
 *
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\blocks;

class link_us_block extends base
{
	static $icon = 'fa-link';

	/**
	 * {@inheritDoc}
	 */
	public function init()
	{
		$this->tpl_name = 'link_us_block';

		if(($data = $this->unserialize()) === false)
		{
			return false;
		}

		if($data['banner_url'])
		{
			$data['banner_url'] = $this->helper->build_image_filename($data['banner_url'], true);
			$link_text = '<img src="' . $data['banner_url'] . '" style="border:0;" alt="' . $this->config['sitename'] . '" />';
		}
		else
		{
			$link_text = $this->config['sitename'];
		}

		$link_title = $this->config['sitename'] . (($this->config['sitename'] && $this->config['site_desc']) ? ' :: ' : '') . $this->config['site_desc'];
		$link_text = '<a href="' . generate_board_url() . '" onclick="window.open(this.href); return false;" title="' . $link_title . '">' . $link_text . '</a>';

		$this->template->assign_vars([
			'LINK_US_TXT'		=> $this->language->lang('LINK_US_TXT', $this->config['sitename']),
			'U_LINK_US'			=> htmlentities($link_text, ENT_QUOTES, 'UTF-8'),
			'U_LINK_US_BANNER'  => $link_text,
		]);

		unset($data);
		return true;
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_config()
	{
		$media = $this->helper->get_media();

		$this->display_vars = [
			'banner_url'	=> ['lang' => 'US_BANNER',	'validate' => 'string', 'type' => 'custom',	'function' => [$media, 'buildSelector'],	'params' => ['{KEY}', 'image', '{CONFIG_VALUE}', 1],	'default' => ''],
		];

		return true;
	}
}
