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
	'ACP_POPUPPM'                       => 'Popup PM',
	'ACP_POPUPPM_EXPLAIN'               => 'Popup PM settings',
	'ACP_POPUPPM_TITLE'                 => 'Popup PM',
	//
	'ACP_POPUPPM_ENABLE_POPUP'             => 'Enable Popup new PM',
	'ACP_POPUPPM_ENABLE_BLINK'             => 'Enable title blink',
]);
