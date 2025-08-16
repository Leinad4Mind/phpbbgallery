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
	'DISC_ENC_QL_TTL'				=> 'Maak een account aan of log in om deel te nemen aan de discussie',
	'DISC_ENC_QL_NO_SGNUP_TTL'		=> 'Log in om deel te nemen aan de discussie',
	'DISC_ENC_QL_INF'				=> 'Je moet lid zijn om een ​​reactie te kunnen plaatsen',

	'DISC_ENC_QL_SGN_UP_TTL'		=> 'Maak een account aan',
	'DISC_ENC_QL_SGN_UP_INF'		=> 'Geen lid? Registreer om lid te worden van onze community',
	'DISC_ENC_QL_SGN_UP_TPCS_INF'	=> 'Leden kunnen hun eigen onderwerpen starten en zich abonneren op onderwerpen',
	'DISC_ENC_QL_SGN_UP_FREE_INF'	=> 'Het is gratis en duurt maar een minuut',

	'DISC_ENC_QL_SGN_IN_TTL'		=> 'Log in',
));
