<?php
/**
*
* BBCore [English]
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
// Placeholders can now contain order information, Par exemple: instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, Par exemple: 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order Par exemple:, 'Click %sHERE%s' is fine
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
		1 => 'You have %d New Private Message',
		2 => 'You have %d New Private Messages',
	],
	'PM_UNREAD_MSG' => [
		1 => 'You have %d Unread Private Message',
		2 => 'You have %d Unread Private Messages',
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
	'BBCORE_BAD_PHP'			=> 'You are using a non-standard build of PHP!',

	'SS_ADDONS'				=> 'Addons',
	'SS_ADDON_SETTINGS'		=> 'Addon Settings',
	'SS_LID_INFO'			=> 'This is your SiteSplat License Key. You will be required to enter this key after you install or update BBCore.',

	'UCP_MAIN'				=> 'Vue Générale',
	'UCP_MAIN_FRONT'		=> 'Tableau de bord',
	'UCP_MAIN_SUBSCRIPTION'	=> 'Gérer les abonnements',
	'UCP_MAIN_BOOKMARKS'	=> 'Gérer les favoris',
	'UCP_MAIN_DRAFTS'		=> 'Gérer les brouillons',
	'UCP_MAIN_ATTACHMENTS'	=> 'Gérer les pièces jointes',

	'USER_PANEL'				=> 'Panneau de contrôle',
	'UCP_PROFILE'				=> 'Profil',
	'UCP_PROFILE_PROFILE'		=> 'Editer profil',
	'UCP_PROFILE_SIGNITURE'		=> 'Editer signature',
	'UCP_PROFILE_AVATAR'		=> 'Editer avatar',
	'UCP_PROFILE_SETTINGS'		=> 'Paramètres compte',
	'UCP_AVATAR_SELECT_OPTIONS'	=> 'Avatar options',
	'UCP_AVATAR_SELECT_UPLOAD'	=> 'Télécharger un avatar',
	'UCP_SUBMIT_TO_UPLOAD'		=> 'Submit below to upload',

	'UCP_PREFERENCE'			=> 'Préférences Forum',
	'UCP_PREFERENCE_SETTINGS'	=> 'Editer paramètres',
	'UCP_PREFERENCE_DEFAULTS'	=> 'Edit posting defaults',
	'UCP_PREFERENCE_OPTIONS'	=> 'Editer options affichage',

	'UCP_MESSAGES'				=> 'Messages',
	'UCP_PM_COMPOSE'			=> 'Ecrire message',
	'UCP_PM_DRAFTS'				=> 'Gérer brouillons',
	'UCP_PM_INBOX'				=> 'Reçus',
	'UCP_PM_OUTBOX'				=> 'Outbox',
	'UCP_PM_SENTBOX'			=> 'Envoyé',
	'UCP_PM_OPTIONS'			=> 'Règles, dossiers &amp; paramètres',
	'UCP_NO_USER_CHANGE_ALLOWED'	=> '**Username change is not allowed**',
	'UCP_REGISTER_EMAIL_EXPLAIN'	=> 'Please do not use disposable emails',

	'WIDTH_SIZE'			=> 'largeur',
	'PIXEL_SIZE'			=> 'px',
	'HEIGHT_SIZE'			=> 'hauteur',

	'UCP_GROUPS'			=> 'Groupe Utilisateurs',
	'UCP_GROUPS_MEMBERSHIP'	=> 'Edit membership',
	'UCP_GROUPS_MANAGE'		=> 'Gérer groupes',

	'UCP_ZEBRA'					=> 'Amis &amp; Ignorés',
	'UCP_ZEBRA_FRIENDS'			=> 'Gérer Amis',
	'UCP_ZEBRA_FOES'			=> 'Gérer Ignorés',
	'UCP_APPLY'					=> 'Appliquer',
	'UCP_PM_DEFAULT_RULE_TAG'	=> 'Default action',
	'UCP_PM_DEFAULT_RULE'		=> 'Ne pas accepter nouveaux messages',
	'UCP_PM_DEFAULT_RULE_EXPLAIN'	=> 'This action will be triggered only if none of the above options is applicable. New messages will be held back until enough space is available.',
	'UCP_PM_NEW_MESSAGE'		=> 'Nouveau Message',
	'BIO'						=> 'Bio Informations Perso',
	'MANAGE'					=> 'Gérer',
	'JOINED_BOARD'				=> 'a rejoint le forum',
	'VISITED_BOARD'				=> 'Dernière visite',
	'SEE_MORE'					=> 'Plus',
	'ATTACH_SIGNATURE'			=> 'Joindre signature',
	'BBCODES'					=> 'BBcodes',

	'DELETE_POST_SOFT'			=> 'Soft Delete post',
	'DELETE_POST_PERMANENT'		=> 'Perma Delete post',
	'DELETE_POST_SOFT_WARN'		=> 'It can be recovered',
	'DELETE_POST_PERMANENT_WARN'	=> 'It can NOT be recovered',

	'POLL_MAX_OPTIONS_EXPLAIN_ALT'	=> 'Enter the max number of options the user can select',
	'POLL_VOTE_CHANGE_LABEL'	=> 'Allow Re-vote',
	'NO_VOTES_NA'				=> 'Non Dispo',
	'NOT_AVAILABLE'				=> 'Non disponible',
	'POST_TOPIC_NEW'			=> 'Nouveau Sujet',
	'QUICK_REPLY_SHOW_HIDE'		=> 'Show/Hide Quick Reply',
	'CHARACTERS_COUNT'			=> 'Caractères',
	'CHARACTERS_COUNT_REM'		=> 'Remaining',
	'BOOKMARKED_TOPICS_UCP'		=> 'Bookmarked Topics',
	'ATTACH_EXPLANATION_SORTABLE'	=> 'Click to sort',
	'ATTACH_FORUM'				=> 'Attachment(s)',
	'MCP_DETAILS_LOG'			=> 'Details',
	'MCP_DETAIL_U_IP'			=> 'User &amp; IP',
	'MCP_MANAG_BAN'				=> 'Ban Management',
	'MCP_UNAPPROVED_POSTS_ZERO'	=> 'There are no posts waiting for approval',
	'MCP_REPORTS_ZERO'			=> 'There are no reports to review',
	'MCP_PM_REPORTS_ZERO'		=> 'There are no PM reports to review',


	'SUBFORUM_LINK'				=> 'Link opens in a new tab',
	'FORUMLIST_UNAPPROVED'		=> 'At least one topic in this forum has not been approved',
	'FORUMLIST_UNAPPROVED_POST'	=> 'At least one post in this forum has not been approved',
	'FORUMLIST_LASTPOST'		=> 'View the latest post',
	'TOPICS_POSTS_STATISTICS'	=> 'Statistics',
	'TOPICS_ROW_REPORTED'		=> 'This Topic has been reported',
	'TOPICS_ROW_NOT_APPROVED'	=> 'This Topic has not been approved',
	'TOPICS_ROW_DELETED'		=> 'This Topic has been deleted',
	'MODERATOR_PANEL_GENERAL'	=> 'Moderator Panel',
	'ADMIN_PANEL_GENERAL'		=> 'Administrator Panel',
	'RANK_IMAGE'				=> 'Rank image',

	'WELCOME_INDEX'			=> 'Bienvenue',
	'FAQ'					=> 'FAQ',
	'CAPTION_FAQ'			=> 'Foire Aux Questions',
	'CAPTION_SEARCH'		=> 'Search it up!',
	'CAPTION_MEMBERS'		=> 'Vous cherchez une personne?',
	'MEMBERS_CAP'			=> 'Membres',
	'CAPTION_UCP'			=> 'Choisir vos préférences',
	'UCP_CAP'				=> 'Panneau Utilisateur',
	'INDEX_CAPTION'			=> 'Page principale du forum',
	'VIEWTOPIC_CAP'			=> 'Titre Sujet',
	'CAPTION_VIEWTOPIC'		=> 'Description sujet',
	'CAPTION_VIEWFORUM'		=> 'Visualiser toutes les catégories du forum',
	'POSTINGS_CAP'			=> 'Editeur',
	'CAPTION_POSTINGS'		=> 'Posting things up!',

	'MCP_CAPTION'				=> 'This is where you get to use the Super Powers ;-)',
	'BOOTSTRAP_ELEMENT'			=> 'Bootstrap Elements',
	'BOOTSTRAP_ELEMENT_CAPTION'	=> 'Forum KickStart Documentation',
	'MAIN_FORUM'				=> 'Forum',
	'MAIN_MAIN_STUFF'			=> 'The Main stuff',
	'MAIN_TRENDS'				=> 'See the trends',

	'MAIN_SEARCH_IT_UP'		=> 'Search it up',
	'SUB_NO_ICON'			=> 'No Icon here at all',
	'EXAMPLE_WITH_ICON'		=> 'Example With Icon',
	'EXAMPLE_LINK'			=> 'Example Link',
	'MAIN_SOCIAL'			=> 'Social',
	'SOCIAL_P'				=> 'Chat away ;-)',

	'MORE'					=> 'Plus',
	'EXPAND_CLOSE'			=> 'Fermer la Vue',
	'MARK_TOPICS_READ'		=> 'Mark Topics Read',
	'CONTACT'				=> 'Contact',
	'GET_IN_TOUCH'			=> 'Get in touch',
	'HANG_AROUND'			=> 'Bienvenue chez vous',
	'JOIN_THE_CLUB'			=> 'Rejoignez la communauté',
	'MENU'					=> 'MENU',
	'YOU_ARE_HERE'			=> 'Vous êtes ici',
	'IN_FOOTER'				=> 'Dans:',
	'REPLY'					=> 'Répondre',

	'LOGIN_REMEMBER'		=> 'Me garder connecté',
	'LOGIN_HIDE_ME'			=> 'Cacher ma session',
	'LOGIN_ME_IN'			=> 'Me connecter',
	'SIGN_IN_ACCOUNT'		=> 'Sign in onto your account',
	'CREATE_ACCOUNT'		=> 'Créer un Compte',
	'GO_TO_SEARCH_ADV'		=> 'Retourner à la recherche avancée',

	'CREATE_ACCOUNT_DISABLED'	=> 'Registrations closed',
	'REGISTRATION_DISABLED'		=> 'It looks like the registrations are closed at the moment. It could also be a temporary measure. If you believe this is a possible error, please contact the webmaster and let him know. We apologize for any inconvenience this might have caused. Our Privacy Policy and Terms of Use are available below.',
	'CONTACT_WEBMASTER'			=> 'Contacter le Webmaster',
	'CONFIRM_QA_EXPLAIN_ALT'	=> 'Pour être sûr que vous êtes un humain, répondez à cette question',

	'PLUPLOAD_PLACE_INLINE'	=> 'Inline',
	'PLUPLOAD_DELETE_FILE'	=> 'Effacer',


	'REG_CREATING'			=> 'Création Profil...',
	'LOADING'				=> 'Chargement...',
	'SAVING'				=> 'Sauvegarde...',
	'CANCELLING'			=> 'Annulation...',
	'SENDING'				=> 'Envoi...',
	'SEARCHING'				=> 'Recherche...',
	'LOADING_LOG_IN'		=> 'Connexion...',
	'FILE_UPLOADING'		=> 'Téléchargement...',
	'CASTING_VOTE'			=> 'Casting vote...',
	'LOADING_FORM'			=> 'Loading form...',

	'MEMBERLIST_P_JOINED'		=> 'Joined the board',
	'MEMBERLIST_P_EXPL'			=> 'This is when I joined the board',
	'MEMBERLIST_P_DATE_EXPL'	=> 'This was last time I visited the board',
	'SPAMMER'					=> 'Spammer',
	'SPAMMER_PLACEHOLDER'		=> 'You cannot just spam our board and get away with it!',
	'MARK_PLACEHOLDER'			=> 'Checkmark your choice',
	'INFO_BOX'					=> 'Information:',
	'USER_REMOVE_PLACEHOLDER'	=> 'Click to remove user',
	'GROUP_REMOVE_PLACEHOLDER'	=> 'Click to remove group',
	'EDIT_LINK_PLACEHOLDER'		=> 'Par exemple: I forgot to code my links',
	'POST_IT_UP_PLACEHOLDER'	=> 'Post it up!',

	'UCP_REG_USR_PLACEHOLDER'	=> 'Par exemple: John Doe',
	'UCP_REG_EMAIL_PLACEHOLDER'	=> 'Par exemple: john@mail.com',
	'UCP_REG_PSWD_PLACEHOLDER'	=> 'Par exemple: ASDFasdf123',
	'UCP_REG_CTCHA_PLACEHOLDER'	=> 'Par exemple: blue sky',
	'SEARCH_USR_PLACEHOLDER'	=> 'Par exemple: SiteSplat',
	'YEAR_MONTH_DAY_PLACEHOLDER'	=> 'E. 2018-12-22',
	'IP_PLACEHOLDER'			=> 'Par exemple: 216.161.111.33',
	'POSTS_PLACEHOLDER'			=> 'Par exemple: 12',
	'SEARCH_KWDS_PLACEHOLDER'	=> 'Par exemple: cats, or cats+, or cats-, or cats|dogs, or cat*',

	'MESSAGE_ENTER_PLACEHOLDER'	=> 'Ecrivez votre message...',
	'FILE_COMMENT_PLACEHOLDER'	=> 'Commentez votre fichier',
	'HEIGTH_PLACEHOLDER'		=> 'hauteur',
	'WIDTH_PLACEHOLDER'			=> 'largeur',
	'UCP_OCCUPATION_PLACEHOLDER'	=> 'Décrivez brièvement votre job...',
	'UCP_INTERESTS_PLACEHOLDER'	=> 'Décrivez vos intérêts...',
	'SOFT_DELETE_PLACEHOLDER'	=> 'Enter your reason if you wish to...',
	'ADD_DESCRIPTION'			=> 'Ajouter description',

	'FILE_SELECT'				=> 'Choisir fichier',
	'FILE_CHANGE'				=> 'Changer',
	'SELECT_IMAGE'				=> 'Choisir image',
	'NOTE'						=> 'Note',
	'EDIT_DRAFT'				=> 'Edit Draft',
	'PM_BALOON_NOTIFICATION'	=> 'Enable floating style notification for new PM (Private Message)',
	'DAYS_AGO'					=> 'Jours',
	'WORK_IN_PROGRESS'			=> 'Maintenance',
	'DISABLE_MESSAGE'			=> 'Forum indisponible',
	'DISABLE_RETURN'			=> 'Retourner à la page Accueil',
	'BOARD_DISABLED_SHUFFLE'	=> 'Have fun and shuffle some letters :-)',
	'DISABLE_TEXT_TRY'			=> 'Test it for yourself!',
	'DISABLE_TEXT_TYPE'			=> 'type anything and hit return...',

	'GRAVATAR_EXPLAIN'			=> 'If a <a href="//en.gravatar.com/" target="_blank">GRAVATAR</a> is associated to your email address, it will be set as default.',
	'GRAVATAR_EXPLAIN_CONFIRM'	=> 'Merci de confirmer votre email ici',

	'DELETE_POLL'			=> 'Delete poll',
	'POLL_DELETE_HELPER'	=> '(This deletes the poll only) check and submit',
	'JUMP_TO_POST'			=> 'Aller au message',
	'JUMP_SELECT_FORUM'		=> 'Choisir le forum où aller',
	'JUMP_TO_PAGE_NUMBER'	=> 'Aller à la page #',
	'VIEW_FIRST_UNREAD'		=> 'Lire message non lu en premier',
	'BOOKMARK_TOPIC_REMOVE'	=> 'Enlever favori',

	'NEW_MESSAGES'				=> 'Nouveaux messages',
	'YOU_HAVE'					=> 'Vous avez',
	'AND'						=> 'et',
	'HELLO'						=> 'Bonjour',
	'DISMISS_PM'				=> 'Defer 5 min',
	'READ_NOW'					=> 'Lire maintenant',
	'PRIVATE_MESSAGE_NEW'		=> 'nouveau message privé',
	'PRIVATE_MESSAGE_UNREAD'	=> 'message privé non lu',
	'NO_PMS_INFO'				=> 'Ok! Ecrire un nouveau MP?',

	'DATES'					=> 'DATE',
	'POWERED'				=> 'Propulsé par',
	'HANDCRAFTED'			=> 'Fait par',
	'BY'					=> 'Par',

	'RECENT_TOPICS'			=> 'Sujets Récents',
	'TWITTER'				=> 'Twitter',
	'FAVORITES'				=> 'Favoris',

	'GALLERY'				=> 'Gallerie',
	'CHAT'					=> 'Chat',
	'ABOUT'					=> 'A Propos',
	'ABOUT_PART_ONE'		=> 'BBOOTS&#8482; Is The First And Only Fully Responsive PhpBB&reg; Unofficial HTML5/CSS3 Theme. It’s Clean And Crisp Design Looks AWESOME Across All Browsers And Devices.',
	'ABOUT_PART_TWO'		=> 'It Utilizes A Bootstrap Based Layout Which Has Been Long Waited For And That Is Sure To AMAZE The phpBB Fan Club.',
	'ABOUT_PART_THREE'		=> 'The Unofficial Responsive Theme',
	'BB'					=> 'B',
	'BOOTS'					=> 'BOOTS',
	'BBOOTS'				=> 'BBOOTS',

	'BBOOTS_VERSION'		=> '<a href="http://www.sitesplat.com/phpBB3/">BBOOTS</a>',
	'U_LOGOUT'				=> 'Se déconnecter',

	'SITESPLAT_STATISTICS'		=> 'Statistiques',
	'SITESPLAT_SEE_DETAILS'		=> 'Voir Details',
	'SITESPLAT_SEARCH_LAST_DAY'	=> 'Derniers messages sur 24H',
	'SITESPLAT_SEARCH_WEEK'		=> 'Derniers messages sur 7 jours',

	'SITESPLAT_TOTAL_POSTS'		=> 'Total messages',
	'SITESPLAT_TOTAL_TOPICS'	=> 'Total sujets',
	'SITESPLAT_TOTAL_USERS'		=> 'Total membres',
	'SITESPLAT_NEWEST_MEMBER'	=> 'Newest Member',
	'SITESPLAT_USERS_ONLINE'	=> 'Utilisateurs en ligne',
	'SITESPLAT_MOST_USERS_ONLINE'	=> 'Most Users Online',
	'SITESPLAT_BIRTHDAYS'		=> 'Today\'s birthdays',

	'BOOTSTRAP_VERSION'		=> '3.3.6',
	'FLATBOOTS'				=> 'FLATBOOTS',
	'CHANGE_AVATAR'			=> 'Change Avatar',
	'CHANGE_PASSWORD'		=> 'Change Password',

	'ADMIN_TIPS'			=> 'Admin Tips &amp; Tricks',
	'ADMIN_TIP_INTRO'		=> 'Did you know you can make your phpBB forum even more secure with some simple steps?',
	'ADMIN_TIP_ONE'			=> 'Keep your software up to-date.',
	'ADMIN_TIP_TWO'			=> 'Always use strong passwords that contain random sequence of letters, numbers and special characters.',
	'ADMIN_TIP_THREE'		=> 'Restrict the admin folder access...',
	'ADMIN_CHECK_IT_BTN'	=> 'Visit SiteSplat.com for more',

	'USER_MINI_PROFILE'			=> 'User mini profile',
	'USER_MINI_PROFILE_VIEW_FULL'	=> 'View full profile',
	'OFF_LINE'					=> 'Off-line',
	'USER_STATUS'				=> 'Status',
	'USER'						=> 'User',
	'TITLE'						=> 'Title',
	'END_TIMELINE'				=> 'End timeline',
	'MEMBERS'					=> 'Members',
	'DRAFTS'					=> 'Drafts',
	'REPORTS'					=> 'Reports',
	'MODERATOR_LOGS'			=> 'Moderator logs',
	'QUEUE'						=> 'Queue',
	'LINKS'						=> 'Links',
	'TOPIC_PERMISSIONS'			=> 'Topic permissions',
	'MODERATOR_OPTIONS'			=> 'Moderate',
	'PASSWORD_EXPLAIN_CONFIRM'	=> 'Make sure it matches',
	'FORUM_REDIRECTS'			=> 'Redirects:',

	'FANCY_TOPICS_TITLE'	=> 'Recent topics from the forum',
	'POST_BY'				=> 'Post by',
	'REPLY_BY'				=> 'Reply by',
	'NO_REPLIES'			=> 'No replies',
	'READ_MORE'				=> 'Read more',
	'RT_READ_MORE'			=> 'READ MORE',
	'VIEW_MORE_TOPICS'		=> 'VIEW MORE TOPICS',
	'BACK_TO_START'			=> 'BACK TO START',

	'TOGGLE_NAV'			=> 'Toggle Navigation',
	'NAVIGATION'			=> 'Navigation',

	'DEMO_LINK'				=> 'Demo link no icons',
	'DEMO_HEADER_MENU'		=> 'Header intro example',

	'FLATBOOTS_INTRO'			=> 'Bootstrap Framework',
	'FLATBOOTS_EXPLAIN'			=> 'Over a dozen reusable components built to provide iconography, dropdowns, input groups, navigation, alerts, and much more...',
	'CALL_TO_ACTION_FOOTER'		=> 'Swap-in out addons, use only what you really need!',
	'PURCHASE_NOW_BTN'			=> 'Purchase now',
	'FLATBOOTS_ABOUT_PART_ONE'	=> 'Why Would you Settle for Less when you can have More? Do not let other Authors Fool you with Empty Marketing Keywords. FLATBOOTS is what you Deserve. Built to last, Built from Scratch, Nothing Less.',
	'FLATBOOTS_ABOUT_TITLE'		=> 'Built to last',
	'DMCA'						=> 'DMCA',
	'TERMS'						=> 'Terms',
	'ADVERTISE'					=> 'Advertise',
	'SITESPLAT'					=> 'SiteSplat',
    'SITESPLAT_URL'	            => '<a href="https://sitesplat.com" class="btn btn-default" target="blank" rel="noopener">SiteSplat.com</a>',
    'SS_URL'	                => '<a href="https://sitesplat.com/" title="SiteSplat Premium Themes" target="_blank" rel="noopener">SiteSplat</a>',
    'PHPBB_CREDIT'	            => 'Powered By <a href="https://www.phpbb.com/" title="Forum Software &copy; phpBB&reg; Group" target="_blank" rel="noopener">phpBB</a> and ',
    'SS_HANDCRAFTED'	        => '<a href="https://sitesplat.com/" title="SiteSplat Premium Themes and Extensions" target="_blank" rel="noopener">SiteSplat</a>, handcrafted with <i class="fa fa-heart text-flatboots-red"></i> and <i class="fa fa-coffee"></i>',
	'JOIN_US_TWITTER'			=> 'Join us on Twitter',
	'TWEET_EXAMPLE'				=> 'BBOOTS reaches 2000 sales! Thank-you all for supporting this amazing project and contributing to built the SiteSplat Community. What\'s next? stay tuned and Follow Me on Twitter: <a href="#">http://bit.ly/000fefs</a>',
));
