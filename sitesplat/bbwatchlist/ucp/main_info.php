<?php
/**
 *
 * BBwatchlist. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, SiteSplat
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace sitesplat\bbwatchlist\ucp;

/**
 * BBwatchlist UCP module info.
 */
class main_info
{
	function module()
	{
		return array(
			'filename'	=> '\sitesplat\bbwatchlist\ucp\main_module',
			'title'		=> 'UCP_SITESPLAT_BBWATCHLIST',
			'modes'		=> array(
				'settings'	=> array(
					'title'	=> 'UCP_SITESPLAT_BBWATCHLIST',
					'auth'	=> 'ext_sitesplat/bbwatchlist',
					'cat'	=> array('UCP_SITESPLAT_BBWATCHLIST')
				),
			),
		);
	}
}
