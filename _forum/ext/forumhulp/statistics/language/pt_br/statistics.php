<?php

/**
 * @package Statistics for phpBB.
 * @copyright (c) 2014 ForumHulp.com
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
	'ACP_ACP_STATISTICS_EXPLAIN' => 'As Estatísticas do Fórum mostram uma visão geral dos seus visitantes. Esta extensão regista todas as visitas dos seus usuários. Uma tarefa cron analisará as estatísticas à meia-noite e limpará as tabelas de acordo com as suas configurações. Pode ver as estatísticas de hoje ou globais. Um gráfico é mostrado para cada página para ter uma visão fácil das suas estatísticas.',
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
	'RESOLUTIONS'                => 'Resoluções de Tela',
	'OVERVIEW'                   => 'Top 10',
	'ADMIN'                      => 'Administrar',
	'USERS'                      => 'Usuários',
	'USERSTATS'                  => 'Gráficos de Estatísticas de Usuários',
	'ONLINE'                     => 'Página das últimas visitas',
	'LASTVISITS'                 => 'Últimas páginas visitadas',
	'FL_DATE'                    => 'Informação da tabela de arquivo',
	'UGROUPS'                    => 'Grupos de usuários',
	'UNIQUE'                     => 'Visitantes únicos',
	'HOV'                        => 'Visão geral horária',
	'DOV'                        => 'Visão geral diária',
	'MOV'                        => 'Visão geral mensal',
	'YOV'                        => 'Visão geral anual',
	'TIME'                       => 'Hora',
	'USER'                       => 'Usuário',
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
	'APPU'                       => 'Média de mensagens por usuário',
	'SEARCHRESULTS'              => 'Resultados de pesquisa',
	'MAX_COUNTRIES'              => 'Países',
	'MAX_REFERER'                => 'Referências',
	'MAX_SE'                     => 'Motores de busca',
	'MAX_SE_TERMS'               => 'Termos de pesquisa',
	'MAX_BROWSERS'               => 'Navegadores',
	'MAX_CRAWL'                  => 'Web Crawlers',
	'MAX_OS'                     => 'Sistemas Informáticos',
	'MAX_MODULES'                => 'Módulos',
	'MAX_USERS'                  => 'Usuários',
	'MAX_AVERAGES'               => 'Médias',
	'MAX_SCREENS'                => 'Resoluções de Tela',
	'MAX_ONLINE'                 => 'Online',
	'DELL'                       => 'Excluir',
	'SEARCHENG_EXPLAIN'          => 'Mude, edite, adicione ou elimine motores de busca.',
	'MAX_COUNTRIES_EXPLAIN'      => 'Veja a explicação em módulos.',
	'MAX_REFERER_EXPLAIN'        => 'Veja a explicação em módulos.',
	'MAX_SE_EXPLAIN'             => 'Veja a explicação em módulos.',
	'MAX_SE_TERMS_EXPLAIN'       => 'Veja a explicação em módulos.',
	'MAX_BROWSERS_EXPLAIN'       => 'Veja a explicação em módulos.',
	'MAX_CRAWL_EXPLAIN'          => 'Veja a explicação em módulos.',
	'MAX_OS_EXPLAIN'             => 'Veja a explicação em módulos.',
	'MAX_MODULES_EXPLAIN'        => 'Máximo de registros em vista exibidos antes da paginação, na tabela número máximo de registros para limpeza.',
	'MAX_USERS_EXPLAIN'          => 'Veja a explicação em módulos.',
	'MAX_AVERAGES_EXPLAIN'       => 'Veja a explicação em módulos.',
	'MAX_SCREENS_EXPLAIN'        => 'Veja a explicação em módulos.',
	'MAX_ONLINE_EXPLAIN'         => 'Veja a explicação em módulos.',
	'CUSTOM_PAGES'               => 'Páginas Personalizadas',
	'CUSTOM_PAGES_EXPLAIN'       => 'Preencha o nome da sua página personalizada e a variável de idioma para mostrar a sua extensão nas Estatísticas do Fórum. Selecione a sua extensão para apagar ou alterar.',
	'START_SCREEN'               => 'Tela inicial',
	'START_SCREEN_EXPLAIN'       => 'Escolha o seu tela inicial para as Estatísticas do Fórum e se quer mostrar o arquivo ou online.',
	'BOTS_INC'                   => 'Incluir bots',
	'BOTS_INC_EXPLAIN'           => 'Incluir bots na visualização online.',
	'LOG'                        => 'Registros',
	'LOG_EXPLAIN'                => 'Adicionar registros ao registro de manutenção.',
	'GEOIP_LOOKUP'               => 'Consultar o país através do ip-api.com',
	'GEOIP_LOOKUP_EXPLAIN'       => 'Quando habilitada, o endereço IP de cada visitante é enviado ao serviço externo ip-api.com para obter a bandeira do país. Quando desabilitada (padrão), o país é deduzido localmente a partir do DNS reverso do IP do visitante, sem que nada seja enviado para fora do servidor.',
	'DEL_STAT'                   => 'Esvaziar tabelas de arquivo',
	'DEL_STAT_EXPLAIN'           => 'Esvaziar tabelas de arquivo e reiniciar as Estatísticas do Fórum.',
	'STAT_DELETE_CONFIRM'        => 'Esvaziar tabelas de arquivo?',
	'BS_STATUS_TIMEOUT'          => 'Tempo limite de atualização',
	'BS_STATUS_ERROR'            => 'Erro de atualização',
	'BS_STATUS_ERROR_EXPLAIN'    => 'Ocorreu um erro durante a atualização da página.',
]);
