<?php
/**
*
* BBCore [German]
*
* @package sitesplat BBcore
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

// TRANSLATORS PLEASE NOTE
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

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB')) {
	exit;
}
if (empty($lang) || !is_array($lang)) {
	$lang = array();
}

// load addon lang files first...allow BBCore to overwrite if needed
if (function_exists('\sitesplat\load_ext_lang')) {
    $addon_lang = [];
    \sitesplat\load_ext_lang(__DIR__, $addon_lang);
    $lang = array_merge($lang, $addon_lang);
}


// BBCore
$lang = array_merge($lang, array(
	'PM_NEW_MSG' => [
  
  
    1 => 'Du hast %d neue private Nachricht',
    2 => 'Du hast %d neue private Nachrichten',
  ],
  'PM_UNREAD_MSG' => [
  
  
    1 => 'Du hast %d ungelesene private Nachricht',
    2 => 'Du hast %d ungelesene private Nachrichten',
  ],
  'PM_NEW_MSG_BUBBLE' => [
    1 => '%d',
    2 => '%d',
  ],
  

	'SITESPLAT_EXT'				=> 'Other Extensions',
	'BBCORE_DASHBOARD'			=> 'Dashboard',
	'SITESPLAT_UPDATE_MANAGER'	=> 'Update Manager',
	'BBCORE_SETTINGS'			=> 'Settings',
	'BBCORE_FS_REQUIRE'			=> '%s requires the SiteSplat Filesystem',
	'BBCORE_MYSQL_REQUIRE'		=> '%s requires MySQL',
	'BBCORE_BAD_SERVER'			=> 'Your server settings are incompatible with %s',
	'SS_CHATBOX'				=> 'Chat',
	'CHATBOX_MODERATORS'		=> 'Chatbox Moderators',
	'BBCORE_MEM'				=> '%1$s total, %2$s in use',

	'SS_ADDONS'				=> 'Addons',
	'SS_ADDON_SETTINGS'		=> 'Addon Settings',
	'SS_LID_INFO'			=> 'This is your SiteSplat License Key. You will be required to enter this key after you install or update BBCore.',
  
  'UCP_MAIN'                   => 'Übersicht',
  'UCP_MAIN_FRONT'             => 'Startseite',
  'UCP_MAIN_SUBSCRIPTION'      => 'Abonnements verwalten',
  'UCP_MAIN_BOOKMARKS'         => 'Lesezeichen verwalten',
  'UCP_MAIN_DRAFTS'            => 'Entwürfe verwalten',
  'UCP_MAIN_ATTACHMENTS'       => 'Anhänge verwalten',
  
  
  'USER_PANEL'                 => 'Verwaltungsbereich', 
  'UCP_PROFILE'                => 'Profil',   
  'UCP_PROFILE_PROFILE'        => 'Profil bearbeiten',   
  'UCP_PROFILE_SIGNITURE'      => 'Signatur bearbeiten',   
  'UCP_PROFILE_AVATAR'         => 'Avatar bearbeiten',   
  'UCP_PROFILE_SETTINGS'       => 'Kontoeinstellungen', 
  'UCP_AVATAR_SELECT_OPTIONS'    => 'Avatar Optionen', 
  'UCP_AVATAR_SELECT_UPLOAD'     => 'Avatar vom Computer hochladen',
  'UCP_SUBMIT_TO_UPLOAD'         => 'Hier unten bestätigen zum Hochladen',
  
  'UCP_PREFERENCE'             => 'Board Einstellungen',
  'UCP_PREFERENCE_SETTINGS'    => 'Globale Einstellungen bearbeiten',
  'UCP_PREFERENCE_DEFAULTS'    => 'Standard Beiträge bearbeiten',
  'UCP_PREFERENCE_OPTIONS'     => 'Anzeigeoptionen bearbeiten',
  
  'UCP_MESSAGES'               => 'Nachrichten',   
  'UCP_PM_COMPOSE'             => 'Nachricht erstellen',   
  
  'UCP_PM_DRAFTS'              => 'Entwürfe verwalten',   
  'UCP_PM_INBOX'               => 'Posteingang',   
  'UCP_PM_OUTBOX'              => 'Postausgang',   
  'UCP_PM_SENTBOX'             => 'Senden',   
  'UCP_PM_OPTIONS'             => 'Regeln, Ordner &amp; Einstellungen', 
  'UCP_NO_USER_CHANGE_ALLOWED'   => '**Wechsel des Nutzernamens ist nicht erlaubt**',
  'UCP_REGISTER_EMAIL_EXPLAIN'   => 'Bitte verwenden Sie keine Wegwerf-E-Mails',
  
  'WIDTH_SIZE'                 => 'Breite',   
  'PIXEL_SIZE'                 => 'px',   
  'HEIGHT_SIZE'                => 'Höhe', 
  
  
  'UCP_GROUPS'                 => 'Nutzergruppen',   
  'UCP_GROUPS_MEMBERSHIP'      => 'Mitgliedschaft bearbeiten',   
  'UCP_GROUPS_MANAGE'          => 'Manage groups',   
  
  
  'UCP_ZEBRA'                  => 'Freunde und ignorierte Mitglieder',   
  'UCP_ZEBRA_FRIENDS'          => 'Freunde bearbeiten',   
  
  
  'UCP_ZEBRA_FOES'             => 'Ignorierte Mitglieder bearbeiten', 
  'UCP_APPLY'                    => 'Anwenden', 
  'UCP_PM_DEFAULT_RULE_TAG'      => 'Standardaktion',
  'UCP_PM_DEFAULT_RULE'          => 'Akzeptiere keine neuen Nachrichten',
  
  'UCP_PM_DEFAULT_RULE_EXPLAIN'  => 'Diese Aktion wird nur dann ausgeführt, wenn keine der oben genannten Optionen anwendbar ist. Neue Nachrichten werden so lange zurückgehalten, bis genügend Speicherplatz vorhanden ist.',
  'UCP_PM_NEW_MESSAGE'           => 'Neue Nachricht',
  
  
  
  'BIO'                          => 'Persönliche Informationen Biographie',
  'MANAGE'                       => 'VERWALTEN',
  'JOINED_BOARD'                 => 'Im Forum beigetreten',
  'VISITED_BOARD'                => 'Letzter Besuch',
  'SEE_MORE'                     => 'Mehr',
  'ATTACH_SIGNATURE'             => 'Signatur anhängen',
  'BBCODES'                      => 'BBcodes',

  'DELETE_POST_SOFT'             => 'Soft Delete post',
  'DELETE_POST_PERMANENT'        => 'Perma Delete post',
  'DELETE_POST_SOFT_WARN'        => 'It can be recovered',
  'DELETE_POST_PERMANENT_WARN'   => 'It can NOT be recovered',
  
  
  'POLL_MAX_OPTIONS_EXPLAIN_ALT' => 'Gib die maximale Anzahl an Möglichkeiten an, die ein Nutzer erhält',
  'POLL_VOTE_CHANGE_LABEL'       => 'Wiederwahl erlauben',
  'NO_VOTES_NA'                  => 'N/A',
  'NOT_AVAILABLE'                => 'Nicht verfügbar',
  'POST_TOPIC_NEW'               => 'Neues Thema',
  'QUICK_REPLY_SHOW_HIDE'        => 'Anzeigen/Verstecken der Schnellanwort',
  'CHARACTERS_COUNT'             => 'Buchstaben',
  'CHARACTERS_COUNT_REM'         => 'übrig',
  'BOOKMARKED_TOPICS_UCP'        => 'Gespeicherte Themen',
  'ATTACH_EXPLANATION_SORTABLE'  => 'Klicken zum Sortieren',
  
  'ATTACH_FORUM'                 => 'Anhänge',
  'MCP_DETAILS_LOG'              => 'Details',
  'MCP_DETAIL_U_IP'              => 'Nutzer &amp; IP',
  'MCP_MANAG_BAN'                => 'Bann-Verwalltung',
  'MCP_UNAPPROVED_POSTS_ZERO'    => 'Keine Einträge die auf Freischaltung warten',
  
  'MCP_REPORTS_ZERO'             => 'Keine Berichte zum Kontrollieren',
  'MCP_PM_REPORTS_ZERO'          => 'Keine PM Berichte zum Kontrollieren',
  
  
  	'SUBFORUM_LINK'				=> 'Link opens in a new tab',
  'FORUMLIST_UNAPPROVED'         => 'Mindestens ein Thema in diesem Forum wurde nicht genehmigt', 
  'FORUMLIST_UNAPPROVED_POST'    => 'Mindestens ein Beitrag in diesem Forum wurde nicht genemigt', 
  'FORUMLIST_LASTPOST'           => 'Letzten Beitrag anzeigen', 
  'TOPICS_POSTS_STATISTICS'      => 'Statistiken',
  'TOPICS_ROW_REPORTED'          => 'Dieses Thema wurde gemeldet',
  'TOPICS_ROW_NOT_APPROVED'      => 'Dieses Thema wurde nicht freigeschalten',
  'TOPICS_ROW_DELETED'           => 'Dieses Thema wurde gelöscht',
  'MODERATOR_PANEL_GENERAL'      => 'Moderationsbereich',
  'ADMIN_PANEL_GENERAL'          => 'Administrationsbereich',
  'RANK_IMAGE'                   => 'Rang Bild',
  
  'WELCOME_INDEX'                => 'Willkommen',
  'FAQ'                          => 'FAQ',
  'CAPTION_FAQ'                  => 'F.A.Q',
  'CAPTION_SEARCH'               => 'Starte eine Suche!',
  'CAPTION_MEMBERS'              => 'Suchst Du jemanden?',
  'MEMBERS_CAP'                  => 'Mitgleider',
  'CAPTION_UCP'                  => 'Einstellungen',
  
  
  'UCP_CAP'                      => 'Nutzerverwaltungsbereich',
  'INDEX_CAPTION'                => 'Dies ist die Forum-Startseite',
  'VIEWTOPIC_CAP'                => 'Thementitel',
  'CAPTION_VIEWTOPIC'            => 'Themenbeschreibung',
  'CAPTION_VIEWFORUM'            => 'Durchsuche alle Forenkategorien',
  
  'POSTINGS_CAP'                 => 'Beitragsbearbeitung',
  'CAPTION_POSTINGS'             => 'Starte einen Beitrag!',
  
  
  'MCP_CAPTION'                  => 'Hier bekommst Du beigebracht deine Superkraft zu nutzen ;-)',
  'BOOTSTRAP_ELEMENT'            => 'Bootstrap Elemente',
  'BOOTSTRAP_ELEMENT_CAPTION'    => 'Forum Anfänger-Dokumentation',
  'MAIN_FORUM'                   => 'Forum',
  'MAIN_MAIN_STUFF'              => 'Das wichtige Zeug',
  
  'MAIN_TRENDS'                  => 'Schaue Dir die Trends an',
  'MAIN_SEARCH_IT_UP'            => 'Suche starten',
  
  'SUB_NO_ICON'                  => 'Kein Bild vorhanden',
  'EXAMPLE_WITH_ICON'            => 'Beispiel mit Bild',
  'EXAMPLE_LINK'                 => 'Beispiel Link',
  'MAIN_SOCIAL'                  => 'Sozial',
  'SOCIAL_P'                     => 'Chat away ;-)',
  
  'MORE'          				   => 'Mehr',
  
  'EXPAND_CLOSE'          	 => 'Fenster schließen',
  'MARK_TOPICS_READ'         => 'Als gelesen markieren',
  
  'CONTACT'                  => 'Kontakt',
  'GET_IN_TOUCH'             => 'In Kontakt kommen',
  'HANG_AROUND'              => 'Rumhängen',
  'JOIN_THE_CLUB'            => 'Melde Dich an',
  
  'MENU'                     => 'MENÜ',
  'YOU_ARE_HERE'             => 'Du bist hier',
  'IN_FOOTER'                => 'In:',
  
  'REPLY'                    => 'Antwort',

  'LOGIN_REMEMBER'             => 'Angemeldet bleiben',
  'LOGIN_HIDE_ME'              => 'Unsichtbar',
  'LOGIN_ME_IN'                => 'Anmelden',
  'SIGN_IN_ACCOUNT'            => 'Anmeldung',
  'CREATE_ACCOUNT'             => 'Konto erstellen',
  
  'GO_TO_SEARCH_ADV'           => 'Zurück zur erweiterten Suche',
  
  'CREATE_ACCOUNT_DISABLED'    => 'Anmeldungen nicht erlaubt',
  
  'REGISTRATION_DISABLED'      => 'Es sieht so aus, als wäre die Anmeldung zur Zeit geschlossen. Es kann sich aber auch um eine kurzfristige Abschaltung handeln. Wenn Du denkst, es könnte sich um einen Fehler handeln, kontaktiere bitte den Foren-Administrator. Wir entschuldigen uns für die verursachtenUmstände. In unsere Nutzungsbedingungen und Datenschutzrichtlinien kannst Du mit einem Klick auf die jeweiligen Links weiter unten, einsehen.',
  'CONTACT_WEBMASTER'          => 'Forenadministrator kontaktieren',
  
  'CONFIRM_QA_EXPLAIN_ALT'     => 'Beweise, dass Du ein Mensch bist und beantworte die Frage',
  'PLUPLOAD_PLACE_INLINE'        => 'Linear',
  'PLUPLOAD_DELETE_FILE'         => 'Löschen',
  
  
  'REG_CREATING'             => 'Profil erstellen...',
  'LOADING'                  => 'Läd...',
  'SAVING'                   => 'Speichert...',
  'CANCELLING'               => 'Abbrechen...',
  'SENDING'                  => 'Senden...',
  'SEARCHING'                => 'Suchen...',
  'LOADING_LOG_IN'           => 'Anmeldung...',
  'FILE_UPLOADING'           => 'Hochladen...',
  'CASTING_VOTE'             => 'Stimme wird eingetragen...',
  'LOADING_FORM'             => 'Lade Formular',

  
  'MEMBERLIST_P_JOINED'          => 'ist dem Forum beigetreten',
  
  
  'MEMBERLIST_P_EXPL'            => 'Zu diesem Zeitpunkt habe ich mich registriert. ;)',
  'MEMBERLIST_P_DATE_EXPL'       => 'Dies war der Zeitpunkt als ich das letzte mal hier war.',
  'SPAMMER_PLACEHOLDER'          => 'Du kannst nicht einfach unser Board zuspammen und dann abhauen!',
  'MARK_PLACEHOLDER'             => 'Deine Wahl markieren',
  'INFO_BOX'                     => 'Information:',
  'USER_REMOVE_PLACEHOLDER'      => 'Klicken um Nutzer zu entfernen',
  'GROUP_REMOVE_PLACEHOLDER'     => 'Klicken um Gruppe zu entfernen',
  
  'EDIT_LINK_PLACEHOLDER'        => 'Ich habe vergessen meine Links richtig zu erstellen',
  'POST_IT_UP_PLACEHOLDER'       => 'Beitrag jetzt ersetellen!',
  
  'UCP_REG_USR_PLACEHOLDER'      => 'Bsp. John Doe',
  'UCP_REG_EMAIL_PLACEHOLDER'    => 'Bsp. john@mail.com',
  'UCP_REG_PSWD_PLACEHOLDER'     => 'Bsp. ASDFasdf123',
  'UCP_REG_CAPCTHA_PLACEHOLDER'  => 'Bsp. blauer Himmel',
  'SEARCH_USR_PLACEHOLDER'       => 'Bsp. SiteSplat',
   'YEAR_MONTH_DAY_PLACEHOLDER'	=> 'E.g. 2018-12-22',
	'IP_PLACEHOLDER'			=> 'E.g. 216.161.111.33',
	'POSTS_PLACEHOLDER'			=> 'E.g. 12',
	'SEARCH_KWDS_PLACEHOLDER'	=> 'E.g. cats, or cats+, or cats-, or cats|dogs, or cat*', 
	
	
	
	
	
	
	
	
	
	
  'MESSAGE_ENTER_PLACEHOLDER'    => 'Nachricht eintragen...',
  'FILE_COMMENT_PLACEHOLDER'     => 'Datei kommentieren',
  'HEIGTH_PLACEHOLDER'           => 'Höhe',
  'WIDTH_PLACEHOLDER'            => 'Weite',
  'UCP_OCCUPATION_PLACEHOLDER'   => 'Bescheibe was Du arbeitest...',
  'UCP_INTERESTS_PLACEHOLDER'    => 'Beschreibe Deine Interessen...',
  'SOFT_DELETE_PLACEHOLDER'      => 'Gib an, warum Du hier bis, wenn Du magst...',
  'ADD_DESCRIPTION'              => 'Beschreibung hinzufügen',
  
  'FILE_SELECT'                  => 'Datei auswählen',
  'FILE_CHANGE'                  => 'wechseln',
  
  
  
  'SELECT_IMAGE'                 => 'Bild auswählen',
  'NOTE'                         => 'merken',
  'EDIT_DRAFT'                   => 'Entwurf bearbeiten',
  'PM_BALOON_NOTIFICATION'       => 'Balonartige Ansicht für PM (Private Message) einstellen',
  
  'DAYS_AGO'                     => 'Tage zuvor',
  'WORK_IN_PROGRESS'             => 'Wartung',
  'DISABLE_MESSAGE'              => 'Forum ist nicht erreichbar',
  
  
  'DISABLE_RETURN'               => 'Zurück zur Startseite',
  'BOARD_DISABLED_SHUFFLE'       => 'Hab Spass und vergnüge Dich mit ein paar Buchstaben :-)',
  'DISABLE_TEXT_TRY'             => 'Probier es doch aus!',
  
  
  'DISABLE_TEXT_TYPE'            => 'tippe was ein und speichere es mit der Return-Taste...',
 
  'GRAVATAR_EXPLAIN'          	 => 'If a <a href="//en.gravatar.com/" target="_blank">GRAVATAR</a> is associated to your email address, it will be set as default.',
  'GRAVATAR_EXPLAIN_CONFIRM'     => 'Please confirm your email address here',
  
  
  
  'DELETE_POLL'              => 'Umfrage löschen',
  'POLL_DELETE_HELPER'       => '(Dies löscht nur die Umfrage) markieren und absenden',
  'JUMP_TO_POST'             => 'springe zum Beitrag',
  'JUMP_SELECT_FORUM'            => 'Wähle Forum zum Wecheln aus',
  'JUMP_TO_PAGE_NUMBER'          => 'Springe zu Seite #',
  'VIEW_FIRST_UNREAD'        => 'Zeige ersten ungelesenen Beitrag',
  'BOOKMARK_TOPIC_REMOVE'        => 'Lesezeichen entfernen',
  
  'NEW_MESSAGES'             => 'Neue Nachrichten',
  'YOU_HAVE'                 => 'Du hast',
  
  
  'AND'                      => 'und',
  'HELLO'                    => 'Hallo',
  'DISMISS_PM'               => 'Defer 5 min',
  
  'READ_NOW'                 => 'Jetzt lesen',
  'PRIVATE_MESSAGE_NEW'	         => 'Neue private Nachricht',
  'PRIVATE_MESSAGE_UNREAD'	     => 'Ungelesene private Nachricht',
  
  'NO_PMS_INFO'	                 => 'Alle gelesen! Erstelle neue PM?',
  
  'DATES'                    => 'DATUM',
  
  
  
  'POWERED'                  => 'Gesponsort von',
  'HANDCRAFTED'              => 'in Handarbeit hergestellt mit',
  'BY'                       => 'von',
  'RECENT_TOPICS'            => 'Letzte Einträge',
  'TWITTER'                  => 'Twitter',
  'FAVORITES'                => 'Favoriten',

  
  'GALLERY'                  => 'Gallerie',
  'CHAT'                     => 'Chat',
  
  
  
  
  
  'ABOUT'                    => 'Über uns',
  'ABOUT_PART_ONE'           => 'BBOOTS&#8482; Ist das erste und einzige voll responsive inoffizielle  PhpBB&reg; HTML5/CSS3 Design. Das saubere und knagige aussehen macht sich echt gut auf allen Browsern und sonstigen Anzeigen.',
  'ABOUT_PART_TWO'           => 'Es wartet mit einem Bootstrap basierten Grundgerüst auf, wurde lange Zeit hoffnungsvoll erwartet und wird sicherlich den phpBB Fan-Club total begeistern.',
  'ABOUT_PART_THREE'         => 'Das inoffizielle responsive Design',
  'BB'                       => 'B',
  'BOOTS'                    => 'BOOTS',
  'BBOOTS'                   => 'BBOOTS',
  
  'BBOOTS_VERSION'           => '<a href="http://www.sitesplat.com/phpBB3/">BBOOTS</a>',
  'U_LOGOUT'                 => 'Abmelden',

  'SITESPLAT_STATISTICS'     => 'Statistiken',
  'SITESPLAT_SEE_DETAILS'    => 'Siehe Details',
  'SITESPLAT_SEARCH_LAST_DAY'    => 'Einträge der letzten 24 Stunden',
  'SITESPLAT_SEARCH_WEEK'		 => 'Einträge der letzten 7 Tage',
  
  'SITESPLAT_TOTAL_POSTS'        => 'Beiträge insgesamt',
  'SITESPLAT_TOTAL_TOPICS'       => 'Themen insgesamt',
  'SITESPLAT_TOTAL_USERS'        => 'Mitglieder insgesamt',
  'SITESPLAT_NEWEST_MEMBER'      => 'Unser neuestes Mitglied',
  'SITESPLAT_USERS_ONLINE'       => 'Nutzer anwesend',
  'SITESPLAT_MOST_USERS_ONLINE'  => 'Höchstanzahl zeitgleicher Besucher',
  
  'BOOTSTRAP_VERSION'	         => '3.3.5',
  'FLATBOOTS'	                 => 'FLATBOOTS',
  'CHANGE_AVATAR'              => 'Avatar ändern',
  'CHANGE_PASSWORD'            => 'Passwort ändern',
  
  'ADMIN_TIPS'                 => 'Admin Tips &amp; Tricks',
  
  
  
  
  'ADMIN_TIP_INTRO'            => 'Wusstest Du, dass Du Dein phpBB-Forum mit ein paar einfachen Handgriffen noch sicherer machen kannst?',
  'ADMIN_TIP_ONE'              => 'Halte Deine Software immer auf dem aktuellsten Stand',
  'ADMIN_TIP_TWO'              => 'Verwende immer sichere Passwörter mit abwechselnde unterschiedlichen Buchstaben, Nummern und Sonderzeichen.',
  'ADMIN_TIP_THREE'            => 'Sperre den direkten Zugriff auf den Administrations-Ordner...',
  'ADMIN_CHECK_IT_BTN'         => 'Besuche SiteSplat.com für mehr Information',
  
  'USER_MINI_PROFILE'            => 'Minimales Nutzerprofil',
  'USER_MINI_PROFILE_VIEW_FULL'  => 'Zeige volles Profil',
  'OFF_LINE'                     => 'Off-line',
  'USER_STATUS'                  => 'Status',
  
  
  
  
  
  
  'USER'                         => 'Nutzer',
  'TITLE'                        => 'Titel',
  'END_TIMELINE'                 => 'Ende der Zeitlinie',
  'MEMBERS'                      => 'Mitglieder',
  'DRAFTS'                       => 'Entwürfe',
  'REPORTS'                      => 'Meldungen',
  'MODERATOR_LOGS'               => 'Moderator Anmeldungen',
  
  'QUEUE'                        => 'Warteschlange',
  'LINKS'                        => 'Links',
  'TOPIC_PERMISSIONS'            => 'Themenberechtigungen',
  'MODERATOR_OPTIONS'            => 'Moderationen',
  'PASSWORD_EXPLAIN_CONFIRM'     => 'Sei Dir sicher, dass es passt',
  'FORUM_REDIRECTS'              => 'Weiterleitungen:',
  
  'FANCY_TOPICS_TITLE'           => 'Letzte Themen dieses Forums',
 





  
  'POST_BY'                      => 'Geschrieben von',
  'REPLY_BY'                     => 'Antwort von',
  'NO_REPLIES'                   => 'Keine Antworten',
  'READ_MORE'                    => 'Weiter lesen...',
  'RT_READ_MORE'                 => 'WEITER LESEN...',
  'VIEW_MORE_TOPICS'             => 'weitere neue Einträge anzeigen',
  'BACK_TO_START'                => 'ZURÜCK ZUM ANFANG',
  
  'TOGGLE_NAV'                   => 'Navigation verstecken',
  
  'DEMO_LINK'                  => 'Demonstraton, keine Bilder verlinkt',
  'DEMO_HEADER_MENU'           => 'Webseiteneinleitungsbeispiel',
  
  'FLATBOOTS_INTRO'              => 'Bootstrap Framework',
  
  
  'FLATBOOTS_EXPLAIN'            => 'Über ein Dutzend wiederverwendbare Erweiterungen vorhanden, z.B. Icons, Dropdown Listen, Navigation, Warnmeldungen und vieles mehr... ',
  'CALL_TO_ACTION_FOOTER'        => 'Ein-/Auschalten von Erweiterungen. Nutze nur was Du wirklich benötigst!',
  'PURCHASE_NOW_BTN'             => 'Jetzt kaufen',
  
  'FLATBOOTS_ABOUT_PART_ONE'     => 'Hier gibt es bald ein paar kurze Zeilen über das Board...',
  'FLATBOOTS_ABOUT_TITLE'        => 'Gebaut für die Ewigkeit',
  'DMCA'                         => 'DMCA',
  
  'TERMS'                        => 'Nutzungsbedingungen',
  'ADVERTISE'                    => 'Werbung',
  'SITESPLAT'                    => 'SiteSplat',
  'SITESPLAT_URL'	            => '<a href="https://sitesplat.com" class="btn btn-default" target="blank" rel="noopener">SiteSplat.com</a>',
    'SS_URL'	                => '<a href="https://sitesplat.com/" title="SiteSplat Premium Themes" target="_blank" rel="noopener">SiteSplat</a>',
    'PHPBB_CREDIT'	            => 'Powered By <a href="https://www.phpbb.com/" title="Forum Software &copy; phpBB&reg; Group" target="_blank" rel="noopener">phpBB</a> and ',
    'SS_HANDCRAFTED'	        => '<a href="https://sitesplat.com/" title="SiteSplat Premium Themes and Extensions" target="_blank" rel="noopener">SiteSplat</a>, handcrafted with <i class="fa fa-heart text-flatboots-red"></i> and <i class="fa fa-coffee"></i>',
  'JOIN_US_TWITTER'              => 'Triff uns auf Twitter',
  
  'TWEET_EXAMPLE'                => 'BBOOTS erreichte 500 verkäufe! Vielen Dank Euch allen für die Unterstützung zu diesem erstaunlichen Projekt und zum Aufbau der SiteSplat Gemeinschaft. Was kommt als nächstes? Bleib am Ball und folge mir auf Twitter: <a href="#">http://bit.ly/000fefs</a>',
 
));