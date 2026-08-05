<?php

/**
 * @package Search Results for phpBB.
 * @copyright (c) 2014 ForumHulp.com
 * @license https://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
	'ACP_SEARCHRESULTS'     => 'Search results',
	'ACP_SR_MANAGE'         => 'Search results',
	'ACP_SR_MANAGE_EXPLAIN' => 'Displays the search words used by visitors.<br />You can sort by search word, hits, and first or latest visit. The limit configured under Board features retains the most frequently and recently searched words.',
	'SEARCHWORD'            => 'Search word(s)',
	'REF_HITS'              => 'Hits',
	'REF_FIRST'             => 'First visit',
	'REF_LAST'              => 'Latest visit',
	'FOUND'                 => 'Found',
	'NOTFOUND'              => 'Not found',
]);
