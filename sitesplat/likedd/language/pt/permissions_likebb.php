<?php

/**
 * phpBB Ajax likeBB.
 * @copyright (c) 2015-2022 SiteSplat All rights reserved
 * @license Proprietary
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

// User Permissions
$lang = array_merge($lang, [
	'ACL_U_LIKEBB_LIKE'    => 'Pode gostar de mensagens via LikeBB',
	'ACL_U_LIKEBB_DISLIKE' => 'Pode desgostar de mensagens via LikeBB',
]);
