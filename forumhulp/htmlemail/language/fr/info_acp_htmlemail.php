<?php
/**
*
* HTML email extension for the phpBB Forum Software package.
* French translation by Galixte (http://www.galixte.com)
*
* @copyright (c) 2015 ForumHulp.com <http://forumhulp.com>
* @license GNU General Public License, version 2 (GPL-2.0)
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
// ’ « » “ ” …
//

$lang = array_merge($lang, array(
	'FH_HELPER_NOTICE'			=> 'L’extension : « Forumhulp Helper » n’est pas installée !<br />Il est nécessaire de télécharger son archive disponible sur cette page : <a href="https://github.com/ForumHulp/helper" target="_blank">Forumhulp Helper</a>, puis de l’envoyer sur son espace FTP et de l’activer.',
	'HTML_EMAIL_NOTICE'			=> '<div class="phpinfo"><p class="entry">Aucun paramètre n’est disponible pour cette extension.<br />Cette extension est utile pour l’extension « E-mail on birthday » en activant l’option : « E-mail d’anniversaire en HTML », dans l’onglet « GÉNÉRAL », rubrique « Fonctionnalités du forum ». Pour utiliser le language HTML dans d’autres e-mails, la fonction « messenger » doit envoyer les e-mails en HTML via la fonction « $messenger->set_mail_html(true) ». Enfin, saisir le contenu en langage HTML de son fichier e-mail (*.txt) par ce que l’on souhaite.</p></div>',
	'DELETE_DATA_NOTICE'		=> '<div style="width:80%;margin:20px auto;"><p style="text-align:left;">Tous les fichiers n’ont pas été remplacés ! Merci de remplacer les fichiers mentionnés dans le « Journal d’administration ».</p></div>',
	'ENABLE_DATA_NOTICE'		=> '<div style="width:80%;margin:20px auto;"><p style="text-align:left;"><br />Cependant, toutes les mises à jour n’ont pas été correctement exécutées en raison des permissions sur les fichiers ou en raison de fichiers manquants. Pour davantage d’informations merci de consulter le « Journal d’administration ».<br /><br />Merci de mettre à jour les fichiers manuellement pour accéder à toutes les fonctionnalités !</p></div>'
));
