<?php

/**
 *
 * Invite. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2010-2015, KillBill
 * @copyright (c) 2017, kasimi
 * @copyright (c) 2017-2022, Leinad4Mind, https://leinad4mind.top/forum
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
	'AUTH_CACHE_PURGE'						=> 'Purger le cache des permissions',

	'CACHE_PURGE'							=> 'Purger le cache du forum',
	'CAT_INSTALL'							=> 'Installation',
	'CAT_OVERVIEW'							=> 'Aperçu',
	'CAT_UNINSTALL'							=> 'Désinstallation',
	'CAT_UPDATE'							=> 'Mise à jour',
	'CAT_VERIFY'							=> 'Vérification',

	'GPL'									=> 'General Public License',

	'INCOMPLETE_FILES_UPLOAD'				=> 'Tous les fichier de phpBB Invite n’ont pas été uploadés. Veuillez vous assurer que vous avez bien uploadé tous les fichiers avant de lancer le script-installateur.',
	'INCOMPLETE_FILE_EDITS'					=> 'L’édition de ce fichier n’a pas encore été faite, on ne peut lancer l’installation tant que tous les fichiers n’ont pas été correctement édités !',
	'INCOMPLETE_LANG_ROWS'					=> 'Des changements dans les fichiers de langue sont manquants. Veuillez faire les éditions comme indiqué %sICI%s.',
	'INSTALLATION'							=> 'Installation de phpBB Invite',
	'INSTALLATION_EXPLAIN'					=> '<br />Ce module permet d’installer la base de données de phpBB Invite.<br /><br />',
	'INSTALL_BODY'							=> 'Ici on peut voir si le MOD a été intallé proprement.',
	'INSTALL_ERR_AUTH'						=> 'Vous n’êtes pas autorisé à utiliser ce script.<br /><br />Veuillez noter que, pour utiliser le script, les conditions suivantes sont requises. Primo vous devez être connecté sur le site et secundo vous devez être un utiliseur avec des permissions de type fondateur. Si vous êtes bien connecté et avez les permissions adéquates, il se peut que vous ayez des réglages incorrects de cookie dans l’ACP. Veuillez vérifier le paramètre du dommaine du cookie. Si l’URL du site est <strong>http://www.example.com</strong> alors le domaine du cookie devrait être <strong>.example.com</strong>.',
	'INSTALL_FOLDER'						=> '<strong>Veuillez supprimer le dossier install. Tant que vous ne l’aurez pas fait, seulement l’ACP sera accessible.</strong>',
	'INSTALL_LOGIN'							=> 'Continuer vers l’ACP',

	'INVITE_CONFIG_ADD'						=> 'Ajout d’une nouvelle variable de configuration pour phpBB Invite: %s',
	'INVITE_CONFIG_ALREADY_EXISTS'			=> 'ERREUR: la variable de configuration de phpBB Invite %s existe déjà.',
	'INVITE_CONFIG_NOT_EXIST'				=> 'ERREUR: la variable de configuration de phpBB Invite %s n’existe pas.',
	'INVITE_CONFIG_REMOVE'					=> 'Suppression de la variable de configuration de phpBB Invite: %s',
	'INVITE_CONFIG_UPDATE'					=> 'Mise à jour de la variable de configuration de phpBB Invite: %s',

	'INVITE_INSTALL_INTRO'					=> 'Bienvenue dans l’Installation de phpBB Invite',
	'INVITE_INSTALL_INTRO_BODY'				=> 'Avec cette option, il est possible d’installer phpBB Invite dans votre base de données.',

	'INVITE_VERSION'						=> 'La version de phpBB Invite est <b>%s</b>, ce script doit être utilisé pour mettre à jour la version <b>%s</b> vers la version <b>%s</b>. <br /> Vous devez d’abord bien mettre à jour à la version <b>%s</b> pour que ce script d’installation fonctionne !',

	'NOT_INSTALL_DIR'						=> 'Il n’est pas possible d’accéder au dossier install !',
	'NOT_LANGUAGE_DIR'						=> 'La librairie de langue n’est pas disponible !',
	'NOT_LANGUAGE_DIR_DIR'					=> 'Le répertoire de langue %s n’a pas été trouvé !',
	'NOT_MODULE'							=> 'Les modules d’installation ne sont pas disponibles !',
	'NOT_MODULE_OPEN'						=> 'Le Module %s n’est pas disponible !',
	'NO_TABLE_DATA'							=> '<span style="color:#FF0000;">Erreur:</span> Les données de la table sont manquantes.',

	'OVERVIEW_BODY'							=> '<br />Bienvenue !<br /><br />Ceci est un guide complet pour l’installation du MOD phpBB Invite, ou sa désinstallation, ou ses mises à jour, ou encore pour effectuer des vérifications.<br />Veuillez sélectionner dans le menu l’option dont vous avez besoin.',

	'PARENT_NOT_EXIST'						=> '<span style="color:#FF0000;">Erreur:</span> La catégorie parente qui désigne le nouveau module n’existe pas.',
	'PERMISSIONS_WARNING'					=> 'Les paramètres des nouvelles permissions ont été ajoutés. Vérifiez bien vos réglages de permissions et voyez s’ils sont à votre convenance.',
	'PHPBB_INVITE_DONATE'					=> 'S’il vous plait, veuillez faire un petit don si vous appréciez notre travail et les nombreuses heures passées à construire le MOD “phpBB Invite”.',
	'PHPBB_INVITE_DONATE_TITLE'				=> 'Donation pour phpBB Invite',
	'PHPBB_VERSION'							=> 'Votre version de phpBB est la <b>%s</b>, le MOD phpBB Invite requiert la version <b>%s</b> !',
	'PHP_VERSION_RUN'						=> 'Votre version de PHP n’est pas compatible, veuillez mettre à jour votre PHP à la version 4.3.3 (ou plus récente) avant de lancer l’installation.</b>',

	'ROLE_NOT_EXIST'						=> '<span style="color:#FF0000;">Erreur:</span> ce modèle ne se trouve pas dans la base de données.',

	'STAGE_INSTALL'							=> 'Installer',
	'STAGE_INTRO'							=> 'Intro',
	'STAGE_UNINSTALL'						=> 'Supprimer la base de données',
	'STAGE_VERIFY'							=> 'Vérifier',
	'STAGE_VERIFY_FILE_EXPLAIN'				=> '<br />Les fichiers du MOD ont été supprimés avec succès.',
	'SUB_INTRO'								=> 'Introduction',
	'SUB_LICENSE'							=> 'Licence',
	'SUB_SUPPORT'							=> 'Support',
	'SUCCESSES'								=> '<span style="color:#000;"><b>Installation complète et réussie !</b></span>',
	'SUPPORT_BODY'							=> '<br />Une prise en charge complète est assurée gratuitement pour la présente version ainsi que pour les versions de développement.<br /><br />Cela inclut :</p><ul><li>information</li><li>configuration</li><li>mises à jour des anciennes versions vers la dernière version</li></ul><p>Nous encourageons les utilisateurs à toujours faire les mises à jour vers la version la plus récente.</p><h2>Forums de support</h2><br /><p><a href="http://jatek-vilag.com/viewtopic.php?p=204#p204" onclick="window.open(this.href); return false;">Site principal de développement</a><br /><a href="https://www.phpbb.com/community/viewtopic.php?p=12855248#p12855248" onclick="window.open(this.href); return false;">Topic de Développement sur phpBB.com</a><br /><a href="http://phpbb.hu/forum/hsz/40666#hsz-40666" onclick="window.open(this.href); return false;">Topic de Développement sur phpBB.hu</a><br /><br />',

	'UNINSTALL_BODY'						=> 'Ici vous pouvez voir que les entrées de la base de donnees pour le MOD ont bien été supprimées.<br /><br /><b>Veuillez supprimer le dossier install. Tant que vous ne l’aurez pas fait, seulement l’ACP sera accessible.</b>',
	'UNINSTALL_INTRO'						=> 'Désinstallation de phpBB Invite',
	'UNINSTALL_INTRO_BODY'					=> 'Grâce à cette option, vous pouvez supprimer phpBB Invite de votre base de données.',
	'UNINSTALL_TITLE'						=> 'phpBB Invite supprimé de la base de données',
	'UPDATE_BODY'							=> 'Ici vous pouvez voir si le MOD a bien été mis à jour proprement.<br /><br /><b>Veuillez supprimer le dossier install. Tant que vous ne l’aurez pas fait, seulement l’ACP sera accessible.</b>',
	'UPDATE_INSTALLATION'					=> 'Mise à jour de phpBB Invite',
	'UPDATE_INSTALLATION_EXPLAIN'			=> '<br />Mettre à jour phpBB Invite à la dernière version.<br />',
	'UPDATE_TITLE'							=> 'Mise à jour des données de la base',

	'VERIFY_ERROR_EXPLAIN'					=> 'La vérification a trouvé une erreur.',
	'VERIFY_ERROR_FILE'						=> 'Erreurs de modifications de fichier',
	'VERIFY_ERROR_FILE_EXPLAIN'				=> 'Ici on peut voir quels fichiers ont mal été édités ou simplement oubliés.',
	'VERIFY_EXITS_PRINT_MYAD'				=> '<br />On peut voir ici la commande SQL si vous souhaitez installer par vous-même avec phpMyAdmin.',
	'VERIFY_EXITS_PRINT_SQL'				=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">Pas trouvé !</span></b><br />%s<br />',
	'VERIFY_INVITE_MOD_CONFIG'				=> 'Configuration de phpBB Invite',
	'VERIFY_INVITE_MOD_CONFIG_OK'			=> '<span style="color:#228822;"><strong>Toute la configuration de phpBB Invite est OK.</strong></span>',
	'VERIFY_INVITE_MOD_FILES'				=> 'Fichiers de phpBB Invite',
	'VERIFY_INVITE_MOD_FILES_OK'			=> '<span style="color:#228822;"><strong>Tous les fichiers ont été trouvés.</strong></span>',
	'VERIFY_INVITE_MOD_MODULES'				=> 'Modules de phpBB Invite',
	'VERIFY_INVITE_MOD_MODULES_OK'			=> '<span style="color:#228822;"><strong>Tous les modules ont été trouvés.</strong></span>',
	'VERIFY_INVITE_MOD_PERM'				=> 'Permissions de phpBB Invite',
	'VERIFY_INVITE_MOD_PERM_OK'				=> '<span style="color:#228822;"><strong>Toutes les permissions sont OK.</strong></span>',
	'VERIFY_INVITE_MOD_TABLES'				=> 'Tables de phpBB Invite',
	'VERIFY_INVITE_MOD_TABLES_OK'			=> '<span style="color:#228822;"><strong>Toutes les tables ont été trouvées.</strong></span>',
	'VERIFY_NOT_AC_FOUND'					=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">pas trouvé !</span></b>',
	'VERIFY_NOT_COLUMN'						=> 'Colonnes manquantes',
	'VERIFY_NOT_COLUMN_EXPLAIN'				=> 'Ici on peut voir les colonnes qui n’ont pas été installées.',
	'VERIFY_NOT_CONFIG'						=> 'Problèmes de configuration',
	'VERIFY_NOT_CONFIG_EXPLAIN'				=> 'Ici on peut vérifier quels fichiers de configuration n’ont pas été installés.',
	'VERIFY_NOT_FILE'						=> 'Fichiers manquants',
	'VERIFY_NOT_FILE_EXPLAIN'				=> 'Ici on peut voir quels fichiers sont corrompus ou pas installés ou bien pas installés au bon endroit.',
	'VERIFY_NOT_INVITE_CONFIG'				=> 'Problèmes de configuration de phpBB Invite',
	'VERIFY_NOT_INVITE_CONFIG_EXPLAIN'		=> 'Ici on peut vérifier quels fichiers de configuration de phpBB Invite n’ont pas été installés.',
	'VERIFY_NOT_MODULE'						=> 'Modules manquants',
	'VERIFY_NOT_MODULE_EXPLAIN'				=> 'Ici on peut voir les modules qui n’ont pas été installés.',
	'VERIFY_NOT_PERMIS'						=> 'Permissions manquantes',
	'VERIFY_NOT_PERMIS_EXPLAIN'				=> 'Ici on peut voir les permissions qui n’ont pas été installées.',
	'VERIFY_NOT_TABLE'						=> 'Table manquante',
	'VERIFY_NOT_TABLE_EXPLAIN'				=> 'Ici on peut voir quelles données n’ont pas été installées.',
	'VERIFY_NO_COLUMN'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">colonne pas trouvée !</span></b><br />%s<br />',
	'VERIFY_NO_MODULE'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">le module n’a pas été trouvé dans la base de données !</span></b>',
	'VERIFY_NO_PERMIS'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">la permission n’a pas été trouvée dans la base de données !</span></b>',
	'VERIFY_NO_TABLE'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">la table n’a pas été trouvée dans la base de données !</span></b>%s',
	'VERIFY_PHPBB_MOD_COLUMNS'				=> 'Nouvelles colonnes de la table phpBB',
	'VERIFY_PHPBB_MOD_COLUMNS_OK'			=> '<span style="color:#228822;"><strong>Toutes les colonnes ont été trouvées.</strong></span>',
	'VERIFY_PHPBB_MOD_CONFIG'				=> 'Nouvelle configuration phpBB',
	'VERIFY_PHPBB_MOD_CONFIG_OK'			=> '<span style="color:#228822;"><strong>La configuration de phpBB est OK.</strong></span>',
	'VERIFY_PHPBB_MOD_FILES'				=> 'Editions des fichiers phpBB',
	'VERIFY_PHPBB_MOD_FILES_OK'				=> '<span style="color:#228822;"><strong>Tous les fichiers ont été édités.</strong></span>',
	'VERIFY_SUCCESSES_EXPLAIN'				=> 'Tout a été vérifié avec succès.',
	'VERIFY_TITLE'							=> 'Vérification de phpBB Invite',
	'VERIFY_TITLE_ELL'						=> 'Erreurs de contrôle',
	'VERIFY_TITLE_ELL_EXPLAIN'				=> '<span style="color:#000;"><b>Ici on peut voir toutes les erreurs qui sont survenues afin de pouvoir tout corriger avec soin !</b></span>',
	'VERIFY_TITLE_EXPLAIN'					=> '<br />Ce module de contrôle vous permet de vérifier si toutes les éditions requises ont bien été faites et si tous les fichiers de la base de données ont bien été installés ou mis à jour.',
	'VERIFY_NEW'							=> 'Re-vérifier',
	'VERIFY_UNINSTALL_ERROR_FILE'			=> 'Stock résiduel',
	'VERIFY_UNINSTALL_ERROR_FILE_EXPLAIN'	=> 'Ici on peut voir les fichiers qui n’ont pas été supprimés.',
));
