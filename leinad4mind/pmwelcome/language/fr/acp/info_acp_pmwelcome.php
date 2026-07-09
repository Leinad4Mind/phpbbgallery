<?php

/**
 *
 * @package PM Welcome
 * @copyright (c) 2015 Anvar
 * @copyright (c) 2020 RMcGirr83
 * @copyright (c) 2019-2022 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

if (!defined('IN_PHPBB')) {
   exit;
}
if (empty($lang) || !is_array($lang)) {
   $lang = [];
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
// Some characters for use
// ’ » “ ” …


$lang = array_merge($lang, [
   // General config options
   'ACP_PMWELCOME'               => 'Message de bienvenue',
   'ACP_PMWELCOME_EXPLAIN'         => 'Vous pouvez spécifier le texte du message de bienvenue qui sera envoyé à l‘utilisateur lors de sa première connexion au forum.',
   'ACP_PMWELCOME_SETTINGS'      => 'Paramètres de message privé de bienvenue',
   'ACP_PMWELCOME_USER'         => 'Expéditeur',
   'ACP_PMWELCOME_USER_EXPLAIN'   => 'Nom du membre qui enverra le message privé de bienvenue aux nouveaux inscrits.',
   'ACP_PMWELCOME_SUBJECT'         => 'Sujet du message de bienvenue',
   'ACP_PMWELCOME_SUBJECT_SHORT'         => 'Sujet',
   'ACP_PMWELCOME_TEXT'         => 'Texte du message de bienvenue',
   'ACP_PMWELCOME_TEXT_SHORT'         => 'Texte',
   'ACP_PMWELCOME_TEXT_EXPLAIN'   => 'You can use bbcode and smilies, and the following tokens: {USERNAME} to replace the name of the user who receives a private message; {USER_EMAIL} to replace the email of the user who receives a private message; {SITE_NAME} and {SITE_DESC} to replace with the name and description of your forum; {BOARD_CONTACT}, {BOARD_EMAIL} and {BOARD_SIG} to replace the forum contact, email and signature; As well as {SENDER} to insert the senders name.',
   'ACP_PMWELCOME_TEXT_EXPLAIN'   => 'Vous pouvez utiliser les bbcodes, les smileys, et les variables: {USERNAME} pour afficher le nom de l‘utilisateur qui reçoit le message privé de bienvenue; {USER_EMAIL} pour afficher le email de l‘utilisateur qui reçoit le message privé de bienvenue; {SITE_NAME} et {SITE_DESC} pour afficher le nom et la description de votre forum; {BOARD_CONTACT}, {BOARD_EMAIL} et {BOARD_SIG} pour afficher le contact, l‘e-mail et la signature du forum; Ainsi que {SENDER} pour insérer le nom de l‘expéditeur dans le message.',
   'ACP_PMWELCOME_PREVIEW'         => 'Aperçu du texte de bienvenue du message privé',
   'ACP_PMWELCOME_NO_USER'         => '<b>L‘expéditeur n‘existe pas</b>',
   'ACP_PMWELCOME_CONFIG_SAVED'   => 'La configuration du message privé de bienvenue a été enregistrée',
   'TOO_SHORT_PMWELCOME_SUBJECT'   => 'Titre du mesage de bienvenue trop court',
   'TOO_SHORT_PMWELCOME_POST_TEXT'   => 'Texte du message privé de bienvenue trop court',
   // Log entries
   'LOG_CONFIG_PMWELCOME_ADMIN'      => '<strong>Modification des paramètres du message privé de bienvenue</strong>',
   'LOG_PMWELCOME_CONFIG_UPDATE'      => '<strong>Mise à jour des paramètres du message privé de bienvenue</strong>',
]);