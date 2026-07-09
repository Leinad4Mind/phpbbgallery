<?php
/**
 *
 * No DEA Emails. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2020, Picaron, https://github.com/picaronin/
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
		'ACP_NO_DEA_EMAILS'					=> 'No DEA Emails',
		'ACP_NO_DEA_EMAILS_EXPLAIN'			=> 'Esta extensión impide el registro de un usuario en el foro cuando se utiliza una cuenta de Correo Electrónico desechable o temporal <a href="https://bit.ly/2W2MrVO" target="_blank">(DED)</a>.',
		'ACP_NO_DEA_EMAILS_WARNING_CRON'	=> 'En esta sección se obtienen datos del estado del CRON.<br>- Se habilita la opción para definir el intervalo de tiempo para ejecución del CRON.<br>Se muestra una relacion de los dominios de Email tipo DED con los que se filtrarán en adelante las Cuentas de Correo Electrónico de los Usuarios del foro.',
		'ACP_NO_DEA_EMAILS_WARNING_LOCAL'	=> 'En esta sección se pueden gestionar (incluir/eliminar) de forma local dominios de cuentas de Correo Electrónico desechables o temporales <a href="https://bit.ly/2W2MrVO" target="_blank">(DED)</a>.<br><br>Se debe de prestar especial atención, ya que si se incluye un dominio válido, impediremos a los usuarios que lo utilicen para poder registrarse.<br><i>Ejemplo: Si damos de alta el dominio “gmail.com” dejaremos a todos nuestros usuarios sin poder usar cuentas de correo Electrónico de Google.</i>',
		'ACP_NO_DEA_EMAILS_WARNING_USERS'	=> 'En esta sección se recopila información de todos los Usuarios del foro que tienen asociado un Correo Electrónico Desechable <a href="https://bit.ly/2W2MrVO" target="_blank">(DED)</a> a su cuenta.<br><br>Podremos <strong>ELIMINAR POR COMPLETO</strong> a los usuarios que sean seleccionados.<br>(Incluidos todos sus mensajes publicados)<br><br><strong>ATENCION:<br>Esta acción NO ES REVERSIBLE, tenga precaución al utilizar esta opción si su foro se encuentra en producción.</strong>',
		'ACP_NO_DEA_EMAILS_SETTINGS'		=> 'Gestión CRON & Dominios de Correo DED Externos',
		'ACP_NO_DEA_EMAILS_LOCALS'			=> 'Gestión Local de Dominios de Correo DED',
		'ACP_NO_DEA_EMAILS_USERS'			=> 'Usuarios con Cuentas de Correo DED',
		'ACP_SUBMIT_DELETE'					=> 'Aplicar Cambios',
		'LOG_CONFIG_CONFIGURATION'			=> '<strong>Configuracion Actualizada Extensión “No DEA Emails”</strong>',
		'LOG_CONFIG_USERS'					=> '<strong>Usuarios ELIMINADOS desde “No DEA Emails”</strong>',
		'LOG_FORCE_CHG_EMAIL'				=> '<strong>No DEA Emails</strong><br>» %s',
		'LOG_FORCE_USERS_CHG_EMAIL'			=> '<strong>Usuarios MARCADOS para FORZAR CAMBIO de “Correo Electrónico”</strong>',
		'LOG_FORCE_USERS_NO_CHG_EMAIL'		=> '<strong>Usuarios DESMARCADOS para FORZAR CAMBIO de “Correo Electrónico”</strong>',
		'LOG_FORCE_USER_CHG_EMAIL'			=> 'Usuario MARCADO para FORZAR CAMBIO de “Correo Electrónico”',
		'L_NO_DEA_EMAILS_DELAY'				=> 'Intervalo para ejecución del CRON',
		'L_NO_DEA_EMAILS_DELAY_EXPLAIN'		=> '(Mínimo: 300 Segundos , Máximo: 86400 Segundos = 1 Día)',
		'L_DEA_DELAY'						=> 'Segundos',
		'L_DEA_DELAY_MIN'					=> 'Minutos',
		'L_NO_DEA_EMAILS_VERSION'			=> 'Versión de Extensión: ',
		'L_NO_DEA_EMAILS_CONFIG'			=> 'Opciones de Configuración del CRON',
		'L_NO_DEA_EMAILS_TEX'				=> 'Dominios de Emails “DED” recopilados mediante CRON',
		'L_NO_DEA_EMAILS_TEX_LOCAL'			=> 'Dominios de Emails “DED” recopilados de forma local',
		'L_NO_DEA_EMAILS_COUNTER'			=> 'Ejecución del CRON',
		'L_NO_DEA_EMAILS_TIMES'				=> 'Desde la instalación de la extensión, el CRON se ha ejecutado <strong>%s</strong> veces.',
		'L_NO_DEA_EMAILS_DATE'				=> 'Última ejecución del CRON',
		'L_NO_DEA_EMAILS_USERS'				=> 'Gestión de Usuarios con Cuentas de Correo Electrónico DED',
		'L_NO_DEA_EMAILS_TOT_USERS'			=> 'Total de Usuarios Registrados',
		'L_NO_DEA_EMAILS_TOT_USERS_EXPLAIN'	=> 'Incluidos Bots y usuarios inactivos.',
		'L_NO_DEA_EMAILS_DEA_USERS'			=> 'Total de Usuarios con Cuentas de Correo Electrónico DED',
		'L_NO_DEA_EMAILS_DOMAIN'			=> 'Dominio de Correo Electrónico Desechable',
		'L_NO_DEA_EMAILS_PLACE'				=> 'Introduzca un dominio de Correo Electrónico Desechable',
		'L_NO_DEA_EMAILS_ACTION'			=> 'Acción',
		'L_NO_DEA_EMAILS_SAVE'				=> 'Guardar',
		'L_NO_DEA_EMAILS_DEL'				=> 'Eliminar',
		'L_NO_DEA_EMAILS_DOM_SAVE'			=> 'Se ha GUARDADO correctamente el Dominio de Correo Electrónico DED: <strong>((%s))</strong>',
		'L_NO_DEA_EMAILS_DOM_DEL'			=> 'Se ha ELIMINADO correctamente el Dominio de Correo Electrónico DED: <strong>((%s))</strong>',
		'L_NO_DEA_EMAILS_DOM_VALID'			=> 'El Dominio de Correo Electrónico DED: <strong>((%s))</strong> no es válido.',
		'L_NO_DEA_EMAILS_DOM_LOCATE'		=> 'No se ha localizado el Dominio de Correo Electrónico DED: <strong>((%s))</strong>.',
		'L_NO_DEA_EMAILS_CANNOT_FOUNDER'	=> 'No tiene permitido eliminar las cuentas de fundadores.<br><br>El Usuario <strong>%s</strong> no puede ser eliminado.',
		'L_NO_DEA_EMAILS_CANNOT_YOURSELF'	=> 'No puede borrar su propia cuenta.',
		'L_NO_DEA_EMAILS_DEL_USERS'			=> 'Herramientas Básicas',
		'L_NO_DEA_EMAILS_DEL_USERS_EXPLAIN'	=> 'Por favor, tenga en cuenta que la eliminación de un usuario es final, no puede ser recuperado. Los mensajes privados enviados por el usuario sin leer, serán eliminados y no estarán disponibles para sus destinatarios.',
		'L_NO_DEA_EMAILS_FORCE_CHG_EMAIL'	=> 'Forzar cambio de “Correo Electrónico”',
		'L_NO_DEA_EMAILS_N_FORCE_CHG_EMAIL' => 'NO Forzar cambio de “Correo Electrónico”',
		'L_NO_DEA_EMAILS_SEND_PM'			=> 'Enviar Mensaje Privado',
		'L_NO_DEA_EMAILS_RETAIN_POSTS'		=> 'ELIMINAR USUARIO y Retener sus Mensajes',
		'L_NO_DEA_EMAILS_REMOVE_POSTS'		=> 'ELIMINAR USUARIO y Borrar sus Mensajes',
		'L_NO_DEA_EMAILS_NEED_ACTION'		=> 'Debe de seleccionar una “Herramienta Básica”.',
		'L_NO_DEA_EMAILS_NO_USERS'			=> 'No se han seleccionado Usuarios.',
		'L_NO_DEA_EMAILS_PERCENTAGE'		=> '<i>(%s &#37; del Total de Usuarios Registrados)</i>',
));
