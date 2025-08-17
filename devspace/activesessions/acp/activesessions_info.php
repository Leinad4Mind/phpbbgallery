<?php
/**
*
* @package Active Sessions Extension
* @copyright (c) 2015 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\activesessions\acp;

class activesessions_info
{
	function module()
	{
		return array(
			'filename'	=> '\david63\activesessions\acp\activesessions_module',
			'title'		=> 'ACTIVE_SESSIONS',
			'modes'		=> array(
				'main'		=> array('title' => 'ACTIVE_SESSIONS', 'auth' => 'ext_david63/activesessions && acl_a_user', 'cat' => array('ACP_CAT_USERS')),
			),
		);
	}
}
