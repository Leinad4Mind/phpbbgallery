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

	'UCP_CAT_MEGHIVO'						=> 'phpBB Invite',
	'UCP_MEGHIVO'							=> 'Meghívó',
	'UCP_MEGHIVO_ADAT'						=> 'Meghívó adatok',
	'UCP_MEGHIVO_BACK'						=> '<br /><br />%sVissza a felhasználói vezérlőpultba%s',
	'UCP_MEGHIVO_DAYF'						=> 'Ma elküldött meghívó',
	'UCP_MEGHIVO_DAYF_EXPLAIN'				=> 'A mai napon eddig ennyi meghívott küldtél el.',
	'UCP_MEGHIVO_DAY_OFF'					=> 'A mai napon már nem küldhetsz ki több meghívót.',
	'UCP_MEGHIVO_DB'						=> '<b>%s darab.</b>',
	'UCP_MEGHIVO_DB_KULDES'					=> 'Kiküldhető meghívó/nap',
	'UCP_MEGHIVO_DB_KULDES_EXPLAIN'			=> 'Maximum ennyi meghívót küldhetsz ki naponta.',
	'UCP_MEGHIVO_DB_MAX'					=> '<span class="meghivo_tred">Korlátlan!</span>',
	'UCP_MEGHIVO_DB_PENDING'				=> 'Függőben lévő meghívó',
	'UCP_MEGHIVO_DB_PENDING_EXPLAIN'		=> 'Itt láthatód, hogy a kiküldött meghívóiddal még mennyien nem regisztráltak be.',
	'UCP_MEGHIVO_DB_SZAM'					=> 'Meghívóid száma',
	'UCP_MEGHIVO_DB_SZAM_EXPLAIN'			=> 'A kiküldhető Meghívóid száma.',
	'UCP_MEGHIVO_DB_USER'					=> 'Meghívott felhasználó',
	'UCP_MEGHIVO_DB_USERS'					=> 'Meghívott felhasználók',
	'UCP_MEGHIVO_DB_USERS_EXPLAIN'			=> 'Az általad eddig meghívott felhasználók száma.',
	'UCP_MEGHIVO_DB_USER_EXPLAIN'			=> 'Az általad eddig meghívott felhasználók száma.',
	'UCP_MEGHIVO_DELETE'					=> 'Meghívó törlése',
	'UCP_MEGHIVO_DELETE_EXPLAIN'			=> 'Itt lehetőséged van a rossz címre kiküldött meghívókat törölni.<br /><em>Elküldéstől számított %s percig.</em>',
	'UCP_MEGHIVO_DELETE_NO_CONFIRM'			=> 'A törlés nem lett megerősítve.',
	'UCP_MEGHIVO_DELETE_SUCCES'				=> 'A meghívó törlése sikeres.',
	'UCP_MEGHIVO_DISABLED'					=> '%sA meghívó rendszer kikapcsolva!%s',
	'UCP_MEGHIVO_DUP'						=> 'A megadott e-mail címre már lett kiküldve meghívó. -> %s',
	'UCP_MEGHIVO_EDUP'						=> 'Egy e-mail címet többször is megadtál. -> %s',
	'UCP_MEGHIVO_EMAILS_SENT'				=> 'A meghívók sikeresen elküldve.',
	'UCP_MEGHIVO_EMAIL_LANG'				=> 'E-mail nyelv',
	'UCP_MEGHIVO_EMAIL_KERES_EXPLAIN'		=> 'Írj pár sort miért is van szükséged ennyi meghívóra.',
	'UCP_MEGHIVO_EMAIL_SELECT'				=> 'Meghívó kiválasztása',
	'UCP_MEGHIVO_EMAIL_SELECT_EXPLAIN'		=> 'Válaszd ki azt a címzettet amelyiket törölni szeretnéd.',
	'UCP_MEGHIVO_EMAIL_SENT'				=> 'A meghívó sikeresen elküldve.',
	'UCP_MEGHIVO_FLOOD_LIMIT'				=> 'Most nem küldhetsz több meghívót. Kérjük, próbálkozz később.',
	'UCP_MEGHIVO_FRIEND'					=> 'Barát hozzáadása',
	'UCP_MEGHIVO_FRIEND_EXPLAIN'			=> 'A meghívott felhasználó hozzáadásra kerül a barát listádhoz.',
	'UCP_MEGHIVO_FUG_LIMIT'					=> 'A mai nap már csak %s meghívót küldhetsz ki te viszont %s címzettet adtál meg.',
	'UCP_MEGHIVO_KERES'						=> 'Meghívó igénylése',
	'UCP_MEGHIVO_KERES_BUYS_SUCCES'			=> 'A meghívók vásárlása sikeres.',
	'UCP_MEGHIVO_KERES_BUY_MIN'				=> 'Minimum (1) meghívó vásárolható.',
	'UCP_MEGHIVO_KERES_BUY_NO'				=> 'Neked nincs elég %sod a vásárláshoz. Jelenleg neked %s %sod van.',
	'UCP_MEGHIVO_KERES_BUY_SUBMIT'			=> 'Vásárlás',
	'UCP_MEGHIVO_KERES_BUY_SUBT'			=> 'Vásárolni kívánt meghívó',
	'UCP_MEGHIVO_KERES_BUY_SUBT_EXPLAIN'	=> 'Írd be a vásárolni kívánt meghívók számát. Egy meghívó ára <b>%s %s</b>.<br />A meghívott személy ért a felelősséget te vállalod, amennyiben a meghívott személy rendbontást csinál.',
	'UCP_MEGHIVO_KERES_BUY_SUCCES'			=> 'A meghívó vásárlása sikeres.',
	'UCP_MEGHIVO_KERES_BUY_TITLE'			=> 'Meghívó vásárlása',
	'UCP_MEGHIVO_KERES_DISABLED'			=> 'Az igénylés jelenleg ki van kapcsolva!',
	'UCP_MEGHIVO_KERES_MAX'					=> 'Maximum igénylések száma (%s) darab.',
	'UCP_MEGHIVO_KERES_MESSAGE_NO_DB'		=> '<em>Nincs! Nem volt rá szükség.</em>',
	'UCP_MEGHIVO_KERES_MIN'					=> 'Minimum igénylések száma (1) darab.',
	'UCP_MEGHIVO_KERES_NO_MES'				=> 'Nem írtál üzenetet. Indoklás nélkül nem igényelhető ennyi meghívó.',
	'UCP_MEGHIVO_KERES_OFF'					=> 'A meghívó iránti kérelmed még nincs elbírálva, amint egy adminisztrátor/moderátor elbírálja, kapni fogsz róla egy privát üzenetet.',
	'UCP_MEGHIVO_KERES_SOK_EXPLAIN'			=> '<b>(%s)</b> darab meghívó igénylésétől indoklás szükséges, kérlek indokold meg, hogy miért is van szükséged ennyi meghívóra.<br />Amennyiben úgy látjuk, hogy kérésed elfogadható, akkor a meghívókat kiutaljuk számodra. Ha visszaélést tapasztalunk, akkor az kitiltással is járhat.',
	'UCP_MEGHIVO_KERES_SUBMIT'				=> 'Igény elküldése',
	'UCP_MEGHIVO_KERES_SUCC'				=> 'A meghívóra az igénylésed elküldésre került.',
	'UCP_MEGHIVO_KERES_SUCCS'				=> 'A meghívókra az igénylésed elküldésre került.',
	'UCP_MEGHIVO_KERES_TITLE'				=> 'Igényelt meghívó',
	'UCP_MEGHIVO_KERES_TITLE_EXPLAIN'		=> 'Írd be az igényelni kívánt meghívók számát maximum <b>(%s)</b> darab meghívó igényelhető.<br />A meghívott személy ért a felelősséget te vállalod, amennyiben a meghívott személy rendbontást csinál.',
	'UCP_MEGHIVO_KULDES'					=> 'Meghívó kiküldése',
	'UCP_MEGHIVO_KULDES_EMAIL_MAX'			=> 'Maximum %s email címet lehet megadni, te viszont %s adtál meg.',
	'UCP_MEGHIVO_KULDES_MAX'				=> '<span class="meghivo_tred">Jelenleg nincs korlátozva.</span>',
	'UCP_MEGHIVO_LAST_ACTIVE'				=> 'Utoljára aktív',
	'UCP_MEGHIVO_MAX_ERROR'					=> 'Jelenleg korlátlan meghívóval rendelkezel így nincs szükséged az igénylésre.',
	'UCP_MEGHIVO_MAX_RECIPIENTS'			=> 'Minden címet új sorba írj.<br />Maximum megadható címzettek száma',
	'UCP_MEGHIVO_MESSAGE_BODY_EXPLAIN'		=> 'Írj pár sort miért is csatlakozzon az illető.',
	'UCP_MEGHIVO_NOT_DELETED_INVITE'		=> 'Nincs törölhető meghívód.',
	'UCP_MEGHIVO_NOT_LANGUAGE'				=> 'Nem létező nyelvi fájl: %s',
	'UCP_MEGHIVO_NO_EMAIL'					=> 'Nem adtál meg e-mail címet.',
	'UCP_MEGHIVO_NO_INVITE_USERS'			=> 'Jelenleg még nem hívtál meg senkit.',
	'UCP_MEGHIVO_NO_LOGIN'					=> 'Még nem lépet be.',
	'UCP_MEGHIVO_NO_PERM'					=> 'Nincs jogosultságod meghívót kiküldeni.',
	'UCP_MEGHIVO_NO_PERM_EMAIL'				=> 'Nincs jogosultságod emailt küldeni.',
	'UCP_MEGHIVO_NO_REG'					=> 'Még nem hívtál meg senkit.',
	'UCP_MEGHIVO_NULL'						=> 'Nincs rendelkezésedre álló meghívó.',
	'UCP_MEGHIVO_POINTS_AMOUNT'				=> 'Ajándék',
	'UCP_MEGHIVO_POINTS_AMOUNT_EXPLAIN'		=> 'Az általad meghívott és be is regisztrált tag után járó ajándék összege.',
	'UCP_MEGHIVO_POINTS_COST'				=> 'Meghívó ára',
	'UCP_MEGHIVO_POINTS_COST_EXPLAIN'		=> 'Vásárlás esetén ennyibe fog kerülne egy darab meghívó.',
	'UCP_MEGHIVO_POST_LIMIT'				=> 'Minimum %s hozzászólással kell rendelkezned ahhoz, hogy meghívott küldhess ki.',
	'UCP_MEGHIVO_REQUEST_SUBJECT'			=> 'Meghívó kérelem',
	'UCP_MEGHIVO_SDB'						=> 'darab.',
	'UCP_MEGHIVO_SEND_OFF'					=> 'A meghívó küldés jelenleg kikapcsolva!',
	'UCP_MEGHIVO_SEND_SUBMIT'				=> 'Meghívó elküldése',
	'UCP_MEGHIVO_TIME_END'					=> 'Lejárati idő',
	'UCP_MEGHIVO_TIME_END_EXPLAIN'			=> 'Azaz idő ami alatt a meghívott felhasználónak felkel használnia a meghívóját.',
	'UCP_MEGHIVO_USER'						=> 'Meghívott felhasználók',
	'UCP_MEGHIVO_USERS_COUNT'				=> 'Meghívott felhasználók (%s)',
	'UCP_MEGHIVO_USER_OK'					=> 'Meghívást elfogadta',
	'UCP_MEGHIVO_UT_REG'					=> 'Utolsó felhasználó',
	'UCP_MEGHIVO_UT_REG_EXPLAIN'			=> 'A meghívásodra érkező utolsó felhasználó.',
	'UCP_MEGHIVO_UT_REG_INFO'				=> '<b>%s</b> regisztrált %s',

	'WEEKS'									=> 'Hét',

	'NOTIFICATION_TYPE_INVITE_BIRTHDAY'		=> 'You receive invitations for your birthday',
	'NOTIFICATION_TYPE_INVITE_GIFT'			=> 'You receive invitations after you successfully invited a user',
	'NOTIFICATION_TYPE_INVITE_PETITION'		=> 'You receive an invitation request',
	'NOTIFICATION_TYPE_INVITE_PETITION_REQUEST' => 'You receive an invitation request',
	'NOTIFICATION_TYPE_INVITE_JOIN'			=> 'A user you invited has registered an account',
));
