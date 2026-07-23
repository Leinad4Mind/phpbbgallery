<?php
/**
*
* Nightstalker
*
* @copyright (c) 2015 sitesplat.com <https://sitesplat.com>
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
	'NIGHTSTALKER' => 'Nightstalker mode',
	'NORMAL_VIEW'  => 'Normal mode',
]);
