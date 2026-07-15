<?php

/**
 *
 * BBReaction
 * @copyright (c) 2015-2022 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\bbreaction\acp;

class bbreaction_info
{
	public function module()
	{
		return [
			'filename'	=> '\sitesplat\bbreaction\acp\bbreaction_module',
			'title'		=> 'ACP_BBREACTION',
			'modes'		=> [
				'settings'	=> [
					'title'	=> 'ACP_BBREACTION',
					'auth'	=> 'ext_sitesplat/bbreaction && acl_a_board',
					'cat'	=> ['ACP_QUICK_ACCESS']
				],
			],
		];
	}
}