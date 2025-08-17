<?php
/**
*
* @package Friends & Foes Extension
* @copyright (c) 2014 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\friendsandfoes\acp;

class friendsandfoes_info
{
	function module()
	{
		return array(
			'filename'	=> '\david63\friendsandfoes\acp\friendsandfoes_module',
			'title'		=> 'FRIENDS_AND_FOES',
			'modes'		=> array(
				'main'		=> array('title' => 'FRIENDS_AND_FOES', 'auth' => 'ext_david63/friendsandfoes && acl_a_user', 'cat' => array('ACP_CAT_USERS')),
			),
		);
	}
}
