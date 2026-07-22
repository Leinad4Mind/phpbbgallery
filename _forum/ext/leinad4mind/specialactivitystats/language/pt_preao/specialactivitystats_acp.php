<?php

/**
 * Special Activity Stats. An extension for the phpBB Forum Software package.
 * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
	$lang = [];
}

$lang = array_merge($lang, [
	'SPECIAL_ACTIVITY_STATS_INSTALLED'             => 'Versão Instalada: v%s',
	'SPECIAL_ACTIVITY_STATS_TITLE'                 => 'Estatísticas de Actividade',
	'SPECIAL_ACTIVITY_STATS_DISP_SET'              => 'Configurações de visualização',
	'SPECIAL_ACTIVITY_STATS_OTHER'                 => 'Outras configurações',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_TOPICS'       => 'Mostrar novos tópicos',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_TOPICS_EXP'   => 'Mostra a contagem de novos tópicos',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_POSTS'        => 'Mostrar novas mensagens',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_POSTS_EXP'    => 'Mostra a contagem de novas mensagens',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_USERS'        => 'Mostrar novos utilizadores',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_USERS_EXP'    => 'Mostra a contagem de novos utilizadores',
	'SPECIAL_ACTIVITY_STATS_DISP_BOTS'             => 'Mostrar bots',
	'SPECIAL_ACTIVITY_STATS_DISP_BOTS_EXP'         => 'Alguns utilizadores podem perguntar o que são bots e receá-los.',
	'SPECIAL_ACTIVITY_STATS_DISP_GUESTS'           => 'Mostrar visitantes',
	'SPECIAL_ACTIVITY_STATS_DISP_GUESTS_EXP'       => 'Mostrar visitantes no contador?',
	'SPECIAL_ACTIVITY_STATS_DISP_HIDDEN'           => 'Mostrar utilizadores ocultos',
	'SPECIAL_ACTIVITY_STATS_DISP_HIDDEN_EXP'       => 'Devem os utilizadores ocultos ser mostrados na lista? (permissão necessária)',
	'SPECIAL_ACTIVITY_STATS_DISP_TIME'             => 'Mostrar tempo',
	'SPECIAL_ACTIVITY_STATS_DISP_TIME_EXP'         => 'Todos os utilizadores veem ou nenhum. Nenhuma função especial para Administradores.',
	'SPECIAL_ACTIVITY_STATS_DISP_TIME_FORMAT'      => 'Formato da hora',
	'SPECIAL_ACTIVITY_STATS_DISP_HOVER'            => 'Mostrar ao passar o rato (hover)',
	'SPECIAL_ACTIVITY_STATS_DISP_IP'               => 'Mostrar ip do utilizador',
	'SPECIAL_ACTIVITY_STATS_DISP_IP_EXP'           => 'Apenas para utilizadores com permissões administrativas, como no viewonline.php',
	'SPECIAL_ACTIVITY_STATS_RECORD'                => 'Recorde',
	'SPECIAL_ACTIVITY_STATS_RECORD_EXP'            => 'Mostrar e guardar recorde',
	'SPECIAL_ACTIVITY_STATS_RECORD_TIMEFORMAT'     => 'Formato de data para o recorde',
	'SPECIAL_ACTIVITY_STATS_RESET'                 => 'Reiniciar recorde',
	'SPECIAL_ACTIVITY_STATS_RESET_EXP'             => 'Reinicia o tempo e contador do recorde das Estatísticas de Actividade.',
	'SPECIAL_ACTIVITY_STATS_RESET_TRUE'            => 'Se enviares este formulário, o recorde será reiniciado.',
	'SPECIAL_ACTIVITY_STATS_SETTINGS_SAVED'        => 'Configuração actualizada com sucesso.',
	'SPECIAL_ACTIVITY_STATS_SORT_BY'               => 'Ordenar utilizadores por',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_EXP'           => 'Por qual ordem o utilizador deve ser apresentado?',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_0'             => 'Nome de utilizador A -> Z',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_1'             => 'Nome de utilizador Z -> A',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_2'             => 'Tempo de visita ascendente',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_3'             => 'Tempo de visita descendente',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_4'             => 'ID do utilizador ascendente',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_5'             => 'ID do utilizador descendente',
	'SPECIAL_ACTIVITY_STATS_CACHE_TIME'            => 'Tempo de cache (segundos)',
	'SPECIAL_ACTIVITY_STATS_CACHE_TIME_EXP'        => 'Duração na qual os dados não são re-calculados (melhora o desempenho)',
	'SPECIAL_ACTIVITY_STATS_CHECK_PERMISSIONS'     => 'Verificar permissões',
	'SPECIAL_ACTIVITY_STATS_CHECK_PERMISSIONS_EXP' => 'não=todos devem ver as estatísticas (ignora configurações de permissão); sim=usar permissões configuradas (ex: permitir apenas para utilizadores registados: ACP->permissões->permissões globais -> permissões de grupo -> utilizadores registados -> Permissões avançadas -> Diversos -> "Pode ver as estatísticas de actividade")',
	'SPECIAL_ACTIVITY_STATS_MODE'                  => 'A mostrar utilizadores de ...',
	'SPECIAL_ACTIVITY_STATS_MODE_EXP'              => 'A mostrar utilizadores de hoje (desde as 00:00 no fuso do fórum), ou do período definido na próxima opção.',
	'SPECIAL_ACTIVITY_STATS_MODE_TODAY'            => 'Hoje',
	'SPECIAL_ACTIVITY_STATS_MODE_PERIOD'           => 'Período de tempo',
	'SPECIAL_ACTIVITY_STATS_MODE_PERIOD_EXP'       => 'insere 0, se desejares exibir os utilizadores das últimas 24h',
	'SPECIAL_ACTIVITY_STATS_MODE_PERIOD_EXP2'      => 'desactivado, se tiveres escolhido "hoje"',
	'SPECIAL_ACTIVITY_STATS_MODE_PERIOD_EXP3'      => 'segundos',
]);
