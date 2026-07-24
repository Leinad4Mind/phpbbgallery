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
	'ACP_CRON_STATUS_TITLE'        => 'Cron Status',
	'ACP_CRON_STATUS_CONFIG_TITLE' => 'Controleer Cron Status',
	'CRONSTAT_NOTICE'              => '<div class="phpinfo"><p>Deze extensie bevindt zich in %1$s » %2$s » %3$s.</p></div>',
	'CRONSTAT_UNLOCKED'            => 'Cron-vergrendeling gereset.',
]);

// Description of Cron Status extension
$lang = array_merge($lang, [
	'DESCRIPTION_PAGE'   => 'Beschrijving',
	'DESCRIPTION_NOTICE' => 'Opmerking bij de extensie',
	'ext_details'        => [
		'details' => [
			'DESCRIPTION_1' => 'Overzicht van taken (met sortering)',
			'DESCRIPTION_2' => 'Toon de status van iedere taak',
			'DESCRIPTION_3' => 'Start een taak manueel',
			'DESCRIPTION_4' => 'Reset de cron-vergrendeling met één klik',
		],
		'note' => [
			'NOTICE_1' => 'Cron Status Melding (optioneel)',
			'NOTICE_2' => 'Instelbaar in Forum instellingen',
			'NOTICE_3' => 'Optie "Cron altijd uitvoeren" instelbaar voor bots',
			'NOTICE_4' => 'Klaar voor phpBB 3.3',
		],
	],
]);
