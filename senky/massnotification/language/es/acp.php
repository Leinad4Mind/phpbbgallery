<?php
/**
 *
 * Mass Notification. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Jakub Senko
 * @license GNU General Public License, version 2 (GPL-2.0)
 * Spanish translation by ThE KuKa (c) 2019 [ver 1.0.0] (https://www.phpbb-es.com)
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
	'MASSNOTIFICATION_DESC'	=> 'Aquí puede enviar una notificación al foro a todos sus usuarios, a usuarios específicos o grupos.',

	'COMPOSE'				=> 'Componer notificación masiva',
	'ALL_USERS'				=> 'Todos los usuarios',
	'SEND_TO_GROUP'			=> 'Enviar al grupo',
	'SEND_TO_USERS'			=> 'Enviar a los usuarios',
	'SEND_TO_USERS_EXPLAIN'	=> 'La introducción de nombres aquí, anulará cualquier grupo seleccionado anteriormente. Introduzca cada nombre de usuario en una nueva línea.',
	'TITLE'					=> 'Título de la notificación',
	'MESSAGE_EXPLAIN'		=> 'Que sea corto, preferiblemente por debajo de 150 caracteres. Puede utilizar HTML.',
	'URL'					=> 'URL de redirección',
	'URL_EXPLAIN'			=> 'Introduzca la URL a la que se redirigirá al usuario después de hacer clic en la notificación.',
	'AUTHOR_EXPLAIN'		=> 'Enter author of the notification. Leave blank for generic notification without author.',
	'SEND_NOTIFICATION'		=> 'Enviar notificación',

	'NO_NOTIFICATION_TITLE'		=> 'Tiene que especificar el título de la notificación.',
	'NO_NOTIFICATION_MESSAGE'	=> 'Tiene que especificar el mensaje de la notificación.',
	'NO_NOTIFICATION_AUTHOR'	=> 'Author does not exist.',

	'NOTIFICATION_SEND'	=> 'Su notificación ha sido enviada.',
));
