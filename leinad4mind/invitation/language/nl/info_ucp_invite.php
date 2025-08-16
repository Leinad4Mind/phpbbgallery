<?php

/**
 *
 * Invite. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2010-2015, KillBill
 * @copyright (c) 2017, kasimi
 * @copyright (c) 2017-2018, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
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
// Some characters you may want to copy&paste: ’ « » „ “ ” …

$lang = array_merge($lang, array(
	'POST_CONFIRM_EXPLAIN'					=> 'De code in typen voorkomt automatische uitnodiging van bots. Je kunt de code vinden in de volgende afbeelding. Als u de code niet kan lezen  door  visuele of andere problemen neem dan contact op met de %sforum beheerder%s.',

	'UCP_CAT_INVITE'						=> 'phpBB Invite',
	'UCP_INVITE'							=> 'Uitnodiging',
	'UCP_INVITE_DATA'						=> 'Uitnodigings details',
	'UCP_INVITE_BACK'						=> '<br /><br />%sterug naar gebruikers controle paneel%s',
	'UCP_INVITE_DAYF'						=> 'Verzonden uitnodigingen vandaag',
	'UCP_INVITE_DAYF_EXPLAIN'				=> 'Het aantal uitnodigingen die je vandaag hebt verzonden.',
	'UCP_INVITE_DAY_OFF'					=> 'We  verzenden vandaag geen uitnodigingen meer!',
	'UCP_INVITE_DB'							=> '<b>%s Uitnodiging(s).</b>',
	'UCP_INVITE_DB_SEND'					=> 'Dagelijkes uitnodigings limiet',
	'UCP_INVITE_DB_SEND_EXPLAIN'			=> 'Maximum aantal uitnodigingen die je per dag kunt verzenden.',
	'UCP_INVITE_DB_MAX'						=> '<span class="meghivo_tred">Onbeperkt!</span>',
	'UCP_INVITE_DB_PENDING'					=> 'In behandeinge uitnodigingen',
	'UCP_INVITE_DB_PENDING_EXPLAIN'			=> 'Het aantal door jou uitgenodigde gebruikers die zich nog niet hebben geregistreerd.',
	'UCP_INVITE_DB_NUMBER'					=> 'Aantal uitnodigingen',
	'UCP_INVITE_DB_NUMBER_EXPLAIN'			=> 'Je resterende uitnodigings limeit',
	'UCP_INVITE_DB_USER'					=> 'Uitgenodigde gebruiker',
	'UCP_INVITE_DB_USERS'					=> 'Uitgenodigde gebruikers',
	'UCP_INVITE_DB_USERS_EXPLAIN'			=> 'Gebruikers die jij hebt uitgenodigd.',
	'UCP_INVITE_DB_USER_EXPLAIN'			=> 'Gebruiker die jij hebt uitgenodigd.',
	'UCP_INVITE_DELETE'						=> 'Verwijder uitnodiging',
	'UCP_INVITE_DELETE_EXPLAIN'				=> 'Als je een uitnodiging verstuurd naar een verkeerd adres, dan kun je hier de uitnodiging verwijderen.<br /><em>Dit is alleen mogelijk binnen %s minuten na het verzenden van de uitnodiging.</em>',
	'UCP_INVITE_DELETE_NO_CONFIRM'			=> 'De verwijdering was niet bevestigd!',
	'UCP_INVITE_DELETE_SUCCESS'				=> 'De uitnodiging is succesvol verwijderd.',
	'UCP_INVITE_DISABLED'					=> '%sUitnodigings systeem is uitgezet!%s',
	'UCP_INVITE_DUP'						=> 'Dit e-mail adres is al eerder een uitnodiging naar toe verzonden. -> %s',
	'UCP_INVITE_EDUP'						=> 'Een e-mail adres meerdere keren toegestaan. -> %s',
	'UCP_INVITE_EMAILS_SENT'				=> 'De uitnodging is succesvol verzonden!',
	'UCP_INVITE_EMAIL_LANG'					=> 'E-mail taal',
	'UCP_INVITE_EMAIL_REQUEST_EXPLAIN'		=> 'Reden voor de gevraagde uitnodigingen.',
	'UCP_INVITE_EMAIL_SELECT'				=> 'Uitnodiging selectie',
	'UCP_INVITE_EMAIL_SELECT_EXPLAIN'		=> 'Kies welke u  wilt verwijderen als ontvanger.',
	'UCP_INVITE_EMAIL_SENT'					=> 'De uitnodging is succesvol verzonden!',
	'UCP_INVITE_FLOOD_LIMIT'				=> 'Je kan geen uitnodigingen meer versturen. Probeer later opnieuw.',
	'UCP_INVITE_FRIEND'						=> 'Voeg een vriend toe',
	'UCP_INVITE_FRIEND_EXPLAIN'				=> 'De uitgenodigde gebruiker zal toegevoegd worden aan je vrienden lijst.',
	'UCP_INVITE_DEP_LIMIT'					=> 'Alleen %s uitnodigingen kunnen versturrd worden vandaag, maar u hebt %s uitgekozen ontvangers.',
	'UCP_INVITE_REQUEST'					=> 'Uitnodigings verzoek',
	'UCP_INVITE_REQUEST_BUYS_SUCCESS'		=> 'Je hebt succesvol uitnodigingen gekocht.',
	'UCP_INVITE_REQUEST_BUY_MIN'			=> 'Minimum (1) uitnodiging kan worden gekocht!',
	'UCP_INVITE_REQUEST_BUY_NO'				=> 'Je hebt niet genoeg %s om dit aantal uitnodigen te kopen! je hebt %s %s  momenteel.',
	'UCP_INVITE_REQUEST_BUY_SUBMIT'			=> 'Koop',
	'UCP_INVITE_REQUEST_BUY_SUBT'			=> 'Uitnodigingen die je wil kopen',
	'UCP_INVITE_REQUEST_BUY_SUBT_EXPLAIN'	=> 'Geef het aantal uitnodigingen in die je wilt kopen. Uitnodiging prijs is <b>%s %s</b>.<br />Je neemt verantwoordelijkheid voor je uitgenodigde gebruiker(s), als de uitgenodigde gebruiker (s) ongepast ongepast gedrag vertoond',
	'UCP_INVITE_REQUEST_BUY_SUCCESS'		=> 'Aankoop uitnodiging was succesvol.',
	'UCP_INVITE_REQUEST_BUY_TITLE'			=> 'Koop uitnodiging.',
	'UCP_INVITE_REQUEST_DISABLED'			=> 'Het verzoek is uitgeschakeld!',
	'UCP_INVITE_REQUEST_MAX'				=> 'Maximaal aantal verzoeken: (%s) uitnodiging(en)!',
	'UCP_INVITE_REQUEST_MESSAGE_NO_DB'		=> '<em>Nee! Er was geen behoefte.</em>',
	'UCP_INVITE_REQUEST_MIN'				=> 'Minimaal aantal verzoeken uitnodigingen: (1)',
	'UCP_INVITE_REQUEST_NO_MESSAGE'			=> 'Je hebt geen bericht geschreven! Zonder uitleg kun je niet zoveel uitnodigingen claimen.',
	'UCP_INVITE_REQUEST_OFF'				=> 'je uitnodigings verzoek is in behandeling. Wanneer een beheerder/moderator je verzoek evalueert, ontvang je een persoonlijk bericht.',
	'UCP_INVITE_REQUEST_SOK_EXPLAIN'		=> 'Bij het verzenden van meer dan <b>(%s)</b> verzoeken, is uitleg aan een beheerder nodig. Leg uit waarom je zoveel uitnodigen wilt hebben.<br />Als we denken dat je verzoek acceptabel is, geven wij je de uitnodigingen. Als we misbruik ontdekken, kan dit een reden zijn om je account te bannen.',
	'UCP_INVITE_REQUEST_SUBMIT'				=> 'Zend verzoek',
	'UCP_INVITE_REQUEST_SUCC'				=> 'Het uitnodigings verzoek is succesvol verzonden!',
	'UCP_INVITE_REQUEST_SUCCS'				=> 'De uitnodigings verzoeken zijn succesvol verzonden!',
	'UCP_INVITE_REQUEST_TITLE'				=> 'Benodigde uitnodigingen',
	'UCP_INVITE_REQUEST_TITLE_EXPLAIN'		=> 'Geef het aantal uitnodigingen aan die je wilt hebben. Er is een maximum van <b>(%s)</b> uitnodiging(en) beschikbaar.<br />Je neemt de volle verantwoordelijkheid voor je uitgenodigde gebruiker(s) als deze ongepast gedrag vertonen.',
	'UCP_INVITE_SEND'						=> 'Zend verzoek',
	'UCP_INVITE_SEND_EMAIL_MAX'				=> 'Maximaal %s e-mail adressen kunnen worden gebruikt. maar je vermeld er %s!',
	'UCP_INVITE_SEND_MAX'					=> '<span class="meghivo_tred">er is momenteel geen limiet!</span>',
	'UCP_INVITE_LAST_ACTIVE'				=> 'Laast actief',
	'UCP_INVITE_MAX_ERROR'					=> 'Momenteel heb je onbeperkt aantal uitnodigingen.',
	'UCP_INVITE_MAX_RECIPIENTS'				=> 'Type alle adressen op een nieuwe lijn!<br />Maximum aantal ontvangers',
	'UCP_INVITE_MESSAGE_BODY_EXPLAIN'		=> 'Geef in een paar lijnen aan waarom men zou moeten deelnemen',
	'UCP_INVITE_NOT_DELETED_INVITE'			=> 'Er zijn geen uitnodigingen om te verwijderen!',
	'UCP_INVITE_NOT_LANGUAGE'				=> 'Geen bestaand taal bestand: %s',
	'UCP_INVITE_NO_EMAIL'					=> 'Je hebt geen e-mail adres opgegeven!',
	'UCP_INVITE_NO_INVITE_USERS'			=> 'Je hebt niemand uitgenodigd, of ze hebben zich nog niet geregistreerd.',
	'UCP_INVITE_NO_LOGIN'					=> 'Hij/Zij hebben zich nog niet geregistreerd op deze site.',
	'UCP_INVITE_NO_PERM'					=> 'Je bent niet gemachtigd om uitnodigingen te verzenden!',
	'UCP_INVITE_NO_PERM_EMAIL'				=> 'Je bent niet gemachtigd om een e-mail te verzenden!',
	'UCP_INVITE_NO_REG'						=> 'Niemand werd uitgenodigd door jou.',
	'UCP_INVITE_NULL'						=> 'Je hebt geen uitnodigingen! <em>Waarom koop je er niet een paar?</em>',
	'UCP_INVITE_POINTS_AMOUNT'				=> 'Geschenk',
	'UCP_INVITE_POINTS_AMOUNT_EXPLAIN'		=> 'Aantal uitnodigingen die je geeft als de door jouw uitgenodigde gebruiker een geregistreerd lid wordt.',
	'UCP_INVITE_POINTS_COST'				=> 'Uitnodigingd prijs',
	'UCP_INVITE_POINTS_COST_EXPLAIN'		=> 'De kosten om een uitnodiging te verzenden.',
	'UCP_INVITE_POST_LIMIT'					=> 'Je moet minimaal %s bericht(en) gepost hebben om een uitnodiging te mogen verzenden!',
	'UCP_INVITE_REQUEST_SUBJECT'			=> 'Uitnodiging verzoek',
	'UCP_INVITE_SDB'						=> 'Uitnodiging(en).',
	'UCP_INVITE_SEND_OFF'					=> 'Uitnodigingen verzenden is momenteel uitgeschakeld!',
	'UCP_INVITE_SEND_SUBMIT'				=> 'Verzend uitnodiging',
	'UCP_INVITE_TIME_END'					=> 'Verlooptijd',
	'UCP_INVITE_TIME_END_EXPLAIN'			=> 'De uitgenodigde gebruiker moet zich binnen deze tijd registreren.',
	'UCP_INVITE_USER'						=> 'Uitgenodigde gebruikers',
	'UCP_INVITE_USERS_COUNT'				=> 'Uitgenodigde gebruikers (%s)',
	'UCP_INVITE_USER_OK'					=> 'Uitnodiging geaccepteerd',
	'UCP_INVITE_LU_REG'						=> 'laatste gebruiker',
	'UCP_INVITE_LU_REG_EXPLAIN'				=> 'laatste gebruiker van jou uitnodigingen.',
	'UCP_INVITE_LU_REG_INFO'				=> '<b>%s</b> geregistreerd %s',

	'WEEKS'									=> 'Weken',

	'NOTIFICATION_TYPE_INVITE_BIRTHDAY'			=> 'You receive invitations for your birthday',
	'NOTIFICATION_TYPE_INVITE_GIFT'				=> 'You receive invitations after you successfully invited a user',
	'NOTIFICATION_TYPE_INVITE_PETITION'			=> 'You receive an invitation request',
	'NOTIFICATION_TYPE_INVITE_PETITION_REQUEST' => 'You receive an invitation request',
	'NOTIFICATION_TYPE_INVITE_JOIN'				=> 'A user you invited has registered an account',
));
