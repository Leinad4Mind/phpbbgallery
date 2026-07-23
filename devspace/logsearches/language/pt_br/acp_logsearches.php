<?php

/**
 * @package Log Searches Extension for phpBB.
 * @copyright (c) 2022 devspace
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
	'SEARCH_ALL'                    => 'Todas',
	'SEARCH_FAILED'                 => 'Falhadas',
	'SEARCH_LOG_ALL'                => 'Registar todas as pesquisas',
	'SEARCH_LOG_ALL_EXPLAIN'        => 'Definir isto como "Falhadas" registará apenas pesquisas que não produzam resultados.',
	'SEARCH_LOG_PER_PAGE'           => 'Itens por página',
	'SEARCH_LOG_PER_PAGE_EXPLAIN'   => 'Defina o número de itens de registro de pesquisa por página.',
	'SEARCH_LOG_PRUNE_ALL'          => 'Limpar todas as entradas do registro de pesquisa',
	'SEARCH_LOG_PRUNE_ALL_EXPLAIN'  => 'Definir isto como "Bem sucedidas" limpará apenas entradas do registro de pesquisa bem sucedidas, deixando as pesquisas falhadas no registro.',
	'SEARCH_LOG_PRUNE_DAYS'         => 'Limpar arquivo de registro (dias)',
	'SEARCH_LOG_PRUNE_DAYS_EXPLAIN' => 'O número de dias para manter as entradas no registro de pesquisa.<br>Definir isto para zero irá desabilitar a limpeza do arquivo de registro de pesquisa.',
	'SEARCH_SUCCESSFUL'             => 'Bem sucedidas',
]);
