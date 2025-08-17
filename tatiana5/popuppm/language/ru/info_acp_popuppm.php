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
	$lang = array();
}

$lang = array_merge($lang, array(
	'ACP_POPUPPM'                       => 'ЛС в конверте',
	'ACP_POPUPPM_EXPLAIN'               => 'Настройки ЛС в конверте',
	'ACP_POPUPPM_TITLE'                 => 'ЛС в конверте',
	//
	'ACP_POPUPPM_ENABLE_POPUP'             => 'Включить всплывающее уведомление о новых ЛС',
	'ACP_POPUPPM_ENABLE_BLINK'             => 'Включить мигание заголовка страницы при непрочитанных ЛС',
));
