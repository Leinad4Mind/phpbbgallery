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
		1 => '<<<! Вам пришло новое личное сообщение !>>>',
		2 => '<<<! Вам пришло %s новых личных сообщений !>>>',
	],
	'POPUPPM_YOU_NEW_PM'			=> [
		1 => 'Вам пришло новое личное сообщение',
		2 => 'Вам пришло %s новых личных сообщений',
	],
]);
