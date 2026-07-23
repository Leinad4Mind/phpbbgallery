<?php

/**
 * Special Activity Stats. An extension for the phpBB Forum Software package.
 * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
	'SPECIAL_ACTIVITY_STATS_TITLE'                 => 'Estatísticas de Atividade',
	'SPECIAL_ACTIVITY_STATS_DISP_SET'              => 'Configurações de visualização',
	'SPECIAL_ACTIVITY_STATS_OTHER'                 => 'Outras configurações',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_TOPICS'       => 'Mostrar novos tópicos',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_TOPICS_EXP'   => 'Mostra a contagem de novos tópicos',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_POSTS'        => 'Mostrar novas mensagens',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_POSTS_EXP'    => 'Mostra a contagem de novas mensagens',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_USERS'        => 'Mostrar novos usuários',
	'SPECIAL_ACTIVITY_STATS_DISP_NEW_USERS_EXP'    => 'Mostra a contagem de novos usuários',
	'SPECIAL_ACTIVITY_STATS_DISP_BOTS'             => 'Mostrar bots',
	'SPECIAL_ACTIVITY_STATS_DISP_BOTS_EXP'         => 'Alguns usuários podem perguntar o que são bots e temê-los.',
	'SPECIAL_ACTIVITY_STATS_DISP_GUESTS'           => 'Mostrar visitantes',
	'SPECIAL_ACTIVITY_STATS_DISP_GUESTS_EXP'       => 'Mostrar visitantes no contador?',
	'SPECIAL_ACTIVITY_STATS_DISP_HIDDEN'           => 'Mostrar usuários ocultos',
	'SPECIAL_ACTIVITY_STATS_DISP_HIDDEN_EXP'       => 'Os usuários ocultos devem ser mostrados na lista? (permissão necessária)',
	'SPECIAL_ACTIVITY_STATS_DISP_TIME'             => 'Mostrar tempo',
	'SPECIAL_ACTIVITY_STATS_DISP_TIME_EXP'         => 'Todos os usuários veem ou nenhum. Nenhuma função especial para Administradores.',
	'SPECIAL_ACTIVITY_STATS_DISP_TIME_FORMAT'      => 'Formato da hora',
	'SPECIAL_ACTIVITY_STATS_DISP_HOVER'            => 'Mostrar ao passar o mouse (hover)',
	'SPECIAL_ACTIVITY_STATS_DISP_IP'               => 'Mostrar ip do usuário',
	'SPECIAL_ACTIVITY_STATS_DISP_IP_EXP'           => 'Apenas para usuários com permissões administrativas, como no viewonline.php',
	'SPECIAL_ACTIVITY_STATS_RECORD'                => 'Recorde',
	'SPECIAL_ACTIVITY_STATS_RECORD_EXP'            => 'Mostrar e salvar recorde',
	'SPECIAL_ACTIVITY_STATS_RECORD_TIMEFORMAT'     => 'Formato de data para o recorde',
	'SPECIAL_ACTIVITY_STATS_RESET'                 => 'Reiniciar recorde',
	'SPECIAL_ACTIVITY_STATS_RESET_EXP'             => 'Reinicia o tempo e contador do recorde das Estatísticas de Atividade.',
	'SPECIAL_ACTIVITY_STATS_RESET_TRUE'            => 'Se você enviar este formulário, o recorde será reiniciado.',
	'SPECIAL_ACTIVITY_STATS_SETTINGS_SAVED'        => 'Configuração atualizada com sucesso.',
	'SPECIAL_ACTIVITY_STATS_SORT_BY'               => 'Ordenar usuários por',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_EXP'           => 'Em qual ordem o usuário deve ser exibido?',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_0'             => 'Nome de usuário A -> Z',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_1'             => 'Nome de usuário Z -> A',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_2'             => 'Tempo de visita crescente',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_3'             => 'Tempo de visita decrescente',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_4'             => 'ID do usuário crescente',
	'SPECIAL_ACTIVITY_STATS_SORT_BY_5'             => 'ID do usuário decrescente',
	'SPECIAL_ACTIVITY_STATS_CACHE_TIME'            => 'Tempo de cache (segundos)',
	'SPECIAL_ACTIVITY_STATS_CACHE_TIME_EXP'        => 'Duração na qual os dados não são recalculados (melhora o desempenho)',
	'SPECIAL_ACTIVITY_STATS_CHECK_PERMISSIONS'     => 'Verificar permissões',
	'SPECIAL_ACTIVITY_STATS_CHECK_PERMISSIONS_EXP' => 'não=todos devem ver as estatísticas (ignora configurações de permissão); sim=usar permissões configuradas (ex: permitir apenas para usuários registrados: ACP->permissões->permissões globais -> permissões de grupo -> usuários registrados -> Permissões avançadas -> Diversos -> "Pode ver as estatísticas de atividade")',
	'SPECIAL_ACTIVITY_STATS_MODE'                  => 'Exibindo usuários de ...',
	'SPECIAL_ACTIVITY_STATS_MODE_EXP'              => 'Exibindo usuários de hoje (desde as 00:00 no fuso do fórum), ou do período definido na próxima opção.',
	'SPECIAL_ACTIVITY_STATS_MODE_TODAY'            => 'Hoje',
	'SPECIAL_ACTIVITY_STATS_MODE_PERIOD'           => 'Período de tempo',
	'SPECIAL_ACTIVITY_STATS_MODE_PERIOD_EXP'       => 'digite 0, se deseja exibir os usuários das últimas 24h',
	'SPECIAL_ACTIVITY_STATS_MODE_PERIOD_EXP2'      => 'desativado, se tiver escolhido "hoje"',
	'SPECIAL_ACTIVITY_STATS_MODE_PERIOD_EXP3'      => 'segundos',
]);
