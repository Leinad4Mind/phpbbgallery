<?php

/**
 * @package phpBB Extension - Official Topic Index for phpBB.
 * @copyright (c) 2015-2022 Leinad4Mind - https://leinad4mind.top/forum
 * @copyright (c) 2015 dmzx - https://www.dmzx-web.net
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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

// Merge the following language entries into the lang array
$lang = array_merge($lang, [
	'OFFICIAL_TOPIC_INDEX'        => 'Gerir a extensão Official Topic Index',
	'ADD_NEW_TOPICS_LIST'         => 'Adiciona uma nova lista',
	'LIST_NAME'                   => 'Nome da lista',
	'OINDEX_CFG_SETUP'            => 'Configura a Official Topic Index',
	'OVERFLOW_IN_TOPIC'           => 'Permite barra de deslocamento na lista de tópicos',
	'NAME_FORUM_LIST_EMPTY'       => 'O nome da lista não pode estar vazio.',
	'SELECT_FORUM_LIST_EMPTY'     => 'Pelo menos um fórum deve ser selecionado.',
	'OINDEX_ADDED_LIST'           => 'Lista guardada com sucesso.',
	'OINDEX_DELETED_LIST'         => 'Lista eliminada com sucesso.',
	'OINDEX_EDIT_CFG'             => 'Configuração da Official Topic Index editada com sucesso.',
	'OINDEX_FORUMS'               => 'Fóruns',
	'OINDEX_SELECT_FORUM'         => 'Seleciona um fórum',
	'OTINDEX_LIST_ALONE_DSC'      => 'Cria uma lista externa de todos os tópicos de um único fórum ou de um conjunto de fóruns. Em vez de uma lista no tópico, as externas não necessitam de ser ativadas diretamente no fórum, mas neste caso serão listados todos os tópicos sem nenhuma escolha.',
	'OTINDEX_LIST_INTOPIC_DSC'    => 'Cria uma lista de tópicos organizada que irá aparecer dentro de um tópico escolhido. Assim que ativares esta função, aparecerão novos ícones para inserir ou remover tópicos da lista em todas as primeiras mensagens de cada tópico.',
	'ACTIVE_TOPIC_INDEX'          => 'Ativa e seleciona o tópico para a lista',
	'TOPIC_INDEX_DEFAULT'         => 'Escolhe quais tópicos adicionar por predefinição.',
	'ACTIVE_TOPIC_INDEX_EXPLAIN'  => 'Escolhe o tópico, entre os tópicos <strong>fixos ou anúncios</strong>, que se converterá na lista. Para isso, deves ter pelo menos um tópico no fórum.',
	'TOPIC_INDEX_DEFAULT_EXPLAIN' => 'Escolhe o sistema pelo qual os tópicos serão incluídos na lista',
	'ACTIVE_INDEX_FILTER'         => 'Ativa filtro de tag',
	'ACTIVE_INDEX_FILTER_EXPLAIN' => 'Deves ativar isto se tiveres tópicos com uma TAG comum no título. Suportamos tags em formato simples ou duplo: <strong>[]</strong>,<strong>{}</strong>,<strong>()</strong>.',
]);

$lang = array_merge($lang, [
	'OINDEX_CFG_EXPLAIN'                 => 'Configura os índices de tópicos incorporados e externos. A mensagem original do tópico oficial não é alterada na base de dados.',
	'TOPICINDEX_MAX_TOPICS'              => 'Máximo de tópicos por índice',
	'TOPICINDEX_MAX_TOPICS_EXPLAIN'      => 'Limite entre 1 e 5000 para proteger o tempo de resposta da página.',
	'TOPICINDEX_NEW_TOPIC_FORUM'         => 'Fórum para novos tópicos',
	'TOPICINDEX_NEW_TOPIC_FORUM_EXPLAIN' => 'Fórum opcional usado pelo botão de novo tópico. O botão fica oculto para quem não puder publicar.',
	'TOPICINDEX_EXISTING_LISTS'          => 'Listas externas existentes',
	'TOPICINDEX_UNKNOWN_FORUM'           => 'Fórum desconhecido #%d',
	'TOPICINDEX_LIST_NAME_TOO_LONG'      => 'O nome da lista não pode exceder 255 caracteres.',
	'TOPICINDEX_LIST_NAME_EXISTS'        => 'Já existe uma lista com este nome.',
	'TOPICINDEX_DELETE_LIST_CONFIRM'     => 'Tens a certeza de que pretendes eliminar esta lista?',
	'TOPICINDEX_DISPLAY_MODE'            => 'Posição do índice incorporado',
	'TOPICINDEX_DISPLAY_MODE_EXPLAIN'    => 'Escolhe como o índice é combinado com a primeira mensagem do tópico oficial.',
	'TOPICINDEX_DISPLAY_AFTER'           => 'Depois da mensagem original (recomendado)',
	'TOPICINDEX_DISPLAY_BEFORE'          => 'Antes da mensagem original',
	'TOPICINDEX_DISPLAY_REPLACE'         => 'Substituir a mensagem original (legado)',
]);
