<?php

/**
 * Change Post Time [English]
 * @copyright (c) 2015 javiexin ( www.exincastillos.es )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Javier Lopez (javiexin)
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
// ’ » “ ” …
//

$lang = array_merge($lang, [
	'JX_CHANGE_POST_TIME'        => 'Alterar tempo da mensagem',
	'JX_CHANGE_POST_TIME_DATE'   => 'AAAA-MM-DD',
	'JX_CHANGE_POST_TIME_TIME'   => 'HH:MM',
	'LOG_MCP_JX_CHANGE_POSTTIME' => '<strong>Alterou o tempo da mensagem #%4$s no tópico "%1$s"</strong><br />» de %2$s para %3$s',
]);
