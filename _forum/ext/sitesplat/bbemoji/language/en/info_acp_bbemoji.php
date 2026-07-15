<?php
/**
*
* @package BBemoji
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
	'ACP_BBEMOJI'					=> 'BBemoji',
	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'BBEMOJI_NOTICE'	            => '<div class="phpinfo"><p>There are no specific settings for this extension. Type a semicolon in posting page or quick reply form, like this ":" to get the auotsuggest to show up.<br />The emoji can be disabled at the user level via <strong>UCP &#187; Board preferences &#187; Edit display options &#187; "Display smilies as images"</strong></p></div>',
));

