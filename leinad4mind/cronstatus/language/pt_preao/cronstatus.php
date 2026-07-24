<?php

/**
 * @package   Cron Status
 * @author    John Peskens, Igor Lavrov, Leinad4Mind
 * @copyright (c) 2014 - 2021 John Peskens, Igor Lavrov | (c) 2022-2026 Leinad4Mind
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ « » “ ” …
//

$lang = array_merge($lang, [
	'CRON'                            => 'Cron',
	'CRON_LOCKED'                     => 'Cron Bloqueado',
	'CRON_TIME_LOCKED'                => 'Hora de bloqueio do Cron',
	'ACP_CRON_STATUS_TITLE'           => 'Estado do Cron',
	'ACP_CRON_STATUS_CONFIG_TITLE'    => 'Verificar o Estado do Cron',
	'ACP_CRON_STATUS_EXPLAIN'         => 'O Estado do Cron é uma página do teu fórum phpBB onde podes verificar se as tarefas cron estão prontas para serem concluídas. A data "Auto" da última tarefa significa que a tarefa tem uma opção específica de controlo de tempo que não pôde ser reconhecida pela extensão de Estado do Cron. Uma tarefa marcada a vermelho significa uma tarefa que nunca começou ou que tem um problema. Um cadeado vermelho significa que esta tarefa está bloqueada pelo gestor cron e bloqueia outras tarefas; clica no cadeado para a desbloquear. Executa uma tarefa pronta agora, ou executa todas as tarefas prontas de uma vez.',
	'CRON_STATUS_REFRESH'             => 'Segundos para actualização',
	'CRON_TASK_LOCKED'                => 'Tarefa cron bloqueada, clica para desbloquear',
	'CRON_STATUS_READY_TASKS'         => 'Tarefas prontas a executar',
	'CRON_STATUS_NOT_READY_TASKS'     => 'Tarefas não prontas',
	'CRON_STATUS_NEVER_STARTED_TASKS' => 'Tarefas nunca iniciadas',
	'CRON_STATUS_NO_TASKS'            => 'Sem tarefas cron disponíveis',
	'CRON_STATUS_DATE_FORMAT'         => 'Formato da data para a página do Estado do Cron',
	'CRON_STATUS_DATE_FORMAT_EXPLAIN' => 'O formato da data é o mesmo que a função PHP <code>date</code>.',
	'CRON_STATUS_MAIN_NOTICE'         => 'Aviso na página de índice do ACP',
	'CRON_STATUS_MAIN_NOTICE_EXPLAIN' => 'Mostra o Aviso de Estado do Cron na página de índice do ACP se o Cron estiver bloqueado.',
	'CRON_STATUS_RUN_ALWAYS'          => 'Executar cron sempre',
	'CRON_STATUS_RUN_ALWAYS_EXPLAIN'  => 'Permite também que visitas de bots accionem tarefas cron prontas, não só os utilizadores normais. Útil para fóruns com pouco tráfego humano mas que continuam a ser rastreados regularmente.',
	'CRON_TASK_NAME'                  => 'Nome da tarefa',
	'CRON_TASK_DATE'                  => 'Data da última tarefa',
	'CRON_NEW_DATE'                   => 'Data da nova tarefa',
	'CRON_TASK_NEVER_STARTED'         => 'Nunca começou',
	'CRON_TASK_AUTO'                  => 'Auto',
	'CRON_TASK_DATE_TIME'             => 'Data & hora actuais',
	'CRON_STATUS_ERROR'               => 'Erro na actualização',
	'CRON_STATUS_TIMEOUT'             => 'Tempo limite na actualização',
	'CRON_STATUS_ERROR_EXPLAIN'       => 'Ocorreu um erro durante a actualização da página.',
	'CRON_STATUS_DEVELOPERS'          => 'Programadores',
	'CRON_TASK_RUN'                   => 'Executar',
	'CRON_TASK_RUNNING'               => 'A executar...',
	'CRON_TASK_RUN_NOW'               => 'Executar agora',
	'CRON_TASK_RUN_ALL'               => 'Executar todas',
]);

// Description of Cron Status extension
$lang = array_merge($lang, [
	'CRONSTATUS_DESCRIPTION_PAGE'            => 'Página do Estado do Cron',
	'CRONSTATUS_DESCRIPTION_PAGE_OVERVIEW'   => 'Visão geral das Tarefas Cron (com ordenação)',
	'CRONSTATUS_DESCRIPTION_PAGE_STATUS'     => 'Mostra o estado de cada Tarefa Cron',
	'CRONSTATUS_DESCRIPTION_PAGE_ABILITY'    => 'Podes executar qualquer tarefa pronta agora, ou executar todas de uma vez',
	'CRONSTATUS_DESCRIPTION_NOTICE'          => 'Aviso do Estado do Cron (opcional)',
	'CRONSTATUS_DESCRIPTION_NOTICE_OVERVIEW' => 'É exibido na página principal do ACP quando o cron está bloqueado',
	'CRONSTATUS_DESCRIPTION_NOTICE_SETTINGS' => 'Pode ser desactivado nas configurações do Fórum',
]);
