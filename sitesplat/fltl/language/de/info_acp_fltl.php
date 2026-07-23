<?php
/**
*
* Fancy Lazy Topics Loader
* @copyright (c) 2015 SiteSplat All rights reserved
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
	'ACP_FANCY_TITLE' => 'Fancy Lazy Topics Loader',
	'FLTL_NOTICE'     => '<div class="phpinfo"><p>Die Einstellungen für diese Erweiterung findest du unter<strong>%1$s » %2$s » %3$s</strong>.</p></div>',
	'SS_HELPER_NOTY'  => 'SiteSplat BBcore existiert nicht!<br />Lade dir die aktuelle Version herunter: <a href="http://sitesplat.com" target="_blank">BBcore</a> und kopiere den BBcore Ordner in deinen SiteSplat-Erweiterungsordner.',
]);
