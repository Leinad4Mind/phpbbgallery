<?php
/**
*
* @package BBembed
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
	'ACP_BBMENTION'					=> 'BBmention',
	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'BBMENTION_NOTICE'	            => '<div class="phpinfo"><p>There are no specific settings for this extension. Use it on posting page or quick reply form by typing a @ to get the autosuggest to show up and tag the users. <br />You can also tag without the autosuggest and also tag users outside the topic discussion.</p></div>',
));

