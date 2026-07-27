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
	'MCP_BBTAGS_QUEUE'                 => 'Propostas de tags',
	'MCP_BBTAGS_QUEUE_EXPLAIN'         => 'Aprova ou rejeita novas tags antes de se tornarem visíveis e serem associadas ao conteúdo que lhes deu origem.',
	'BBTAGS_PROVIDER'                  => 'Fornecedor',
	'BBTAGS_PROVIDER_FORUM_TOPICS'     => 'Tópicos do fórum',
	'BBTAGS_SCOPE_ITEM'                => 'Âmbito / item',
	'BBTAGS_SUGGESTED_BY'              => 'Proposta por',
	'BBTAGS_APPROVE'                   => 'Aprovar',
	'BBTAGS_REJECT'                    => 'Rejeitar',
	'BBTAGS_NO_PENDING_SUGGESTIONS'    => 'Não existem propostas de tags a aguardar revisão.',
	'BBTAGS_PENDING_TOTAL'             => '%d propostas pendentes',
	'BBTAGS_SUGGESTION_APPROVED'       => 'A proposta de tag foi aprovada.',
	'BBTAGS_SUGGESTION_REJECTED'       => 'A proposta de tag foi rejeitada.',
	'BBTAGS_SUGGESTION_RESOLVE_FAILED' => 'Não foi possível processar a proposta de tag. O conteúdo poderá já não existir.',
]);
