<?php

/**
 * BBAwards AutoGroup Addon.
 * @copyright (c) 2015 SiteSplat <http://www.sitesplat.com>
 * @license SiteSplat 2015 all rights reserved
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, array(
	'BADGEAUTO_TYPE_AVATAR'			=> 'Prémio Emblema de Avatar',
	'BADGEAUTO_TYPE_BADGES'			=> 'Prémio Emblema de Emblemas',
	'BADGEAUTO_TYPE_CROSS_BADGE'	=> 'Prémio Emblema de Emblemas Cruzados',
	'BADGEAUTO_TYPE_CUSTOM'			=> 'Prémio Emblema Personalizado',
	'BADGEAUTO_TYPE_DONATIONS'		=> 'Prémio Emblema de Doações',
	'BADGEAUTO_TYPE_LIKEDD'			=> 'Prémio Emblema LikeBB',
	'BADGEAUTO_TYPE_PROFILEWALL'	=> 'Prémio Emblema de Mural de Perfil',
	'BADGEAUTO_TYPE_SIGNATURE'		=> 'Prémio Emblema de Assinatura',
	'BADGEAUTO_TYPE_TOPICS'			=> 'Prémio Emblema de Tópicos',
	'BADGEAUTO_TYPE_ZEBRA_FOES'		=> 'Prémio Emblema de Inimigos',
	'BADGEAUTO_TYPE_ZEBRA_FRIENDS'	=> 'Prémio Emblema de Amigos',

	'BADGE_AUTOGROUPS_NOTICE'		=> '<div class="phpinfo"><p>A Configuração para esta extensão encontra-se em <strong>%1$s » %2$s » %3$s</strong>.<br />Por favor note, os Tipos de Regras de Emblemas são adicionados em conjunto! Extensões como LikeBB, Donation etc não funcionarão se não estiverem instaladas.</p></div>'
));
