<?php
/**
*
* Bookmark Post
*
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bookmarkpost\ucp;

class main_info
{
	function module()
	{
		return array(
			'filename'	=> '\sitesplat\bookmarkpost\ucp\main_module',
			'title'		=> 'UCP_POST_BOOKMARKS_TITLE',
			'modes'		=> array(
				'post_bookmarks'	=> array(
					'title'	=> 'UCP_POST_BOOKMARKS_TITLE',
					'auth'	=> 'ext_sitesplat/bookmarkpost',
					'cat'	=> array('UCP_POST_BOOKMARKS_TITLE')
				),
			),
		);
	}
}
