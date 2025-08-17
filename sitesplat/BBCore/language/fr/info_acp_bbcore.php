<?php
/**
*
* common [English]
*
* @package language
* @package sitesplat BBcore
* @version $Id$
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
* French translation by Mathieu M. ( https://www.monsieur2m.fr/ )
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
    
	'ACP_SITESPLAT_UPDATE_MANAGER'  => 'Gestionnaire de mises à jour par SiteSplat',
    'VERSION_INSTALLED'  			=> 'Version installée',
	'NEW_BOOTS_VERSION'				=> 'Nouvelle version %s disponible',
	'VERSIONNUMBERS'				=> 'Version istallée : %s, télécharger la nouvelle version depuis le serveur : <a style="color:#fff;" href="%s" title="Téclarger" target="_blank">%s</a>',
	'SS_RAPID_DISABLE'				=> 'SS Désactivation rapide',
	'SS_RAPID_DISABLE_TLT'		    => 'Désactive (toutes) les extensions immédiatement. Effectuez une sauvegarde avant toute action !',
	
	'DOWNLOAD_MSG'					=> 'La version actuelle <span class="label label-success">%s</span> peut être téléchargée sur Themeforest : <a href="%s" title="Télécharger" target="_blank">%s - phpBB3</a>',
	'CHANGE_LOG_MSG'				=> 'Le changelog est disponible ici : <a href="%s" target="_blank">Changelog pour %s (phpBB3.1)</a>',
	'SUPPORT_FORUM_MSG'				=> 'Le forum de support est disponible depuis la communauté officielle : <a href="%s" title="Télécharger" target="_blank">http://www.sitesplat.com</a>',
	'COLORIZE_MSG'					=> 'Le service Colorize est disponible ici : <a href="http://www.sitesplat.com/phpBB3/themer.php" target="_blank">Colorize</a> (Veuillez vous assurer d\'être connecté)',
	'NO_VERSIONINFO'				=> 'Aucune information sur la version disponible, veuillez réessayer dans quelques minutes !',

    'LOG_FILES_CHANGED'			    => '<strong>BBcore a modifié les %s fichiers suivants pour vous :</strong><br />» %s',
    'LOG_THEME_INSTALLED'			=> '<strong>BBcore installé avec succès</strong>',
    'LOG_FILES_CHANGED_FAILED'	    => '<strong>BBcore n’a pas été installé correctement</strong><br />» Certaines fonctionnalités pourraient ne pas fonctionner !',
    'LOG_THEME_UNINSTALLED'		    => '<strong>BBcore désinstallé avec succès</strong>',
  
    'LOG_FILE_NOT_REPLACED'		    => '<strong>BBcore n’a pas réussi à remplacer le fichier original pour vous :</strong><br />» %s',
    'LOG_FILE_NOT_UPDATED'		    => '<strong>BBcore n’a pas réussi à mettre à jour le fichier %s pour vous :</strong><br />» %s',
	
	'LOG_BBCORE_INSTALLED'			=> '<strong>Sitesplat BBCore installé avec succès</strong>',
	'LOG_BBCORE_DEINSTALLED'		=> '<strong>Sitesplat BBCore désinstallé avec succès</strong>',

	'LOG_BBCORE_NOT_REPLACED'		=> '<strong>Sitesplat BBCore ne s’est pas désinstallé correctement</strong><br />Impossible de remplacer les fichiers suivants<br />» %s',
	'LOG_BBCORE_NOT_UPDATED'		=> '<strong>Sitesplat BBCore ne s’est pas installé correctement</strong><br />Impossible de mettre à jour les fichiers suivants<br />» %s',
    
	'ACP_BBCORE_MSG_FILES_FAIL'		=> 'Tous les fichiers n’ont pas été modifiés ! Veuillez remplacer manuellement les fichiers mentionnés dans le journal d’administration de l’onglet MAINTENANCE.',
	'ACP_BBCORE_MSG_SETTINGS'		=> 'Il n’y a pas de configuration pour l’extension.<br /> Cependant, toutes les mises à jour n’ont pas été effectuées correctement en raison des permissions de fichiers du serveur ou des fichiers manquants.<br />Consultez le journal d’administration pour plus de détails.<br /><br />Veuillez mettre à jour les permissions de fichiers manuellement.',
	'BBCORE_ERROR_DISABLE'		    => 'Vous ne pouvez pas désactiver SiteSplat BBCore à cause des autres extensions actives de SiteSplat.<br />Désactivez les extensions de SiteSplat en premier (vous pouvez utiliser la désinstallation rapide pour désactiver toutes les extensions de SiteSplat immédiatement).<br /><br /><div style="margin: 0px auto; width: 50%%;"><strong>» %s</strong></div>'
));

?>