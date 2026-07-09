<?php
/**
*
* @package sitesplat BBlinks
* @copyright (c) 2017 SiteSplat All rights reserved
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
	'ACP_BBLINKS'					=> 'BBlinks',
	'ACP_BBLINKS_TITLE'				=> 'BBlinks',
	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'BBLINKS_NOTICE'	            => '<div class="phpinfo"><p>The settings for this extension are under the <strong>EXTENSIONS</strong> tab.</p></div>',
));

