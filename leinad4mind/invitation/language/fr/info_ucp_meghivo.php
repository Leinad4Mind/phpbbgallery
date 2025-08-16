<?php

/**
 *
 * Invite. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2010-2015, KillBill
 * @copyright (c) 2017, kasimi
 * @copyright (c) 2017-2018, Leinad4Mind, https://leinad4mind.top/forum
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
	'POST_CONFIRM_EXPLAIN'					=> 'Ce code prévient des tentatives automatisées de connexion de robots. Le code est dans l’image ci-dessous. Si vous ne pouvez pas lire le code en raison de problèmes visuels ou autres, veuillez contacter un %sadministrateur du forum%s.',

	'UCP_CAT_MEGHIVO'						=> 'phpBB Invite',
	'UCP_MEGHIVO'							=> 'Invitation',
	'UCP_MEGHIVO_ADAT'						=> 'Détails des invitations',
	'UCP_MEGHIVO_BACK'						=> '<br /><br />%sRetour au Profil%s',
	'UCP_MEGHIVO_DAYF'						=> 'Invitations envoyées aujourd’hui',
	'UCP_MEGHIVO_DAYF_EXPLAIN'				=> 'C’est le nombre d’invitations que vous avez envoyées aujourd’hui.',
	'UCP_MEGHIVO_DAY_OFF'					=> 'Nous ne sommes plus en mesure d’envoyer des invitations pour aujourd’hui!',
	'UCP_MEGHIVO_DB'						=> '<b>%s invitation(s).</b>',
	'UCP_MEGHIVO_DB_KULDES'					=> 'Limite quotidienne d’invitations',
	'UCP_MEGHIVO_DB_KULDES_EXPLAIN'			=> 'C’est le nombre maximum d’invitations que vous pouvez envoyer par jour.',
	'UCP_MEGHIVO_DB_MAX'					=> '<span class="meghivo_tred">Illimitées !</span>',
	'UCP_MEGHIVO_DB_PENDING'				=> 'Invitations en attente',
	'UCP_MEGHIVO_DB_PENDING_EXPLAIN'		=> 'C’est le nombre d’utilisateurs que vous avez invités et qui ne se sont pas encore enregistrés.',
	'UCP_MEGHIVO_DB_SZAM'					=> 'Nombre d’invitations',
	'UCP_MEGHIVO_DB_SZAM_EXPLAIN'			=> 'C’est la quantité restante d’invitations disponibles.',
	'UCP_MEGHIVO_DB_USER'					=> 'Utilisateurs invités',
	'UCP_MEGHIVO_DB_USERS'					=> 'Utilisateurs invités',
	'UCP_MEGHIVO_DB_USERS_EXPLAIN'			=> 'C’est le nombre de membres que vous avez invités.',
	'UCP_MEGHIVO_DB_USER_EXPLAIN'			=> 'C’est le nombre de membres que vous avez invités.',
	'UCP_MEGHIVO_DELETE'					=> 'Annuler des invitations',
	'UCP_MEGHIVO_DELETE_EXPLAIN'			=> 'Si vous avez envoyé des invitations à des mauvaises adresses, vous pouvez annuler ces invitations ici.<br /><em>On ne peut effectuer cette action que dans les %s minutes qui suivent une invitation.</em>',
	'UCP_MEGHIVO_DELETE_NO_CONFIRM'			=> 'La suppression n’a pas été confirmée!',
	'UCP_MEGHIVO_DELETE_SUCCES'				=> 'L’invitation a été supprimée avec succès.',
	'UCP_MEGHIVO_DISABLED'					=> '%sLe Système des Invitations est désactivé !%s',
	'UCP_MEGHIVO_DUP'						=> 'Il a déjà été envoyé une invitation à cette adresse e-mail. -> %s',
	'UCP_MEGHIVO_EDUP'						=> 'Adresse e-mail sollicitée à plusieurs reprises. -> %s',
	'UCP_MEGHIVO_EMAILS_SENT'				=> 'Les invitations ont été envoyées avec succès !',
	'UCP_MEGHIVO_EMAIL_LANG'				=> 'Langue de l’e-mail',
	'UCP_MEGHIVO_EMAIL_KERES_EXPLAIN'		=> 'Motif pour les demandes d’invitations.',
	'UCP_MEGHIVO_EMAIL_SELECT'				=> 'Sélection de l’invitation',
	'UCP_MEGHIVO_EMAIL_SELECT_EXPLAIN'		=> 'Choisir quel destinataire vous voulez supprimer.',
	'UCP_MEGHIVO_EMAIL_SENT'				=> 'L’invitation a été envoyée avec succès!',
	'UCP_MEGHIVO_FLOOD_LIMIT'				=> 'Vous ne pouvez plus envoyer d’invitations. Veuillez réessayer ultérieurement.',
	'UCP_MEGHIVO_FRIEND'					=> 'Ajouter en ami',
	'UCP_MEGHIVO_FRIEND_EXPLAIN'			=> 'L’utilisateur invité sera ajouté à votre liste d’amis.',
	'UCP_MEGHIVO_FUG_LIMIT'					=> 'Seulement %s invitations peuvent être envoyées aujourd’hui. Cependant %s destinataires sont répertoriés.',
	'UCP_MEGHIVO_KERES'						=> 'Demander des invitations',
	'UCP_MEGHIVO_KERES_BUYS_SUCCES'			=> 'Vous avez acheté des invitations avec succès.',
	'UCP_MEGHIVO_KERES_BUY_MIN'				=> 'Il faut acheter au minimum (1) invitation !',
	'UCP_MEGHIVO_KERES_BUY_NO'				=> 'Vous n’avez pas assez de %s pour acheter cette quantité d’invitations! Vous disposez actuellement de %s %s.',
	'UCP_MEGHIVO_KERES_BUY_SUBMIT'			=> 'Acheter',
	'UCP_MEGHIVO_KERES_BUY_SUBT'			=> 'Invitations que vous voulez acheter',
	'UCP_MEGHIVO_KERES_BUY_SUBT_EXPLAIN'	=> 'Saisir le nombre d’invitations que vous voulez acheter. Le prix d’une invitation est de <b>%s %s</b>.<br />Vous engagez votre responsabilité par rapport aux utilisateurs que vous invitez, Lsi ces utilisateurs invités créent des incidents.',
	'UCP_MEGHIVO_KERES_BUY_SUCCES'			=> 'L’invitation a été achetée avec succès.',
	'UCP_MEGHIVO_KERES_BUY_TITLE'			=> 'Acheter une invitation.',
	'UCP_MEGHIVO_KERES_DISABLED'			=> 'La procédure de demande est désactivée!',
	'UCP_MEGHIVO_KERES_MAX'					=> 'Nombre maximum de demandes: (%s) invitation(s)!',
	'UCP_MEGHIVO_KERES_MESSAGE_NO_DB'		=> '<em>Non! Ce n’était pas nécessaire.</em>',
	'UCP_MEGHIVO_KERES_MIN'					=> 'Nombre minimum de demandes d’invitations: (1)',
	'UCP_MEGHIVO_KERES_NO_MES'				=> 'Vous n’avez pas écrit de message! Sans une explication, vous ne pouvez demander autant d’invitations.',
	'UCP_MEGHIVO_KERES_OFF'					=> 'Votre demande d’invitation est en attente. Quand un administrateur/modérateur aura évalué votre demande, vous recevrez un message personnel.',
	'UCP_MEGHIVO_KERES_SOK_EXPLAIN'			=> 'Quand on envoie plus de <b>(%s)</b> demandes, une clarification à l’admin est nécessaire. Veuillez expliquer pourquoi vous avez besoin d’autant d’invitations.<br />Si nous pensons que votre requète est acceptable, nous vous donnerons les invitations. Si nous estimons qu’il y a abus, ce peut être une cause de bannissement de votre compte.',
	'UCP_MEGHIVO_KERES_SUBMIT'				=> 'Envoyer demande',
	'UCP_MEGHIVO_KERES_SUCC'				=> 'La demande d’invitation a été envoyée avec succès!',
	'UCP_MEGHIVO_KERES_SUCCS'				=> 'Les demandes d’invitation ont été envoyées avec succès!',
	'UCP_MEGHIVO_KERES_TITLE'				=> 'Invitations souhaitées',
	'UCP_MEGHIVO_KERES_TITLE_EXPLAIN'		=> 'Entrer le nombre d’invitations que vous voulez demander. Il y a un maximum de <b>(%s)</b> invitation(s) disponible(s).<br />Vous êtes tenu pour responsable des utilisateurs que vous invitez et qui auraient un comportement inapproprié.',
	'UCP_MEGHIVO_KULDES'					=> 'Envoyer une invitation',
	'UCP_MEGHIVO_KULDES_EMAIL_MAX'			=> 'Un maximum de %s adresses e-mail peuvent être utilisées et vous en avez cependant listées %s!',
	'UCP_MEGHIVO_KULDES_MAX'				=> '<span class="meghivo_tred">Il n’y a actuellement aucune limite!</span>',
	'UCP_MEGHIVO_LAST_ACTIVE'				=> 'Dernière active',
	'UCP_MEGHIVO_MAX_ERROR'					=> 'Actuellement vous disposez d’invitations illimitées.',
	'UCP_MEGHIVO_MAX_RECIPIENTS'			=> 'Saisir toutes les adresses sur une nouvelle ligne!<br />Nombre maximal de destinataires',
	'UCP_MEGHIVO_MESSAGE_BODY_EXPLAIN'		=> 'Ecrire quelques lignes pour expliquer pourquoi la personne pourrait nous rejoindre.',
	'UCP_MEGHIVO_NOT_DELETED_INVITE'		=> 'Il n’y a aucune invitation à supprimer !',
	'UCP_MEGHIVO_NOT_LANGUAGE'				=> 'Fichier langue qui n’est pas présent: %s',
	'UCP_MEGHIVO_NO_EMAIL'					=> 'Vous n’avez pas donné d’adresse e-mail!',
	'UCP_MEGHIVO_NO_INVITE_USERS'			=> 'Vous n’avez encore invité personne, ou bien les personnes concernées ne se sont pas encore enregistrées.',
	'UCP_MEGHIVO_NO_LOGIN'					=> 'Il/Elle n’est pas enregistré(e) sur ce site.',
	'UCP_MEGHIVO_NO_PERM'					=> 'Vous n’êtes pas autorisé à envoyer des invitations!',
	'UCP_MEGHIVO_NO_PERM_EMAIL'				=> 'Vous n’êtes pas autorisé à envoyer des e-mails!',
	'UCP_MEGHIVO_NO_REG'					=> 'Vous n’avez encore invité personne.',
	'UCP_MEGHIVO_NULL'						=> 'Vous n’avez aucune invitation! <em>Pourquoi pas en acheter ?</em>',
	'UCP_MEGHIVO_POINTS_AMOUNT'				=> 'Cadeau',
	'UCP_MEGHIVO_POINTS_AMOUNT_EXPLAIN'		=> 'C’est le montant de points que l’utilisateur recevra en cadeau pour avoir invité quelqu’un si la personne invitée s’enregistre sur le forum.',
	'UCP_MEGHIVO_POINTS_COST'				=> 'Coût de l’invitation',
	'UCP_MEGHIVO_POINTS_COST_EXPLAIN'		=> 'C’est le tarif pour l’Envoi d’une Invitation.',
	'UCP_MEGHIVO_POST_LIMIT'				=> 'Vous devez avoir un minimum de %s post(s) pour pouvoir envoyer des invitations!',
	'UCP_MEGHIVO_REQUEST_SUBJECT'			=> 'Demande d’Invitation',
	'UCP_MEGHIVO_SDB'						=> 'invitation(s).',
	'UCP_MEGHIVO_SEND_OFF'					=> 'L’envoi d’invitations est actuellement désactivé!',
	'UCP_MEGHIVO_SEND_SUBMIT'				=> 'Envoyer invitation',
	'UCP_MEGHIVO_TIME_END'					=> 'Période d’expiration',
	'UCP_MEGHIVO_TIME_END_EXPLAIN'			=> 'L’utilisateur invité doit s’enregister pendant cette période de temps.',
	'UCP_MEGHIVO_USER'						=> 'Utilisateurs invités',
	'UCP_MEGHIVO_USERS_COUNT'				=> 'Utilisateurs invités (%s)',
	'UCP_MEGHIVO_USER_OK'					=> 'Invitation acceptée',
	'UCP_MEGHIVO_UT_REG'					=> 'Dernier utilisateur',
	'UCP_MEGHIVO_UT_REG_EXPLAIN'			=> 'Dernier utilisateur bénéficiaire de vos invitations.',
	'UCP_MEGHIVO_UT_REG_INFO'				=> '<b>%s</b> enregistré %s',

	'WEEKS'									=> 'Semaines',

	'NOTIFICATION_TYPE_INVITE_BIRTHDAY'		=> 'You receive invitations for your birthday',
	'NOTIFICATION_TYPE_INVITE_GIFT'			=> 'You receive invitations after you successfully invited a user',
	'NOTIFICATION_TYPE_INVITE_PETITION'		=> 'You receive an invitation request',
	'NOTIFICATION_TYPE_INVITE_PETITION_REQUEST' => 'You receive an invitation request',
	'NOTIFICATION_TYPE_INVITE_JOIN'			=> 'A user you invited has registered an account',
));
