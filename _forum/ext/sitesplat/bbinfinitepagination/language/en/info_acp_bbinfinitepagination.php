<?php
/**
*
* @package BBinfinitepagination
* @copyright (c) 2019 SiteSplat All rights reserved
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

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'BBPAGINATION_NOTICE' => '<div class="phpinfo"><p>The settings for this extensions are in <strong>%1$s &#187; %2$s &#187; %3$s</strong>.</p></div>',
	'ACP_BBPAGINATION'    => 'BBinfinitepagination',
	'SS_HELPER_NOTY'      => 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
]);
