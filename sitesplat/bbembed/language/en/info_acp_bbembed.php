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
	'ACP_BBEMBED'					=> 'BBembed',
	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'BBEMBED_NOTICE'	            => '<div class="phpinfo"><p>There are no specific settings for this extension. Post straight links into posts and BBembed will automagically display the videos.</p></div>',
));

