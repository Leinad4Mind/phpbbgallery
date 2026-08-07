<?php
/**
 *
 * Advanced Polls [Spanish]
 *
 * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 * @author Translation by Raul [ThE KuKa] (https://github.com/phpbb-es)
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
	'AP_TITLE_ACP'					=> 'Encuestas Avanzadas',
	'AP_SETTINGS_ACP'				=> 'Configuración',

	'AP_TITLE'						=> 'Encuestas Avanzadas',
	'AP_TITLE_EXPLAIN'				=> 'Mejora el sistema de encuestas nativo de phpBB con nuevas posibilidades como ocultar votos hasta el final, mostrar los votantes de la encuesta, limitar los posibles votantes y más.',

	'AP_SETTINGS'					=> 'Configuración de Encuestas Avanzadas',
	'AP_GLOBAL_SETTINGS'			=> 'Configuración Global de Encuestas Avanzadas (aplicables a todas las encuestas)',
	'AP_PER_POLL_SETTINGS'			=> 'Configuración Por Encuesta de Encuestas Avanzadas (seleccionables por encuesta, con los valores por defecto indicados aquí)',
	'AP_DEFAULT_POLL_VISIBILITY' => 'Visibilidad predeterminada de los resultados',
	'AP_DEFAULT_POLL_VISIBILITY_EXPLAIN' => 'Modo de visibilidad seleccionado inicialmente al crear una encuesta.',
	'AP_DEFAULT_POLL_VOTE_MODE' => 'Modo predeterminado de cambio de voto',
	'AP_DEFAULT_POLL_VOTE_MODE_EXPLAIN' => 'Modo de cambio de voto seleccionado inicialmente al crear una encuesta.',
	'AP_VISIBILITY_PUBLIC' => 'Pública — mostrar siempre los resultados',
	'AP_VISIBILITY_DEFAULT' => 'Después del primer voto',
	'AP_VISIBILITY_VOTE_COMPLETED' => 'Después de usar todos los votos disponibles',
	'AP_VISIBILITY_PRIVATE' => 'Privada — solo después de finalizar la encuesta',
	'AP_VOTE_MODE_NO_CHANGE' => 'Sin cambios',
	'AP_VOTE_MODE_INCREMENTAL' => 'Votación incremental',
	'AP_VOTE_MODE_CHANGE' => 'Permitir cambios',
	'AP_DEFAULT_SCORE_RESULT' => 'Resultado de puntuación predeterminado',
	'AP_DEFAULT_SCORE_RESULT_EXPLAIN' => 'Selecciona si las nuevas encuestas de puntuación numérica muestran inicialmente los puntos acumulados o la media aritmética de cada opción.',
	'AP_DEFAULT_SHOW_PERCENT' => 'Mostrar porcentajes de forma predeterminada',
	'AP_DEFAULT_SHOW_PERCENT_EXPLAIN' => 'Visibilidad inicial del porcentaje para las nuevas encuestas de puntuación numérica.',
	'AP_SCORE_RESULT_TOTAL' => 'Puntos acumulados',
	'AP_SCORE_RESULT_AVERAGE' => 'Valoración media',

	'AP_ACT_VOTES_HIDE'				=> 'Activar votos ocultos',
	'AP_ACT_VOTES_HIDE_EXPLAIN'		=> 'Activa la opción de que los votos de la encuesta estén ocultos hasta que termine la encuesta.',
	'AP_ACT_VOTERS_SHOW'			=> 'Activar mostrar votantes',
	'AP_ACT_VOTERS_SHOW_EXPLAIN'	=> 'Activa la opción de que se muestren los votantes de cada opción de la encuesta.',
	'AP_ACT_VOTERS_LIMIT'			=> 'Activar limitar votos',
	'AP_ACT_VOTERS_LIMIT_EXPLAIN'	=> 'Activa la opción de limitar los votantes para una encuesta a los usuarios que ya han escrito en ese tema.',
	'AP_ACT_POLL_NO_VOTE'			=> 'Activar no votar',
	'AP_ACT_POLL_NO_VOTE_EXPLAIN'	=> 'Cambia el enlace "Mostrar resultados" por un enlace "No quiero votar", que no permite votar después de ver los resultados a menos que "Cambiar el voto" esté seleccionado.',
	'AP_ACT_SHOW_ABSTAINERS' => 'Mostrar el número de abstenciones',
	'AP_ACT_SHOW_ABSTAINERS_EXPLAIN' => 'Muestra cuántos usuarios registrados decidieron explícitamente no votar. Los nombres solo aparecen cuando está activa la lista de votantes y el usuario tiene permiso.',
	'AP_ACT_VOTE_DELETE' => 'Permitir eliminar el voto',
	'AP_ACT_VOTE_DELETE_EXPLAIN' => 'Permite a los usuarios registrados eliminar su propio voto mientras la encuesta esté abierta y admita cambios.',
	'AP_ACT_SHOW_ORDERED'			=> 'Activar ordenación',
	'AP_ACT_SHOW_ORDERED_EXPLAIN'	=> 'Activa la opción de mostrar los resultados por orden descendente de votos recibidos (el más votado primero).',
	'AP_ACT_POLL_SCORING'			=> 'Activar encuestas puntuables',
	'AP_ACT_POLL_SCORING_EXPLAIN'	=> 'Activa la posibilidad de asignar diferentes puntuaciones a las opciones de la encuesta.',
	'AP_ACT_INCREMENTAL_VOTES'		=> 'Activar voto incremental',
	'AP_ACT_INCREMENTAL_VOTES_EXPLAIN'	=> 'Activa la posibilidad de votar incrementalmente, mientras no se hayan emitido todos los votos disponibles.',
	'AP_ACT_CLOSED_VOTING'			=> 'Activar voto en temas cerrados',
	'AP_ACT_CLOSED_VOTING_EXPLAIN'	=> 'Activa la posibilidad de votar en encuestas abiertas incluse cuando el tema correspondiente está cerrado.',
	'AP_ACT_POLL_END'				=> 'Activar final de encuesta',
	'AP_ACT_POLL_END_EXPLAIN'		=> 'Permite especificar cuando termina una encuesta en fecha y hora, en lugar de especificar tan solo una duración a partir del inicio de la encuesta.',
	'AP_ACT_POLL_NOTIFICATIONS'				=> 'Activar notificaciones de encuestas',
	'AP_ACT_POLL_NOTIFICATIONS_EXPLAIN'		=> 'Activa las notificaciones cuando se hacen visibles los resultados de una encuesta oculta y cuando se añaden nuevas opciones a una encuesta en la que ha votado un usuario.',
	'AP_ACT_POLL_COLLAPSIBLE'				=> 'Activar encuestas contraíbles',
	'AP_ACT_POLL_COLLAPSIBLE_EXPLAIN'		=> 'Muestra la opción contraíble al crear o editar una encuesta. Durante la instalación, esta opción se activa automáticamente si está instalada «Collapsible Forum Categories»; los administradores siempre pueden cambiarla.',
	'AP_SHOW_POLL_LIST_NAVBAR' => 'Mostrar el enlace de encuestas en la barra de navegación',
	'AP_SHOW_POLL_LIST_NAVBAR_EXPLAIN' => 'Añade un enlace a la lista de encuestas accesibles en la barra de navegación del foro.',

	'AP_DEFAULT_VOTES_CHANGE'		=> 'Valor por defecto para cambiar el voto',
	'AP_DEFAULT_VOTES_HIDE'			=> 'Valor por defecto para votos ocultos',
	'AP_DEFAULT_VOTERS_SHOW'		=> 'Valor por defecto para mostrar votantes',
	'AP_DEFAULT_VOTERS_LIMIT'		=> 'Valor por defecto para limitar votos',
	'AP_DEFAULT_SHOW_ORDERED'		=> 'Valor por defecto para ordenación',

	'AP_ENABLE_NOTICE' => '<br /><br /><div class="phpinfo"><p><strong>Próximos pasos</strong></p><ol><li>Revisa la configuración de la extensión en <strong>%1$s » %2$s » %3$s</strong> y configura las funciones y los valores predeterminados que necesite tu foro.</li><li>Revisa los permisos <strong>%8$s</strong> y <strong>%9$s</strong> en <strong>%4$s » %5$s » %6$s</strong> (miembros) y <strong>%4$s » %5$s » %7$s</strong> (moderadores). Concédelos solo a los roles o grupos que puedan ver la identidad de los votantes.</li></ol><p>Las demás funciones de las encuestas no necesitan configuración adicional.</p></div>',
]);
