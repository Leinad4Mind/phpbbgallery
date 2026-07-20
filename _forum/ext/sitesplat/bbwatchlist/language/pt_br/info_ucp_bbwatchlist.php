<?php

/**
 * BBwatchlist. An extension for the phpBB Forum Software package.
 * @copyright (c) 2018 SiteSplat All rights reserved
 * @license Proprietary
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

$lang = array_merge($lang, [
	'UCP_SITESPLAT_BBWATCHLIST' => 'Gerir a Minha Lista',

	'KEYWORD'                           => 'Palavra-chave',
	'SEARCH_TYPE'                       => 'Tipo de Pesquisa',
	'ACTIONS'                           => 'Ações',
	'KEYWORDS'                          => 'Palavras-chave',
	'UCP_SITESPLAT_BBWATCHLIST_EXPLAIN' => 'Você pode adicionar palavras-chave para seguir e ser notificado quando estas forem usadas em mensagens ou nos títulos dos tópicos',
	'NO_UCP_KEYWORDS'                   => 'Não tem quaisquer palavras-chave definidas. Está à espera de quê? Adiciona lá algumas!',
	'ADD_NEW_KEYWORD'                   => 'Adicionar nova palavra-chave',
	'SEARCH_TYPE_TOPIC_SUBJECT'         => 'Correspondência no título dos tópicos',
	'SEARCH_TYPE_POST_CONTENT'          => 'Correspondência no conteúdo das mensagens',

	'KEYWORD_EMPTY'     => 'Ups! Não inseriste nenhuma palavra-chave.',
	'KEYWORD_PATTERN'   => '3 a 50 caracteres',
	'KEYWORD_TOO_SHORT' => 'Palavra-chave demasiado curta. Tem de ter pelo menos 3 caracteres',
	'KEYWORD_TOO_LONG'  => 'Palavra-chave demasiado longa. Não pode ultrapassar os 50 caracteres',
	'KEYWORD_EXISTS'    => 'Outra vez arroz? Já tem essa palavra-chave definida.',
	'KEYWORD_ADDED'     => 'Palavra-chave adicionada',
	'KEYWORD_DELETED'   => 'Palavra-chave removida',

	// Notifications
	'NOTIFICATION_GROUP_BBWATCHLIST'    => 'Watchlist',
	'NOTIFICATION_TYPE_SUBJECT_KEYWORD' => 'Uma das suas palavra-chave que segues foi detectada no título do tópico',
	'NOTIFICATION_TYPE_CONTENT_KEYWORD' => 'Uma das suas palavra-chave que segues foi detectada no conteúdo de uma mensagem',
]);
