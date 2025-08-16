<?php
/**
*
* @package User Login Redirect
* @copyright (c) 2014 david63
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
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
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'REDIRECT_ANNOUNCE'					=> 'Redireccionar al Anuncio en el inicio de sesión',
	'REDIRECT_ANNOUNCE_EXPLAIN'			=> 'Redireccionar todos los usuarios que no han iniciado sesión desde la última publicación del anuncio.',
	'REDIRECT_ANNOUNCE_MESSAGE_EXPLAIN'	=> 'Mostrar un mensaje para decir que el usuario se redirige al último anuncio.',
	'REDIRECT_ANNOUNCE_OPTIONS'			=> 'Opciones de Anuncio',

	'REDIRECT_ENABLED'					=> 'Redirección de inicio de usuario habilitado',

	'REDIRECT_GROUP'					=> 'Tema de Redirección del grupo',
	'REDIRECT_GROUP_ALL'				=> 'Todos los miembros de los grupos',
	'REDIRECT_GROUP_ALL_EXPLAIN'		=> 'Fijar esto a Sí, anulará cualquier grupo seleccionado individualmente a continuación.',
	'REDIRECT_GROUP_EXPLAIN'			=> 'Redireccionar a los miembros de un grupo, o todos los grupos, a un tema específico al iniciar sesión.',
	'REDIRECT_GROUP_ID'					=> 'Seleccionar grupo',
	'REDIRECT_GROUP_MESSAGE_EXPLAIN'	=> 'Mostrar un mensaje para decir que el usuario se redirige a un tema específico.',
	'REDIRECT_GROUP_OPTIONS'			=> 'Opciones del grupo',
	'REDIRECT_GROUP_TOPIC_ID'			=> 'ID del tema del grupo',
	'REDIRECT_GROUP_TOPIC_ID_EXPLAIN'	=> 'Introduzca el ID del tema al que desea redirigir los miembros del grupo.',

	'REDIRECT_LOGIN'					=> 'Redirección de inicio',
	'REDIRECT_LOGIN_ANNOUNCE_TOPIC'		=> 'Ha iniciado sesión correctamente. Un anuncio ha sido publicado desde su última visita, ahora será redirigido a él.',
	'REDIRECT_LOGIN_EXPLAIN'			=> 'Aquí puede elegir, tener un nuevo usuario redirigido a un tema de bienvenida en su primera sesión después de registrarse, redirigir ha todos los usuarios al último anuncio si aún no lo ha visto, y/o redirigir a todos los miembros, o los de un grupo seleccionado a un nuevo mensaje al iniciar sesión.',
	'REDIRECT_LOGIN_GROUP_TOPIC'		=> 'Ha iniciado sesión correctamente. Un nuevo mensaje del grupo ha sido publicado desde su última visita, ahora será redirigido a él.',
	'REDIRECT_LOGIN_WELCOME_TOPIC'		=> 'Ha iniciado sesión correctamente. Como esta es su primera visita, ahora será redirigido a nuestro tema de bienvenida.',

	'REDIRECT_REFRESH_ANNOUNCE'			=> '%sContinúe con el tema de anuncio%s',
	'REDIRECT_REFRESH_GROUP' 			=> '%sContinúe con el tema del grupo%s',
	'REDIRECT_REFRESH_WELCOME'			=> '%sContinúe con el tema de bienvenida%s',

	'REDIRECT_SHOW_MESSAGE'				=> 'Mostrar un mensaje de redirección',

	'REDIRECT_WELCOME'            		=> 'Welcome topic redirect',
	'REDIRECT_WELCOME_EXPLAIN'			=> 'Redireccionar a todos los nuevos usuarios a un tema de bienvenida en su primer inicio de sesión en el foro.',
	'REDIRECT_WELCOME_MESSAGE_EXPLAIN'	=> 'Mostrar un mensaje para decir que el nuevo usuario se redirige al tema de bienvenida.',
	'REDIRECT_WELCOME_OPTIONS'			=> 'Opciones de bienvenida',
	'REDIRECT_WELCOME_TOPIC_ID'			=> 'ID del tema de bienvenida',
	'REDIRECT_WELCOME_TOPIC_ID_EXPLAIN'	=> 'Introduzca el ID del tema de bienvenida al que desea redirigir todos los nuevos usuarios.',



));
