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
	'MCP_BBTAGS_QUEUE'                  => 'Tag suggestions',
	'MCP_BBTAGS_QUEUE_EXPLAIN'          => 'Approve or reject new tags before they become visible and are attached to their originating content.',
	'BBTAGS_PROVIDER'                   => 'Provider',
	'BBTAGS_PROVIDER_FORUM_TOPICS'      => 'Forum topics',
	'BBTAGS_SCOPE_ITEM'                 => 'Scope / item',
	'BBTAGS_SUGGESTED_BY'               => 'Suggested by',
	'BBTAGS_APPROVE'                    => 'Approve',
	'BBTAGS_REJECT'                     => 'Reject',
	'BBTAGS_NO_PENDING_SUGGESTIONS'     => 'There are no tag suggestions awaiting review.',
	'BBTAGS_PENDING_TOTAL'              => '%d pending suggestions',
	'BBTAGS_SUGGESTION_APPROVED'        => 'The tag suggestion was approved.',
	'BBTAGS_SUGGESTION_REJECTED'        => 'The tag suggestion was rejected.',
	'BBTAGS_SUGGESTION_RESOLVE_FAILED'  => 'The tag suggestion could not be resolved. Its content may no longer exist.',
]);
