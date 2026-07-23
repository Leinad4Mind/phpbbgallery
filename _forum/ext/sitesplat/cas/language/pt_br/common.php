<?php

/**
 * @package Categorize CAS for phpBB.
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
	'GLOBAL_ANNOUNCEMENTS' => 'Anúncios Globais',
	'STICKY'               => 'Tópicos Fixos',
]);
