<?php

/**
 * @package Double Account Preventer for phpBB.
 * info_acp_dap [English]
 * @copyright (c) 2014 www.phpbb-work.ru
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
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
	'ACL_A_CLEARDUPE' => 'Can clear Dupe User List',
]);
