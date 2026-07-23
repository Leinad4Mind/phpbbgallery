<?php

/**
 * @package BBSidebar for phpBB.
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
	'ACP_SIDEBAR_SLOTS' => 'Barra lateral',
	'NEWEST_TOPICS'     => 'Mensagens mais recentes',
	'NO_TOPIC_EXIST'    => 'Não existem mensagens para visualização',
	'TOP_POSTERS'       => 'Utilizadores activos de topo',
	'NEWEST_USERS'      => 'Utilizadores mais recentes',
	'IN'                => 'Em',
	'BBPOINTS_TRANSFER' => 'Transferir pontos',

	'SIDEBAR_ALL_TIME' => 'De Todos os Tempos',
	'SIDEBAR_DAILY'    => 'Diariamente',
	'SIDEBAR_WEEKLY'   => 'Semanalmente',

	'BORN'          => 'Nasceu a',
	'NEW_DOWNLOADS' => 'Mais recentes',
	'POP_DOWNLOADS' => 'Mais populares',

	'CALENDAR' => 'Calendário',
	'CLOCK'    => 'Tempo',
	'LIKEDD'   => 'Últimos gostos',

	'LAST_BADGES'      => 'Últimos emblemas',
	'SIDEBAR_BADGE'    => 'Nome do emblema',
	'SIDEBAR_DATE'     => 'Data',
	'LAST_BBREACTIONS' => 'Últimas reacções',
	'SIDEBAR_REACTION' => 'Tipo de reação',
	'BBPOINTS'         => 'BBpoints',
	'POLL'             => 'Última votação',
	'NEWSLETTER'       => 'Newsletter',
	'SIGN_IN_NEWS'     => 'Inscreve-te na nossa newsletter',
	'SUBSCRIBE_BTN'    => 'Subscrever',
	'DOWNLOADS'        => 'Downloads',
	'UNREAD'           => 'não lidas',

	'INFOMSG'           => 'Informação',
	'VOTE_NOT_POSIIBLE' => 'Mudança de votos não é possível',
	'VOTE_SAVED'        => 'O teu voto está guardado',
	'VOTE_CHANGED'      => 'O teu voto foi alterado',
	'NOT_FOUND'         => 'A tua votação não foi encontrada',

	'STAFF'         => 'Equipa (Staff) online',
	'STAFF_UNKNOWN' => 'N/D',

	'DONATIONS'       => 'Doações',
	'DONATE_ALSO'     => 'Pronto para doar? Incrível! Aqui tens.',
	'MEMBERSHIPS'     => 'Assinaturas (Membros VIP)',
	'MEMBERSHIPS_CTA' => 'Já tens o teu pacote de Assinatura?',
	'HOT_TOPICS'      => 'Tópicos populares'
]);
