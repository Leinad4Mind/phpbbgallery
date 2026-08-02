<?php
/**
 * phpBB Gallery Contest ACP language.
 *
 * @package   phpbbgallery/contest
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

$lang = array_merge($lang, [
	'CONTEST_CREATION'                    => 'Nieuwe wedstrijden toestaan',
	'CONTEST_CREATION_EXPLAIN'            => 'Staat beheerders toe nieuwe wedstrijdalbums te maken. Bestaande wedstrijden blijven actief en bewerkbaar wanneer deze optie is uitgeschakeld.',
	'CONTEST_CREATION_DISABLED'           => 'Het maken van nieuwe wedstrijdalbums is uitgeschakeld in de Galerijconfiguratie.',
	'ALBUM_NO_TYPE_CHANGE_TO_CONTEST'   => 'Een Niet-Wedstrijd-Album kan niet veranderd worden naar Wedstrijd-Album.',
	'ALBUM_WITH_CONTEST_NO_TYPE_CHANGE' => 'Wedstrijd-Albums kunnen niet veranderd worden naar Niet-Wedstrijd-Album.',
	'CONTEST_DATE_EXPLAIN'                => 'Voer een datum in in: YYYY-MM-DD HH:MM formaat.',
	'CONTEST_END'                         => 'Einde wedstrijd',
	'CONTEST_END_BEFORE_RATING'           => 'Het einde van de wedstrijd kan niet voor het begin van de wedstrijd beoordelingsperiode liggen.',
	'CONTEST_END_BEFORE_START'            => 'Het einde van de wedstrijd kan niet voor het begin van de wedstrijd liggen.',
	'CONTEST_END_EXPLAIN'                 => 'Na het einde van de wedstrijd, kunnen gebruikers de afbeeldingen niet meer beoordelen.',
	'CONTEST_END_INVALID'                 => 'Ongeldig wedstijd-einde (%s). Voer een datum in in: YYYY-MM-DD HH:MM formaat..',
	'CONTEST_RATING'                      => 'Start beoordelingsperiode',
	'CONTEST_RATING_BEFORE_START'         => 'Het begin van de beoordelingspriode van een wedstrijd, kan niet voor het begin van de wedstrijd liggen.',
	'CONTEST_RATING_EXPLAIN'              => 'Nadat de beoordelingsperiode is gestart, kunnen gebruikers geen nieuwe afbeeldingen uploaden.',
	'CONTEST_RATING_INVALID'              => 'Ongeldig wedstrijd-beoordelings-start (%s). Voer een datum in in: YYYY-MM-DD HH:MM formaat.',
	'CONTEST_SETTINGS'                    => 'Wedstrijd insellingen',
	'CONTEST_START'                       => 'Begin wedstrijd',
	'CONTEST_START_EXPLAIN'               => 'Aan het begin van de wedstrijd, is het toegestaan dat gebruikers afbeeldingen uploaden.',
	'CONTEST_START_INVALID'               => 'Ongeldig wedstrijd-begin (%s). Voer een datum in in: YYYY-MM-DD HH:MM formaat.',
]);
