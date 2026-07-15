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
	'DISC_ENC_QL_TTL'				=> 'Cria uma conta ou inicia sessão para participares na discussão',
	'DISC_ENC_QL_NO_SGNUP_TTL'		=> 'Entra na tua conta e participa com outros malucos como tu!',
	'DISC_ENC_QL_INF'				=> 'Precisas de ter conta para responder',

	'DISC_ENC_QL_SGN_UP_TTL'		=> 'Criar uma conta',
	'DISC_ENC_QL_SGN_UP_INF'		=> 'Não és membro ainda? Regista-te e une-te à melhor comunidade portuguesa de animação',
	'DISC_ENC_QL_SGN_UP_TPCS_INF'	=> 'Os membros podem criar os seus próprios tópicos e seguir tópicos de outros',
	'DISC_ENC_QL_SGN_UP_FREE_INF'	=> 'Não tem custos e demora menos de um minuto',

	'DISC_ENC_QL_SGN_IN_TTL'		=> 'Entrar na conta',
));
