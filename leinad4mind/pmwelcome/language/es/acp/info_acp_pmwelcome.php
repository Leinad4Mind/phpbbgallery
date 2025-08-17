<?php

/**
 *
 * @package PM Welcome
 * @copyright (c) 2015 Anvar
 * @copyright (c) 2020 RMcGirr83
 * @copyright (c) 2019-2022 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

if (!defined('IN_PHPBB')) {
   exit;
}
if (empty($lang) || !is_array($lang)) {
   $lang = [];
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
// Some characters for use
// ’ » “ ” …


$lang = array_merge($lang, [
   // General config options
   'ACP_PMWELCOME'               => 'Mensaje privado de bienvenida',
   'ACP_PMWELCOME_EXPLAIN'         => 'Puede especificar el texto del mensaje personal que será enviado al usuario en el momento que se inscriba.',
   'ACP_PMWELCOME_SETTINGS'      => 'Configuraciones del mensaje de bienvenida.',
   'ACP_PMWELCOME_USER'         => 'Remitente',
   'ACP_PMWELCOME_USER_EXPLAIN'   => 'El ID del usuario del foro quien enviara el mensaje privado.',
   'ACP_PMWELCOME_SUBJECT'         => 'Asunto del mensaje de bienvenida',
   'ACP_PMWELCOME_SUBJECT_SHORT'         => 'Asunto ',
   'ACP_PMWELCOME_TEXT'         => 'Texto del mensaje de bienvenida',
   'ACP_PMWELCOME_TEXT_SHORT'         => 'Texto',
   'ACP_PMWELCOME_TEXT_EXPLAIN'   => 'Puede usar BBCode y emoticonos, o {USERNAME} para reemplazar el nombre del usuario que recibe un mensaje privado, {USER_EMAIL} para reemplazar el email del usuario que recibe un mensaje privado, {SITE_NAME} y {SITE_DESC} para reemplazar el nombre y descripción de su foro, {BOARD_CONTACT}, {BOARD_EMAIL} y {BOARD_SIG} para reemplazar el contacto, correo electrónico y firma de su foro, así como {SENDER} para insertar el nombre del remitente.',
   'ACP_PMWELCOME_PREVIEW'         => 'Texto del MP de bienvenida - Vista Previa',
   'ACP_PMWELCOME_NO_USER'         => '<b>El remitente solicitado no existe</b>',
   'ACP_PMWELCOME_CONFIG_SAVED'   => 'Configuración del MP de bienvenida guardado',
   'TOO_SHORT_PMWELCOME_SUBJECT'   => 'El valor del tema de bienvenida es demasiado corto',
   'TOO_SHORT_PMWELCOME_POST_TEXT'   => 'El valor del Texto del mensaje de bienvenida es demasiado corto',
   // Log entries
   'LOG_CONFIG_PMWELCOME_ADMIN'      => '<strong>Ajustes cambiados de la página de la extensión Mensaje privado de bienvenida</strong>',
   'LOG_PMWELCOME_CONFIG_UPDATE'      => '<strong>Ajustes actualizados de Mensaje privado de bienvenida</strong>',
]);