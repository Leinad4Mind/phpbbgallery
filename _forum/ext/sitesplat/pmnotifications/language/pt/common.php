<?php
/**
*
* @package PMnotifications
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'FROM_AUTHOR_PM_LIST'		=> 'MP\'s trocadas com este utilizador',
	'PM_UNREAD_COUNT'	=> array(
		0	=> 'Sem MPs por ler. Perfeito!',
		1	=> '1 MP por ler',
		2	=> '%d MPs por ler',
	),
	'NO_PRIVATE_MESSAGES' => 'Sem Mensagens Privadas'
));
