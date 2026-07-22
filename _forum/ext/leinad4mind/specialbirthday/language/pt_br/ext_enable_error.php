<?php

/**
 * @package Special Birthday for phpBB.
 * @copyright (c) 2019 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
	'EXT_ENABLE_ERROR' => 'Esta extensão requer phpBB 3.2.0 (ou superior).',
]);
$lang = array_merge($lang, [
	'EXTENSION_NOT_ENABLEABLE'     => isset($lang['EXTENSION_NOT_ENABLEABLE']) ? $lang['EXTENSION_NOT_ENABLEABLE'] . '<br><br><strong>' . $lang['EXT_ENABLE_ERROR'] . '</strong>' : null,
	'CLI_EXTENSION_ENABLE_FAILURE' => isset($lang['CLI_EXTENSION_ENABLE_FAILURE']) ? $lang['CLI_EXTENSION_ENABLE_FAILURE'] . ' : ' . $lang['EXT_ENABLE_ERROR'] : null,
]);
