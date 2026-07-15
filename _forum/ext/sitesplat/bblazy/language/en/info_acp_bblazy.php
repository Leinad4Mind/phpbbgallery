<?php
/**
*
* @package BBlazy
* @copyright (c) 2018 SiteSplat All rights reserved
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
	'ACP_BBLAZY'					=> 'BBlazy',
	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'BBLAZY_NOTICE'	                => '<div class="phpinfo"><p>There are no specific settings for this extension. All the board images will be lazy loaded for performance. Enjoy!</p></div>',
));

