<?php
/**
 *
 * Best Answer extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, kinerity, https://www.layer-3.org/
 * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
 * @translation (c) 2019 Galixte (http://www.galixte.com)
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
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, [
	'ANSWERS'  => 'Réponses',
	'ANSWERED' => 'Répondue',
	
	'BEST_ANSWER'             => 'Meilleure réponse',
	'BBPOINTS_ANSWER'         => 'Nombre de BBPoints pour le message "Meilleure réponse"',
	'BBPOINTS_ANSWER_EXPLAIN' => 'Définissez le nombre de BBpoints à créditer à l’auteur du message lorsque son message dans ce forum est marqué comme "Meilleure réponse"',

	'ENABLE_ANSWER'         => 'Activer les réponses les plus pertinentes',
	'ENABLE_ANSWER_EXPLAIN' => 'Permet aux auteurs de sujets et aux modérateurs de mettre en avant un message comme étant la réponse la plus pertinente de son sujet.',
	'EXTENSION_NOT_ENABLED' => 'L’extension « Meilleure réponse » n’est pas activée sur ce forum.',

	'LOG_MARK_ANSWER'   => '<strong>Mise en avant effectuée d’un message, comme étant la réponse la plus pertinente de son sujet</strong><br />» %1$s par %2$s',
	'LOG_UNMARK_ANSWER' => '<strong>Mise en avant annulée d’un message, comme étant la réponse la plus pertinente de son sujet</strong><br />» %1$s par %2$s',

	'LOG_BBPOINTS_MARK_ANSWER'   => '<strong>Ajout de BBPoints à l\'auteur pour la réponse la plus pertinente</strong><br />» %1$s par %2$s',
	'LOG_BBPOINTS_UNMARK_ANSWER' => '<strong>Suppression des BBPoints de l\'auteur pour la réponse la plus pertinente</strong><br />» %1$s par %2$s',

	'MARK_ANSWER'         => 'Mettre en avant ce message comme réponse la plus pertinente',
	'MARK_ANSWER_CONFIRM' => 'Confirmer la mise en avant de ce message en tant que réponse la plus pertinente de son sujet.',

	'TO_POST'          => '<i class="fa fa-eye"></i> Se rendre au message',
	'TOPIC_FIRST_POST' => 'Vous ne pouvez pas marquer cette réponse comme meilleure réponse, car il s’agit de la première réponse du sujet.',
	'TOTAL_ANSWERS'    => 'Réponses pertinentes',

	'UNMARK_ANSWER'         => 'Annuler la mise en avant de ce message comme réponse la plus pertinente',
	'UNMARK_ANSWER_CONFIRM' => 'Confirmer le retrait de la mise en avant de ce message en tant que réponse la plus pertinente de son sujet.',

	'MARK_ANSWER_NOTIFICATION'        => '%1$s a mis en avant votre message « %2$s » en tant que réponse la plus pertinente de son sujet.',
	'UNMARK_ANSWER_NOTIFICATION'      => '%1$s a retiré la mise en avant de votre message « %2$s » comme réponse la plus pertinente de son sujet.',
	'NOTIFICATION_TYPE_MARK_ANSWER'   => 'Un membre a mis en avant votre message, en tant que réponse la plus pertinente de son sujet.',
	'NOTIFICATION_TYPE_UNMARK_ANSWER' => 'Un membre a annulée sa mise en avant pour votre message, en tant que réponse la plus pertinente de son sujet.',
]);
