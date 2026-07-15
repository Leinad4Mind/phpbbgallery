<?php
/**
*
* Fancy Lazy Topics Loader
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if ( empty($lang) || !is_array($lang) )
{
	$lang = array();
}

$lang = array_merge($lang, array(
    'ACP_FANCY_TITLE'				=> 'Fancy Lazy Topics Loader',
	'FLTL_NOTICE'				    => '<div class="phpinfo"><p>The settings for this extensions are in <strong>%1$s » %2$s » %3$s</strong>.</p></div>',
	'SS_HELPER_NOTY'				=> 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
));

