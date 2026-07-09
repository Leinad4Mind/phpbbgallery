<?php
/**
 *
 * @package       Popup PM
 * @copyright (c) Татьяна5
 * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
	'POPUPPM_YOU_NEW_PM_BLINK'		=> [
		1 => '<<<! You have a new private message !>>>',
		2 => '<<<! You have the %s new private messages !>>>',
	],
	'POPUPPM_YOU_NEW_PM'			=> [
		1 => 'You have a new private message',
		2 => 'You have the %s new private messages',
	],
]);
