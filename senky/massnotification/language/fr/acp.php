<?php
/**
 *
 * Mass Notification. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Jakub Senko
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

$lang = array_merge($lang, array(
	'MASSNOTIFICATION_DESC'	=> 'Vous pouvez envoyer une notification à tous vos utilisateurs ou à un groupe spécifique.',

	'COMPOSE'				=> 'Créer une notification de masse',
	'ALL_USERS'				=> 'Tous les utilisateurs',
	'SEND_TO_GROUP'			=> 'Envoyer à un groupe',
	'SEND_TO_USERS'			=> 'Envoyer aux utilisateurs',
	'SEND_TO_USERS_EXPLAIN'	=> 'Entrez les pseudos qui remplaceront les groupes sélectionnés ci-dessus. Entrez chaque pseudo sur une nouvelle ligne.',
	'TITLE'					=> 'Titre de la notification',
	'MESSAGE_EXPLAIN'		=> 'Il est préférable d\'écrire un message de moins de 150 caractères. Le HTML est autorisé.',
	'URL'					=> 'URL de redirection',
	'URL_EXPLAIN'			=> 'Entrez une URL où les utilisateurs seront redirigés lorsqu\'ils cliqueront sur la notification.',
	'AUTHOR_EXPLAIN'		=> 'Entrez l\'auteur de la notification. Laissez vide pour envoyer une notification sans auteur.',
	'SEND_NOTIFICATION'		=> 'Envoyer la notification',

	'NO_NOTIFICATION_TITLE'		=> 'Tu dois mettre un titre à ta notification.',
	'NO_NOTIFICATION_MESSAGE'	=> 'Tu dois mettre un message à ta notification.',
	'NO_NOTIFICATION_AUTHOR'	=> 'L\'auteur n\'existe pas.',

	'NOTIFICATION_SEND'	=> 'Ta notification a été envoyée.',
));
