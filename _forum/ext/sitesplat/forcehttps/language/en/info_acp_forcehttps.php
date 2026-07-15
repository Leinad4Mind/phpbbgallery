<?php
/**
*
* Force https extension for the phpBB Forum Software package.
* @copyright (c) 2017 sitesplat.com <http://sitesplat.com>
* @license Proprietary
*
*/

/**
* @ignore
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
	'FORCEHTTPS_NOTICE'			=> '<div class="phpinfo"><p>Your board is now correctly configured to run in HTTPS mode. <br /><strong>This assumes the SSL certificate and server configuration has been previously setup correctly.</strong></p></div>',
	'SS_HELPER_NOTY'	        => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
));
