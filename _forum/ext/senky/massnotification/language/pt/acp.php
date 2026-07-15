<?php
/**
 *
 * Mass Notification. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Jakub Senko
 * @license GNU General Public License, version 2 (GPL-2.0)
 * Brazilian Portuguese translation by eunaumtenhoid [2019][ver 1.0.2] (https://github.com/phpBBTraducoes)
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
	'MASSNOTIFICATION_DESC'	=> 'Podes enviar uma notificação do fórum para todos os teus utilizadores ou grupos específicos.',

	'COMPOSE'				=> 'Compor notificação em massa',
	'ALL_USERS'				=> 'Todos os utilizadores',
	'SEND_TO_GROUP'			=> 'Enviar para grupo',
	'SEND_TO_USERS'			=> 'Enviar para utilizadores',
	'SEND_TO_USERS_EXPLAIN'	=> 'Escrevendo nome de utilizador aqui substituirá qualquer grupo selecionado acima. Insira cada nome de utilizador numa nova linha.',
	'TITLE'					=> 'Título da notificação',
	'MESSAGE_EXPLAIN'		=> 'Mensagem curta, de preferência abaixo de 150 caracteres. Podes usar HTML.',
	'URL'					=> 'URL de redirecionamento',
	'URL_EXPLAIN'			=> 'Insere o URL para o qual o utilizador será redirecionado depois de clicar na notificação.',
	'AUTHOR_EXPLAIN'		=> 'Insere o autor da notificação. Deixe em branco para notificação genérica sem autor.',
	'SEND_NOTIFICATION'		=> 'Enviar notificação',

	'NO_NOTIFICATION_TITLE'		=> 'Precisas especificar o título da notificação.',
	'NO_NOTIFICATION_MESSAGE'	=> 'Precisas especificar uma mensagem de notificação.',
	'NO_NOTIFICATION_AUTHOR'	=> 'Autor não existe.',

	'NOTIFICATION_SEND'	=> 'A tua notificação foi enviada.',
));
