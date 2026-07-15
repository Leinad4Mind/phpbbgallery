<?php
/**
*
* @package phpBB Extension - Topic Index
* @copyright (c) 2015 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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

// Merge the following language entries into the lang array
$lang = array_merge($lang, array(
	'OFFICIAL_TOPIC_INDEX'			=> 'Gerencia a extensão Official Topic Index',
	'ADD_NEW_TOPICS_LIST'			=> 'Adiciona uma nova lista',
	'LIST_NAME'						=> 'Nome da lista',
	'OINDEX_CFG_SETUP'				=> 'Configura a Official Topic Index',
	'OVERFLOW_IN_TOPIC'				=> 'Permite barra de rolagem na lista de tópicos',
	'NAME_FORUM_LIST_EMPTY'			=> 'O nome da lista não pode estar vazio.',
	'SELECT_FORUM_LIST_EMPTY'		=> 'Pelo menos um fórum deve ser selecionado.',
	'OINDEX_ADDED_LIST'				=> 'Lista salva com sucesso.',
	'OINDEX_DELETED_LIST'			=> 'Lista deletada com sucesso.',
	'OINDEX_EDIT_CFG'				=> 'Configuração da Official Topic Index editada com sucesso.',
	'OINDEX_FORUMS'					=> 'Fóruns',
	'OINDEX_SELECT_FORUM'			=> 'Selecione um fórum',
	'OTINDEX_LIST_ALONE_DSC'		=> 'Cria uma lista externa de todos os tópicos de um único fórum ou um conjunto de fóruns. Ao invés de uma lista no tópico, as externas não necessitam ser ativadas diretamente no fórum mas neste caso serão listados todos os tópicos sem nenhuma escolha.',
	'OTINDEX_LIST_INTOPIC_DSC'		=> 'Cria uma lista de tópicos organizada que irá aparecer dentro de um tópico escolhido. Uma vez que você ative esta função, aparecerão novos ícones para inserir ou remover tópicos da lista em todos as primeiras mensagens de cada tópico.',
	'ACTIVE_TOPIC_INDEX'			=> 'Ativa e seleciona o tópico para a lista',
	'TOPIC_INDEX_DEFAULT'			=> 'Escolha quais tópicos adicionar por padrão.',
	'ACTIVE_TOPIC_INDEX_EXPLAIN'	=> 'Escolha o tópico nos tópicos <strong>fixos ou anúncios</strong> que se converterão na lista. Para isso, você deve ter ao menos um tópico no fórum.',
	'TOPIC_INDEX_DEFAULT_EXPLAIN'	=> 'Escolha o sistema pelo qual os tópicos serão incluídos à lista',
	'ACTIVE_INDEX_FILTER'			=> 'Ativa filtro de tag',
	'ACTIVE_INDEX_FILTER_EXPLAIN'	=> 'Você deve ativar isso se você tem tópicos com uma TAG comum no título. Nós suportamos tags com formato simples ou duplo: <strong>[]</strong>,<strong>{}</strong>,<strong>()</strong>.',
));
