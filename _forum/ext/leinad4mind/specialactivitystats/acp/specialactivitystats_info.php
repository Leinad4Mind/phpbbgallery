<?php

/**
 *
 * Special Activity Stats. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\specialactivitystats\acp;

class specialactivitystats_info
{
	function module()
	{
		return array(
			'filename'	=> '\leinad4mind\specialactivitystats\acp\specialactivitystats_module',
			'title'		=> 'ACP_SPECIAL_ACTIVITY_STATS_TITLE',
			'modes'		=> array(
				'settings'	=> array(
					'title' => 'ACP_SPECIAL_ACTIVITY_STATS_SETTINGS',
					'auth' => 'ext_leinad4mind/specialactivitystats && acl_a_board',
					'cat' => array('ACP_SPECIAL_ACTIVITY_STATS_TITLE')
				),
			),
		);
	}
}
