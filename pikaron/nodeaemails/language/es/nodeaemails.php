<?php
/**
 *
 * No DEA Emails extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019 Picaron
 * @license GNU General Public License, version 2 (GPL-2.0)
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

$lang = array_merge($lang, array(
		'NO_DEA_EMAILS_INSTALL_ERROR'		=> '“No DEA Emails” no se puede instalar.<br><br>- Se requiere phpBB 3.2.4 o posterior.',
		'NO_DEA_EMAILS_NO_CURL'				=> '“No DEA Emails” no se puede instalar.<br><br>- Se requiere la extension “curl“ de PHP habilitada.',
		'NO_DEA_EMAILS_FOUND'				=> 'ERROR: El DOMINIO del Email ((%s)) no es válido.<br />Nuestro sitio Web NO admite cuentas de correo electrónico desechables o temporales <a href="https://bit.ly/2W2MrVO" target="_blank">(DED)</a>.<br />Si desea continuar con el registro en nuestra web, debe de utilizar una cuenta de correo electrónico NO desechable.',
		'NO_DEA_EMAILS_TITLE_FORCE_CHANGE'	=> 'Cambio Requerido por la Extensión “No Dea Emails”',
		'NO_DEA_EMAILS_FORCE_CHANGE'		=> 'Antes de continuar navegando por el sitio es necesario que cambie su “Correo Electrónico”.',
		'NO_DEA_EMAILS_NOT_FORCE_CHANGE'	=> 'Antes de continuar navegando por el sitio es necesario que cambie su “Correo Electrónico”.<br>Usted no tiene permisos para realizar el cambio.<br>Es necesario que contacte con la Administración del Sitio y solicite su actualizacón.',
		'LOG_NO_DEA_EMAILS'					=> 'No DEA Emails',
		'LOG_NO_DEA_EMAILS_SETTINGS'		=> 'Gestión CRON & Dominios de Correo DED Externos',
		'LOG_NO_DEA_EMAILS_LOCALS'			=> 'Gestión Local de Dominios de Correo DED',
		'LOG_NO_DEA_EMAILS_USERS'			=> 'Usuarios con Cuentas de Correo DED',
));
