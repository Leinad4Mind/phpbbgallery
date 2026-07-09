<?php
/**
*
* HTML email extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 ForumHulp.com <http://forumhulp.com>
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
//
// Some characters you may want to copy&paste:
// ’ « » “ ” …
//

$lang = array_merge($lang, array(
	'FH_HELPER_NOTICE'		=> '¡La aplicación Forumhulp helper no existe!<br />Descargar <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> y copie la carpeta helper dentro de la carpeta de extensión forumhulp.',
	'HTML_EMAIL_NOTICE'			=> '<div class="phpinfo"><p class="entry">Los ajustes de está extensión no son necesarios.<br />Puede usarlo para correo electrónico en la extensión de cumpleaños activando "Usar HTML en email" en PCA - Características del Sitio. Si quiere usar HTML en otros correos, tiene que dejar saber a messenger que debe enviar correos electrónicos en HTML, puede configurar messenger con $messenger->set_mail_html(true). Actualice sus plantillas de correo como quiera.</p></div>',
	'DELETE_DATA_NOTICE'		=> '<div style="width:80%;margin:20px auto;"><p style="text-align:left;">¡ No todos los archivos se reemplazaron ! Por favor, reemplace a mano los archivos mencionados en el Registro de Administrador</p></div>',
	'ENABLE_DATA_NOTICE'		=> '<div style="width:80%;margin:20px auto;"><p style="text-align:left;"><br />Sin embargo, no todas las actualizaciones se realizan correctamente debido a los permisos de archivos o archivos perdidos. Consulte el Registro de Administrador para obtener una visión general.<br /><br />¡ Por favor, actualice los archivos a mano para disfrutar de todas las funciones !</p></div>'
));
