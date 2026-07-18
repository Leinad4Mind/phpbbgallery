<?php
/**
*
* PM Search extension for the phpBB Forum Software package.
* Brazilian Portuguese translation by eunaumtenhoid (c) 2017 [ver 1.0.0] (https://github.com/phpBBTraducoes)
*
* @license GNU General Public License, version 2 (GPL-2.0)
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

$lang = array_merge($lang, array(
	'PMSEARCH_TITLE'	=> 'Pesquise em MPs',
	'PMSEARCH_KEYWORDS_EXPLAIN'	=>	'Coloque + em frente da palavra que deve ser encontrada e - em frente da palavra que não deve ser encontrada. Coloca uma lista de palavras separadas por | entre parênteses se apenas uma dessas deve ser encontrada. Use * para pesquisas parciais.',
	'SEARCH_ALL_TERMS'	=>	' Procura todos os termos ou usa a consulta como inserida',
	'SEARCH_ANY_TERMS'	=>	'Procura por quaisquer termos',
	'NO_RESULTS_FOUND'	=> 'Nenhum resultado encontrado.',
	'SEARCH_PMS'	=> 'Pesquisar MPs',
	'ACCESS_DENIED'	=> 'Não tem permissões para pesquisar em MPs',

	// Added in version 1.0.1
	'SEARCH_FOR_NICK'	=> 'Pesquisar com nome de utilizador',
	'SEARCH_WITH_USER'	=> 'Mensagens Privadas',
	'SEARCH_WITH_USER_LANG'	=> 'Ver MPs com este utilizador',

	// Added in version 1.0.2
	'SEARCH_USR_PLACEHOLDER'	=> 'Pesquisar palavras-chave ou nome de utilizador…',
));
