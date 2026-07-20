<?php

/**
 * @copyright (c) 2024
 * @license GNU General Public License, version 2 (GPL-2.0)
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
	'LIMITREPLIES_MSG_REPLY_DENIED' => 'Como a última mensagem neste tópico foi sua e é mais recente que <strong>%1$s</strong>, apenas poderá responder de novo a partir das <strong>%2$s</strong>.',
	'LIMITREPLIES_MINUTES_PLURAL'   => [
		1 => '1 minuto',
		2 => '%u minutos',
	],
]);
