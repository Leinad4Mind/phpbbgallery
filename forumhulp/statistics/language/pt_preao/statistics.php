<?php

/**
 * @package Statistics for phpBB.
 * @copyright (c) 2014 ForumHulp.com
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
	'ACP_STATISTICS'             => 'Estatísticas do Fórum',
	'ACP_ACP_STATISTICS_EXPLAIN' => 'As Estatísticas do Fórum mostram uma visão geral dos teus visitantes. Esta extensão regista todas as visitas dos teus utilizadores. Uma tarefa cron analisará as estatísticas à meia-noite e limpará as tabelas de acordo com as tuas configurações. Podes ver as estatísticas de hoje ou globais. Um gráfico é mostrado para cada página para teres uma visão fácil das tuas estatísticas.',
	'OPTIONS'                    => 'Opções',
	'COUNTRIES'                  => 'Países',
	'REFERRALS'                  => 'Referências',
	'SEARCHENG'                  => 'Motores de busca',
	'SEARCHTERMS'                => 'Termos de pesquisa',
	'BROWSERS'                   => 'Navegadores',
	'CRAWLERS'                   => 'Web Crawlers',
	'SYSTEMS'                    => 'Sistemas Informáticos',
	'MODULES'                    => 'Módulos',
	'AVERAGES'                   => 'Médias',
	'RESOLUTIONS'                => 'Resoluções de Ecrã',
	'OVERVIEW'                   => 'Top 10',
	'ADMIN'                      => 'Administrar',
	'USERS'                      => 'Utilizadores',
	'USERSTATS'                  => 'Gráficos de Estatísticas de Utilizadores',
	'ONLINE'                     => 'Página das últimas visitas',
	'LASTVISITS'                 => 'Últimas páginas visitadas',
	'FL_DATE'                    => 'Informação da tabela de arquivo',
	'UGROUPS'                    => 'Grupos de utilizadores',
	'UNIQUE'                     => 'Visitantes únicos',
	'HOV'                        => 'Visão geral horária',
	'DOV'                        => 'Visão geral diária',
	'MOV'                        => 'Visão geral mensal',
	'YOV'                        => 'Visão geral anual',
	'TIME'                       => 'Hora',
	'USER'                       => 'Utilizador',
	'MODULE'                     => 'Módulo',
	'COUNTRY'                    => 'País',
	'HOST'                       => 'Host',
	'IP'                         => 'Endereço IP',
	'MODULE_FORUM'               => 'Módulos / Fóruns',
	'VIEWS'                      => 'Visualizações',
	'PERC'                       => 'Percentagem',
	'GRAPH'                      => 'Gráfico',
	'PPD'                        => 'Mensagens por dia',
	'PPM'                        => 'Mensagens por mês',
	'TPD'                        => 'Tópicos por dia',
	'TPM'                        => 'Tópicos por mês',
	'FORUMDAYS'                  => 'Dias no Fórum',
	'APPT'                       => 'Média de mensagens por tópico',
	'APPU'                       => 'Média de mensagens por utilizador',
	'SEARCHRESULTS'              => 'Resultados de pesquisa',
	'MAX_COUNTRIES'              => 'Países',
	'MAX_REFERER'                => 'Referências',
	'MAX_SE'                     => 'Motores de busca',
	'MAX_SE_TERMS'               => 'Termos de pesquisa',
	'MAX_BROWSERS'               => 'Navegadores',
	'MAX_CRAWL'                  => 'Web Crawlers',
	'MAX_OS'                     => 'Sistemas Informáticos',
	'MAX_MODULES'                => 'Módulos',
	'MAX_USERS'                  => 'Utilizadores',
	'MAX_AVERAGES'               => 'Médias',
	'MAX_SCREENS'                => 'Resoluções de Ecrã',
	'MAX_ONLINE'                 => 'Online',
	'DELL'                       => 'Eliminar',
	'SEARCHENG_EXPLAIN'          => 'Muda, edita, adiciona ou elimina motores de busca.',
	'MAX_COUNTRIES_EXPLAIN'      => 'Vê a explicação em módulos.',
	'MAX_REFERER_EXPLAIN'        => 'Vê a explicação em módulos.',
	'MAX_SE_EXPLAIN'             => 'Vê a explicação em módulos.',
	'MAX_SE_TERMS_EXPLAIN'       => 'Vê a explicação em módulos.',
	'MAX_BROWSERS_EXPLAIN'       => 'Vê a explicação em módulos.',
	'MAX_CRAWL_EXPLAIN'          => 'Vê a explicação em módulos.',
	'MAX_OS_EXPLAIN'             => 'Vê a explicação em módulos.',
	'MAX_MODULES_EXPLAIN'        => 'Máximo de registos em vista exibidos antes da paginação, na tabela número máximo de registos para limpeza.',
	'MAX_USERS_EXPLAIN'          => 'Vê a explicação em módulos.',
	'MAX_AVERAGES_EXPLAIN'       => 'Vê a explicação em módulos.',
	'MAX_SCREENS_EXPLAIN'        => 'Vê a explicação em módulos.',
	'MAX_ONLINE_EXPLAIN'         => 'Vê a explicação em módulos.',
	'CUSTOM_PAGES'               => 'Páginas Personalizadas',
	'CUSTOM_PAGES_EXPLAIN'       => 'Preenche o nome da tua página personalizada e a variável de idioma para mostrar a tua extensão nas Estatísticas do Fórum. Selecciona a tua extensão para apagar ou alterar.',
	'START_SCREEN'               => 'Ecrã inicial',
	'START_SCREEN_EXPLAIN'       => 'Escolhe o teu ecrã inicial para as Estatísticas do Fórum e se queres mostrar o arquivo ou online.',
	'BOTS_INC'                   => 'Incluir bots',
	'BOTS_INC_EXPLAIN'           => 'Incluir bots na visualização online.',
	'LOG'                        => 'Registos',
	'LOG_EXPLAIN'                => 'Adicionar registos ao registo de manutenção.',
	'DEL_STAT'                   => 'Esvaziar tabelas de arquivo',
	'DEL_STAT_EXPLAIN'           => 'Esvaziar tabelas de arquivo e reiniciar as Estatísticas do Fórum.',
	'STAT_DELETE_CONFIRM'        => 'Esvaziar tabelas de arquivo?',
	'BS_STATUS_TIMEOUT'          => 'Tempo limite de actualização',
	'BS_STATUS_ERROR'            => 'Erro de actualização',
	'BS_STATUS_ERROR_EXPLAIN'    => 'Ocorreu um erro durante a actualização da página.',
]);
