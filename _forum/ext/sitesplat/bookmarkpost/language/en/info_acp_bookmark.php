<?php
/**
*
* Bookmark Post
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ACP_POSTBOOKMARK'				=> 'PostBookmarks',
	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'POSTBOOKMARK_NOTICE'	        => '<div class="phpinfo"><p>There are no specific ACP settings for this extension. Users will now be able to bookmark single posts and also review them under UCP Overview.</p></div>',
));

