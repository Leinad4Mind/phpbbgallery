<?php

/**
 * French translation by Galixte (http://www.galixte.com)
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
	'ACP_CRON_STATUS_TITLE'        => 'Statut du Cron',
	'ACP_CRON_STATUS_CONFIG_TITLE' => 'Vérifier le statut du Cron',
	'CRONSTAT_NOTICE'              => '<div class="phpinfo"><p>Cette extension est disponible depuis la page : %1$s » %2$s » %3$s.</p></div>',
	'CRONSTAT_UNLOCKED'            => 'Verrou du Cron réinitialisé.',
]);

// Description of Cron Status extension
$lang = array_merge($lang, [
	'DESCRIPTION_PAGE'   => 'Description',
	'DESCRIPTION_NOTICE' => 'Informations sur l’extension',
	'ext_details'        => [
		'details' => [
			'DESCRIPTION_1' => 'Vue d’ensemble des tâches du Cron (avec tri).',
			'DESCRIPTION_2' => 'Affichage du statut de chaque tâche du Cron.',
			'DESCRIPTION_3' => 'Exécution de n’importe quelle tâche disponible maintenant, ou de toutes en une fois.',
			'DESCRIPTION_4' => 'Réinitialisation du verrouillage du Cron en un clic.',
		],
		'note' => [
			'NOTICE_1' => 'Notification sur le statut du Cron (optionnelle).',
			'NOTICE_2' => 'Peut être désactivée depuis la page « Configuration du forum ».',
			'NOTICE_3' => 'Permet d’exécuter le Cron plus souvent, y compris pour les robots.',
			'NOTICE_4' => 'Compatible avec phpBB 3.3.x.',
		],
	],
]);
