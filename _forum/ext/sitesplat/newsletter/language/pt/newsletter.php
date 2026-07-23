<?php

/**
 * @package BBnewsletter for phpBB.
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
	'NEWSLETTER' => 'Newsletter',
	'OVERVIEW'   => 'Bem-vindo à nossa Newsletter! :-) Nesta página encontrarás as últimas Newsletters, bem como os arquivos dos anos anteriores.',

	'SUBSCRIBE_NO'          => 'NÃO quero continuar a receber a Newsletter',
	'SUBSCRIBE_YES'         => 'Sim, quero receber a Newsletter',
	'SUBSCRIBE_BTN_NO'      => 'Cancelar',
	'SUBSCRIBE_BTN_YES'     => 'Subscrever',
	'SUBSCRIBE_CONFIRM_NO'  => 'Por favor, submete para cancelares a tua subscrição',
	'SUBSCRIBE_CONFIRM_YES' => 'Por favor, submete para confirmares a tua subscrição',

	'SUBSCRIBE_Y_EMAIL' => 'O teu email',
	'SUBSCRIBE'         => 'Subscrever',
	'UNSUBSCRIBE'       => 'Cancelar subscrição de',
	'SUBSCRIBE_INFO'    => 'A nossa newsletter. Os membros que cancelarem a subscrição deixam de receber o nosso resumo periódico de novidades.',

	'OVERVIEW_ARCHIVE' => 'Arquivo',
	'ARCHIVES'         => 'Arquivos',
	'SUBSCRIBED'       => 'Obrigado por subscreveres! A partir de hoje vais receber a nossa newsletter!',
	'UNSUBSCRIBED'     => 'Subscrição cancelada com sucesso, deixarás de receber a nossa newsletter'
]);
