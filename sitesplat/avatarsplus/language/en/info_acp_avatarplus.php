<?php
/**
*
* @package BBavatar+
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
	'ACP_BBAVATARPLUS'				=> 'BBavatar+',
	'UCP_UCP'				        => 'User Control Panel',
	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'BBAVATARPLUS_NOTICE'	        => '<div class="phpinfo"><p>The settings for this extension are in <strong>%1$s » %2$s » %3$s</strong> then select the driver <strong>"Material Avatar"</strong> or <strong>"Avatar Generator"</strong>.<br />For best result it is strongly recommended to increase the avatar max size to 400x400 in <strong>ACP > Avatar settings > Maximum avatar dimensions</strong>. </p></div>',
));

