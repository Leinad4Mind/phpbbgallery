<?php
/**
*
* Bookmark Post
*
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
	'UCP_POST_BOOKMARKS_TITLE'	=> 'Manage post bookmarks',

	'POST_BOOKMARKS_EXPLAIN'	=> 'You can bookmark posts for future reference. Select the checkbox for any bookmark you wish to delete, then press the <em>Remove marked bookmarks</em> button.',
	'POST_BOOKMARKS'			=> 'Post bookmarks',
));
