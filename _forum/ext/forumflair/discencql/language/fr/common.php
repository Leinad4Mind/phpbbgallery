<?php

/*
* @package phpBB Extension - Discussion Encouragement With Quick Login
* @copyright (c) 2022, ForumFlair, https://forumflair.co.uk
* @license GNU General Public License, version 2 (GPL-2.0)
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
	'DISC_ENC_QL_TTL'				=> 'Créer un compte ou se connecter pour rejoindre la discussion',
	'DISC_ENC_QL_NO_SGNUP_TTL'		=> 'Connectez-vous pour rejoindre la discussion',
	'DISC_ENC_QL_INF'				=> 'Vous devez être membre pour pouvoir répondre',

	'DISC_ENC_QL_SGN_UP_TTL'		=> 'Créer un compte',
	'DISC_ENC_QL_SGN_UP_INF'		=> 'Vous n‘êtes pas membre ? Inscrivez-vous pour rejoindre notre communauté',
	'DISC_ENC_QL_SGN_UP_TPCS_INF'	=> 'Les membres peuvent créer leurs propres sujets et s‘abonner à des sujets',
	'DISC_ENC_QL_SGN_UP_FREE_INF'	=> 'C‘est gratuit et cela ne prend qu‘une minute',

	'DISC_ENC_QL_SGN_IN_TTL'		=> 'Se connecter',
));
