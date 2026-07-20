<?php

/**
 * @copyright (c) 2019-2022 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
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
	'NOTIFICATION_GROUP_STAFFNOTIFICATIONS'      => 'Notificações da Equipa',
	'STAFFNOTIFICATIONS_DELETE_POST'             => 'Uma mensagem é eliminada',
	'STAFFNOTIFICATIONS_TITLE_DELETE_POST'       => '%1$s <strong>eliminou uma mensagem</strong> de %2$s',
	'STAFFNOTIFICATIONS_SOFT_DELETE_POST'        => 'Uma mensagem é eliminada de forma suave',
	'STAFFNOTIFICATIONS_TITLE_SOFT_DELETE_POST'  => '%1$s <strong>eliminou de forma suave uma mensagem</strong> de %2$s',
	'STAFFNOTIFICATIONS_MERGE_TOPICS'            => 'Tópicos são fundidos',
	'STAFFNOTIFICATIONS_TITLE_MERGE_TOPICS'      => '%1$s <strong>fundiu tópicos</strong>',
	'STAFFNOTIFICATIONS_MERGE_POSTS'             => 'Mensagens são fundidas',
	'STAFFNOTIFICATIONS_TITLE_MERGE_POSTS'       => '%1$s <strong>fundiu mensagens</strong>',
	'STAFFNOTIFICATIONS_DELETE_TOPIC'            => 'Um tópico é eliminado',
	'STAFFNOTIFICATIONS_TITLE_DELETE_TOPIC'      => '%1$s <strong>eliminou um tópico</strong> de %2$s',
	'STAFFNOTIFICATIONS_SOFT_DELETE_TOPIC'       => 'Um tópico é eliminado de forma suave',
	'STAFFNOTIFICATIONS_TITLE_SOFT_DELETE_TOPIC' => '%1$s <strong>eliminou de forma suave um tópico</strong> de %2$s',
	'STAFFNOTIFICATIONS_BAN_USER'                => 'Um usuário é banido',
	'STAFFNOTIFICATIONS_TITLE_BAN_USER'          => '%1$s <strong>baniu usuário</strong> %2$s',
	'STAFFNOTIFICATIONS_REFERENCE_REASON'        => 'Razão: %s',
	'STAFFNOTIFICATIONS_REFERENCE_SUBJECT'       => 'Assunto: %s',
	'STAFFNOTIFICATIONS_REFERENCE_TITLE'         => 'Título: %s',
	'STAFFNOTIFICATIONS_REFERENCE_DURATION'      => [
		0 => 'Duração: permanentemente',
		1 => 'Duração: %2$d minutos',
		2 => 'Duração: até %2$s',
	],
]);
