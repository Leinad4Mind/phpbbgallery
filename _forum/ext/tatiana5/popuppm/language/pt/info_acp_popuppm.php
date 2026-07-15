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
	'ACP_POPUPPM'                       => 'Popup MP',
	'ACP_POPUPPM_EXPLAIN'               => 'Configurações Popup MP',
	'ACP_POPUPPM_TITLE'                 => 'Popup MP',

	'ACP_POPUPPM_ENABLE_POPUP'             => 'Activar Popup em Novas MPs',
	'ACP_POPUPPM_ENABLE_BLINK'             => 'Activar Título a Piscar',
]);
