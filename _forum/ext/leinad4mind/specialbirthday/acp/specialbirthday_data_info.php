<?php

/**
*
* @package Special Birthday
* @copyright (c) 2019 Leinad4Mind
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace leinad4mind\specialbirthday\acp;

class specialbirthday_data_info
{
	function module()
	{
		return array(
			'filename'	=> '\leinad4mind\specialbirthday\acp\specialbirthday_data_module',
			'title'		=> 'REGISTRATION_AGE',
			'modes'		=> array(
				'main'		=> array('title' => 'REGISTRATION_AGE', 'auth' => 'ext_leinad4mind/specialbirthday && acl_a_user', 'cat' => array('ACP_CAT_USERS')),
			),
		);
	}
}
