<?php

/**
 * @package BBgdpr for phpBB.
 * @copyright (c) 2018 SiteSplat All rights reserved
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

$lang = array_merge($lang, [
	'ACL_U_DELETE_MY_ACCOUNT_POSTS' => 'Pode eliminar as publicações ao eliminar a conta (BBgdpr)',
	'ACL_U_DELETE_MY_ACCOUNT_PMS'   => 'Pode eliminar as mensagens privadas (MPs) ao eliminar a conta (BBgdpr)',
]);
