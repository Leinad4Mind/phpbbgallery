<?php

/**
 * BBAvatars
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
	'BBAVATARS_PARTECIPANTS' => 'Contribuintes do Tópico',
	'PARTICIPATE_OTHERS'     => 'Ver todos os Contribuintes',
]);
