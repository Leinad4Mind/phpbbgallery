<?php

/**
 * @package PMnotifications for phpBB.
 * @copyright (c) 2016 SiteSplat All rights reserved
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
	'FROM_AUTHOR_PM_LIST' => 'MP\'s trocadas com este usuário',
	'PM_UNREAD_COUNT'     => [
		0 => 'Sem MPs por ler. Perfeito!',
		1 => '1 MP por ler',
		2 => '%d MPs por ler',
	],
	'NO_PRIVATE_MESSAGES' => 'Sem Mensagens Privadas'
]);
