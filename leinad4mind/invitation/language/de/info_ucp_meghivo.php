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
	'POST_CONFIRM_EXPLAIN'					=> 'Die Eingabe des Codes verhindert die automatische Einladung von Bots. Du kannst den Code auf dem folgenden Bild sehen. Falls du ihn aufgrund von visuellen oder anderen Problemen nicht sehen kannst, kontaktiere bitte den %sAdministrator%s.',

	'UCP_CAT_MEGHIVO'						=> 'phpBB Invite',
	'UCP_MEGHIVO'							=> 'Einladung',
	'UCP_MEGHIVO_ADAT'						=> 'Einladungsdetails',
	'UCP_MEGHIVO_BACK'						=> '<br /><br />%sZurück zum persönlichen Bereich%s',
	'UCP_MEGHIVO_DAYF'						=> 'Heute versandte Einladungen',
	'UCP_MEGHIVO_DAYF_EXPLAIN'				=> 'Die Anzahl der Einladungen, die du heute versandt hast.',
	'UCP_MEGHIVO_DAY_OFF'					=> 'Wir versenden heute keine Einladungen mehr!',
	'UCP_MEGHIVO_DB'						=> '<b>%s Einladung(en).</b>',
	'UCP_MEGHIVO_DB_KULDES'					=> 'Tägliche Einladungsgrenze',
	'UCP_MEGHIVO_DB_KULDES_EXPLAIN'			=> 'Die Höchstzahl an Einladungen, die du pro Tag versenden kannst.',
	'UCP_MEGHIVO_DB_MAX'					=> '<span class="meghivo_tred">Unbegrenzt!</span>',
	'UCP_MEGHIVO_DB_PENDING'				=> 'Ausstehende Einladungen',
	'UCP_MEGHIVO_DB_PENDING_EXPLAIN'		=> 'Die Anzahl an von dir eingeladenen Benutzern, die sich noch nicht registriert haben.',
	'UCP_MEGHIVO_DB_SZAM'					=> 'Anzahl an Einladungen',
	'UCP_MEGHIVO_DB_SZAM_EXPLAIN'			=> 'Dein verbleibendes Einladungskontingent',
	'UCP_MEGHIVO_DB_USER'					=> 'Eingeladener Benutzer',
	'UCP_MEGHIVO_DB_USERS'					=> 'Eingeladene Benutzer',
	'UCP_MEGHIVO_DB_USERS_EXPLAIN'			=> 'Mitglieder, die du eingeladen hast.',
	'UCP_MEGHIVO_DB_USER_EXPLAIN'			=> 'Mitglied, das du eingeladen hast.',
	'UCP_MEGHIVO_DELETE'					=> 'Einladung löschen',
	'UCP_MEGHIVO_DELETE_EXPLAIN'			=> 'Falls du irgendwelche Einladungen an die falsche Adresse gesendet hast, so kannst du diese hier ungültig machen.<br /><em>Dies ist nur in den ersten %s Minuten nach der Einladung möglich.</em>',
	'UCP_MEGHIVO_DELETE_NO_CONFIRM'			=> 'Die Löschung wurde nicht bestätigt!',
	'UCP_MEGHIVO_DELETE_SUCCES'				=> 'Die Einladung wurde erfolgreich gelöscht.',
	'UCP_MEGHIVO_DISABLED'					=> '%sDas Einladungssystem wurde deaktiviert!%s',
	'UCP_MEGHIVO_DUP'						=> 'Der E-Mail-Adresse wurde bereits eine Einladung gesendet. -> %s',
	'UCP_MEGHIVO_EDUP'						=> 'Eine E-Mail-Adresse wurde wiederholt aufgerufen. -> %s',
	'UCP_MEGHIVO_EMAILS_SENT'				=> 'Die Einladungen wurden erfolgreich versandt!',
	'UCP_MEGHIVO_EMAIL_LANG'				=> 'E-mail language',
	'UCP_MEGHIVO_EMAIL_KERES_EXPLAIN'		=> 'Grund für die angeforderten Einladungen.',
	'UCP_MEGHIVO_EMAIL_SELECT'				=> 'Einladungsauswahl',
	'UCP_MEGHIVO_EMAIL_SELECT_EXPLAIN'		=> 'Wähle den Empfänger aus, den du entfernern möchtest.',
	'UCP_MEGHIVO_EMAIL_SENT'				=> 'Die Einladung wurde erfolgreich versandt!',
	'UCP_MEGHIVO_FLOOD_LIMIT'				=> 'Du kannst keine weiteren Einladungen versenden. Bitte versuche es später erneut.',
	'UCP_MEGHIVO_FRIEND'					=> 'Einen Freund hinzufügen',
	'UCP_MEGHIVO_FRIEND_EXPLAIN'			=> 'Der eingeladene Benutzer wird deiner Freundesliste hinzugefügt.',
	'UCP_MEGHIVO_FUG_LIMIT'					=> 'Nur %s Einladungen können heute versandt werden. Du hast jedoch %s Empfänger aufgeführt.',
	'UCP_MEGHIVO_KERES'						=> 'Einladungsanfrage',
	'UCP_MEGHIVO_KERES_BUYS_SUCCES'			=> 'Du hast erfolgreich Einladungen erworben.',
	'UCP_MEGHIVO_KERES_BUY_MIN'				=> 'Mindestens (1) Einladung muss gekauft werden!',
	'UCP_MEGHIVO_KERES_BUY_NO'				=> 'Du hast nicht genügend %s, um so viele Einladungen zu erwerben! Du hast derzeit %s %s.',
	'UCP_MEGHIVO_KERES_BUY_SUBMIT'			=> 'Kaufen',
	'UCP_MEGHIVO_KERES_BUY_SUBT'			=> 'Einladungen, die du kaufen möchtest',
	'UCP_MEGHIVO_KERES_BUY_SUBT_EXPLAIN'	=> 'Gebe die Anzahl an Einladungen ein, die du kaufen möchtest. Der Einladungspreis beträgt <b>%s %s</b>.<br />Du trägst die Verantwortung für deine eingeladenen Benutzer, falls sie sich unangemessen verhalten.',
	'UCP_MEGHIVO_KERES_BUY_SUCCES'			=> 'Der Einladungskauf war erfolgreich.',
	'UCP_MEGHIVO_KERES_BUY_TITLE'			=> 'Einladung kaufen.',
	'UCP_MEGHIVO_KERES_DISABLED'			=> 'Die Anfrage ist ausgeschaltet!',
	'UCP_MEGHIVO_KERES_MAX'					=> 'Höchstanzahl an Anfragen: (%s) Einladung(en)!',
	'UCP_MEGHIVO_KERES_MESSAGE_NO_DB'		=> '<em>Nein! Es gab keinen Anlass.</em>',
	'UCP_MEGHIVO_KERES_MIN'					=> 'Mindestanzahl an Einladungsanfragen: (1)',
	'UCP_MEGHIVO_KERES_NO_MES'				=> 'Du hast keine Nachricht eingegeben! Grundlos kannst du nicht so viele Einladungen beanspruchen.',
	'UCP_MEGHIVO_KERES_OFF'					=> 'Deine Einladungsanfrage steht aus. Wenn ein Administrator/Moderator deine Anfrage bearbeitet hat, erhältst du eine private Nachricht.',
	'UCP_MEGHIVO_KERES_SOK_EXPLAIN'			=> 'Wenn du mehr als <b>(%s)</b> Anfragen versendest, ist eine Erklärung nötig. Bitte erkläre, warum du so viele Einladungen benötigst.<br />Wenn wir glauben, deine Anfrage sei akzeptabel, wirst du die Einladungen erhalten. Falls wir Missbrauch feststellen, kann dein Benutzerkonto gesperrt werden.',
	'UCP_MEGHIVO_KERES_SUBMIT'				=> 'Anfrage senden',
	'UCP_MEGHIVO_KERES_SUCC'				=> 'Die Einladungsanfrage wurde erfolgreich versandt!',
	'UCP_MEGHIVO_KERES_SUCCS'				=> 'Die Einladungsanfragen wurden erfolgreich versandt',
	'UCP_MEGHIVO_KERES_TITLE'				=> 'Benötigte Einladungen',
	'UCP_MEGHIVO_KERES_TITLE_EXPLAIN'		=> 'Gebe die Anzahl an Einladungen ein, die du beantragen möchtest. Es gibt eine Höchstgrenze von <b>(%s)</b> verfügbaren Einladungen.<br />Du übernimmst die volle Haftung für jeden von dir eingeladenen Benutzer, falls er sich unangemessen verhält.',
	'UCP_MEGHIVO_KULDES'					=> 'Einladung senden',
	'UCP_MEGHIVO_KULDES_EMAIL_MAX'			=> 'Höchstens %s E-Mail-Adressen können verwendet werden. Du hast aber %s aufgeführt!',
	'UCP_MEGHIVO_KULDES_MAX'				=> '<span class="meghivo_tred">Momentan gibt es keine Grenze!</span>',
	'UCP_MEGHIVO_LAST_ACTIVE'				=> 'Zuletzt aktiv',
	'UCP_MEGHIVO_MAX_ERROR'					=> 'Momentan hast du unbegrenzte Einladungen.',
	'UCP_MEGHIVO_MAX_RECIPIENTS'			=> 'Gebe alle Adressen in einer neuen Zeile ein!<br />Höchstanzahl an Empfängern',
	'UCP_MEGHIVO_MESSAGE_BODY_EXPLAIN'		=> 'Schreibe ein paar Zeilen und erläutere, warum sie beitreten sollen.',
	'UCP_MEGHIVO_NOT_DELETED_INVITE'		=> 'Es ist keine Einladung zu löschen!',
	'UCP_MEGHIVO_NOT_LANGUAGE'				=> 'Inexistente Sprachdatei: %s',
	'UCP_MEGHIVO_NO_EMAIL'					=> 'Du hast keine E-Mail-Adresse angegeben!',
	'UCP_MEGHIVO_NO_INVITE_USERS'			=> 'Du hast noch niemanden eingeladen oder es hat sich noch niemand registriert.',
	'UCP_MEGHIVO_NO_LOGIN'					=> 'Er/sie hat sich nicht auf der Seite registriert.',
	'UCP_MEGHIVO_NO_PERM'					=> 'Du bist nicht befugt, Einladungen zu versenden!',
	'UCP_MEGHIVO_NO_PERM_EMAIL'				=> 'Du bist nicht befugt, E-Mails zu versenden!',
	'UCP_MEGHIVO_NO_REG'					=> 'Niemand wurde von dir eingeladen.',
	'UCP_MEGHIVO_NULL'						=> 'Du hast keine Einladungen! <em>Warum kaufst du nicht einfach welche?</em>',
	'UCP_MEGHIVO_POINTS_AMOUNT'				=> 'Geschenk',
	'UCP_MEGHIVO_POINTS_AMOUNT_EXPLAIN'		=> 'Anzahl der Punkte, die du bekommst, wenn dein eingeladener Benutzer sich registriert.',
	'UCP_MEGHIVO_POINTS_COST'				=> 'Einladungspreis',
	'UCP_MEGHIVO_POINTS_COST_EXPLAIN'		=> 'Die Kosten für das Versenden einer Einladung.',
	'UCP_MEGHIVO_POST_LIMIT'				=> 'Du musst mindestens %s Beiträge haben, um Einladungen versenden zu können!',
	'UCP_MEGHIVO_REQUEST_SUBJECT'			=> 'Einladungsanfrage',
	'UCP_MEGHIVO_SDB'						=> 'Einladung(en).',
	'UCP_MEGHIVO_SEND_OFF'					=> 'Das Versenden von Einladungen ist zurzeit deaktiviert!',
	'UCP_MEGHIVO_SEND_SUBMIT'				=> 'Einladung senden',
	'UCP_MEGHIVO_TIME_END'					=> 'Ablaufdatum',
	'UCP_MEGHIVO_TIME_END_EXPLAIN'			=> 'Der eingeladene Benutzer muss sich in dieser Zeitspanne registrieren.',
	'UCP_MEGHIVO_USER'						=> 'Eingeladene Benutzer',
	'UCP_MEGHIVO_USERS_COUNT'				=> 'Eingeladene Benutzer (%s)',
	'UCP_MEGHIVO_USER_OK'					=> 'Einladung angenommen',
	'UCP_MEGHIVO_UT_REG'					=> 'Letzter Benutzer',
	'UCP_MEGHIVO_UT_REG_EXPLAIN'			=> 'Der letzte von dir eingeladene Benutzer.',
	'UCP_MEGHIVO_UT_REG_INFO'				=> '<b>%s</b> registrierte sich am %s',

	'WEEKS'									=> 'Wochen',

	'NOTIFICATION_TYPE_INVITE_BIRTHDAY'		=> 'You receive invitations for your birthday',
	'NOTIFICATION_TYPE_INVITE_GIFT'			=> 'You receive invitations after you successfully invited a user',
	'NOTIFICATION_TYPE_INVITE_PETITION'		=> 'You receive an invitation request',
	'NOTIFICATION_TYPE_INVITE_PETITION_REQUEST' => 'You receive an invitation request',
	'NOTIFICATION_TYPE_INVITE_JOIN'			=> 'A user you invited has registered an account',
));
