<?php
/**
 *
 * CF Change Post Time
 *
 * @copyright (c) 2024 chris1278
 * @copyright (c) 2015 javiexin ( www.exincastillos.es )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Javier Lopez (javiexin)
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
	'CF_CHANGE_POST_TIME'				=> 'Ändere Beitragszeit',
	'LOG_MCP_CF_CHANGE_POSTTIME'		=> '<strong>Beitrag Nr. #%4$s im Thema “%1$s”</strong><br>» von %2$s zu %3$s',
	'CF_ERROR_DATE'						=> '<b>Achtung</b><br><br>Du hast versucht ein Datum einzugeben was in der Zukunft liegt. Aus technichen Grünen ist es jedoch nur erlaubt ein Datum einzutragen welches in der Vergangenheit liegt jedoch maximal dem aktuellem Datum entspricht. Bitte versuche es einfach nochmal.',
]);
