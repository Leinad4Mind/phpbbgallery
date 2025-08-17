<?php
/**
*
* @package Registration Age Check
* @copyright (c) 2016 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\registrationage\acp;

class registrationage_info
{
	function module()
	{
		return array(
			'filename'	=> '\david63\registrationage\acp\registrationage_module',
			'title'		=> 'REGISTRATION_AGE',
			'modes'		=> array(
				'main'		=> array('title' => 'REGISTRATION_AGE_MANAGE', 'auth' => 'ext_david63/registrationage && acl_a_board', 'cat' => array('REGISTRATION_AGE')),
			),
		);
	}
}
