<?php

/**
 *
 * Special Activity Stats. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
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
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, [
	'SPECIAL_ACTIVITY_STATS_INSTALLED' => 'Installed Version: v%s',

	'SPECIAL_ACTIVITY_STATS_TITLE'    => 'Estadísticas de actividad',
	'SPECIAL_ACTIVITY_STATS_DISP_SET' => 'Ajustes de pantalla',
	'SPECIAL_ACTIVITY_STATS_OTHER'    => 'Otros ajustes',

	// acp form
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_TOPICS'     => 'Mostrar nuevos temas',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_TOPICS_EXP' => 'Muestra la cantidad de nuevos temas',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_POSTS'      => 'Mostrar nuevos mensajes',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_POSTS_EXP'  => 'Muestra la cantidad de nuevos mensajes',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_USERS'      => 'Mostrar nuevos usuarios',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_USERS_EXP'  => 'Muestra la cantidad de nuevos usuarios',

	'SPECIAL_ACTIVITY_STATS_DISP_BOTS'        => 'Mostrar robots',
	'SPECIAL_ACTIVITY_STATS_DISP_BOTS_EXP'    => 'Algunos usuarios podrían preguntarse qué son los robots y les temen.',
	'SPECIAL_ACTIVITY_STATS_DISP_GUESTS'      => 'Mostrar invitados',
	'SPECIAL_ACTIVITY_STATS_DISP_GUESTS_EXP'  => '¿Mostrar invitados en el contador?',
	'SPECIAL_ACTIVITY_STATS_DISP_HIDDEN'      => 'Mostrar usuarios ocultos',
	'SPECIAL_ACTIVITY_STATS_DISP_HIDDEN_EXP'  => '¿Si el usuario esta oculto, será mostrado en la lista? (permisos necesarios)',
	'SPECIAL_ACTIVITY_STATS_DISP_TIME'        => 'Mostrar hora',
	'SPECIAL_ACTIVITY_STATS_DISP_TIME_EXP'    => 'Ver todos los usuarios o ninguno. Sin función especial para Administradores.',
	'SPECIAL_ACTIVITY_STATS_DISP_TIME_FORMAT' => 'Formato de hora',
	'SPECIAL_ACTIVITY_STATS_DISP_HOVER'       => 'Mostrar en hover (suspendido)',
	'SPECIAL_ACTIVITY_STATS_DISP_IP'          => 'Mostrar IP de usuario',
	'SPECIAL_ACTIVITY_STATS_DISP_IP_EXP'      => 'Sólo para los usuarios con permisos administrativos, como en el viewonline.php',

	'SPECIAL_ACTIVITY_STATS_RECORD'            => 'Registro',
	'SPECIAL_ACTIVITY_STATS_RECORD_EXP'        => 'Mostrar y guardar el registro',
	'SPECIAL_ACTIVITY_STATS_RECORD_TIMEFORMAT' => 'Formato de fecha del registro',
	'SPECIAL_ACTIVITY_STATS_RESET'             => 'Resetear registro',
	'SPECIAL_ACTIVITY_STATS_RESET_EXP'         => 'Restablece el contador de tiempo y del registro de actividades estadísticas.',
	'SPECIAL_ACTIVITY_STATS_RESET_TRUE'        => 'Si envia este formulario, el registro será reseteado.',


	'SPECIAL_ACTIVITY_STATS_SETTINGS_SAVED' => 'Configuración actualizada correctamente.',
	'SPECIAL_ACTIVITY_STATS_SORT_BY'        => 'Ordenar los usuarios por',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_EXP'    => '¿En qué orden se mostrará al usuario?',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_0'      => 'Nombre de usuario A -> Z',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_1'      => 'Nombre de usuario Z -> A',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_2'      => 'Tiempo de visita ascendente',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_3'      => 'Tiempo de visita descendente',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_4'      => 'Usuario-ID ascendente',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_5'      => 'Usuario-ID descendiente',

	'SPECIAL_ACTIVITY_STATS_CACHE_TIME'     => 'Tiempo de cache (segundos)',
	'SPECIAL_ACTIVITY_STATS_CACHE_TIME_EXP' => 'Período en el que no se volverá a calcular los datos (mejora el rendimiento)',

	'SPECIAL_ACTIVITY_STATS_CHECK_PERMISSIONS'     => 'Comprobar permisos',
	'SPECIAL_ACTIVITY_STATS_CHECK_PERMISSIONS_EXP' => 'No=Todos verán las estadísticas de actividad (ignorar los ajustes de permisos); Si=Usar permisos configurados (por ejemplo, permitir sólo para usuarios registrados: ACP -> Permisos -> Permisos Globales -> Permisos de grupos -> Usuarios registrados -> Permisos avanzados -> Varios -> "Puede ver las estadísticas de actividad")',

	'SPECIAL_ACTIVITY_STATS_MODE'             => 'Viendo usuarios de ...',
	'SPECIAL_ACTIVITY_STATS_MODE_EXP'         => 'Viendo usuarios de hoy, o el plazo fijado en la siguiente opción.',
	'SPECIAL_ACTIVITY_STATS_MODE_TODAY'       => 'Hoy',
	'SPECIAL_ACTIVITY_STATS_MODE_PERIOD'      => 'Período de tiempo',
	'SPECIAL_ACTIVITY_STATS_MODE_PERIOD_EXP'  => 'tipo 0, si desea mostrar a los usuarios de las últimas 24h',
	'SPECIAL_ACTIVITY_STATS_MODE_PERIOD_EXP2' => 'deshabilitado, si ha elegido "Hoy"',
	'SPECIAL_ACTIVITY_STATS_MODE_PERIOD_EXP3' => 'segundos',

]);
