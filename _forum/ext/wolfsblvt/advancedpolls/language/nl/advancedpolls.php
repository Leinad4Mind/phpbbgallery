<?php
/**
 *
 * Advanced Polls [Dutch]
 *
 * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 * @author Translation by Beun12 (https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1466206), </Solidjeuh> (https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1544706) and dvoijen (https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1947676)
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
	'ADVANCEDPOLLS_EXT_NAME'				=> 'Geavanceerde Peilingen',

// Viewtopic
	'AP_VOTES_HIDDEN'						=> 'Stemmen verbergen',
	'AP_POLL_RUN_TILL_APPEND'				=> ', tot, dan alle stemmen verbergen.',
	'AP_VOTERS'								=> 'Stemmers',
	'AP_NONE'								=> 'Geen',
	'AP_DELETED_USER'					=> 'Verwijderde gebruiker',

	'AP_POLL_CANT_VOTE'						=> 'U kunt op deze vraag niet stemmen omdat',
	'AP_POLL_REASON_NOT_POSTED'				=> 'U heeft in dit onderwerp niets geschreven.',
	'AP_POLL_VOTES_ARE_VISIBLE'				=> 'Denk eraan dat wanneer u stemt uw stem zichtbaar wordt',
	'AP_POLL_DONT_VOTE_SHOW_RESULTS'		=> 'Resultaten tonen zonder te stemmen',
	'AP_POLL_RESULTS_ARE_ORDERED'			=> 'Let op dat de resultaten in aflopende volgorde worden weergegeven op basis van de ontvangen stemmen.',
	'AP_POLL_TYPE_MISMATCH'					=> 'Inconsistente peiling gegevens, interne fout.',
	'AP_VOTE_CHANGED'						=> 'U hoeft geen rechten om uw uitgebrachte stemmen te veranderen.',
	'AP_TOO_MANY_VOTES'						=> 'U heeft geprobeerd om te veel te stemmen.',
	'AP_ABSTAINERS' => 'Hebben ervoor gekozen niet te stemmen',
	'AP_DELETE_VOTE' => 'Mijn stem verwijderen',

	'AP_MAX_VOTES_SELECT'	=> [
		1	=> 'U mag tot <strong>%2$d</strong> opties kiezen bij <strong>%1$d</strong> stemmen',
		2	=> 'U mag tot <strong>%2$d</strong> opties kiezen onder <strong>%1$d</strong> stemmen',
	],
	'AP_GUEST_VOTES'	=> [
		1	=> '%d stem van een gast',
		2	=> '%d stemmen van gasten',
	],
	'AP_SCORE_TOTAL' => [
		1 => '%d stem',
		2 => '%d stemmen',
	],
	'AP_SCORE_BREAKDOWN' => 'Stemverdeling',
	'AP_SCORE_DISTRIBUTION_ENTRY' => [
		1 => '%1$d stem van %2$d punt',
		2 => '%1$d stemmen van %2$d punten',
	],
	'AP_RANK_TOTAL' => [1 => '%d punt', 2 => '%d punten'],
	'AP_RANK_BREAKDOWN' => 'Rangschikkingsverdeling',
	'AP_RANK_DISTRIBUTION_ENTRY' => [1 => '%1$d stem op positie %2$d', 2 => '%1$d stemmen op positie %2$d'],
	'AP_RANK_SELECT_EXACTLY' => [
		1 => 'Selecteer precies %d optie in volgorde van voorkeur.',
		2 => 'Selecteer precies %d opties in volgorde van voorkeur.',
	],
// Posting
	'AP_POLL_TYPE' => 'Peilingtype',
	'AP_POLL_TYPE_EXPLAIN' => 'Kies hoe gebruikers hun stemmen of punten toekennen.',
	'AP_POLL_TYPE_CHOICE' => 'Keuze',
	'AP_POLL_TYPE_SCORING' => 'Numerieke score',
	'AP_POLL_TYPE_RANKING' => 'Geordende rangschikking',
	'AP_POLL_VISIBILITY' => 'Zichtbaarheid van resultaten',
	'AP_POLL_VISIBILITY_EXPLAIN' => 'Kies wanneer de gezamenlijke peilingresultaten zichtbaar worden.',
	'AP_VISIBILITY_PUBLIC' => 'Openbaar — resultaten altijd tonen',
	'AP_VISIBILITY_DEFAULT' => 'Na de eerste stem',
	'AP_VISIBILITY_VOTE_COMPLETED' => 'Nadat alle beschikbare stemmen zijn gebruikt',
	'AP_VISIBILITY_PRIVATE' => 'Privé — alleen nadat de peiling is afgelopen',
	'AP_POLL_VOTE_MODE' => 'Stemwijzigingen',
	'AP_POLL_VOTE_MODE_EXPLAIN' => 'Kies of stemmen definitief zijn, stapsgewijs kunnen worden uitgebracht of tijdens een open peiling kunnen worden gewijzigd.',
	'AP_VOTE_MODE_NO_CHANGE' => 'Geen wijzigingen',
	'AP_VOTE_MODE_INCREMENTAL' => 'Stapsgewijs stemmen',
	'AP_VOTE_MODE_CHANGE' => 'Wijzigingen toestaan',
	'AP_POLL_VOTES_HIDE'					=> 'Verberg stemmen',
	'AP_POLL_VOTES_HIDE_EXPLAIN'			=> 'Indien ingeschakeld zullen de stemmen tot het einde van de peiling verborgen zijn. Deze optie werkt alleen wanneer de peiling een specifieke einde heeft.',
	'AP_POLL_VOTERS_SHOW'					=> 'Toon stemmers van deze peiling',
	'AP_POLL_VOTERS_SHOW_EXPLAIN'			=> 'Indien ingeschakeld zullen de stemmers getoond worden aan die personen die deze rechten hebben. Let erop dat de stemmers verborgen blijven wanneer de stemmen niet getoont worden.',
	'AP_POLL_VOTERS_LIMIT'					=> 'Beperk stemmen',
	'AP_POLL_VOTERS_LIMIT_EXPLAIN'			=> 'Indien ingeschakeld kunnen gebruikers alleen stemmen wanneer ze in dat onderwerp iets geschreven hebben.',
	'AP_POLL_SHOW_ORDERED'					=> 'Toon resultaten op volgorde',
	'AP_POLL_SHOW_ORDERED_EXPLAIN'			=> 'Indien resultaten weergegeven worden zijn deze op aflopende volgorde op basis van het aantal ontvangen stemmen (Meest gestemde eerst). Of anders op basis van peiling opties.',
	'AP_POLL_COLLAPSIBLE'					=> 'Inklapbare peiling',
	'AP_POLL_COLLAPSIBLE_EXPLAIN'			=> 'Sta gebruikers toe deze peiling in en uit te klappen.',
	'AP_COLLAPSE_POLL'						=> 'Peiling inklappen',
	'AP_EXPAND_POLL'						=> 'Peiling uitklappen',
	'AP_RUN_POLL'							=> 'Start peiling',
	'AP_RUN_POLL_FOR' 						=> 'voor',
	'AP_RUN_POLL_UNTIL' 					=> 'tot',
	'AP_RUN_POLL_INDEFINITELY' 				=> 'oneindig',
	'AP_POLL_END'							=> 'Einde van de peiling',
	'AP_POLL_END_EXPLAIN'					=> 'Geef de datum op wanneer de peiling eindigt. Indien opgegeven overschrijft deze de lengte van de peiling. Als u dit niet wenst te gebruiken dient deze velden leeg te laten/maken.',

	'AP_YYYY_MM_DD'							=> 'JJJJ-MM-DD',
	'AP_HH_MM'								=> 'UU:MM',
	'AP_POLL_END_INVALID'					=> 'Opgegeven datum of tijd is ongeldig',
	'AP_POLL_TOTAL_LOWER_MAX_VOTES'			=> 'De maximale aantal stemmen voor een enkele optie kan nooit meer zijn dan het maximale aantal stemmen over alle opties',
	'AP_POLL_TOTAL_LOWER_MAX_OPTS'			=> 'De maximale opties om te stemmen mag niet meer dan de totale stemmen die onder alle opties te verdelen zijn',

	'AP_POLL_MAX_VALUE'						=> 'Maximale aantal stemmen',
	'AP_POLL_MAX_VALUE_EXPLAIN'				=> 'Dit is het maximale aantal stemmen dat een gebruiker per optie mag geven.',
	'AP_POLL_TOTAL_VALUE'					=> 'Totale stemmen',
	'AP_POLL_TOTAL_VALUE_EXPLAIN'			=> 'Dit is het totale aantal stemmen dat een gebruiker voor alle opties mag vergeven.',

	'AP_RANK_POINTS' => 'Punten per positie',
	'AP_RANK_POINTS_EXPLAIN' => 'Stel voor elke positie een positieve, afnemende puntenwaarde in. Het aantal posities wordt bepaald door het maximum aantal opties per gebruiker.',
	'AP_RANK_POSITION' => 'Positie %d',

	'AP_VOTE_GREATER_THAN_MAXVALUE' 		=> 'U kunt niet meer stemmen geven dan het opgegeven maximum.',
	'AP_POLL_VALUES_INVALID' => 'De minimale score mag niet hoger zijn dan de maximale score; het maximum aantal opties, de maximale score en de totaalscore moeten groter zijn dan nul.',
	'AP_RANK_POSITIONS_INVALID' => 'Het aantal posities moet tussen 1 en het aantal peilingopties liggen.',
	'AP_RANK_POINTS_INCOMPLETE' => 'Definieer voor elke positie een puntenwaarde.',
	'AP_RANK_POINTS_INVALID' => 'Elke puntenwaarde moet tussen 1 en 999 liggen.',
	'AP_RANK_POINTS_ORDER' => 'De punten moeten strikt afnemen van de eerste tot de laatste positie.',
	'AP_RANK_INCREMENTAL_UNSUPPORTED' => 'Incrementeel stemmen kan niet met een geordende rangschikking worden gebruikt.',
	'AP_RANK_SELECTION_INCOMPLETE' => 'Selecteer precies het ingestelde aantal opties in volgorde van voorkeur.',
	'AP_QUESTION' => 'Vraag',
	'AP_QUESTION_REQUIRED' => 'Verplichte vraag',
	'AP_PRIMARY_QUESTION_REQUIRED_EXPLAIN' => 'Vereist een antwoord op de eerste vraag voordat het volledige stembiljet kan worden verzonden.',
	'AP_ADDITIONAL_QUESTIONS' => 'Extra vraagpagina’s',
	'AP_ADDITIONAL_QUESTIONS_EXPLAIN' => 'Elke pagina gebruikt hetzelfde peilingtype en dezelfde regels voor limieten, punten, zichtbaarheid en het wijzigen van stemmen. Voer één optie per regel in.',
	'AP_ADD_QUESTION' => 'Vraag toevoegen',
	'AP_MULTI_INVALID' => 'De gegevens van de extra vragen zijn ongeldig.',
	'AP_MULTI_TOO_MANY' => 'Een peiling mag maximaal 20 extra vragen bevatten.',
	'AP_MULTI_CONTENT_INVALID' => 'Elke extra vraag heeft een titel en voldoende geldige opties voor de algemene peilinglimieten nodig.',
	'AP_REQUIRED_QUESTION_MISSING' => 'Beantwoord deze verplichte vraag voordat je doorgaat.',
	'AP_POLL_NAVIGATION' => 'Navigatie door de peilingvragen',
	'AP_POLL_MIN_VALUE' => 'Minimumscore',
	'AP_POLL_MIN_VALUE_EXPLAIN' => 'Dit is de laagste score die een stemmer aan een geselecteerde optie mag toekennen.',
	'AP_VOTE_OUTSIDE_RANGE' => 'Elke toegekende score moet tussen de ingestelde minimum- en maximumwaarde liggen.',
]);
