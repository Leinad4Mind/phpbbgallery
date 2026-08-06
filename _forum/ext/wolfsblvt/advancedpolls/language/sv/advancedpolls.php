<?php
/**
 *
 * Advanced Polls [Swedish]
 *
 * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 * Swedish translation by Holger (http://www.maskinisten.net)
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
//6
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
	'ADVANCEDPOLLS_EXT_NAME'				=> 'Avancerade omröstningar',

// Viewtopic
	'AP_VOTES_HIDDEN'						=> 'Omröstningar dolda',
	'AP_POLL_RUN_TILL_APPEND'				=> 'Alla omröstningar döljs fram till denna tidpunkt.',
	'AP_VOTERS'								=> 'Medlemmar som har röstat',
	'AP_NONE'								=> 'Inga',
	'AP_DELETED_USER'					=> 'Borttagen användare',

	'AP_POLL_CANT_VOTE'						=> 'Du kan ej rösta. Orsak',
	'AP_POLL_REASON_NOT_POSTED'				=> 'du har ej skrivit något inlägg i denna tråd.',
	'AP_POLL_VOTES_ARE_VISIBLE'				=> 'Beakta att ditt medlemsnamn kommer att visas vid ditt val i resultatet.',
	'AP_POLL_DONT_VOTE_SHOW_RESULTS'		=> 'Rösta ej, visa resultat',
	'AP_POLL_RESULTS_ARE_ORDERED' => 'Observera att resultaten sorteras efter fallande antal mottagna röster.',
	'AP_POLL_TYPE_MISMATCH' => 'Inkonsistenta omröstningsdata, internt fel.',
	'AP_VOTE_CHANGED' => 'Du har inte behörighet att ändra dina avgivna röster.',
	'AP_TOO_MANY_VOTES' => 'Du har försökt tilldela för många röster.',
	'AP_ABSTAINERS' => 'Valde att inte rösta',
	'AP_DELETE_VOTE' => 'Ta bort min röst',

	'AP_MAX_VOTES_SELECT' => [
		1 => 'Du kan ge upp till <strong>%2$d</strong> röster till <strong>%1$d</strong> alternativ',
		2 => 'Du kan fördela upp till <strong>%2$d</strong> röster mellan <strong>%1$d</strong> alternativ',
	],
	'AP_GUEST_VOTES' => [
		1 => '%d röst från en gäst',
		2 => '%d röster från gäster',
	],
	'AP_SCORE_TOTAL' => [
		1 => '%d röst',
		2 => '%d röster',
	],
	'AP_SCORE_BREAKDOWN' => 'Röstfördelning',
	'AP_SCORE_DISTRIBUTION_ENTRY' => [
		1 => '%1$d röst med %2$d poäng',
		2 => '%1$d röster med %2$d poäng',
	],
	'AP_RANK_TOTAL' => [1 => '%d poäng', 2 => '%d poäng'],
	'AP_RANK_BREAKDOWN' => 'Rangordningsfördelning',
	'AP_RANK_DISTRIBUTION_ENTRY' => [1 => '%1$d röst på position %2$d', 2 => '%1$d röster på position %2$d'],
	'AP_RANK_SELECT_EXACTLY' => [
		1 => 'Välj exakt %d alternativ i önskad ordning.',
		2 => 'Välj exakt %d alternativ i önskad ordning.',
	],
// Posting
	'AP_POLL_TYPE' => 'Omröstningstyp',
	'AP_POLL_TYPE_EXPLAIN' => 'Välj hur användarna tilldelar sina röster eller poäng.',
	'AP_POLL_TYPE_CHOICE' => 'Val',
	'AP_POLL_TYPE_SCORING' => 'Numerisk poängsättning',
	'AP_POLL_TYPE_RANKING' => 'Ordnad rangordning',
	'AP_POLL_VISIBILITY' => 'Resultatens synlighet',
	'AP_POLL_VISIBILITY_EXPLAIN' => 'Välj när omröstningens sammanlagda resultat ska bli synliga.',
	'AP_VISIBILITY_PUBLIC' => 'Offentlig — visa alltid resultaten',
	'AP_VISIBILITY_DEFAULT' => 'Efter den första rösten',
	'AP_VISIBILITY_VOTE_COMPLETED' => 'När alla tillgängliga röster har använts',
	'AP_VISIBILITY_PRIVATE' => 'Privat — först när omröstningen är avslutad',
	'AP_POLL_VOTE_MODE' => 'Ändring av röster',
	'AP_POLL_VOTE_MODE_EXPLAIN' => 'Välj om röster är slutgiltiga, kan lämnas stegvis eller ändras medan omröstningen är öppen.',
	'AP_VOTE_MODE_NO_CHANGE' => 'Inga ändringar',
	'AP_VOTE_MODE_INCREMENTAL' => 'Stegvis röstning',
	'AP_VOTE_MODE_CHANGE' => 'Tillåt ändringar',
	'AP_POLL_VOTES_HIDE'					=> 'Dölj omröstningen',
	'AP_POLL_VOTES_HIDE_EXPLAIN'			=> 'Om denna inställning aktiveras så döljs resultatet tills omröstningen har avslutats.<br />Denna inställning fungerar endast om ett slutdatum har ställts in för omröstningen.',
	'AP_POLL_VOTERS_SHOW'					=> 'Visa medlemmar som har röstat',
	'AP_POLL_VOTERS_SHOW_EXPLAIN'			=> 'Om denna inställning aktiveras så visas medlemsnamnet under motsvarande röst för alla med motsvarande behörighet.<br />Beakta att detta döljs om omröstningen är dold.',
	'AP_POLL_VOTERS_LIMIT'					=> 'Inlägg förutsätts',
	'AP_POLL_VOTERS_LIMIT_EXPLAIN'			=> 'Om denna inställning aktiveras så kan endast medlemmar rösta som har skrivit ett inlägg i tråden.',
	'AP_POLL_SHOW_ORDERED' => 'Visa sorterade resultat',
	'AP_POLL_SHOW_ORDERED_EXPLAIN' => 'När resultaten visas sorteras de efter fallande antal röster. Annars används alternativens ursprungliga ordning.',
	'AP_RUN_POLL' => 'Kör omröstningen',
	'AP_RUN_POLL_FOR' => 'i',
	'AP_RUN_POLL_UNTIL' => 'till',
	'AP_RUN_POLL_INDEFINITELY' => 'utan slutdatum',
	'AP_POLL_END' => 'Omröstningens slut',
	'AP_POLL_END_EXPLAIN' => 'Ange datum och tid då omröstningen avslutas. Om något av dessa fält anges ersätter det omröstningens längd. Tomma datumfält använder aktuellt slutdatum och tomma tidsfält använder 0. Rensa alla fält för att återgå till att använda omröstningens längd.',

	'AP_YYYY_MM_DD' => 'ÅÅÅÅ-MM-DD',
	'AP_HH_MM' => 'TT:MM',
	'AP_POLL_END_INVALID' => 'Angivet datum eller klockslag är ogiltigt',
	'AP_POLL_TOTAL_LOWER_MAX_VOTES' => 'Det högsta antalet röster för ett alternativ får inte överstiga det totala antalet röster som kan fördelas',
	'AP_POLL_TOTAL_LOWER_MAX_OPTS' => 'Det högsta antalet valbara alternativ får inte överstiga det totala antalet röster som kan fördelas',

	'AP_POLL_MAX_VALUE' => 'Högsta antal röster',
	'AP_POLL_MAX_VALUE_EXPLAIN' => 'Det högsta antal röster som en användare kan ge till ett enskilt alternativ.',
	'AP_POLL_TOTAL_VALUE' => 'Totalt antal röster',
	'AP_POLL_TOTAL_VALUE_EXPLAIN' => 'Det totala antal röster som en användare kan fördela mellan alla alternativ.',

	'AP_RANK_POINTS' => 'Poäng per position',
	'AP_RANK_POINTS_EXPLAIN' => 'Ange ett positivt, minskande poängvärde för varje position. Antalet positioner styrs av det högsta antalet alternativ per användare.',
	'AP_RANK_POSITION' => 'Position %d',

	'AP_VOTE_GREATER_THAN_MAXVALUE' => 'Du kan inte tilldela fler röster än det högsta tillåtna värdet.',
	'AP_POLL_VALUES_INVALID' => 'Högsta antal alternativ, högsta poäng och totalpoäng måste vara större än noll.',
	'AP_RANK_POSITIONS_INVALID' => 'Antalet positioner måste vara mellan 1 och antalet omröstningsalternativ.',
	'AP_RANK_POINTS_INCOMPLETE' => 'Ange ett poängvärde för varje position.',
	'AP_RANK_POINTS_INVALID' => 'Varje poängvärde måste vara mellan 1 och 999.',
	'AP_RANK_POINTS_ORDER' => 'Poängen måste minska strikt från den första till den sista positionen.',
	'AP_RANK_INCREMENTAL_UNSUPPORTED' => 'Inkrementell röstning kan inte användas med ordnad rangordning.',
	'AP_RANK_SELECTION_INCOMPLETE' => 'Välj exakt det inställda antalet alternativ i önskad ordning.',
]);
