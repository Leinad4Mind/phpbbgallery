<?php
/**
 * BBTags MCP language.
 *
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
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
	'MCP_BBTAGS_QUEUE'                 => 'Sugestões de tags',
	'MCP_BBTAGS_QUEUE_EXPLAIN'         => 'Aprove ou rejeite novas tags antes que fiquem visíveis e sejam associadas ao conteúdo que lhes deu origem.',
	'BBTAGS_PROVIDER'                  => 'Provedor',
	'BBTAGS_PROVIDER_FORUM_TOPICS'     => 'Tópicos do fórum',
	'BBTAGS_SCOPE_ITEM'                => 'Escopo / item',
	'BBTAGS_SUGGESTED_BY'              => 'Sugerida por',
	'BBTAGS_APPROVE'                   => 'Aprovar',
	'BBTAGS_REJECT'                    => 'Rejeitar',
	'BBTAGS_NO_PENDING_SUGGESTIONS'    => 'Não há sugestões de tags aguardando revisão.',
	'BBTAGS_PENDING_TOTAL'             => '%d sugestões pendentes',
	'BBTAGS_SUGGESTION_APPROVED'       => 'A sugestão de tag foi aprovada.',
	'BBTAGS_SUGGESTION_REJECTED'       => 'A sugestão de tag foi rejeitada.',
	'BBTAGS_SUGGESTION_RESOLVE_FAILED' => 'Não foi possível processar a sugestão de tag. O conteúdo pode não existir mais.',
]);
