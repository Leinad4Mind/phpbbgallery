<?php
/**
*
* @package PM Moderation
* @copyright (c) 2016 ForumHulp | 2025 Leinad4Mind
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace forumhulp\pmmoderation\acp;

class pmmoderation_info
{
	function module()
	{
		return array(
			'filename'	=> 'forumhulp\pmmoderation\acp\pmmoderation_info',
			'title'		=> 'ACP_PMMODERATION',
			'version'	=> '1.0.0',
			'modes'		=> array(
				'pmmoderation'	=> array(
					'title'	=> 'ACP_PM_MODERATION',
					'auth'	=> 'ext_forumhulp/pmmoderation && acl_a_viewlogs',
					'cat'	=> array('ACP_MESSAGES')
				),
			),
		);
	}

	function install()
	{
	}

	function uninstall()
	{
	}
}
