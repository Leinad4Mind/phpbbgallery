<?php

/**
 * PM Search extension for the phpBB Forum Software package.
 * @author Stanislav Atanasov | Leinad4Mind
 * @copyright 2014 Stanislav Atanasov | 2026 Leinad4Mind
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
// ’ » “ ” …
//

$lang = array_merge($lang, [
	'PMSEARCH_TITLE'            => 'Pesquisar em MPs',
	'PMSEARCH_KEYWORDS_EXPLAIN' => 'Coloca um + à frente de uma palavra que deve ser encontrada e - à frente de uma palavra que não deve ser encontrada. Coloca uma lista de palavras separadas por | dentro de parênteses se apenas uma das palavras precisar de ser encontrada. Usa * como um curinga para correspondências parciais.',
	'SEARCH_ALL_TERMS'          => ' Pesquisar por todos os termos ou usar consulta como inserida',
	'SEARCH_ANY_TERMS'          => 'Pesquisar por quaisquer termos',
	'NO_RESULTS_FOUND'          => 'Nenhum resultado encontrado.',
	'SEARCH_PMS'                => 'Pesquisar MPs',
	'ACCESS_DENIED'             => 'Não tens permissão para pesquisar em MPs',

	// Added in version 1.0.1
	'SEARCH_FOR_NICK'       => 'Pesquisar com nome de utilizador',
	'SEARCH_WITH_USER'      => 'Pesquisar',
	'SEARCH_WITH_USER_LANG' => 'Mostrar conversas com o utilizador',

	// Added in version 1.0.2
	'SEARCH_USR_PLACEHOLDER' => 'Pesquisar palavras-chave ou nome de utilizador…',
]);
