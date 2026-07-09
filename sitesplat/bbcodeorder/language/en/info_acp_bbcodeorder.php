<?php
/**
*
* @package BBCodeorder
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
	'ACP_BBCODEORDER'				=> 'BBCodeOrder+',
	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'BBCODEORDER_NOTICE'	        => '<div class="phpinfo"><p>The Setting for this extension are in <strong>%1$s &#187; %2$s &#187; %3$s</strong>.</p></div>',
));

