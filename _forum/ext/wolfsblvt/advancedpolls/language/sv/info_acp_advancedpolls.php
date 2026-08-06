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
	'AP_TITLE_ACP'					=> 'Avancerade omröstningar',
	'AP_SETTINGS_ACP'				=> 'Inställningar',

	'AP_TITLE'						=> 'Avancerade omröstningar',
	'AP_TITLE_EXPLAIN'				=> 'Utökar omröstningssystemet i phpBB med nya funktioner, du kan t.ex. dölja omröstningesresultatet tills omröstningen har avslutats, visa vem som röstat, osv.',

	'AP_SETTINGS'					=> 'Inställningar för Avancerade omröstningar',
	'AP_GLOBAL_SETTINGS' => 'Globala inställningar för avancerade omröstningar',
	'AP_PER_POLL_SETTINGS' => 'Inställningar per omröstning',
	'AP_DEFAULT_POLL_VISIBILITY' => 'Standard för resultatens synlighet',
	'AP_DEFAULT_POLL_VISIBILITY_EXPLAIN' => 'Synlighetsläget som väljs när en omröstning skapas.',
	'AP_DEFAULT_POLL_VOTE_MODE' => 'Standardläge för ändring av röster',
	'AP_DEFAULT_POLL_VOTE_MODE_EXPLAIN' => 'Läget för ändring av röster som väljs när en omröstning skapas.',
	'AP_VISIBILITY_PUBLIC' => 'Offentlig — visa alltid resultaten',
	'AP_VISIBILITY_DEFAULT' => 'Efter den första rösten',
	'AP_VISIBILITY_VOTE_COMPLETED' => 'När alla tillgängliga röster har använts',
	'AP_VISIBILITY_PRIVATE' => 'Privat — först när omröstningen är avslutad',
	'AP_VOTE_MODE_NO_CHANGE' => 'Inga ändringar',
	'AP_VOTE_MODE_INCREMENTAL' => 'Stegvis röstning',
	'AP_VOTE_MODE_CHANGE' => 'Tillåt ändringar',

	'AP_ACT_VOTES_HIDE'				=> 'Aktivera döljning av resultat',
	'AP_ACT_VOTES_HIDE_EXPLAIN'		=> 'Aktiverar inställningen som döljer omröstningens resultat tills omröstningen har avslutats.',
	'AP_ACT_VOTERS_SHOW'			=> 'Aktivera visning av medlemmar som har röstat',
	'AP_ACT_VOTERS_SHOW_EXPLAIN'	=> 'Aktiverar inställningen som visar vem som har röstat och vad rösten har lagts på.',
	'AP_ACT_VOTERS_LIMIT'			=> 'Aktivera förutsättning av inlägg för omröstning',
	'AP_ACT_VOTERS_LIMIT_EXPLAIN'	=> 'Aktiverar inställningen som gör att man endast kan rösta om man har skrivit ett inlägg i omröstningstråden.',
	'AP_ACT_POLL_NO_VOTE' => 'Aktivera valet att inte rösta',
	'AP_ACT_POLL_NO_VOTE_EXPLAIN' => 'Ersätter länken ”Visa resultat” med ”Rösta inte, visa resultat”, vilket förhindrar senare röstning om inte ändring av röster är tillåten.',
	'AP_ACT_SHOW_ABSTAINERS' => 'Visa antal som avstått',
	'AP_ACT_SHOW_ABSTAINERS_EXPLAIN' => 'Visar hur många registrerade användare som uttryckligen valde att inte rösta. Namn visas bara när väljarlistan är aktiverad och användaren har behörighet.',
	'AP_ACT_VOTE_DELETE' => 'Tillåt borttagning av röst',
	'AP_ACT_VOTE_DELETE_EXPLAIN' => 'Låter registrerade användare ta bort sin egen röst medan omröstningen är öppen och tillåter ändringar.',
	'AP_ACT_SHOW_ORDERED' => 'Aktivera sorterade resultat',
	'AP_ACT_SHOW_ORDERED_EXPLAIN' => 'Aktiverar möjligheten att visa resultaten efter fallande antal mottagna röster.',
	'AP_ACT_POLL_SCORING' => 'Aktivera poängomröstningar',
	'AP_ACT_POLL_SCORING_EXPLAIN' => 'Gör det möjligt att ge olika poäng till omröstningens alternativ.',
	'AP_ACT_INCREMENTAL_VOTES' => 'Aktivera stegvis röstning',
	'AP_ACT_INCREMENTAL_VOTES_EXPLAIN' => 'Gör det möjligt att rösta stegvis så länge det finns återstående röster.',
	'AP_ACT_CLOSED_VOTING' => 'Aktivera röstning i låsta ämnen',
	'AP_ACT_CLOSED_VOTING_EXPLAIN' => 'Gör det möjligt att rösta i en öppen omröstning även om ämnet är låst.',
	'AP_ACT_POLL_END' => 'Aktivera slutdatum för omröstningar',
	'AP_ACT_POLL_END_EXPLAIN' => 'Gör det möjligt att ange exakt datum och tid för omröstningens slut i stället för en längd från starttiden.',
	'AP_ACT_POLL_NOTIFICATIONS' => 'Aktivera omröstningsaviseringar',
	'AP_ACT_POLL_NOTIFICATIONS_EXPLAIN' => 'Skickar en avisering till alla som röstat i en dold omröstning när den avslutas och resultaten blir synliga.',
	'AP_ACT_POLL_COLLAPSIBLE' => 'Aktivera hopfällbara omröstningar',
	'AP_ACT_POLL_COLLAPSIBLE_EXPLAIN' => 'Visar hopfällningsalternativet när en omröstning skapas eller redigeras. Vid installation aktiveras inställningen automatiskt om ”Collapsible Forum Categories” är installerat; administratörer kan alltid ändra den.',

	'AP_DEFAULT_VOTES_CHANGE'		=> 'Välj grundinställning för ändring av röstning',
	'AP_DEFAULT_VOTES_HIDE'			=> 'Välj grundinställning för "Dölja omröstning"',
	'AP_DEFAULT_VOTERS_SHOW'		=> 'Välj grundinställning för "Visning av medlemmar som har röstat"',
	'AP_DEFAULT_VOTERS_LIMIT'		=> 'Välj grundinställning för "Inskränkning av omröstning"',
	'AP_DEFAULT_SHOW_ORDERED' => 'Visa sorterade resultat som standard',

	'AP_ENABLE_NOTICE' => '<br /><br /><div class="phpinfo"><p><strong>Nästa steg</strong></p><ol><li>Granska tilläggets inställningar under <strong>%1$s » %2$s » %3$s</strong> och konfigurera de omröstningsfunktioner och standardvärden som forumet behöver.</li><li>Granska behörigheterna <strong>%8$s</strong> och <strong>%9$s</strong> under <strong>%4$s » %5$s » %6$s</strong> (medlemmar) och <strong>%4$s » %5$s » %7$s</strong> (moderatorer). Ge dem endast till roller eller grupper som får se de röstandes identitet.</li></ol><p>Övriga omröstningsfunktioner kräver ingen ytterligare konfiguration.</p></div>',
]);
