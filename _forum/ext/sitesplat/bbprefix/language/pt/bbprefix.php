<?php

/**
 * @package BBprefix for phpBB.
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
 */

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
	'POSTING_PREFIXES'      => 'Prefixos de tópico',
	'POSTING_PREFIXES_USED' => 'Prefixos de tópico aplicados',
	'POSTING_PREFIXES'      => 'Prefixos',

	'PREFIXED_TOKEN_USERNAME'         => '{USERNAME}',
	'PREFIXED_TOKEN_USERNAME_EXPLAIN' => 'Este símbolo é substituído pelo nome de utilizador do utilizador que aplica o prefixo ao tópico.',
	'PREFIXED_TOKEN_POSTER'           => '{POSTER}',
	'PREFIXED_TOKEN_POSTER_EXPLAIN'   => 'Este símbolo é substituído pelo nome de utilizador do autor do tópico.',
	'PREFIXED_TOKEN_DATE'             => '{DATE}',
	'PREFIXED_TOKEN_DATE_EXPLAIN'     => 'Este símbolo é substituído pela data em que o prefixo foi aplicado ao tópico.',

	'BBPREFIX_MIN_SELECTED_ERROR' => 'Tens de selecionar pelo menos %d prefixo(s).',
	'BBPREFIX_MAX_SELECTED_ERROR' => 'Podes selecionar no máximo %d prefixo(s).',
]);
