<?php

/**
 * @package   Cron Status
 * @author    John Peskens, Igor Lavrov, Leinad4Mind
 * @copyright (c) 2014 - 2021 John Peskens, Igor Lavrov | (c) 2022-2026 Leinad4Mind
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
// ’ « » “ ” …
//

$lang = array_merge($lang, [
	'ACP_CRON_STATUS_TITLE'        => 'Estado del Cron',
	'ACP_CRON_STATUS_CONFIG_TITLE' => 'Comprobar estado del Cron',
	'CRONSTAT_NOTICE'              => '<div class="phpinfo"><p>Esta extensión reside en %1$s » %2$s » %3$s.</p></div>',
	'CRONSTAT_UNLOCKED'            => 'Bloqueo de cron reiniciado.',
]);

// Description of Cron Status extension
$lang = array_merge($lang, [
	'DESCRIPTION_PAGE'   => 'Descripción',
	'DESCRIPTION_NOTICE' => 'Nota de la extensión',
	'ext_details'        => [
		'details' => [
			'DESCRIPTION_1' => 'Visión general de trabajos Cron (con clasificación)',
			'DESCRIPTION_2' => 'Muestra el estado de cada tarea Cron',
			'DESCRIPTION_3' => 'Ejecute cualquier tarea preparada ahora, o ejecute todas a la vez',
			'DESCRIPTION_4' => 'Restablecer cronlock con un simple clic',
		],
		'note' => [
			'NOTICE_1' => 'Noticia de Estado Cron (opcional)',
			'NOTICE_2' => 'Puede apagar esta opción en los Ajustes del Foro',
			'NOTICE_3' => 'Opción "Ejecutar cron siempre" conmutable para tráfico de robots',
			'NOTICE_4' => 'Preparado para phpBB 3.3',
		],
	],
]);
