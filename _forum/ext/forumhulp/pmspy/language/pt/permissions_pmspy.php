<?php

/**
 * @package PM SPy for phpBB.
 * @copyright (c) 2016 ForumHulp.com
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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
	'ACL_A_PMSPY' => 'Pode utilizar o Espião de MP',
]);
