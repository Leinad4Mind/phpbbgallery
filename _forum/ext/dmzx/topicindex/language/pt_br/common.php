<?php

/**
 * @package phpBB Extension - Topic Index for phpBB.
 * @copyright (c) 2015 dmzx - https://www.dmzx-web.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
	'ADD_INILIST'           => '+Lista',
	'REMOVE_INILIST'        => '-Lista',
	'OTINDEX_LINK_TITLE'    => 'Lista de Tópicos',
	'NUM'                   => 'N°',
	'POSTER'                => 'Enviado por',
	'INDEX_POST_PRES'       => 'Antes de abrir um novo tópico, por favor verifica se já existe na lista. Se existir, usa esse tópico para escrever uma mensagem.<br />Obrigado',
	'NON_ACTIVE'            => 'Inactivo',
	'DEF_ALL_TOPICS_IN'     => 'Todos os novos tópicos automaticamente',
	'DEF_ALL_TOPICS_OFF'    => 'Adiciona tópicos manualmente à lista',
	'REMOVE_FROM_LIST'      => 'remover',
	'TOPICINDEX_VERSION'    => 'Versão',
	'ALL'                   => 'Todos',
	'09'                    => '0-9',
	'SYMB'                  => '#&%',
	'ANY_TOPIC_IN_LIST'     => 'Nenhum tópico enviado!',
	'SELECT_A_LIST'         => 'Seleccione uma lista',
	'OIINDEX_HEADER'        => 'Lista de tópicos',
	'LANGUAGE'              => 'Idioma',
	'CATEGORY'              => 'Categoria',
	'COMMENTS'              => 'Comentários',
	'BUTTON_UPLOAD'         => 'Partilhar Projecto',
	'BUTTON_UPLOAD_EXPLAIN' => 'Sim! Começa a partilhar projectos na nossa comunidade!',

]);
