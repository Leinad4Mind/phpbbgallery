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
	'ALBUM_TYPE_CONTEST'                  => 'Wedstrijd',
	'CONTEST_CREATION'                    => 'Nieuwe wedstrijden toestaan',
	'CONTEST_CREATION_EXPLAIN'            => 'Staat beheerders toe nieuwe wedstrijdalbums te maken. Bestaande wedstrijden blijven actief en bewerkbaar wanneer deze optie is uitgeschakeld.',
	'CONTEST_CREATION_DISABLED'           => 'Het maken van nieuwe wedstrijdalbums is uitgeschakeld in de Galerijconfiguratie.',
	'CONTEST_SCHEMA_OUTDATED'             => 'Het databaseschema van de Wedstrijden-add-on is verouderd. Voer de phpBB-databasemigraties uit of schakel de add-on uit en weer in voordat je een wedstrijd maakt of bewerkt.',
	'ALBUM_NO_TYPE_CHANGE_TO_CONTEST'   => 'Een Niet-Wedstrijd-Album kan niet veranderd worden naar Wedstrijd-Album.',
	'ALBUM_WITH_CONTEST_NO_TYPE_CHANGE' => 'Wedstrijd-Albums kunnen niet veranderd worden naar Niet-Wedstrijd-Album.',
	'CONTEST_DATE_EXPLAIN'                => 'Selecteer de datum en tijd. De tijdzone uit je phpBB-profiel wordt gebruikt.',
	'CONTEST_DATE_MUST_BE_FUTURE'         => '%s moet in de toekomst liggen.',
	'CONTEST_END'                         => 'Einde wedstrijd',
	'CONTEST_END_BEFORE_RATING'           => 'Het einde van de wedstrijd kan niet voor het begin van de wedstrijd beoordelingsperiode liggen.',
	'CONTEST_END_BEFORE_START'            => 'Het einde van de wedstrijd kan niet voor het begin van de wedstrijd liggen.',
	'CONTEST_END_EXPLAIN'                 => 'Na het einde van de wedstrijd, kunnen gebruikers de afbeeldingen niet meer beoordelen.',
	'CONTEST_END_INVALID'                 => 'Ongeldig einde van de wedstrijd (%s). Selecteer een geldige datum en tijd.',
	'CONTEST_RATING'                      => 'Start beoordelingsperiode',
	'CONTEST_RATING_BEFORE_START'         => 'Het begin van de beoordelingspriode van een wedstrijd, kan niet voor het begin van de wedstrijd liggen.',
	'CONTEST_RATING_EXPLAIN'              => 'Nadat de beoordelingsperiode is gestart, kunnen gebruikers geen nieuwe afbeeldingen uploaden.',
	'CONTEST_RATING_INVALID'              => 'Ongeldige start van de beoordeling (%s). Selecteer een geldige datum en tijd.',
	'CONTEST_SETTINGS'                    => 'Wedstrijd insellingen',
	'CONTEST_WINNER_THUMBNAIL'            => 'Miniaturen van wedstrijdwinnaars gebruiken',
	'CONTEST_WINNER_THUMBNAIL_EXPLAIN'    => 'Gebruikt na afloop van een wedstrijd standaard de geldige afbeelding op de eerste plaats als albumminiatuur. Elke wedstrijd kan deze instelling overnemen of overschrijven. Een handmatig ingesteld albumbeeld heeft altijd voorrang.',
	'CONTEST_THUMBNAIL_POLICY'            => 'Albumminiatuur na de wedstrijd',
	'CONTEST_THUMBNAIL_POLICY_EXPLAIN'    => 'Bepaalt alleen de miniatuur in de albumlijst. Datum, auteur en leesstatus van de nieuwste afbeelding blijven ongewijzigd.',
	'CONTEST_THUMBNAIL_INHERIT'           => 'Globale instelling overnemen',
	'CONTEST_THUMBNAIL_LAST'              => 'Nieuwste afbeelding gebruiken',
	'CONTEST_THUMBNAIL_WINNER'            => 'Winnende afbeelding na afloop gebruiken',
	'CONTEST_START'                       => 'Begin wedstrijd',
	'CONTEST_START_EXPLAIN'               => 'Aan het begin van de wedstrijd, is het toegestaan dat gebruikers afbeeldingen uploaden.',
	'CONTEST_START_INVALID'               => 'Ongeldige start van de wedstrijd (%s). Selecteer een geldige datum en tijd.',
]);
