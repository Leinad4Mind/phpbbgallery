<?php

/**
 * @package Auto db Backup for phpBB.
 * @copyright (c) 2020 david63
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// â€™ Â» â€œ â€ â€¦
//

$lang = array_merge($lang, [
	'NEW_VERSION'         => 'Nova VersÃ£o - %s',
	'NEW_VERSION_EXPLAIN' => 'A versÃ£o %s desta extensÃ£o estÃ¡ agora disponÃ­vel para descarregar.',
	'NEW_VERSION_LINK'    => 'Transfere aqui',
	'NO_JS'               => 'Aparentemente tens o javascript desactivado.<br>Por favor <a href="https://enablejavascript.co/">activa</a> no teu navegador para poderes tirar proveito de todas as funcionalidades desta pÃ¡gina.',
	'NO_VERSION_EXPLAIN'  => 'A informaÃ§Ã£o de actualizaÃ§Ã£o da versÃ£o nÃ£o estÃ¡ disponÃ­vel.',

	'PHP_NOT_VALID'   => 'A tua versÃ£o do PHP nÃ£o Ã© compatÃ­vel com esta extensÃ£o.',
	'PHPBB_NOT_VALID' => 'A tua versÃ£o do phpBB nÃ£o Ã© compatÃ­vel com esta extensÃ£o.',

	'SAVE'         => 'Guardar',
	'SAVE_CHANGES' => 'Guardar alteraÃ§Ãµes',

	'VERSION' => 'VersÃ£o',
]);
