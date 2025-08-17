<?php
/**
*
* BBCore [English]
*
* @package sitesplat BBcore
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
* French translation by Mathieu M. ( https://www.monsieur2m.fr/ )
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB')) {
	exit;
}
if (empty($lang) || !is_array($lang)) {
	$lang = array();
}

// BBCore
$lang = array_merge($lang, array(

  'PM_NEW_MSG' => array(
    1 => 'Vous avez %d nouveau message privé',
    2 => 'Vous avez %d nouveaux messages privés',
  ),
  'PM_UNREAD_MSG' => array(
    1 => 'Vous avez %d message privé non lu',
    2 => 'Vous avez %d messages privés non lus',
  ),
  'PM_NEW_MSG_BUBBLE' => array(
    1 => '%d',
    2 => '%d',
  ),
  
  'UCP_MAIN'                	 => 'Vue d’ensemble',
  'UCP_MAIN_FRONT'          	 => 'Page principale',
  'UCP_MAIN_SUBSCRIPTION'   	 => 'Gestion des surveillances',
  'UCP_MAIN_BOOKMARKS'      	 => 'Gestion des favoris',
  'UCP_MAIN_DRAFTS'         	 => 'Gestion des brouillons',
  'UCP_MAIN_ATTACHMENTS'    	 => 'Gestion des fichiers joints',
  
  'USER_PANEL'             	     => 'Panneau de l’utilisateur', 
  'UCP_PROFILE'             	 => 'Profil',   
  'UCP_PROFILE_PROFILE'    		 => 'Modifier le profil',   
  'UCP_PROFILE_SIGNITURE'  		 => 'Modifier la signature',   
  'UCP_PROFILE_AVATAR'      	 => 'Modifier l’avatar',   
  'UCP_PROFILE_SETTINGS'    	 => 'Paramètres du compte', 
  'UCP_AVATAR_SELECT_OPTIONS'    => 'Options de l’avatar', 
  'UCP_AVATAR_SELECT_UPLOAD'     => 'Transférez votre propre avatar',
  'UCP_SUBMIT_TO_UPLOAD'         => 'Transférer avant de télécharger',
  
  'UCP_PREFERENCE'         		 => 'Préférences du forum',
  'UCP_PREFERENCE_SETTINGS' 	 => 'Modifier les préférences générales',
  'UCP_PREFERENCE_DEFAULTS' 	 => 'Modifier les préférences des messages',
  'UCP_PREFERENCE_OPTIONS'  	 => 'Modifier les options d’affichage',
  
  'UCP_MESSAGES'            	 => 'Messages',   
  'UCP_PM_COMPOSE'          	 => 'Rédiger un message',   
  'UCP_PM_DRAFTS'           	 => 'Gestion des brouillons',   
  'UCP_PM_INBOX'            	 => 'Boîte de réception',   
  'UCP_PM_OUTBOX'           	 => 'Boîte d’envoi',   
  'UCP_PM_SENTBOX'          	 => 'Messages envoyés',   
  'UCP_PM_OPTIONS'          	 => 'Filtres, dossiers et paramètres', 
  'UCP_NO_USER_CHANGE_ALLOWED'   => '**Le changement de nom d’utilisateur n’est pas autorisé**',
  'UCP_REGISTER_EMAIL_EXPLAIN'   => 'Veuillez ne pas utiliser une adresse de courriel temporaire',
  
  'WIDTH_SIZE'            	     => 'largeur',   
  'PIXEL_SIZE'           	     => 'px',   
  'HEIGHT_SIZE'          	     => 'hauteur',
  
  'UCP_GROUPS'              	 => 'Groupes d’utilisateurs',   
  'UCP_GROUPS_MEMBERSHIP'   	 => 'Modifier mes adhésions',   
  'UCP_GROUPS_MANAGE'       	 => 'Gestion des groupes',   
  
  'UCP_ZEBRA'               	 => 'Amis et ignorés',   
  'UCP_ZEBRA_FRIENDS'       	 => 'Gestion des amis',   
  'UCP_ZEBRA_FOES'          	 => 'Gestion des ignorés', 
  'UCP_APPLY'                    => 'Envoyer', 
  'UCP_PM_DEFAULT_RULE_TAG'      => 'Action par défaut',
  'UCP_PM_DEFAULT_RULE'          => 'Ne pas accepter de nouveaux messages',
  'UCP_PM_DEFAULT_RULE_EXPLAIN'  => 'Cette action ne sera réalisée que si aucune des options ci-dessus n’est applicable. Les nouveaux messages seront sauvegardés jusqu’à ce que l’espace disponible soit suffisant.',
  'UCP_PM_NEW_MESSAGE'           => 'Nouveau message',
  'BIO'                          => 'Informations personnelles',
  'MANAGE'                       => 'Gérer',
  'JOINED_BOARD'                 => 'a rejoint le forum',
  'VISITED_BOARD'                => 'Dernière visite',
  'SEE_MORE'                     => 'Plus',
  'ATTACH_SIGNATURE'             => 'Attacher ma signature',
  'BBCODES'                      => 'BBCodes',

  'DELETE_POST_SOFT'             => 'Mettre le message hors-ligne',
  'DELETE_POST_PERMANENT'        => 'Supprimer le message définitivement',
  'DELETE_POST_SOFT_WARN'        => 'Il pourra être restauré',
  'DELETE_POST_PERMANENT_WARN'   => 'Il ne pourra pas être restauré',
  
  'POLL_MAX_OPTIONS_EXPLAIN_ALT' => 'Saisir le nombre maximum d’options qu’un utilisateur peut choisir',
  'POLL_VOTE_CHANGE_LABEL'       => 'Autoriser le changement de vote',
  'NO_VOTES_NA'                  => 'N/A',
  'NOT_AVAILABLE'                => 'Indisponible',
  'POST_TOPIC_NEW'               => 'Nouveau sujet',
  'QUICK_REPLY_SHOW_HIDE'        => 'Montrer/Cacher la réponse rapide',
  'CHARACTERS_COUNT'             => 'Caractères',
  'CHARACTERS_COUNT_REM'         => 'Restant',
  'BOOKMARKED_TOPICS_UCP'        => 'Sujets favoris',
  'ATTACH_EXPLANATION_SORTABLE'  => 'Trier',
  'ATTACH_FORUM'                 => 'Fichier(s) joint(s)',
  'MCP_DETAILS_LOG'              => 'Détails',
  'MCP_DETAIL_U_IP'              => 'Utilisateur &amp; IP',
  'MCP_MANAG_BAN'                => 'Gestion des bannissement',
  'MCP_UNAPPROVED_POSTS_ZERO'    => 'Il n’y a pas de messages en attente d’approbation',
  'MCP_REPORTS_ZERO'             => 'Il n’y a pas de messages rapportés en attente',
  'MCP_PM_REPORTS_ZERO'          => 'Il n’y a pas de messages privés rapportés en attente',
  
 
  'SUBFORUM_LINK'                => 'Ouvrir le lien dans une nouvelle fenêtre',
  'FORUMLIST_UNAPPROVED'         => 'Il y a au moins un sujet dans ce forum en attente d’approbation', 
  'FORUMLIST_UNAPPROVED_POST'    => 'Il y a au moins un message dans ce forum en attente d’approbation', 
  'FORUMLIST_LASTPOST'           => 'Voir le dernier message', 
  'TOPICS_POSTS_STATISTICS'      => 'Statistiques',
  'TOPICS_ROW_REPORTED'          => 'Le sujet a été rapporté',
  'TOPICS_ROW_NOT_APPROVED'      => 'Le sujet n’a pas encore été approuvé',
  'TOPICS_ROW_DELETED'           => 'Le sujet a été supprimé',
  'MODERATOR_PANEL_GENERAL'      => 'Panneau de modération',
  'ADMIN_PANEL_GENERAL'          => 'Panneau d’administration',
  'RANK_IMAGE'                   => 'Image du rang',
  
  'WELCOME_INDEX'                => 'Bienvenue',
  'FAQ'                          => 'FAQ',
  'CAPTION_FAQ'                  => 'Foire aux questions',
  'CAPTION_SEARCH'               => 'Votre recherche',
  'CAPTION_MEMBERS'              => 'Vous recherchez un membre ?',
  'MEMBERS_CAP'                  => 'Membres',
  'CAPTION_UCP'                  => 'Définir vos préférences',
  'UCP_CAP'                      => 'Panneau de l’utilisateur',
  'INDEX_CAPTION'                => 'Page d’accueil du forum',
  'VIEWTOPIC_CAP'                => 'Titre du sujet',
  'CAPTION_VIEWTOPIC'            => 'Description du sujet',
  'CAPTION_VIEWFORUM'            => 'Parcourir toutes les catégories du forum',
  'POSTINGS_CAP'                 => 'Posting Editor',
  'CAPTION_POSTINGS'             => 'Posting things up!',
  
  'MCP_CAPTION'                  => 'This is where you get to use the Super Powers ;-)',
  'BOOTSTRAP_ELEMENT'            => 'Composants Bootstrap',
  'BOOTSTRAP_ELEMENT_CAPTION'    => 'Documentation pour bien débuter',
  'MAIN_FORUM'                   => 'Forum',
  'MAIN_MAIN_STUFF'              => 'The Main stuff',
  'MAIN_TRENDS'                  => 'See the trends',
  
  'MAIN_SEARCH_IT_UP'            => 'Rechercher',
  'SUB_NO_ICON'                  => 'Aucune icône',
  'EXAMPLE_WITH_ICON'            => 'Exemple avec une icône',
  'EXAMPLE_LINK'                 => 'Exemple de lien',
  'MAIN_SOCIAL'                  => 'Social',
  'SOCIAL_P'                     => 'Chat away ;-)',
  
  'MORE'          				 => 'Plus',
  'EXPAND_CLOSE'          		 => 'Close View',
  'MARK_TOPICS_READ'  			 => 'Marquer les sujets comme lus',
  'CONTACT'           			 => 'Contact',
  'GET_IN_TOUCH'      			 => 'Get in touch',
  'HANG_AROUND'       			 => 'Hang around',
  'JOIN_THE_CLUB'     			 => 'Rejoindre le club',
  'MENU'         				 => 'MENU',
  'YOU_ARE_HERE'      			 => 'Vous êtes ici',
  'IN_FOOTER'         			 => 'Dans :',
  'REPLY'        				 => 'Répondre',

  'LOGIN_REMEMBER'        		 => 'Se souvenir de moi',
  'LOGIN_HIDE_ME'        		 => 'Cacher mon statut en ligne pour cette session',
  'LOGIN_ME_IN'        		     => 'Connexion',
  'SIGN_IN_ACCOUNT'        		 => 'Se connecter à son compte',
  'CREATE_ACCOUNT'        		 => 'S’enregistrer',
  'GO_TO_SEARCH_ADV'             => 'Retourner à la recherche avancée',
  
  'CREATE_ACCOUNT_DISABLED'      => 'Les enregistrements sont fermés',
  'REGISTRATION_DISABLED'        => 'Il semble que les enregistrements sont fermés pour le moment. Il s’agit peut-être d’une restriction temporaire. Si vous pensez qu’il s’agit d’une erreur, veuillez contacter le webmaster. Nous sommes désolés pour les inconvénients occasionnés. Notre politique sur la vie privée et les conditions d’utilisation sont disponibles ci-dessous',
  'CONTACT_WEBMASTER'        	 => 'Contacter le webmaster',
  'CONFIRM_QA_EXPLAIN_ALT'       => 'Pour éviter le SPAM, merci de répondre à une simple question.',
  
  'PLUPLOAD_PLACE_INLINE'        => 'Insérer en ligne',
  'PLUPLOAD_DELETE_FILE'         => 'Supprimer',
  
  
  'REG_CREATING'        		 => 'Création de profil...',
  'LOADING'        				 => 'Chargement...',
  'SAVING'        				 => 'Sauvegarde...',
  'CANCELLING'        			 => 'Annulation...',
  'SENDING'        				 => 'Envoi...',
  'SEARCHING'        			 => 'Recherche...',
  'LOADING_LOG_IN'        		 => 'Connexion...',
  'FILE_UPLOADING'        		 => 'Transfert en cours...',
  'CASTING_VOTE'        		 => 'Votre voix compte...',
  'LOADING_FORM'        		 => 'Chargement du formulaire...',

  
  'MEMBERLIST_P_JOINED'          => 'a rejoint le forum',
  'MEMBERLIST_P_EXPL'            => 'La date à laquelle j’ai rejoint le forum',
  'MEMBERLIST_P_DATE_EXPL'       => 'Ma dernière visite sur le forum',
  'SPAMMER'                      => 'Spammer',
  'SPAMMER_PLACEHOLDER'          => 'Vous ne pouvez pas spammer notre forum et vous en allez comme ça !',
  'MARK_PLACEHOLDER'      	     => 'Cochez votre choix',
  'INFO_BOX'      			     => 'Information :',
  'USER_REMOVE_PLACEHOLDER'      => 'Cliquer pour supprimer l’utilisateur',
  'GROUP_REMOVE_PLACEHOLDER'     => 'Cliquer pour supprimer le groupe',
  'EDIT_LINK_PLACEHOLDER'        => 'Ex. J’ai oublié de mettre en forme mes liens',
  'POST_IT_UP_PLACEHOLDER'       => 'Rédigez le !',
  
  'UCP_REG_USR_PLACEHOLDER'      => 'Ex. John Doe',
  'UCP_REG_EMAIL_PLACEHOLDER'    => 'Ex. john@mail.com',
  'UCP_REG_PSWD_PLACEHOLDER'     => 'Ex. ASDFasdf123',
  'UCP_REG_CTCHA_PLACEHOLDER'    => 'Ex. ciel bleu',
  'SEARCH_USR_PLACEHOLDER'       => 'Ex. John Doe',
  
  'MESSAGE_ENTER_PLACEHOLDER'    => 'Saisir votre message...',
  'FILE_COMMENT_PLACEHOLDER'     => 'Titre de votre fichier',
  'HEIGTH_PLACEHOLDER'       	 => 'hauteur',
  'WIDTH_PLACEHOLDER'       	 => 'largeur',
  'UCP_OCCUPATION_PLACEHOLDER'   => 'Décrire rapidement votre emploi...',
  'UCP_INTERESTS_PLACEHOLDER'    => 'Décrire vos centres d’intérêt...',
  'SOFT_DELETE_PLACEHOLDER'      => 'Rédiger la raison si vous le souhaitez...',
  'ADD_DESCRIPTION'              => 'Ajouter une description',
  
  'FILE_SELECT'       			 => 'Sélectionner le fichier',
  'FILE_CHANGE'       			 => 'Modifier',
  'SELECT_IMAGE'       			 => 'Sélectionner une image',
  'NOTE'       			         => 'Note',
  'EDIT_DRAFT'       			 => 'Modifier le brouillon',
  'PM_BALOON_NOTIFICATION'       => 'Activer les badges de notifications pour les nouveaux messages privés',
  'DAYS_AGO'       			     => 'Jours d’ancienneté',
  'WORK_IN_PROGRESS'       		 => 'Maintenance',
  'DISABLE_MESSAGE'              => 'Forum indisponible',
  'DISABLE_RETURN'               => 'Retourner à l’index du forum',
  'BOARD_DISABLED_SHUFFLE'       => 'Have fun and shuffle some letters :-)',
  'DISABLE_TEXT_TRY'             => 'Essayez par vous-même !',
  'DISABLE_TEXT_TYPE'            => 'type anything and hit return...',
  
  'GRAVATAR_EXPLAIN'          	 => 'Si un <a href="//en.gravatar.com/" target="_blank">GRAVATAR</a> est associé à votre adresse de courriel, il sera affiché par défaut.',
  'GRAVATAR_EXPLAIN_CONFIRM'     => 'Merci de confirmer votre adresse de courriel',
  
  'DELETE_POLL'       			 => 'Supprimer le sondage',
  'POLL_DELETE_HELPER'       	 => '(Seul le sondage sera supprimé) Cochez et validez',
  'JUMP_TO_POST'       			 => 'Aller au message',
  'JUMP_SELECT_FORUM'            => 'Aller à',
  'JUMP_TO_PAGE_NUMBER'          => 'Cliquer pour aller à la page...',
  'VIEW_FIRST_UNREAD'            => 'Voir le premier message non lu',
  'BOOKMARK_TOPIC_REMOVE'        => 'Supprimer le favoris',
  
  'NEW_MESSAGES'	             => 'Nouveaux messages',
  'YOU_HAVE'        	   		 => 'Vous avez',
  'AND'        					 => 'et',
  'HELLO'            		     => 'Bienvenue',
  'DISMISS_PM'       			 => 'Reporter 5 minutes',
  'READ_NOW'      			     => 'Lire',
  'PRIVATE_MESSAGE_NEW'	         => 'nouveau message privé',
  'PRIVATE_MESSAGE_UNREAD'	     => 'message privé non lu',
  'NO_PMS_INFO'	                 => 'Souhaitez-vous rédiger un nouveau message privé ?',
  
  'DATES'       			     => 'DATE',
  'POWERED'       			     => 'Développé par',
  'HANDCRAFTED'       			 => 'Conçu avec',
  'BY'       					 => 'par',

  'RECENT_TOPICS'       		 => 'Sujets récents',
  'TWITTER'       				 => 'Twitter',
  'FAVORITES'       			 => 'Favoris',

  'GALLERY'       				 => 'Galerie',
  'CHAT'       					 => 'Chat',
  'ABOUT'       				 => 'A propos',
  'ABOUT_PART_ONE'       		 => 'BBOOTS&#8482; est le premier et unique thème complètement responsive pour phpBB&reg;. Sa réalisation est soignée et impressionnante sur tous les navigateurs et périphériques.',
  'ABOUT_PART_TWO'       		 => 'Il utilise un design basé sur Twitter Bootstrap attendu depuis longtemps et qui satisfera les utilisateurs de phpBB.',
  'ABOUT_PART_THREE'       		 => 'Le thème responsive non officiel',
  'BB'       		             => 'B',
  'BOOTS'                		 => 'BOOTS',
  'BBOOTS'       		         => 'BBOOTS',
  
  'BBOOTS_VERSION'    			 => '<a href="http://www.sitesplat.com/phpBB3/">BBOOTS</a>',
  'U_LOGOUT'          			 => 'Déconnexion',

  'SITESPLAT_STATISTICS'		 => 'Statistiques',
  'SITESPLAT_SEE_DETAILS'		 => 'Voir les détails',
  'SITESPLAT_SEARCH_LAST_DAY'    => 'Messages publiés les 24 dernières heures',
  'SITESPLAT_SEARCH_WEEK'		 => 'Messages publiés les 7 derniers jours',
  
  'SITESPLAT_TOTAL_POSTS'		 => 'Nombre de messages',
  'SITESPLAT_TOTAL_TOPICS'	     => 'Nombre de sujets',
  'SITESPLAT_TOTAL_USERS'		 => 'Nombre de membres',
  'SITESPLAT_NEWEST_MEMBER'		 => 'Membre le plus récent',
  'SITESPLAT_USERS_ONLINE'		 => 'Membres',
  'SITESPLAT_MOST_USERS_ONLINE'	 => 'Record du nombre d’utilisateurs',
  'SITESPLAT_BIRTHDAYS'	         => 'Anniversaires',
  
  'BOOTSTRAP_VERSION'	         => '3.3.6',
  'FLATBOOTS'	                 => 'FLATBOOTS',
  'CHANGE_AVATAR'	             => 'Modifier l’avatar',
  'CHANGE_PASSWORD'	             => 'Modifier le mot de passe',
  
  'ADMIN_TIPS'	                 => 'Trucs &amp; Astuces pour les administrateurs',
  'ADMIN_TIP_INTRO'	             => 'Saviez-vous qu’il est possible de rendre votre forum phpBB plus sécurisé en quelques étapes ?',
  'ADMIN_TIP_ONE'	             => 'Maintenir à jour votre forum.',
  'ADMIN_TIP_TWO'	             => 'Utiliser des mots de passe complexes qui contiennent des suites aléatoires de lettres, chiffres et caractères spéciaux.',
  'ADMIN_TIP_THREE'	             => 'Resteindre l’accès au dossier admin...',
  'ADMIN_CHECK_IT_BTN'	         => 'Visiter SiteSplat.com pour plus d’informations',
  
  'USER_MINI_PROFILE'	         => 'Profil simplifié du membre',
  'USER_MINI_PROFILE_VIEW_FULL'	 => 'Voir le profil complet',
  'OFF_LINE'	                 => 'Hors-ligne',
  'USER_STATUS'	                 => 'Statut',
  'USER'	                     => 'Membre',
  'TITLE'	                     => 'Titre',
  'END_TIMELINE'	             => 'Fin du journal',
  'MEMBERS'	                     => 'Membres',
  'DRAFTS'	                     => 'Brouillons',
  'REPORTS'	                     => 'Reports',
  'MODERATOR_LOGS'	             => 'Journaux du modérateur',
  'QUEUE'	                     => 'En attente',
  'LINKS'	                     => 'Liens',
  'TOPIC_PERMISSIONS'	         => 'Permissions du sujet',
  'MODERATOR_OPTIONS'	         => 'Modérer',
  'PASSWORD_EXPLAIN_CONFIRM'	 => 'Veuillez vous assurer qu’ils sont identiques',
  'FORUM_REDIRECTS'	             => 'Redirections :',
  
  'FANCY_TOPICS_TITLE'	         => 'Sujets récents du forum',
  'POST_BY'	                     => 'Posté par',
  'REPLY_BY'	                 => 'Message par',
  'NO_REPLIES'	                 => 'Pas de message',
  'READ_MORE'	                 => 'Lire la suite',
  'RT_READ_MORE'	             => 'Lire la suite',
  'VIEW_MORE_TOPICS'	         => 'Voir plus de sujets',
  'BACK_TO_START'	             => 'Revenir au début',
  
  'TOGGLE_NAV'	                 => 'Étendre la navigation',
  'NAVIGATION'	                 => 'Navigation',
  
  'DEMO_LINK'	                 => 'Exemple de lien sans icône',
  'DEMO_HEADER_MENU'	         => 'Exemple',
  
  'FLATBOOTS_INTRO'	             => 'Bootstrap Framework',
  'FLATBOOTS_EXPLAIN'	         => 'Plus d’une douzaine de composants réutilisables pour créer iconographie, dropdowns, input groups, navigation, alertes et bien plus...',
  'CALL_TO_ACTION_FOOTER'        => 'Avec les extensions, utilisez uniquement ce dont vous avez besoin !',
  'PURCHASE_NOW_BTN'             => 'Acheter maintenant',
  'FLATBOOTS_ABOUT_PART_ONE'     => 'Pourquoi vous contenter de moins lorsque vous pouvez en avoir plus ? Ne laissez pas les autres auteurs vous tromper avec des arguments trompeurs. FLATBOOTS est ce que vous méritez. Développé pour durer, développé à partir de zéro, rien de moins.',
  'FLATBOOTS_ABOUT_TITLE'	     => 'Développé pour durer',
  'DMCA'	                     => 'DMCA',
  'TERMS'	                     => 'Conditions d’utilisation',
  'ADVERTISE'	                 => 'Publicité',
  'SITESPLAT'	                 => 'SiteSplat',
  'SITESPLAT_URL'	             => '<a href="http://sitesplat.com" class="btn btn-default" target="blank">SiteSplat.com</a>',
  'JOIN_US_TWITTER'	             => 'Rejoignez-nous sur Twitter',
  'TWEET_EXAMPLE'	             => 'BBOOTS a atteint les 2000 ventes ! Merci à tous de soutenir ce projet merveilleux et de contribuer à élargir  la communauté SiteSplat. Et maintenant ? Restez attentifs et suivez-moi sur Twitter : <a href="#">http://bit.ly/000fefs</a>',
  
));
