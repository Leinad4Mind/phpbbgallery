<?php

/**
 * @package Log Connections for phpBB.
 * @copyright (c) 2017 david63
 * @copyright (c) 2022 devspace
 * @copyright (c) 2026 Leinad4Mind
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

/**
 * DEVELOPERS PLEASE NOTE
 *
 * All language files should use UTF-8 as their encoding and the files must not contain a BOM.
 *
 * Placeholders can now contain order information, e.g. instead of
 * 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
 * translators to re-order the output of data while ensuring it remains correct
 *
 * You do not need this where single placeholders are used, e.g. 'Message %d' is fine
 * equally where a string contains only two placeholders which are used to wrap text
 * in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
 *
 * Some characters you may want to copy&paste:
 * â€™ Â» â€œ â€ â€¦
 *
 */

$lang = array_merge($lang, [
	'EXT_ENABLE_ERROR' => 'Esta extensÃ£o requer uma versÃ£o do phpBB igual ou superior a %1$s mas inferior a %2$s.<br>A sua versÃ£o do phpBB Ã© %3$s.',
	'EXT_PHP_ERROR'    => 'Esta extensÃ£o requer o PHP %1$s (ou superior).<br>A sua versÃ£o do PHP Ã© %2$s.',
]);

$lang = array_merge($lang, [
	'EXTENSION_NOT_ENABLEABLE'     => isset($lang['EXTENSION_NOT_ENABLEABLE']) ? $lang['EXTENSION_NOT_ENABLEABLE'] . '<br><br><strong>' . $lang['EXT_ENABLE_ERROR'] . '</strong>' : null,
	'CLI_EXTENSION_ENABLE_FAILURE' => isset($lang['CLI_EXTENSION_ENABLE_FAILURE']) ? $lang['CLI_EXTENSION_ENABLE_FAILURE'] . ' : ' . $lang['EXT_ENABLE_ERROR'] : null,
]);
