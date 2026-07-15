<?php
/**
*
* @package BBsort
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
	'ACP_BBSORT'					=> 'BBsort',
	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'BBSORT_NOTICE'	                => '<div class="phpinfo"><p>There are no specific settings for this extension. Forum and topic paginations are automatically converted with the new scrolling system and the filter for the topic ready to be used as well.</p></div>',
));

