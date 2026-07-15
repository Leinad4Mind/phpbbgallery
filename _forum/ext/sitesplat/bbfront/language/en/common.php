<?php
/**
*
* @package BBfront
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
	'BBFRONT_PAGE'				=> 'Front Page',
	'ACP_BBFRONT_SETTING_SAVED'	=> 'Settings have been saved successfully!',
	'BBFRONT_SHOW'				=> 'Publish on the front page',
	'BBFRONT_MORE'				=> 'Keep Reading',
	'BBFRONT_HIDE'				=> 'Remove from the front page',
	'NO_POSTS_SELECTED'			=> 'There Are No Published Topics Yet Or Forum Selected',
	'NO_POSTS_EOC'			    => 'End Of Content',
	'NO_POSTS_NMPTL'			=> 'No More Cards To Load',
	'BBFRONT_LOAD_MORE'			=> 'LOAD MORE CARDS',
	'REPLIES_ARY'			=> array(
		1	=> '%1$d reply',
		2	=> '%1$d replies',
	),
));
