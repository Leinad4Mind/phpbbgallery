<?php
/**
*
* @package User Login Redirect
* @copyright (c) 2014 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\loginredirect\acp;

class loginredirect_info
{
	function module()
	{
		return array(
			'filename'	=> '\david63\loginredirect\acp\loginredirect_module',
			'title'		=> 'REDIRECT_MANAGE',
			'modes'		=> array(
				'manage'	=> array('title' => 'REDIRECT_MANAGE', 'auth' => 'ext_david63/loginredirect && acl_a_board', 'cat' => array('REDIRECT')),
			),
		);
	}
}
