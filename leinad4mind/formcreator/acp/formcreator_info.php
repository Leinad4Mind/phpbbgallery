<?php
/**
*
* @package phpBB Extension - Form Creator
* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
* @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace leinad4mind\formcreator\acp;

class formcreator_info
{
	function module()
	{
		return array(
			'filename'	=> '\leinad4mind\formcreator\acp\formcreator_module',
			'title'		=> 'ACP_FORM_CREATOR',
			'modes'		=> array(
				'manage' 	=> array('title' => 'ACP_FORM_CREATOR_CONFIG', 'auth'	=> 'ext_leinad4mind/formcreator && acl_a_form_creator', 'cat' => array('ACP_FORM_CREATOR')
			)),
		);
	}
}
