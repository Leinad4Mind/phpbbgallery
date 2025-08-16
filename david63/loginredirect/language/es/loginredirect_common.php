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
	'REDIRECT_LOGIN_ANNOUNCE_TOPIC'		=> 'Ha iniciado sesión correctamente. Un anuncio ha sido publicado desde su última visita, ahora será redirigido a él.',
	'REDIRECT_LOGIN_GROUP_TOPIC'		=> 'Ha iniciado sesión correctamente. Un nuevo mensaje del grupo ha sido publicado desde su última visita, ahora será redirigido a él.',
	'REDIRECT_LOGIN_WELCOME_TOPIC'		=> 'Ha iniciado sesión correctamente. Como esta es su primera visita, ahora será redirigido a nuestro tema de bienvenida.',

	'REDIRECT_REFRESH_ANNOUNCE'			=> '%sIr all tema del anuncio%s',
	'REDIRECT_REFRESH_GROUP' 			=> '%sIr al tema del grupo%s',
	'REDIRECT_REFRESH_WELCOME'			=> '%sIr al tema de bienvenida%s',
));
