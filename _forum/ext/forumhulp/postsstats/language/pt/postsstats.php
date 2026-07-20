<?php

/**
 * @package PostsStatistics for phpBB.
 * @copyright (c) 2014 ForumHulp.com
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
	'ACP_POSTSSTATS'               => 'Estatísticas de Mensagens',
	'ACP_POSTSSTATS_EXPLAIN'       => 'As Estatísticas de Mensagens apresentam uma visão geral das mensagens e tópicos num período de tempo. Um gráfico é mostrado para cada página para ter uma visão fácil das suas estatísticas.',
	'PPO'                          => 'Visão geral de mensagens',
	'PPU'                          => 'Mensagens por utilizador',
	'PPT'                          => 'Mensagens por tópico',
	'TPO'                          => 'Visão geral de tópicos',
	'TPU'                          => 'Tópicos por utilizador',
	'TPF'                          => 'Tópicos por fórum',
	'TV'                           => 'Visualizações de tópicos',
	'GP'                           => 'Mensagens de grupos',
	'PTV'                          => 'Mensagens / Tópicos',
	'POL'                          => 'Visão geral de votações',
	'USERSTATS'                    => 'Gráfico de utilizadores',
	'ONLINE'                       => 'Últimas mensagens',
	'DO'                           => 'Visão geral mensal',
	'DOV'                          => 'Visão geral diária',
	'MO'                           => 'Visão geral anual',
	'MOV'                          => 'Visão geral mensal',
	'YO'                           => 'Visão geral',
	'YOV'                          => 'Visão geral de todos os anos',
	'MAX_POSTS_PER_USER'           => 'Máx. de mensagens por utilizador',
	'MAX_POSTS_PER_USER_EXPLAIN'   => 'Máx. de registos na vista',
	'MAX_POSTS_PER_TOPIC'          => 'Máx. de mensagens por tópico',
	'MAX_POSTS_PER_TOPIC_EXPLAIN'  => 'Máx. de registos na vista',
	'MAX_TOPICS_PER_USER'          => 'Máx. de tópicos por utilizador',
	'MAX_TOPICS_PER_USER_EXPLAIN'  => 'Máx. de registos na vista',
	'MAX_TOPICS_PER_FORUM'         => 'Máx. de tópicos por fórum',
	'MAX_TOPICS_PER_FORUM_EXPLAIN' => 'Máx. de registos na vista',
	'MAX_TOPICS_VIEWS'             => 'Máx. de visualizações de tópicos',
	'MAX_TOPICS_VIEWS_EXPLAIN'     => 'Máx. de registos na vista',
	'MAX_GROUPS_POSTS'             => 'Máx. de mensagens de grupo',
	'MAX_GROUPS_POSTS_EXPLAIN'     => 'Máx. de registos na vista',
	'MAX_ONLINE'                   => 'Máx. de registos nas últimas mensagens',
	'MAX_ONLINE_EXPLAIN'           => 'Máx. de registos por página',
	'START_SCREEN'                 => 'Ecrã inicial',
	'START_SCREEN_EXPLAIN'         => 'Escolha o seu ecrã inicial para as Estatísticas do Fórum e se quer mostrar o arquivo ou online.',
]);
