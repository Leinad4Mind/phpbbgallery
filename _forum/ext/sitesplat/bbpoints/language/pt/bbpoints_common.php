<?php

/**
 * BBpoints extension for the phpBB Forum Software package.
 * @copyright (c) 2015-2022 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
 */

/**
 * DO NOT CHANGE
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
	'BBPOINTS'                    => 'PontosGold', // This is the forum point name. You can edit it to reflect your own point name.
	'BBPOINTS_SHORT'              => 'Pontos',
	'YOUR_BBPOINTS'               => 'Os Teus PontosGold',
	'BB_AMOUNT'                   => 'Montante',
	'BB_PAID_UP'                  => 'PontosGold',
	'BB_PAID'                     => 'Obtido',
	'BB_PERSONAL'                 => 'Autor',
	'BB_PERSONAL_EXPLAIN'         => 'Tens acesso ao tópico por seres o autor do mesmo',
	'TOPIC_HIDDEN'                => 'O acesso antecipado a este projecto requer uma troca de PontosGold para com o seu autor.',
	'WAS_HIDDEN'                  => 'Já obtiveste este tópico à troca de PontosGold',
	'BBPOINTS_HIDE_TOPIC'         => 'Pontos Mín.',
	'BBPOINTS_HIDE_TOPIC_EXPLAIN' => 'Introduza o montante mínimo de PontosGold necessários para acederem a este tópico. <br />(Os pontos serão transferidos para a tua conta)',
	'TRANSFER_NOTI'               => 'Recebeste %1$s PontosGold da parte de %2$s %3$s',

	'NOTIFICATION_TYPE_SITESPLAT.BBPOINTS.NOTIFICATION.TYPE.TRANSFER' => 'Foram-te transferidos PontosGold.',
	'NOTIFICATION_TYPE_BBPOINTS_TRANSFER'                             => 'Foram-te transferidos PontosGold',
]);
