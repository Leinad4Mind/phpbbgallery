<?php
/**
*
* @package language
* @package sitesplat BBcore addon
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
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge(
	$lang, array(
		'UCP_IR'				    => 'Redimensionner l’image',
		'IMAGE_RESIZE'			    => 'Redimensionner l’image',
		'IMAGE_RESIZE_EXPLAIN'	    => 'Recadrez votre %1$s de votre image et validez.',
		// Your avatar will be saved with a height of %1$s pixels and a width of %2$s pixels.',

		'IMAGE_RESIZE_ERROR'	    => 'Aucune application ou fichier à envoyer !',
		'IMAGERESIZE_NOTICE'	    => '<div class="phpinfo"><p>Il n’y a pas de configuration pour l’extension. Une fois que l’utilisateur a téléchargé l’avatar depuis le panneau de l’utilisateur, l’option de recadrage sera disponible.<br /> Vérifier dans le Panneau d’administration &#62; Paramètres des avatars : "Taille maximale d’un avatar"  que la valeur soit 0 ou supérieure à 2 Mo pour une expérience d’utilisateur optimale.</p></div>',
		'ERROR_IMAGERESIZE_DISABLE'	=> 'Vous ne pouvez pas désactiver BBAvatarResize à cause des autres extensions actives de SiteSplat<br /><div>» %s</div>',
	    'SS_HELPER_NOTY'	    	=> 'SiteSplat BBcore n’existe pas !<br />Téléchargez <a href="http://sitesplat.com" target="_blank">BBcore</a> et copiez le dossier BBCore dans votre dossier ext/sitesplat/.',
	)
);
