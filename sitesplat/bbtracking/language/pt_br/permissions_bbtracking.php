<?php

/**
 * BBtracking
 * @copyright (c) 2017, Sitesplat
 * @license private
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
	'ACL_M_PRIMEPOSTREV_VIEW'    => 'Pode visualizar as revisões das mensagens',
	'ACL_M_PRIMEPOSTREV_DELETE'  => 'Pode excluir as revisões das mensagens',
	'ACL_M_PRIMEPOSTREV_RESTORE' => 'Pode restaurar as revisões das mensagens',
	'ACL_F_PRIMEPOSTREV_VIEW'    => 'Pode visualizar as revisões das suas próprias mensagens',
	'ACL_F_PRIMEPOSTREV_DELETE'  => 'Pode excluir as revisões das suas próprias mensagens',
	'ACL_F_PRIMEPOSTREV_RESTORE' => 'Pode restaurar as revisões das suas próprias mensagens',
]);
