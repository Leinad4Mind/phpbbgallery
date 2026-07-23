<?php

/**
 * Badge Award extension for the phpBB Forum Software package.
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
	'BADGE_MANAGE'            => 'Medalhas',
	'BADGE_MANAGE_EXPLAIN'    => 'Vista geral de todas as medalhas ganhas',
	'BADGE_RECENT'            => 'Prémios Recentes',
	'BADGE_USER'              => 'Medalhas do Utilizador',
	'BADGE_INTRO_TITLE'       => 'Toca a ganhar medalhas, pá!',
	'BADGE_INTRO_TEASER_BODY' => 'Seja por teres ganho um passatempo, jogo, ajudado a comunidade, ou por apenas teres participado, estamos felizes por celebrar a tua contribuição para com a nossa comunidade.',
	'BADGE_INTRO'             => 'Seja por teres ganho um passatempo, jogo, ajudado a comunidade, ou por apenas teres participado, estamos felizes por celebrar a tua contribuição para com a nossa comunidade.',
	'BADGE_AWARDS_TOPIC'      => 'Prémio',
	'BADGE_WALL_TITLE'        => 'O meu mural de medalhas',

	'UCP_BADGE_TITLE'   => 'Medalhas',
	'UCP_BADGE_EXPLAIN' => 'Vista geral de todas as minhas medalhas',

	// Conditions
	'BADGE_TYPE_AVATAR'        => 'Avatar',
	'BADGE_TYPE_BADGES'        => 'Medalhas Ganhas',
	'BADGE_TYPE_BIRTHDAYS'     => 'Idade do Utilizador',
	'BADGE_TYPE_CUSTOM'        => 'Especial',
	'BADGE_TYPE_DONATIONS'     => 'Donativos',
	'BADGE_TYPE_LIKEDD'        => 'Gostos',
	'BADGE_TYPE_MEMBERSHIP'    => 'Dias de Registo',
	'BADGE_TYPE_POSTS'         => 'Mensagens',
	'BADGE_TYPE_PROFILEWALL'   => 'Mural de Perfil',
	'BADGE_TYPE_SIGNATURE'     => 'Assinatura',
	'BADGE_TYPE_WARNINGS'      => 'Avisos',
	'BADGE_TYPE_ZEBRA_FOES'    => 'Inimigos',
	'BADGE_TYPE_ZEBRA_FRIENDS' => 'Amigos',
	'BADGE_TYPE_RADAR'         => 'Radar',

	'BADGE_USED'    => 'usado',
	'BADGE_BETWEEN' => 'entre',
	'BADGE_AND'     => 'e',
	'BADGE_MORE'    => 'igual ou maior que',
	'MORE_BADGES'   => '<a class="badge-more" href="%1$s"><span class="hidden-xs">&#43;%2$s mais</span><i class="visible-xs-inline-block fa fa-plus-circle"></i></a>',

	// Notifications
	'BADGE_NOTIFICATION_EVENT_ADDED'   => '<strong>Ganhaste uma nova medalha!</strong><br />uma nova medalha %1$s foi adicionada ao teu mural.',
	'BADGE_NOTIFICATION_EVENT_REMOVED' => '<strong>Perdeste uma medalha</strong>:<br />Uma medalha %1$s foi removida do teu mural.',
	'BADGE_WHOHOO'                     => 'Yatta!!! Ganhaste uma nova medalha, parabéns!<hr><strong>Desbloqueaste uma nova medalha</strong>, vai à <a href="%1$s">tua página de medalhas</a> para veres todas as que tens!',

	'NOTIFICATION_TYPE_AWARD_ADDED'   => 'Quando uma Medalha é adicionada',
	'NOTIFICATION_TYPE_AWARD_REMOVED' => 'Quando uma Medalha é removida',

	// Misc
	'BADGE_LINK_AD'       => 'Prémios GoldTugAnime',
	'BADGE_LINK_AD_TITLE' => 'Estás pronto para ser um campeão?!',
]);
