<?php
/**
*
* @package BBSidebar
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
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

$lang = array_merge($lang, array(
	'ACP_SIDEBAR_SLOTS'	=> 'Sidebar',
	'NEWEST_TOPICS'		=> 'Últimas Mensagens',
	'NO_TOPIC_EXIST'	=> 'Não existe tópicos',
	'TOP_POSTERS'		=> 'Utilizadores + Activos',
	'NEWEST_USERS'		=> 'Utilizadores + Recentes',
	'IN'                => 'Em',
    'BBPOINTS_TRANSFER' => 'Transferir Pontos',

	'SIDEBAR_ALL_TIME'	=> 'Sempre',
	'SIDEBAR_DAILY'		=> 'Diário',
	'SIDEBAR_WEEKLY'	=> 'Semanal',
	
	'BORN'				=> 'Nascido',
	'NEW_DOWNLOADS'		=> 'Mais Recente',
	'POP_DOWNLOADS'		=> 'Popular',

	'CALENDAR'			=> 'Calendário',
	'CLOCK'				=> 'Tempo',
	'LIKEDD'			=> 'Últimos Agradecimentos',
	
	'LAST_BADGES'		=> 'Últimas Medalhas',
	'SIDEBAR_BADGE'		=> 'Título da Medalha',
	'SIDEBAR_DATE'		=> 'Data',
	'LAST_BBREACTIONS'	=> 'Últimas Reacções',
	'SIDEBAR_REACTION'	=> 'Tipo de Reacção',
	//'BBPOINTS'		=> 'Points',
	'POLL'				=> 'Última Votação',
	'NEWSLETTER'		=> 'Newsletter',
	'SIGN_IN_NEWS'		=> 'Subscreve a nossa newsletter',
	'SUBSCRIBE_BTN'		=> 'Subscrever',
	'DOWNLOADS'			=> 'Downloads',
	
	'INFOMSG'			=> 'Informação',
	'VOTE_NOT_POSIIBLE'	=> 'Alteração de votos não é possível',
	'VOTE_SAVED'		=> 'O teu voto foi guardado',
	'VOTE_CHANGED'		=> 'O teu voto foi alterado',
	'NOT_FOUND'			=> 'Votação não encontrada',
	
	'STAFF'				=> 'Staff online',
	'UNKNOWN'			=> 'Desconhecido',
	
	'RECEIVED_BY'		=> 'Recebido Por',
	
	'DONATIONS'			=> 'Donativos',
	'DONATE_ALSO'		=> 'Também queres ajudar?<br>Assim é que é!',
	'MEMBERSHIPS'		=> 'Memberships',
	'MEMBERSHIPS_CTA'	=> 'Got your Membership package yet?',
	'HOT_TOPICS'		=> 'Tópicos + Activos'
));