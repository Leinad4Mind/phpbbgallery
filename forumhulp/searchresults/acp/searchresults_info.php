<?php
/**
*
* @package Search Results
* @copyright (c) 2014 ForumHulp.com
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace forumhulp\searchresults\acp;

class searchresults_info
{
	function module()
	{
		return array(
			'filename'	=> 'forumhulp\searchresults\acp\searchresults_info',
			'title'		=> 'ACP_SEARCHRESULTS',
			'version'	=> '1.0.0',
			'modes'		=> array(
				'log'	=> array(
					'title'	=> 'ACP_SEARCHRESULTS',
					'auth'	=> 'ext_forumhulp/searchresults && acl_a_viewlogs',
					'cat'	=> array('ACP_FORUM_LOGS')
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
