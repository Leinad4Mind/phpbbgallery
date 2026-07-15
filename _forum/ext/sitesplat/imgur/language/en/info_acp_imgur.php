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
	
	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'IMGUR_NOTICE'				=> '<div style="width:80%;margin:20px auto;"><p>The settings for this extension are in <strong>%1$s &#187; %2$s &#187; %3$s.</strong><br />Please note, You will need to register an Imgur app to get the Client ID needed for this extension to work. <br />For creating a new App, go to <a href="https://api.imgur.com/oauth2/addclient" target="_blank">https://api.imgur.com/oauth2/addclient</a> and register it following the instruction provided. <br />Then use the client ID under <strong>ACP &#187; Postings &#187; Attachment settings: Imgur Client ID</strong><br />Avatar option under: General &#187; Board Configuration &#187; Avatar settings.<br />Signature option under: General &#187; Board Configuration &#187; Signature settings.</p></div>',
	
));

