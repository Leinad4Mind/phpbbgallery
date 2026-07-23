<?php

/**
 * Private Post
 * @copyright (c) 2016 SiteSplat All rights reserved
 * @license Proprietary
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

$lang = array_merge($lang, [
	'PRIVATE_POST'                     => 'Mensagem Oculta',
	'PRIVATE_POST_EXPLAIN'             => 'Mensagens Ocultas podem APENAS ser lidas pela Equipa GoldTugAnime',
	'PRIVATE_BY'                       => 'Mensagem Oculta por',
	'PRIVATE_POST_NO_CONTENT'          => 'O conteúdo desta mensagem foi marcado como oculto',
	'NO_QUOTE_PRIVATE_POST'            => 'Não podes citar mensagens ocultas.',
	'NO_MANIPULATION_PRIVATE_POST'     => 'Não podes manipular mensagens ocultas.',
	'NO_QUICKMOD_WITH_PRIVATE_POST'    => 'Não podes usar ferramentas de moderação rápidas em tópicos com mensagens ocultas.',
	'NO_MCP_TOPIC_WITH_PRIVATE_POST'   => 'Não podes moderar tópicos com mensagens ocultas.',
	'NO_MCP_WARN_PRIVATE_POST'         => 'Não podes avisar utilizador sobre mensagens ocultas.',
	'NO_MCP_POST_DETAILS_PRIVATE_POST' => 'Não podes ver detalhes de mensagens ocultas de outrem.',
	'NO_MCP_REPORT_PRIVATE_POST'       => 'Não podes gerir denúncias de mensagens ocultas.',
	'NO_REPORT_PRIVATE_POST'           => 'Não podes denunciar mensagens ocultas.',
	'PRIVATE_TAG'                      => '<a title="Esta mensagem foi marcada como oculta. Certifica-te de não divulgar informações privadas!"><span class="label label-warning" style="display: inline-block;font-size: 11px;margin-bottom: 3px;padding: 2px 4px;line-height: inherit;vertical-align: middle;"><i class="fa fa-exclamation-triangle"></i>&nbsp;[MENSAGEM OCULTA]</span></a>&nbsp;',

	'FLTL_PRIVATE'      => '[mensagem oculta]',
	'BBPREVIEW_PRIVATE' => '[mensagem oculta]',
]);
