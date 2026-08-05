<?php
/**
 *
 * @package Error Pages
 * @copyright (c) 2014 ForumHulp.com
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
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
	'ERRORPAGES_LOG' => 'Log server errors',
	'ERRORPAGES_LOG_EXPLAIN' => 'Log HTTP 5xx server errors in the ACP error log. Routine 4xx client errors are not logged.',
	'ERRORPAGES_EXPLAIN' => 'Explain error pages',
	'ERRORPAGES_EXPLAIN_EXPLAIN' => 'Display a short, non-sensitive explanation below the error title.',
]);
