<?php
/**
*
* Nightstalker
*
* @copyright (c) 2015 sitesplat.com <https://sitesplat.com>
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
	'ACP_NIGHT'					=> 'Nightstalker',
	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'NIGHT_NOTICE'	            => '<div class="phpinfo"><p>There are no specific settings for this extension.<br />Nightstalker (Night Mode) is activated by clicking on the Nightstalker mode from the user navigation.</p></div>',
));

