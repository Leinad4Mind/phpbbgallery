<?php
/**
*
* @package BBoauth
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
	'ACP_BBOAUTH'					=> 'BBoauth',
	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'BBOAUTH_NOTICE'	            => '<div class="phpinfo"><p>The settings for this extension are under <strong>%1$s &#187; %2$s &#187; %3$s</strong>. <br />Select "Oauth" then add the appropriate keys for each providers in order to enable them.</p></div>',
));

