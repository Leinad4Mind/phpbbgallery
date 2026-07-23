<?php

/**
 * BBmembership extension for the phpBB Forum Software package.
 * @copyright (c) 2015 SiteSplat All rights reserved
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
	'MEMBERSHIPS'                      => 'Membros VIP (Memberships)',
	'NOTIFICATION_TYPE_BBMEMBERSHIP'   => 'Notificações ou Alertas referentes ao serviço de Adesão',
	'MEMBERSHIP_NOTIFICATION_BOUGHT'   => '<strong>Aquisição de serviço e registo de membro</strong>: O nosso utilizador %1$s terminou e comprou com sucesso o nível do escalão para ser %2$s.',
	'MEMBERSHIP_NOTIFICATION_EXPIRING' => '<strong>Expiração ou validade de membro</strong>: Ao nosso prezado utilizador %1$s, alertamos o mesmo que as suas regalias ou benefícios vão expirar em menos de 24 horas.',
]);
