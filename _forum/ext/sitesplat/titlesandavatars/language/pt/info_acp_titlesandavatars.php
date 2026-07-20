<?php

/**
 * BBAvatars
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'TAT'                      => 'BBAvatars',
	'TAT_SHOW_AVATARS'         => 'Mostrar Avatares na Lista de fóruns',
	'TAT_SHOW_AVATARS_EXPLAIN' => 'Apresentar Avatar do último publicador, do primeiro publicador ou de ambos',
	'TAT_SHOW_AVATARS_ML'      => 'Mostrar Avatares na Lista de membros',
	'TAT_SHOW_AVATARS_PP'      => 'Mostrar Avatares dos Contribuintes no Tópico',
	'TAT_SHOW_AVATARS_OL'      => 'Mostrar Avatares na lista de Utilizadores Online',

	'TAT_BOTH'  => 'Mostrar ambos os Avatares',
	'TAT_FIRST' => 'Mostrar apenas o Avatar do primeiro a publicar (autor)',
	'TAT_LAST'  => 'Mostrar apenas o Avatar do último a publicar',

	'TAT_AVATAR_FIRST' => 'Primeiro a publicar:',
	'TAT_AVATAR_LAST'  => 'Último a publicar:',

	'SS_HELPER_NOTY'   => 'O SiteSplat BBcore não existe!<br />Faça o download do <a href="https://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
	'BBAVATARS_NOTICE' => '<div class="phpinfo"><p>A configuração para esta extensão encontra-se em <strong>%1$s &#187; %2$s &#187; %3$s.</strong></p></div>',

]);
