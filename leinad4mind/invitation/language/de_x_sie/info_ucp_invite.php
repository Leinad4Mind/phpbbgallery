<?php

/**
 *
 * Invite. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2010-2015, KillBill
 * @copyright (c) 2017, kasimi
 * @copyright (c) 2017-2021, Leinad4Mind, https://leinad4mind.top/forum
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
	'POST_CONFIRM_EXPLAIN'					=> 'Die Eingabe des Codes verhindert die automatische Einladung von Bots. Sie können den Code auf dem folgenden Bild sehen. Falls Sie ihn aufgrund von visuellen oder anderen Problemen nicht sehen können, kontaktieren Sie bitte den %sAdministrator%s.',

	'UCP_CAT_INVITE'						=> 'phpBB Invite',
	'UCP_INVITE'							=> 'Einladung',
	'UCP_INVITE_DATA'						=> 'Einladungsdetails',
	'UCP_INVITE_BACK'						=> '<br /><br />%sZurück zum persönlichen Bereich%s',
	'UCP_INVITE_DAYF'						=> 'Heute versandte Einladungen',
	'UCP_INVITE_DAYF_EXPLAIN'				=> 'Die Anzahl der Einladungen, die Sie heute versandt haben.',
	'UCP_INVITE_DAY_OFF'					=> 'Wir versenden heute keine Einladungen mehr!',
	'UCP_INVITE_DB'							=> '<b>%s Einladung(en).</b>',
	'UCP_INVITE_DB_SEND'					=> 'Tägliche Einladungsgrenze',
	'UCP_INVITE_DB_SEND_EXPLAIN'			=> 'Die Höchstzahl an Einladungen, die Sie pro Tag versenden können.',
	'UCP_INVITE_DB_MAX'						=> '<span class="meghivo_tred">Unbegrenzt!</span>',
	'UCP_INVITE_DB_PENDING'					=> 'Ausstehende Einladungen',
	'UCP_INVITE_DB_PENDING_EXPLAIN'			=> 'Die Anzahl an von Ihnen eingeladenen Benutzern, die sich noch nicht registriert haben.',
	'UCP_INVITE_DB_NUMBER'					=> 'Anzahl an Einladungen',
	'UCP_INVITE_DB_NUMBER_EXPLAIN'			=> 'Ihr verbleibendes Einladungskontingent',
	'UCP_INVITE_DB_USER'					=> 'Eingeladener Benutzer',
	'UCP_INVITE_DB_USERS'					=> 'Eingeladene Benutzer',
	'UCP_INVITE_DB_USERS_EXPLAIN'			=> 'Mitglieder, die Sie eingeladen haben.',
	'UCP_INVITE_DB_USER_EXPLAIN'			=> 'Mitglied, das Sie eingeladen haben.',
	'UCP_INVITE_DELETE'						=> 'Einladung löschen',
	'UCP_INVITE_DELETE_EXPLAIN'				=> 'Falls Sie irgendwelche Einladungen an die falsche Adresse gesendet haben, so können Sie diese hier ungültig machen.<br /><em>Dies ist nur in den ersten %s Minuten nach der Einladung möglich.</em>',
	'UCP_INVITE_DELETE_NO_CONFIRM'			=> 'Die Löschung wurde nicht bestätigt!',
	'UCP_INVITE_DELETE_SUCCESS'				=> 'Die Einladung wurde erfolgreich gelöscht.',
	'UCP_INVITE_DISABLED'					=> '%sDas Einladungssystem wurde deaktiviert!%s',
	'UCP_INVITE_DUP'						=> 'Der E-Mail-Adresse wurde bereits eine Einladung gesendet. -> %s',
	'UCP_INVITE_EDUP'						=> 'Eine E-Mail-Adresse wurde wiederholt gewährt. -> %s',
	'UCP_INVITE_EMAILS_SENT'				=> 'Die Einladungen wurden erfolgreich versandt!',
	'UCP_INVITE_EMAIL_LANG'					=> 'E-mail language',
	'UCP_INVITE_EMAIL_REQUEST_EXPLAIN'		=> 'Grund für die angeforderten Einladungen.',
	'UCP_INVITE_EMAIL_SELECT'				=> 'Einladungsauswahl',
	'UCP_INVITE_EMAIL_SELECT_EXPLAIN'		=> 'Wählen Sie den Empfänger aus, den Sie entfernern möchten.',
	'UCP_INVITE_EMAIL_SENT'					=> 'Die Einladung wurde erfolgreich versandt!',
	'UCP_INVITE_FLOOD_LIMIT'				=> 'Sie können keine weiteren Einladungen versenden. Bitte versuchen Sie es später erneut.',
	'UCP_INVITE_FRIEND'						=> 'Einen Freund hinzufügen',
	'UCP_INVITE_FRIEND_EXPLAIN'				=> 'Der eingeladene Benutzer wird Ihrer Freundesliste hinzugefügt.',
	'UCP_INVITE_DEP_LIMIT'					=> 'Nur %s Einladungen können heute versandt werden. Sie haben jedoch %s Empfänger aufgeführt.',
	'UCP_INVITE_REQUEST'					=> 'Einladungsanfrage',
	'UCP_INVITE_REQUEST_BUYS_SUCCESS'		=> 'Sie haben erfolgreich Einladungen erworben.',
	'UCP_INVITE_REQUEST_BUY_MIN'			=> 'Mindestens (1) Einladung muss gekauft werden!',
	'UCP_INVITE_REQUEST_BUY_NO'				=> 'Sie haben nicht genügend %s, um so viele Einladungen zu erwerben! Sie haben derzeit %s %s.',
	'UCP_INVITE_REQUEST_BUY_SUBMIT'			=> 'Kaufen',
	'UCP_INVITE_REQUEST_BUY_SUBT'			=> 'Einladungen, die Sie kaufen möchten',
	'UCP_INVITE_REQUEST_BUY_SUBT_EXPLAIN'	=> 'Geben Sie die Anzahl an Einladungen ein, die Sie kaufen möchten. Der Einladungspreis beträgt <b>%s %s</b>.<br />Sie tragen die Verantwortung für Ihre eingeladenen Benutzer, falls sie sich unangemessen verhalten.',
	'UCP_INVITE_REQUEST_BUY_SUCCESS'		=> 'Der Einladungskauf war erfolgreich.',
	'UCP_INVITE_REQUEST_BUY_TITLE'			=> 'Einladung kaufen.',
	'UCP_INVITE_REQUEST_DISABLED'			=> 'Die Anfrage ist ausgeschaltet!',
	'UCP_INVITE_REQUEST_MAX'				=> 'Höchstanzahl an Anfragen: (%s) Einladung(en)!',
	'UCP_INVITE_REQUEST_MESSAGE_NO_DB'		=> '<em>Nein! Es gab keinen Anlass.</em>',
	'UCP_INVITE_REQUEST_MIN'				=> 'Mindestanzahl an Einladungsanfragen: (1)',
	'UCP_INVITE_REQUEST_NO_MESSAGE'			=> 'Sie haben keine Nachricht eingegeben! Grundlos können Sie nicht so viele Einladungen beanspruchen.',
	'UCP_INVITE_REQUEST_OFF'				=> 'Ihre Einladungsanfrage steht aus. Wenn ein Administrator/Moderator Ihre Anfrage bearbeitet hat, erhalten Sie eine private Nachricht.',
	'UCP_INVITE_REQUEST_SOK_EXPLAIN'		=> 'Wenn Sie mehr als <b>(%s)</b> Anfragen versenden, ist eine Erklärung nötig. Bitte erklären Sie, warum Sie so viele Einladungen benötigen.<br />Wenn wir glauben, Ihre Anfrage sei akzeptabel, werden Sie die Einladungen erhalten. Falls wir Missbrauch feststellen, kann Ihr Benutzerkonto gesperrt werden.',
	'UCP_INVITE_REQUEST_SUBMIT'				=> 'Anfrage senden',
	'UCP_INVITE_REQUEST_SUCC'				=> 'Die Einladungsanfrage wurde erfolgreich versandt!',
	'UCP_INVITE_REQUEST_SUCCS'				=> 'Die Einladungsanfragen wurden erfolgreich versandt',
	'UCP_INVITE_REQUEST_TITLE'				=> 'Benötigte Einladungen',
	'UCP_INVITE_REQUEST_TITLE_EXPLAIN'		=> 'Geben Sie die Anzahl an Einladungen ein, die Sie beantragen möchten. Es gibt eine Höchstgrenze von <b>(%s)</b> verfügbaren Einladungen.<br />Sie übernehmen die volle Haftung für jeden von Ihnen eingeladenen Benutzer, falls er sich unangemessen verhält.',
	'UCP_INVITE_SEND'						=> 'Einladung senden',
	'UCP_INVITE_SEND_EMAIL_MAX'				=> 'Höchstens %s E-Mail-Adressen können verwendet werden. Sie haben aber %s aufgeführt!',
	'UCP_INVITE_SEND_MAX'					=> '<span class="meghivo_tred">Momentan gibt es keine Grenze!</span>',
	'UCP_INVITE_LAST_ACTIVE'				=> 'Zuletzt aktiv',
	'UCP_INVITE_MAX_ERROR'					=> 'Momentan haben Sie unbegrenzte Einladungen.',
	'UCP_INVITE_MAX_RECIPIENTS'				=> 'Geben Sie alle Adressen in einer neuen Zeile ein!<br />Höchstanzahl an Empfängern',
	'UCP_INVITE_MESSAGE_BODY_EXPLAIN'		=> 'Schreiben Sie ein paar Zeilen und erläutern Sie, warum sie beitreten sollen.',
	'UCP_INVITE_NOT_DELETED_INVITE'			=> 'Es ist keine Einladung zu löschen!',
	'UCP_INVITE_NOT_LANGUAGE'				=> 'Inexistente Sprachdatei: %s',
	'UCP_INVITE_NO_EMAIL'					=> 'Sie haben keine E-Mail-Adresse angegeben!',
	'UCP_INVITE_NO_INVITE_USERS'			=> 'Sie haben noch niemanden eingeladen oder es hat sich noch niemand registriert.',
	'UCP_INVITE_NO_LOGIN'					=> 'Er/sie hat sich nicht auf der Seite registriert.',
	'UCP_INVITE_NO_PERM'					=> 'Sie sind nicht befugt, Einladungen zu versenden!',
	'UCP_INVITE_NO_PERM_EMAIL'				=> 'Sie sind nicht befugt, E-Mails zu versenden!',
	'UCP_INVITE_MEMBERSHIP_DAYS'			=> 'Sie müssen mindestens %1$d Tage Mitglied sein, bevor Sie Einladungen senden können. Sie können Einladungen ab %2$s senden.',
	'UCP_INVITE_NO_REG'						=> 'Niemand wurde von Ihnen eingeladen.',
	'UCP_INVITE_NULL'						=> 'Sie haben keine Einladungen! <em>Warum kaufen Sie nicht einfach welche?</em>',
	'UCP_INVITE_POINTS_AMOUNT'				=> 'Geschenk',
	'UCP_INVITE_POINTS_AMOUNT_EXPLAIN'		=> 'Anzahl der Punkte, die Sie bekommen, wenn Ihr eingeladener Benutzer sich registriert.',
	'UCP_INVITE_POINTS_COST'				=> 'Einladungspreis',
	'UCP_INVITE_POINTS_COST_EXPLAIN'		=> 'Die Kosten für das Versenden einer Einladung.',
	'UCP_INVITE_POST_LIMIT'					=> 'Sie müssen mindestens %s Beiträge haben, um Einladungen versenden zu können!',
	'UCP_INVITE_REQUEST_SUBJECT'			=> 'Einladungsanfrage',
	'UCP_INVITE_SDB'						=> 'Einladung(en).',
	'UCP_INVITE_SEND_OFF'					=> 'Das Versenden von Einladungen ist zurzeit deaktiviert!',
	'UCP_INVITE_SEND_SUBMIT'				=> 'Einladung senden',
	'UCP_INVITE_TIME_END'					=> 'Ablaufdatum',
	'UCP_INVITE_TIME_END_EXPLAIN'			=> 'Der eingeladene Benutzer muss sich in dieser Zeitspanne registrieren.',
	'UCP_INVITE_USER'						=> 'Eingeladene Benutzer',
	'UCP_INVITE_USERS_COUNT'				=> 'Eingeladene Benutzer (%s)',
	'UCP_INVITE_USER_OK'					=> 'Einladung angenommen',
	'UCP_INVITE_LU_REG'						=> 'Letzter Benutzer',
	'UCP_INVITE_LU_REG_EXPLAIN'				=> 'Der letzte von Ihnen eingeladene Benutzer.',
	'UCP_INVITE_LU_REG_INFO'				=> '<b>%s</b> registrierte sich am %s',

	'WEEKS'									=> 'Wochen',

	'NOTIFICATION_TYPE_INVITE_BIRTHDAY'			=> 'You receive invitations for your birthday',
	'NOTIFICATION_TYPE_INVITE_GIFT'				=> 'You receive invitations after you successfully invited a user',
	'NOTIFICATION_TYPE_INVITE_PETITION'			=> 'You receive an invitation request',
	'NOTIFICATION_TYPE_INVITE_PETITION_REQUEST' => 'You receive an invitation request',
	'NOTIFICATION_TYPE_INVITE_JOIN'				=> 'A user you invited has registered an account',
));
