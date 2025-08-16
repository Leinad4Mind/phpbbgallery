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
	'AUTH_CACHE_PURGE'						=> 'Jogosultság gyorsítótár kiürítése',

	'CACHE_PURGE'							=> 'Fórum gyorsítótárának kiürítése',
	'CAT_INSTALL'							=> 'Telepítés',
	'CAT_OVERVIEW'							=> 'Áttekintés',
	'CAT_UNINSTALL'							=> 'Törlés',
	'CAT_UPDATE'							=> 'Frissítés',
	'CAT_VERIFY'							=> 'Ellenőrzés',

	'GPL'									=> 'Általános Nyilvános Licenc',

	'INCOMPLETE_FILES_UPLOAD'				=> 'A fájlok feltöltése hiányos, míg nem kerül feltöltésre az összes fájl addig a telepítés nem futtatható!',
	'INCOMPLETE_FILE_EDITS'					=> 'A fájl szerkesztések nem lettek elvégezve, míg a szerkesztések nem lesznek elvégezve addig a telepítés nem futtatható!',
	'INCOMPLETE_LANG_ROWS'					=> 'A használt nyelvi fájlban hiányosságok vannak, kérlek frissítsd az %sITT%s leírtak szerint.',
	'INSTALLATION'							=> 'phpBB Invite telepítése',
	'INSTALLATION_EXPLAIN'					=> '<br />phpBB Invite adatbázisának telepítése.<br /><br />',
	'INSTALL_BODY'							=> 'Itt láthatod, hogy a mod állttal létrehozott adatbázis adatok jól-e lettek beszerelve.',
	'INSTALL_ERR_AUTH'						=> 'Nincs jogosultságod a telepítő futtatásához.<br /><br />Kérlek ellenőrizd, hogy be-e vagy jelentkezve, ha igen és mégse működik akkor nem te vagy az alapítója az pagenak, vagy nem megfelelőek a süti beállításaid, <strong>http://www.example.com</strong> ellenőrizd, hogy helyesek-e a fórum süti beállításaid <strong>example.com</strong>',
	'INSTALL_FOLDER'						=> '<strong>Kérlek töröld az install mappát, míg nem törlöd addig csak az (AVP) lesz elérhető.</strong>',
	'INSTALL_LOGIN'							=> 'Tovább az AVP-be',

	'INVITE_CONFIG_ADD'						=> 'Új meghívó konfigurációs változó hozzáadása: %s',
	'INVITE_CONFIG_ALREADY_EXISTS'			=> 'HIBA: A %s meghívó konfigurációs változó már létezik.',
	'INVITE_CONFIG_NOT_EXIST'				=> 'HIBA: A %s meghívó konfigurációs változó nem létezik.',
	'INVITE_CONFIG_REMOVE'					=> 'Meghívó konfigurációs változó törlése: %s',
	'INVITE_CONFIG_UPDATE'					=> 'Meghívó konfigurációs változó frissítése: %s',

	'INVITE_INSTALL_INTRO'					=> 'Üdvözöllek, phpBB Invite telepítő',
	'INVITE_INSTALL_INTRO_BODY'				=> 'Ezzel az opcióval telepítheted a phpBB Invite az adatbázisodba.',

	'INVITE_VERSION'						=> 'A phpBB Invite verziója <b>%s</b>, ez a frissítő állomány <b>%s</b> - <b>%s</b> verzió frissítésére használható.<br />Neked először frissítened kell <b>%s</b> verzióra ahhoz, hogy ezt a frissítő állományt letud futtatni.',

	'NOT_INSTALL_DIR'						=> 'Nem lehet az install könyvtárat megnyitni.',
	'NOT_LANGUAGE_DIR'						=> 'A language könyvtár nem elérhető.',
	'NOT_LANGUAGE_DIR_DIR'					=> 'A %s nyelvi könyvtár nem található.',
	'NOT_MODULE'							=> 'Az üzembe helyezési modulok nem elérhetőek.',
	'NOT_MODULE_OPEN'						=> '%s Modul nem hozzáférhető.',
	'NO_TABLE_DATA'							=> '<span style="color:#FF0000;">Hiba:</span> A tábla adatai hiányoznak.',

	'OVERVIEW_BODY'							=> 'Üdvözlet<br /><br />A telepítési rendszer teljes útmutatót mutat be a mod beszerelésére vagy törlésére, ill. frissítésére.<br />Válasz a menüből, folytatás.... kérem válasza ki a megfelelő opciót.',

	'PARENT_NOT_EXIST'						=> '<span style="color:#FF0000;">Hiba:</span> A szülőkategória, amire az új modul mutat nem létezik.',
	'PERMISSIONS_WARNING'					=> 'Új jogosultság beállítások kerültek hozzáadásra.  Feltétlenül ellenőrizd a jogosultság beállításaid, és győződj meg róla, hogy jól vannak beállítva.',
	'PHPBB_INVITE_DONATE'					=> 'Kérlek értékeld egy kis adománnyal a sok munkát, időt amit a fejlesztők áldoznak a “phpBB Invite” fejlesztésére.',
	'PHPBB_INVITE_DONATE_TITLE'				=> 'phpBB Invite adományozás',
	'PHPBB_VERSION'							=> 'A phpBB verziód <b>%s</b>, a phpBB Invite csak <b>%s</b> verziótól futtatható.',
	'PHP_VERSION_RUN'						=> 'A jelenlegi PHP verziód nem támogatott, kérlek frissítsd a PHP 4.3.3 verzióra vagy egy újabb verzióra mielőtt futtatnád a phpBB Invite telepítését.</b>',

	'ROLE_NOT_EXIST'						=> '<span style="color:#FF0000;">Hiba:</span> ez a szerep nem szerepel az adatbázisban.',

	'STAGE_INSTALL'							=> 'Telepítés',
	'STAGE_INTRO'							=> 'Bevezető',
	'STAGE_UNINSTALL'						=> 'Adatbázis törlése',
	'STAGE_VERIFY'							=> 'Ellenőrzés',
	'STAGE_VERIFY_FILE_EXPLAIN'				=> '<br />A mod által használt fájlok sirequesten törölve.',
	'SUB_INTRO'								=> 'Bevezető',
	'SUB_LICENSE'							=> 'Licenc',
	'SUB_SUPPORT'							=> 'Támogatás',
	'SUCCESSES'								=> '<span style="color:#000;"><b>Sirequesten végrehajtva.</b></span>',
	'SUPPORT_BODY'							=> 'Teljes támogatást fognak nyújtani a phpBB Invite aktuális telepítési és fejlesztési kibocsátásáért, mindez ingyen.<br />Ez tartalmaz:</p><ul><li>üzembe helyezést</li><li>konfigurációt</li><li>régebbi verzió frissítése a legújabb verzióra</li></ul><p>Bátorítok mindenkit aki a régebbi verziót használja az nyugodtan frissítse le az új verzióra.</p><h2>Támogatási csoport</h2><br /><p><a href="http://jatek-vilag.com/viewtopic.php?p=204#p204" onclick="window.open(this.href); return false;">Fő fejlesztési helyszín</a><br /><a href="https://www.phpbb.com/community/viewtopic.php?p=12855248#p12855248" onclick="window.open(this.href); return false;">phpBB.com Fejlesztési téma</a><br /><a href="http://phpbb.hu/forum/hsz/40666#hsz-40666" onclick="window.open(this.href); return false;">phpBB.hu Fejlesztési téma</a><br /><br />',

	'UNINSTALL_BODY'						=> 'Itt láthatod, hogy a mod állttal létrehozott adatbázis adatok sirequesten el-e lettek távolítva.<br /><br /><b>Kérlek töröld az install mappát, míg nem törlöd addig csak az (AVP) lesz elérhető.</b>',
	'UNINSTALL_INTRO'						=> 'phpBB Invite törlése',
	'UNINSTALL_INTRO_BODY'					=> 'Ebben az opcióban törölheted az adatbázisból a phpBB Invite adatait.',
	'UNINSTALL_TITLE'						=> 'phpBB Invite törlése az adatbázisból',
	'UPDATE_BODY'							=> 'Itt láthatod, hogy a mod állttal létrehozott adatbázis adatok jól-e lettek frissítve.<br /><br /><b>Kérlek töröld az install mappát, míg nem törlöd addig csak az (AVP) lesz elérhető.</b>',
	'UPDATE_INSTALLATION'					=> 'phpBB Invite frissítése',
	'UPDATE_INSTALLATION_EXPLAIN'			=> '<br />phpBB Invite adatbázisának frissítése a legújabb verzióra.<br />',
	'UPDATE_TITLE'							=> 'Adatbázis adatok frissítése',

	'VERIFY_ERROR_EXPLAIN'					=> 'Az ellenőrzés hibát talált.',
	'VERIFY_ERROR_FILE'						=> 'Hibás fájl módosítás',
	'VERIFY_ERROR_FILE_EXPLAIN'				=> 'Itt láthatód azokat a fájlokat amik rosszul lettek szerkesztve vagy ki lett hagyva.',
	'VERIFY_EXITS_PRINT_MYAD'				=> '<br />Az itt látható sql paranccsal te magad is telepítheted, ha lefuttatod a phpmyadminba.',
	'VERIFY_EXITS_PRINT_SQL'				=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">nem található.</span></b><br />%s<br />',
	'VERIFY_INVITE_MOD_CONFIG'				=> 'phpBB Invite konfiguráció',
	'VERIFY_INVITE_MOD_CONFIG_OK'			=> '<span style="color:#228822;"><strong>Összes phpBB Invite config létezik.</strong></span>',
	'VERIFY_INVITE_MOD_FILES'				=> 'phpBB Invite fájlok',
	'VERIFY_INVITE_MOD_FILES_OK'			=> '<span style="color:#228822;"><strong>Összes fájl létezik.</strong></span>',
	'VERIFY_INVITE_MOD_MODULES'				=> 'phpBB Invite modulok',
	'VERIFY_INVITE_MOD_MODULES_OK'			=> '<span style="color:#228822;"><strong>Összes modul létezik.</strong></span>',
	'VERIFY_INVITE_MOD_PERM'				=> 'phpBB Invite jogosultságok',
	'VERIFY_INVITE_MOD_PERM_OK'				=> '<span style="color:#228822;"><strong>Összes jogosultság létezik.</strong></span>',
	'VERIFY_INVITE_MOD_TABLES'				=> 'phpBB Invite táblák',
	'VERIFY_INVITE_MOD_TABLES_OK'			=> '<span style="color:#228822;"><strong>Összes tábla létezik</strong></span>',
	'VERIFY_NOT_AC_FOUND'					=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">nem található.</span></b>',
	'VERIFY_NOT_COLUMN'						=> 'Hiányzó oszlop',
	'VERIFY_NOT_COLUMN_EXPLAIN'				=> 'Itt láthatod azokat az oszlopokat amik nem lettek telepítve.',
	'VERIFY_NOT_CONFIG'						=> 'Hiányzó config',
	'VERIFY_NOT_CONFIG_EXPLAIN'				=> 'Itt láthatod azokat a config állományokat amik nem lettek telepítve.',
	'VERIFY_NOT_FILE'						=> 'Hiányzó állomány',
	'VERIFY_NOT_FILE_EXPLAIN'				=> 'Itt láthatód azokat a fájlokat amik nem kerültek feltöltésre vagy ép rossz helyre lettek feltöltve.',
	'VERIFY_NOT_INVITE_CONFIG'				=> 'Hiányzó meghivo_config',
	'VERIFY_NOT_INVITE_CONFIG_EXPLAIN'		=> 'Itt láthatod azokat a meghivo_config állományokat amik nem lettek telepítve.',
	'VERIFY_NOT_MODULE'						=> 'Hiányzó modul',
	'VERIFY_NOT_MODULE_EXPLAIN'				=> 'Itt láthatod azokat a modulokat amik nem lettek telepítve.',
	'VERIFY_NOT_PERMIS'						=> 'Hiányzó jogosultság',
	'VERIFY_NOT_PERMIS_EXPLAIN'				=> 'Itt láthatod azokat a jogosultságokat amik nem lettek telepítve.',
	'VERIFY_NOT_TABLE'						=> 'Hiányzó tábla',
	'VERIFY_NOT_TABLE_EXPLAIN'				=> 'Itt láthatod azokat a táblákat amik nem lettek telepítve.',
	'VERIFY_NO_COLUMN'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">oszlop nem található.</span></b><br />%s<br />',
	'VERIFY_NO_MODULE'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">modul nem található az adatbázisban.</span></b>',
	'VERIFY_NO_PERMIS'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">jogosultság nem található az adatbázisban.</span></b>',
	'VERIFY_NO_TABLE'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">tábla nem található az adatbázisban.</span></b>%s',
	'VERIFY_PHPBB_MOD_COLUMNS'				=> 'PhpBB users tábla új oszlopok',
	'VERIFY_PHPBB_MOD_COLUMNS_OK'			=> '<span style="color:#228822;"><strong>Összes oszlop létezik.</strong></span>',
	'VERIFY_PHPBB_MOD_CONFIG'				=> 'PhpBB új config',
	'VERIFY_PHPBB_MOD_CONFIG_OK'			=> '<span style="color:#228822;"><strong>phpBB config létezik.</strong></span>',
	'VERIFY_PHPBB_MOD_FILES'				=> 'PhpBB fájl szerkesztések',
	'VERIFY_PHPBB_MOD_FILES_OK'				=> '<span style="color:#228822;"><strong>Összes fájl helyesen lett szerkesztve.</strong></span>',
	'VERIFY_SUCCESSES_EXPLAIN'				=> 'Az ellenőrzés mindent rendben talált.',
	'VERIFY_TITLE'							=> 'phpBB Invite ellenőrzése',
	'VERIFY_TITLE_ELL'						=> 'Ellenőrzési hiba',
	'VERIFY_TITLE_ELL_EXPLAIN'				=> '<span style="color:#000;"><b>Itt láthatód az összes hibát ami keletkezet e szerint javíts mindent figyelmesen.</b></span>',
	'VERIFY_TITLE_EXPLAIN'					=> '<br />Itt lehetőséged van ellenőrizni, hogy a mod által szükséges szerkesztések ill. a hozzá szükséges fájlok és adatbázis tartományok helyesen-e lettek telepítve ill. frissítve.',
	'VERIFY_NEW'							=> 'Ellenőrzés újra',
	'VERIFY_UNINSTALL_ERROR_FILE'			=> 'Meglévő állomány',
	'VERIFY_UNINSTALL_ERROR_FILE_EXPLAIN'	=> 'Itt láthatód azokat a fájlokat amik nem kerültek eltávolításra.',
));
