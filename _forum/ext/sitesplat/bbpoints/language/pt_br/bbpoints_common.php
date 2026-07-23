<?php

/**
 * BBpoints extension for the phpBB Forum Software package.
 * @copyright (c) 2015-2022 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
	'BB_PAID_UP'                  => 'PontosGold',
	'YOUR_BBPOINTS'               => 'Seus PontosGold',
	'BB_AMOUNT'                   => 'Valor',
	'BB_PAID'                     => 'Obtido',
	'BB_PERSONAL'                 => 'Autor',
	'BB_PERSONAL_EXPLAIN'         => 'Você tem acesso ao tópico por ser o autor dele',
	'TOPIC_HIDDEN'                => 'O acesso antecipado a este projeto requer uma troca de PontosGold com o seu autor.',
	'WAS_HIDDEN'                  => 'Você já obteve este tópico em troca de PontosGold',
	'BBPOINTS_HIDE_TOPIC'         => 'Pontos Mín.',
	'BBPOINTS_HIDE_TOPIC_EXPLAIN' => 'Digite o valor mínimo de PontosGold necessário para acessar este tópico. <br />(Os pontos serão transferidos para a sua conta)',
	'TRANSFER_NOTI'               => 'Você recebeu %1$s PontosGold de %2$s %3$s',

	'NOTIFICATION_TYPE_SITESPLAT.BBPOINTS.NOTIFICATION.TYPE.TRANSFER' => 'Transferiram PontosGold para você.',
	'NOTIFICATION_TYPE_BBPOINTS_TRANSFER'                             => 'Transferiram PontosGold para você',
]);
