<?php
/**
 *
 * CF Change Post Time
 *
 * @copyright (c) 2024 chris1278
 * @copyright (c) 2015 javiexin ( www.exincastillos.es )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Javier Lopez (javiexin)
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
	'CF_CPT_TITLE_EXPLAIN'		=> 'Hier auf der Seite kannst du die Einstellung für die Begrenzung festlegen. Im Normalfall ist die Eingabe eines Zeit-Formates, das in der Zukunft liegt, gesperrt. Das hat den Hintergrund, dass, wenn man einen Beitrag so ändert, dass dieser ein zukünftiges Datum hat, der Beitrag für die Benutzer immer als ungelesener Beitrag markiert wird. Selbst wenn der Benutzer den Beitrag gelesen hat oder wenn der Benutzer die Option benutzt „Alle Foren als gelesen markieren“. Der Beitrag wird solange als ungelesen angezeigt, bis das aktuelle Datum höher ist als das des Beitrages. Daher wird davon abgeraten. Allerdings kann es Probleme mit dem Ändern geben in Bezug auf die Zeitzonen. Daher habe ich hier einige Optionen mit eingebunden.',
	'CF_CPT_INFO_TITLE'			=> 'Erklärung der nachfolgenden Optionsauswahl!',
	'CF_CPT_OPTION_1_EXPLAIN'	=> 'Hier wie gehabt. Die Datumsgrenze wird einfach mittels der PHP-Funktion <b>date(\'Y-m-d\')</b> ermittelt und verwendet. So wie es bisher der Fall war.',
	'CF_CPT_OPTION_2_EXPLAIN'	=> 'Bei dieser Option wird die Zeitzone des Moderators berücksichtigt, die er eingestellt hat.',
	'CF_CPT_OPTION_3_EXPLAIN'	=> 'Hier wird die Zeitzone des Forums berücksichtigt. Unabhängig davon, welche Zeitzone der Moderator eingestellt hat.',
	'CF_CPT_OPTION_4_EXPLAIN'	=> 'Bei dieser Option wird einfach mittels der Standard-PHP-Funktion <b>date(\'Y-m-d\')</b> ein Tag zusätzlich erhöht.',
	'CF_CPT_OPTION_5_EXPLAIN'	=> 'Diese Option deaktiviert die Begrenzung komplett. <b>Wird</b> <b style="color: red">nicht </b> <b>empfohlen!</b>',
	'CF_CPT_NAME'				=> 'Optionsauswahl',
	'CF_CPT_OPTION'				=> 'Optionen',
	'CF_CPT_OPTION_EXPLAIN'		=> 'Hier kannst du die gewünschte Option auswählen.<br><br>Erklärungen dazu finden sich im Kopfbereich dieser Seite.<br><br><b>Standard:</b> Option Nr. 1',
	'CF_CPT_OPTION_1'			=> 'Option Nr. 1',
	'CF_CPT_OPTION_2'			=> 'Option Nr. 2',
	'CF_CPT_OPTION_3'			=> 'Option Nr. 3',
	'CF_CPT_OPTION_4'			=> 'Option Nr. 4',
	'CF_CPT_OPTION_5'			=> 'Option Nr. 5',
	'CF_CPT_SETTING_SAVED'		=> 'Die ausgewählte Option wurde erfolgreich gespeichert!',
]);
