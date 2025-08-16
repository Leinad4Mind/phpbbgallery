<?php
/**
*
* Cloudflare IP
*
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
	'ACP_CLOUDFLARE'				=> 'Cloudflare IP',
	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'CLOUDFLARE_NOTICE'	            => '<div class="phpinfo"><p>There are no specific settings for this extension. The IP addresses are now all normilized and will be the real users IP. Enjoy!<br />You might get kicked out from the ACP after you click away from this page. It is totally normal as your current IP is mormilized. Login again.</p></div>',
));

