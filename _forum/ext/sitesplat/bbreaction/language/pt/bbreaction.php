<?php

/**
 *
 * BBReaction
 * @copyright (c) 2015-2022 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

/**
 * DO NOT CHANGE
 */
if (!defined('IN_PHPBB')) {
	exit;
}

if (empty($lang) || !is_array($lang)) {
	$lang = [];
}

$lang = array_merge($lang, [
	'BBREACTION'						 => 'Reações',
	'BBREACTION_TOP_LIST'			 => 'Top Reações',
	'BBREACTION_OTHERS'				 => 'Outros?',
	'BBREACTION_REACT'				 => 'Reage!',

	'BBREACTION_WHAT'					 => 'Qual é a tua reação?',
	'BBREACTION_MODE_ERROR'			 => 'Modo não existe',
	'BBREACTION_POST_ERROR'			 => 'Mensagem não existe',
	'BBREACTION_POST_NO_AUTH'		 => 'Não tens permissões para reagir a esta mensagem.',
	'BBREACTION_OWN_POST_ERROR'		 => 'Não podes reagir à tua própria mensagem.',
	'BBREACTION_TIME_ERROR'			 => 'Não podes reagir a uma mensagem assim tão rápido!',
	'BBREACTION_REMOVED'				 => 'A tua reação foi removida',
	'REMOVED'							 => 'removida',
	'BBREACTION_ADDED'				 => 'A tua reação foi adicionada',
	'ADDED'								 => 'adicionada',
	'INFOMSG'							 => 'Atenção!',

	'REACTIONS_POSITIVE'				 => 'Reações positivas',
	'REACTIONS_NEGATIVE'				 => 'Reações negativas',

	'REACTIONS_OVERVIEW_FORUM'		 => 'Visão Geral do Fórum',
	'REACTIONS_OVERVIEW_TOPIC'		 => 'Visão Geral do Tópico',
	'REACTIONS_OVERVIEW_POSTS'		 => 'Visão Geral da Mensagem',
	'REACTIONS_OVERVIEW_USER'		 => 'Visão Geral do Utilizador',

	'BBREACTION_GIVEN'				 => 'Dados',
	'BBREACTION_RECEIVED'			 => 'Recebidos',
	'BBREACTION_NO_RECORDS'			 => 'Nenhuma reação até ao momento',
	'UCP_BBREACTION_EXPLAIN'		 => 'Visão geral de reações dadas e recebidas',
	'ACL_U_BBREACTION'				 => 'Pode usar Reações',
	'ACL_U_BBREACTION_MODULE'		 => 'Pode usar Reações no UCP e na página Top Reações',

	'NOTIFICATION_TYPE_BBREACTIONS_ADD'	 => 'Alguém reagiu à tua mensagem',

	'BBREACTION_NOTI_EVENT_ADDED'	 => '<strong>Atualização Reações</strong>:<br />Uma reação foi %1$s a uma mensagem tua por %2$s.',
]);