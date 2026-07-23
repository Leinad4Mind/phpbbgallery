<?php

/**
 * @package Friends & Foes Extension for phpBB.
 * @copyright (c) 2014 devspace
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
 * ’ » “ ” …
 *
 */

$lang = array_merge($lang, [
	'ALL'                      => 'Todos',
	'FF_CLEAR_FILTER'          => 'Limpar filtros',
	'FILTER_BY'                => 'Filtrar Nome de usuário por',
	'FOE'                      => 'Tornou-se inimigo de',
	'FRIEND'                   => 'Tornou-se amigo de',
	'FRIENDS_AND_FOES_EXPLAIN' => 'Isto dá-lhe uma lista dos amigos e inimigos de cada membro (onde definido).',
	'NO_FF_DATA'               => 'Não existem amigos e inimigos para apresentar',
	'OTHER'                    => 'Outro',
	'SELECT_CHAR'              => 'Selecionar caractere',
	'SORT_FOE'                 => 'Inimigos',
	'SORT_FRIEND'              => 'Amigos',
	'SORT_USERNAME'            => 'Nome de usuário',
	'TOTAL_USERS'              => 'Contagem de Amigos e Inimigos : <strong>%1$s</strong>',
	'YES'                      => 'Sim',
	'START_CHARACTER'          => 'A',
	'END_CHARACTER'            => 'Z',
]);
