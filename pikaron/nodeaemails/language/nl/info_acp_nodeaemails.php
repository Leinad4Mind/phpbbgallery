<?php
/**
 *
 * No DEA Emails extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019 Picaron
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
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
	$lang = array();
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

$lang = array_merge($lang, array(
		'ACP_NO_DEA_EMAILS'					=> 'Geen DEA e-mails',
		'ACP_NO_DEA_EMAILS_EXPLAIN'			=> 'Deze extensie voorkomt dat een gebruiker op het forum wordt geregistreerd wanneer een wegwerp of tijdelijke e-mailaccount wordt gebruikt <a href="https://bit.ly/2LBsbqe" target="_blank">(DEA)</a>.',
		'ACP_NO_DEA_EMAILS_WARNING_CRON'	=> 'In dit gedeelte worden de CRON statusgegevens verkregen.<br>- De optie om het tijdsinterval voor de uitvoering van de CRON te definiëren, is ingeschakeld.<br>Een relatie van de e-maildomeinen van het DEA type wordt getoond waarmee ze gefilterd worden in de e-mailaccounts van de gebruikers van het forum.',
		'ACP_NO_DEA_EMAILS_WARNING_LOCAL'	=> 'In dit gedeelte kunt u lokale domeinen van wegwerp of tijdelijke e-mailaccounts beheren (toevoegen/verwijderen) <a href="https://bit.ly/2LBsbqe" target="_blank">(DEA)</a>.<br><br>Er moet speciale aandacht worden besteed, want als een geldig domein wordt opgenomen, zullen we voorkomen dat gebruikers het gebruiken om zich te registreren.<br><i>Voorbeeld: als we het domein "gmail.com" toevoegen, zullen gebruikers met een Google e-mailaccount zich niet kunnen registreren op het forum.</i> ',
		'ACP_NO_DEA_EMAILS_WARNING_USERS'	=> 'Dit gedeelte verzamelt informatie over alle forumgebruikers die een wegwerpmail <a href="https://bit.ly/2LBsbqe" target="_blank">(DEA)</a> hebben gekoppeld aan hun account.<br><br>We kunnen gebruikers die zijn geselecteerd <strong>VOLLEDIG verwijderen</strong><br>(Inclusief al hun gepubliceerde berichten)<br><br><strong>OPGELET:<br>Deze actie is NIET OMKEERBAAR, wees voorzichtig wanneer u deze optie gebruikt als uw forum in productie is.</strong>',
		'ACP_NO_DEA_EMAILS_SETTINGS'		=> 'Cron Beheer & externe DEA Mail Domeinen',
		'ACP_NO_DEA_EMAILS_LOCALS'			=> 'Lokaal Beheer van DEA Mail Domeinen',
		'ACP_NO_DEA_EMAILS_USERS'			=> 'Gebruikers met DEA Mail Accounts',
		'ACP_SUBMIT_DELETE'					=> 'Wijzigingen toepassen',
		'LOG_CONFIG_CONFIGURATION'			=> '<strong>Configuratie van extensie “Geen DEA e-mails” geüpdate</strong>',
		'LOG_CONFIG_USERS'					=> '<strong>Gebruikers VERWIJDERD van “Geen DEA e-mails”</strong>',
		'L_NO_DEA_EMAILS_DELAY'				=> 'Interval voor uitvoering van de CRON',
		'L_NO_DEA_EMAILS_DELAY_EXPLAIN'		=> '(Minimum: 300 seconden, Maximum: 86400 seconden = 1 dag)',
		'L_DEA_DELAY'						=> 'Seconden',
		'L_DEA_DELAY_MIN'					=> 'Minuten',
		'L_NO_DEA_EMAILS_VERSION'			=> 'Extensie Versie: ',
		'L_NO_DEA_EMAILS_CONFIG'			=> 'CRON configuratie opties',
		'L_NO_DEA_EMAILS_TEX'				=> 'E-maildomeinen “DEA” verzameld via CRON',
		'L_NO_DEA_EMAILS_TEX_LOCAL'			=> 'E-maildomeinen “DEA” lokaal verzameld',
		'L_NO_DEA_EMAILS_COUNTER'			=> 'Uitvoering van de CRON',
		'L_NO_DEA_EMAILS_TIMES'				=> 'Sinds de installatie van de extensie is de CRON <strong>%s</strong> keer uitgevoerd.',
		'L_NO_DEA_EMAILS_DATE'				=> 'Laatste uitvoering van de CRON',
		'L_NO_DEA_EMAILS_USERS'				=> 'Gebruikersbeheer met DEA Email Accounts',
		'L_NO_DEA_EMAILS_TOT_USERS'			=> 'Totaal geregistreerde gebruikers',
		'L_NO_DEA_EMAILS_TOT_USERS_EXPLAIN'	=> 'Inclusief Bots en inactieve gebruikers.',
		'L_NO_DEA_EMAILS_DEA_USERS'			=> 'Totaal aantal gebruikers met DEA Email Accounts',
		'L_NO_DEA_EMAILS_NAME_USER'			=> 'Gebruikersnaam',
		'L_NO_DEA_EMAILS_EMAIL'				=> 'E-mail',
		'L_NO_DEA_EMAILS_JOINED'			=> 'Geregistreerd',
		'L_NO_DEA_EMAILS_LAST_ACTIVE'		=> 'Laatst actief',
		'L_NO_DEA_EMAILS_POST'				=> 'Aantal berichten',
		'L_NO_DEA_EMAILS_DOMAIN'			=> 'Wegwerp e-mail domein',
		'L_NO_DEA_EMAILS_PLACE'				=> 'Voer een wegwerp e-maildomein in',
		'L_NO_DEA_EMAILS_ACTION'			=> 'Actie',
		'L_NO_DEA_EMAILS_SAVE'				=> 'Opslagen',
		'L_NO_DEA_EMAILS_DEL'				=> 'Verwijder',
		'L_NO_DEA_EMAILS_MARK'				=> 'Markeer',
		'L_NO_DEA_EMAILS_DOM_SAVE'			=> 'Het DEA Email Domain is correct opgeslagen: <strong>((%s))</strong>',
		'L_NO_DEA_EMAILS_DOM_DEL'			=> 'Het DEA-e-maildomein is correct VERWIJDERD: <strong>((%s))</strong>',
		'L_NO_DEA_EMAILS_DOM_VALID'			=> 'Het DEA-e-maildomein: <strong>((%s))</strong> is niet geldig.',
		'L_NO_DEA_EMAILS_DOM_LOCATE'		=> 'Het DEA e-maildomein is niet gevonden: <strong>((%s))</strong>.',
		'L_NO_DEA_EMAILS_CANNOT_FOUNDER'	=> 'Het is niet toegestaan om de oprichters accounts te verwijderen.<br><br>Gebruiker <strong>%s</strong> kan niet worden verwijderd.',
		'L_NO_DEA_EMAILS_CANNOT_YOURSELF'	=> 'Je kunt je eigen account niet verwijderen.',
		'L_NO_DEA_EMAILS_DEL_USERS'			=> 'Basis hulpmiddelen',
		'L_NO_DEA_EMAILS_DEL_USERS_EXPLAIN'	=> 'Houd er rekening mee dat het verwijderen van een gebruiker definitief is en niet kan worden hersteld. Privéberichten die door de ongelezen gebruiker worden verzonden, worden verwijderd en zijn niet beschikbaar voor hun ontvangers.',
		'L_NO_DEA_EMAILS_SEND_PM'			=> 'Stuur een privé bericht',
		'L_NO_DEA_EMAILS_RETAIN_POSTS'		=> 'VERWIJDER GEBRUIKER en bewaar berichten',
		'L_NO_DEA_EMAILS_REMOVE_POSTS'		=> 'VERWIJDER GEBRUIKER en verwijder berichten',
		'L_NO_DEA_EMAILS_NEED_ACTION'		=> 'U moet een “Basis Hulpmiddel” selecteren.',
		'L_NO_DEA_EMAILS_NO_USERS'			=> 'Geen gebruikers geselecteerd',
));
