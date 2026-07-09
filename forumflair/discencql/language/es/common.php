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
	'DISC_ENC_QL_TTL'				=> 'Cree una cuenta o inicie sesión para unirse a la discusión',
	'DISC_ENC_QL_NO_SGNUP_TTL'		=> 'Regístrese para unirse a la discusión',
	'DISC_ENC_QL_INF'				=> 'Necesita ser miembro para publicar una respuesta.',

	'DISC_ENC_QL_SGN_UP_TTL'		=> 'Crear una cuenta',
	'DISC_ENC_QL_SGN_UP_INF'		=> '¿No es un miembro? regístrese para unirse a nuestra comunidad',
	'DISC_ENC_QL_SGN_UP_TPCS_INF'	=> 'Los miembros pueden iniciar sus propios temas y suscribirse a los temas',
	'DISC_ENC_QL_SGN_UP_FREE_INF'	=> 'Es gratis y solo toma un minuto',

	'DISC_ENC_QL_SGN_IN_TTL'		=> 'Registrarse',
));
