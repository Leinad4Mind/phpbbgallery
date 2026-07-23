<?php

/**
 * @package BBSwitch for phpBB.
 * @copyright (c) 2016 SiteSplat All rights reserved
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
	'ACCOUNTSWITCH'            => 'Troca de Conta',
	'ACCOUNTSWITCH_EXPLAIN'    => 'Cria contas e usa o mesmo endereço de e-mail; as tuas contas serão listadas aqui e poderás alternar de uma conta para outra.',
	'ACCOUNTSWITCH_NO_RECORDS' => 'Não existem contas conhecidas',
	'SWITCH_TO'                => 'Trocar para',
	'SWITCH_ALT'               => 'Alternar',
]);
