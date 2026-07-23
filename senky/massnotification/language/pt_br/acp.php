<?php

/**
 * Mass Notification. An extension for the phpBB Forum Software package.
 * @copyright (c) 2019, Jakub Senko
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
	'MASSNOTIFICATION_DESC' => 'Você pode enviar uma notificação do fórum para todos os seus usuários ou grupos específicos.',

	'COMPOSE'               => 'Compor notificação em massa',
	'ALL_USERS'             => 'Todos os usuários',
	'SEND_TO_GROUP'         => 'Enviar para grupo',
	'SEND_TO_USERS'         => 'Enviar para usuários',
	'SEND_TO_USERS_EXPLAIN' => 'Digitar nomes de usuário aqui substituirá qualquer grupo selecionado acima. Insira cada nome de usuário em uma nova linha.',
	'TITLE'                 => 'Título da notificação',
	'MESSAGE_EXPLAIN'       => 'Mensagem curta, de preferência abaixo de 150 caracteres. Você pode usar HTML.',
	'URL'                   => 'URL de redirecionamento',
	'URL_EXPLAIN'           => 'Insere o URL para o qual o usuário será redirecionado depois de clicar na notificação.',
	'AUTHOR_EXPLAIN'        => 'Insere o autor da notificação. Deixe em branco para notificação genérica sem autor.',
	'SEND_NOTIFICATION'     => 'Enviar notificação',

	'NO_NOTIFICATION_TITLE'   => 'Precisas especificar o título da notificação.',
	'NO_NOTIFICATION_MESSAGE' => 'Precisas especificar uma mensagem de notificação.',
	'NO_NOTIFICATION_AUTHOR'  => 'Autor não existe.',

	'NOTIFICATION_SEND' => 'A sua notificação foi enviada.',
]);
