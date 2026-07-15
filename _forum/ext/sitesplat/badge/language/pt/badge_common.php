<?php
/**
*
* Badge Award extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
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

$lang = array_merge($lang, array(
	'BADGE_MANAGE'			    => 'Emblemas',
	'BADGE_MANAGE_EXPLAIN'	    => 'Todos os Emblemas',
	'BADGE_RECENT'			    => 'Emblemas Recentes',
	'BADGE_USER'			    => 'Emblemas dos Utilizadores',
	'BADGE_INTRO_TITLE'		    => 'Emblemas! Vou apanhá-los a todos!',
	'BADGE_INTRO_TEASER_BODY'	=> 'Seja por teres ganho um passatempo, por teres ajudado a comunidade, ou por apenas comentares, estamos aqui para celebrar todos os teus feitos e contribuições na nossa comunidade.',
	'BADGE_INTRO'	            => 'Seja por teres ganho um passatempo, por teres ajudado a comunidade, ou por apenas comentares, estamos aqui para celebrar todos os teus feitos e contribuições na nossa comunidade.',
	'BADGE_AWARDS_TOPIC'	    => 'Emblemas',
	'BADGE_WALL_TITLE'	        => 'O meu mural de emblemas',
	
	'UCP_BADGE_TITLE'		    => 'Emblemas Ganhos',
	'UCP_BADGE_EXPLAIN'		    => 'Todos os emblemas que ganhaste',

	// Conditions
	'BADGE_TYPE_AVATAR'			=> 'Avatar',
	'BADGE_TYPE_BADGES'			=> 'Emblemas Oferecidos',
	'BADGE_TYPE_BIRTHDAYS'		=> 'Aniversários',
	'BADGE_TYPE_CUSTOM'			=> 'Especiais',
	'BADGE_TYPE_DONATIONS'		=> 'Donativos',
	'BADGE_TYPE_LIKEDD'			=> 'Agradecimentos',
	'BADGE_TYPE_MEMBERSHIP'		=> 'Dias de Registo',
	'BADGE_TYPE_POSTS'			=> 'Mensagens',
	'BADGE_TYPE_PROFILEWALL'	=> 'Mural do Perfil',
	'BADGE_TYPE_SIGNATURE'		=> 'Assinatura',
	'BADGE_TYPE_WARNINGS'		=> 'Avisos',
	'BADGE_TYPE_ZEBRA_FOES'		=> 'Inimigos',
	'BADGE_TYPE_ZEBRA_FRIENDS'	=> 'Amigos',

	'BADGE_USED'				=> 'usado',
	'BADGE_BETWEEN'				=> 'entre',
	'BADGE_AND'					=> 'e',
	'BADGE_MORE'				=> 'igual ou maior que',
	'MORE_BADGES'				=> '<a class="badge-more" href="%1$s"><span class="hidden-xs">&#43;%2$s mais</span><i class="visible-xs-inline-block fa fa-plus-circle"></i></a>',

	// Notifications
	'BADGE_NOTIFICATION_EVENT_ADDED'	=> '<strong>Actualização</strong>:<br />Ganhaste um novo emblema: %1$s.',
	'BADGE_NOTIFICATION_EVENT_REMOVED'	=> '<strong>Actualização</strong>:<br />Perdeste o emblema %1$s.',
	'BADGE_WHOHOO'	                    => 'Whoohoo!!! Ganhaste um novo emblema, parabéns!<hr><strong>Acabaste de desbloquear um novo emblema</strong>, vai à tua <a href="%1$s">página de emblemas</a> para veres todos os que já tens!',
	
	'NOTIFICATION_TYPE_AWARD_ADDED'	    => 'Quando um Emblema é ganho',
	'NOTIFICATION_TYPE_AWARD_REMOVED'	=> 'Quando um Emblema é perdido',
	
	// Misc
	'BADGE_LINK_AD'	                    => 'Emblemas por Leinad4Mind',
	'BADGE_LINK_AD_TITLE'	            => 'GoldTugAnime',
));
