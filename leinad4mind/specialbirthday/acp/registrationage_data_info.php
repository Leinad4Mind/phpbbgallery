<?php
/**
*
* @package Registration Age Check
* @copyright (c) 2016 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\registrationage\acp;

class registrationage_data_info
{
	function module()
	{
		return array(
			'filename'	=> '\david63\registrationage\acp\registrationage_data_module',
			'title'		=> 'REGISTRATION_AGE',
			'modes'		=> array(
				'main'		=> array('title' => 'REGISTRATION_AGE', 'auth' => 'ext_david63/registrationage && acl_a_user', 'cat' => array('ACP_CAT_USERS')),
			),
		);
	}
}
