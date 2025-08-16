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
	'POST_CONFIRM_EXPLAIN'					=> 'Az automatikus meghívó küldés megakadályozása érdekében meg kell adnod egy megerősítő kódot. A kód az alábbi képen szerepel. Ha látási vagy egyéb problémák miatt nem tudod elolvasni a kódot, lépj kapcsolatba a %sfórum adminisztrátorával%s.',

	'UCP_CAT_INVITE'						=> 'phpBB Invite',
	'UCP_INVITE'							=> 'Meghívó',
	'UCP_INVITE_DATA'						=> 'Meghívó adatok',
	'UCP_INVITE_BACK'						=> '<br /><br />%sVissza a felhasználói vezérlőpultba%s',
	'UCP_INVITE_DAYF'						=> 'Ma elküldött meghívó',
	'UCP_INVITE_DAYF_EXPLAIN'				=> 'A mai napon eddig ennyi meghívott küldtél el.',
	'UCP_INVITE_DAY_OFF'					=> 'A mai napon már nem küldhetsz ki több meghívót.',
	'UCP_INVITE_DB'							=> '<b>%s piece.</b>',
	'UCP_INVITE_DB_SEND'					=> 'Kiküldhető meghívó/nap',
	'UCP_INVITE_DB_SEND_EXPLAIN'			=> 'Maximum ennyi meghívót küldhetsz ki naponta.',
	'UCP_INVITE_DB_MAX'						=> '<span class="meghivo_tred">Korlátlan!</span>',
	'UCP_INVITE_DB_PENDING'					=> 'Függőben lévő meghívó',
	'UCP_INVITE_DB_PENDING_EXPLAIN'			=> 'Itt láthatód, hogy a kiküldött meghívóiddal még mennyien nem regisztráltak be.',
	'UCP_INVITE_DB_NUMBER'					=> 'Meghívóid száma',
	'UCP_INVITE_DB_NUMBER_EXPLAIN'			=> 'A kiküldhető Meghívóid száma.',
	'UCP_INVITE_DB_USER'					=> 'Meghívott felhasználó',
	'UCP_INVITE_DB_USERS'					=> 'Meghívott felhasználók',
	'UCP_INVITE_DB_USERS_EXPLAIN'			=> 'Az általad eddig meghívott felhasználók száma.',
	'UCP_INVITE_DB_USER_EXPLAIN'			=> 'Az általad eddig meghívott felhasználók száma.',
	'UCP_INVITE_DELETE'						=> 'Meghívó törlése',
	'UCP_INVITE_DELETE_EXPLAIN'				=> 'Itt lehetőséged van a rossz címre kiküldött meghívókat törölni.<br /><em>Elküldéstől számított %s percig.</em>',
	'UCP_INVITE_DELETE_NO_CONFIRM'			=> 'A törlés nem lett megerősítve.',
	'UCP_INVITE_DELETE_SUCCESS'				=> 'A meghívó törlése sirequest.',
	'UCP_INVITE_DISABLED'					=> '%sA meghívó rendszer kikapcsolva!%s',
	'UCP_INVITE_DUP'						=> 'A megadott e-mail címre már lett kiküldve meghívó. -> %s',
	'UCP_INVITE_EDUP'						=> 'Egy e-mail címet többször is megadtál. -> %s',
	'UCP_INVITE_EMAILS_SENT'				=> 'A meghívók sirequesten elküldve.',
	'UCP_INVITE_EMAIL_LANG'					=> 'E-mail nyelv',
	'UCP_INVITE_EMAIL_REQUEST_EXPLAIN'		=> 'Írj pár sort miért is van szükséged ennyi meghívóra.',
	'UCP_INVITE_EMAIL_SELECT'				=> 'Meghívó kiválasztása',
	'UCP_INVITE_EMAIL_SELECT_EXPLAIN'		=> 'Válaszd ki azt a címzettet amelyiket törölni szeretnéd.',
	'UCP_INVITE_EMAIL_SENT'					=> 'A meghívó sirequesten elküldve.',
	'UCP_INVITE_FLOOD_LIMIT'				=> 'Most nem küldhetsz több meghívót. Kérjük, próbálkozz később.',
	'UCP_INVITE_FRIEND'						=> 'Barát hozzáadása',
	'UCP_INVITE_FRIEND_EXPLAIN'				=> 'A meghívott felhasználó hozzáadásra kerül a barát listádhoz.',
	'UCP_INVITE_DEP_LIMIT'					=> 'A mai nap már csak %s meghívót küldhetsz ki te viszont %s címzettet adtál meg.',
	'UCP_INVITE_REQUEST'					=> 'Meghívó igénylése',
	'UCP_INVITE_REQUEST_BUYS_SUCCESS'		=> 'A meghívók vásárlása sirequest.',
	'UCP_INVITE_REQUEST_BUY_MIN'			=> 'Minimum (1) meghívó vásárolható.',
	'UCP_INVITE_REQUEST_BUY_NO'				=> 'Neked nincs elég %sod a vásárláshoz. Jelenleg neked %s %sod van.',
	'UCP_INVITE_REQUEST_BUY_SUBMIT'			=> 'Vásárlás',
	'UCP_INVITE_REQUEST_BUY_SUBT'			=> 'Vásárolni kívánt meghívó',
	'UCP_INVITE_REQUEST_BUY_SUBT_EXPLAIN'	=> 'Írd be a vásárolni kívánt meghívók számát. Egy meghívó ára <b>%s %s</b>.<br />A meghívott személy ért a felelősséget te vállalod, amennyiben a meghívott személy rendbontást csinál.',
	'UCP_INVITE_REQUEST_BUY_SUCCESS'		=> 'A meghívó vásárlása sirequest.',
	'UCP_INVITE_REQUEST_BUY_TITLE'			=> 'Meghívó vásárlása',
	'UCP_INVITE_REQUEST_DISABLED'			=> 'Az igénylés jelenleg ki van kapcsolva!',
	'UCP_INVITE_REQUEST_MAX'				=> 'Maximum igénylések száma (%s) piece.',
	'UCP_INVITE_REQUEST_MESSAGE_NO_DB'		=> '<em>Nincs! Nem volt rá szükség.</em>',
	'UCP_INVITE_REQUEST_MIN'				=> 'Minimum igénylések száma (1) piece.',
	'UCP_INVITE_REQUEST_NO_MESSAGE'			=> 'Nem írtál üzenetet. Indoklás nélkül nem igényelhető ennyi meghívó.',
	'UCP_INVITE_REQUEST_OFF'				=> 'A meghívó iránti kérelmed még nincs elbírálva, amint egy adminisztrátor/moderátor elbírálja, kapni fogsz róla egy privát üzenetet.',
	'UCP_INVITE_REQUEST_SOK_EXPLAIN'		=> '<b>(%s)</b> piece meghívó igénylésétől indoklás szükséges, kérlek indokold meg, hogy miért is van szükséged ennyi meghívóra.<br />Amennyiben úgy látjuk, hogy kérésed elfogadható, akkor a meghívókat kiutaljuk számodra. Ha visszaélést tapasztalunk, akkor az kitiltással is járhat.',
	'UCP_INVITE_REQUEST_SUBMIT'				=> 'Igény elküldése',
	'UCP_INVITE_REQUEST_SUCC'				=> 'A meghívóra az igénylésed elküldésre került.',
	'UCP_INVITE_REQUEST_SUCCS'				=> 'A meghívókra az igénylésed elküldésre került.',
	'UCP_INVITE_REQUEST_TITLE'				=> 'Igényelt meghívó',
	'UCP_INVITE_REQUEST_TITLE_EXPLAIN'		=> 'Írd be az igényelni kívánt meghívók számát maximum <b>(%s)</b> piece meghívó igényelhető.<br />A meghívott személy ért a felelősséget te vállalod, amennyiben a meghívott személy rendbontást csinál.',
	'UCP_INVITE_SEND'						=> 'Meghívó kiküldése',
	'UCP_INVITE_SEND_EMAIL_MAX'				=> 'Maximum %s email címet lehet megadni, te viszont %s adtál meg.',
	'UCP_INVITE_SEND_MAX'					=> '<span class="meghivo_tred">Jelenleg nincs korlátozva.</span>',
	'UCP_INVITE_LAST_ACTIVE'				=> 'Utoljára aktív',
	'UCP_INVITE_MAX_ERROR'					=> 'Jelenleg korlátlan meghívóval rendelkezel így nincs szükséged az igénylésre.',
	'UCP_INVITE_MAX_RECIPIENTS'				=> 'Minden címet új sorba írj.<br />Maximum megadható címzettek száma',
	'UCP_INVITE_MESSAGE_BODY_EXPLAIN'		=> 'Írj pár sort miért is csatlakozzon az illető.',
	'UCP_INVITE_NOT_DELETED_INVITE'			=> 'Nincs törölhető meghívód.',
	'UCP_INVITE_NOT_LANGUAGE'				=> 'Nem létező nyelvi fájl: %s',
	'UCP_INVITE_NO_EMAIL'					=> 'Nem adtál meg e-mail címet.',
	'UCP_INVITE_NO_INVITE_USERS'			=> 'Jelenleg még nem hívtál meg senkit.',
	'UCP_INVITE_NO_LOGIN'					=> 'Még nem lépet be.',
	'UCP_INVITE_NO_PERM'					=> 'Nincs jogosultságod meghívót kiküldeni.',
	'UCP_INVITE_NO_PERM_EMAIL'				=> 'Nincs jogosultságod emailt küldeni.',
	'UCP_INVITE_NO_REG'						=> 'Még nem hívtál meg senkit.',
	'UCP_INVITE_NULL'						=> 'Nincs rendelkezésedre álló meghívó.',
	'UCP_INVITE_POINTS_AMOUNT'				=> 'Ajándék',
	'UCP_INVITE_POINTS_AMOUNT_EXPLAIN'		=> 'Az általad meghívott és be is regisztrált tag után járó ajándék összege.',
	'UCP_INVITE_POINTS_COST'				=> 'Meghívó ára',
	'UCP_INVITE_POINTS_COST_EXPLAIN'		=> 'Vásárlás esetén ennyibe fog kerülne egy piece meghívó.',
	'UCP_INVITE_POST_LIMIT'					=> 'Minimum %s hozzászólással kell rendelkezned ahhoz, hogy meghívott küldhess ki.',
	'UCP_INVITE_REQUEST_SUBJECT'			=> 'Meghívó kérelem',
	'UCP_INVITE_SDB'						=> 'piece.',
	'UCP_INVITE_SEND_OFF'					=> 'A meghívó küldés jelenleg kikapcsolva!',
	'UCP_INVITE_SEND_SUBMIT'				=> 'Meghívó elküldése',
	'UCP_INVITE_TIME_END'					=> 'Lejárati idő',
	'UCP_INVITE_TIME_END_EXPLAIN'			=> 'Azaz idő ami alatt a meghívott felhasználónak felkel használnia a meghívóját.',
	'UCP_INVITE_USER'						=> 'Meghívott felhasználók',
	'UCP_INVITE_USERS_COUNT'				=> 'Meghívott felhasználók (%s)',
	'UCP_INVITE_USER_OK'					=> 'Meghívást elfogadta',
	'UCP_INVITE_LU_REG'						=> 'Utolsó felhasználó',
	'UCP_INVITE_LU_REG_EXPLAIN'				=> 'A meghívásodra érkező utolsó felhasználó.',
	'UCP_INVITE_LU_REG_INFO'				=> '<b>%s</b> regisztrált %s',

	'WEEKS'									=> 'Hét',

	'NOTIFICATION_TYPE_INVITE_BIRTHDAY'			=> 'You receive invitations for your birthday',
	'NOTIFICATION_TYPE_INVITE_GIFT'				=> 'You receive invitations after you successfully invited a user',
	'NOTIFICATION_TYPE_INVITE_PETITION'			=> 'You receive an invitation request',
	'NOTIFICATION_TYPE_INVITE_PETITION_REQUEST' => 'You receive an invitation request',
	'NOTIFICATION_TYPE_INVITE_JOIN'				=> 'A user you invited has registered an account',
));
