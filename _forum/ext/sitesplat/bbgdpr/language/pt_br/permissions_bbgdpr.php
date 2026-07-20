<?php

/**
 * @package BBgdpr for phpBB.
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
	'ACL_U_DELETE_MY_ACCOUNT_POSTS' => 'Pode excluir as publicações ao excluir a conta (BBgdpr)',
	'ACL_U_DELETE_MY_ACCOUNT_PMS'   => 'Pode excluir as mensagens privadas (MPs) ao excluir a conta (BBgdpr)',
]);
