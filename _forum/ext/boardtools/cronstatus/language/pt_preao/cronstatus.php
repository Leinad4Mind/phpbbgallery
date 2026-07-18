<?php
/**
 *
 * @package       Cron Status
 * @copyright (c) 2014 - 2021 Igor Lavrov, John Peskens, Leinad4Mind
 * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
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
	$lang = array();
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
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'CRON'                            => 'Cron',
	'CRON_LOCKED'                     => 'Cron Bloqueado',
	'CRON_TIME_LOCKED'                => 'Hora de bloqueio do Cron',
	'ACP_CRON_STATUS_TITLE'           => 'Estado do Cron',
	'ACP_CRON_STATUS_CONFIG_TITLE'    => 'Verificar Estado do Cron',
	'ACP_CRON_STATUS_EXPLAIN'         => 'Estado do Cron é uma página do seu fórum phpBB onde pode verificar se as tarefas Cron estão prontas a ser executadas. A data “Auto” da última tarefa significa que a tarefa tem uma opção de controlo de tempo específica que não pôde ser reconhecida pela extensão Estado do Cron. Uma tarefa marcada a vermelho significa uma tarefa que nunca foi iniciada ou que tem um problema. Um cadeado vermelho significa que esta tarefa está bloqueada pelo gestor do cron e bloqueia outras tarefas.',
	'CRON_STATUS_REFRESH'             => 'Segundos para actualizar',
	'CRON_TASK_LOCKED'                => 'Tarefa Cron bloqueada',
	'CRON_STATUS_READY_TASKS'         => 'Tarefas prontas a executar',
	'CRON_STATUS_NOT_READY_TASKS'     => 'Tarefas não prontas',
	'CRON_STATUS_NO_TASKS'            => 'Nenhuma tarefa cron disponível',
	'CRON_STATUS_DATE_FORMAT'         => 'Formato de data para a página Estado do Cron',
	'CRON_STATUS_DATE_FORMAT_EXPLAIN' => 'O formato de data é o mesmo que o da função <code>date</code> do PHP.',
	'CRON_STATUS_MAIN_NOTICE'         => 'Aviso na página principal do ACP',
	'CRON_STATUS_MAIN_NOTICE_EXPLAIN' => 'Mostrar o Aviso de Estado do Cron na página principal do ACP se o Cron estiver bloqueado.',
	'CRON_TASK_NAME'                  => 'Nome da tarefa',
	'CRON_TASK_DATE'                  => 'Data da última tarefa',
	'CRON_NEW_DATE'                   => 'Nova data da tarefa',
	'CRON_TASK_NEVER_STARTED'         => 'Nunca iniciada',
	'CRON_TASK_AUTO'                  => 'Auto',
	'CRON_TASK_DATE_TIME'             => 'Data e hora actual',
	'CRON_STATUS_ERROR'               => 'Erro de actualização',
	'CRON_STATUS_TIMEOUT'             => 'Tempo limite de actualização',
	'CRON_STATUS_ERROR_EXPLAIN'       => 'Ocorreu um erro durante a actualização da página.',
	'CRON_STATUS_DEVELOPERS'          => 'Programadores',
	'CRON_TASK_RUN'                   => 'Executar',
	'CRON_TASK_RUNNING'               => 'A executar...',
));

// Description of Cron Status extension
$lang = array_merge($lang, array(
	'CRONSTATUS_DESCRIPTION_PAGE'            => 'Página de Estado do Cron',
	'CRONSTATUS_DESCRIPTION_PAGE_OVERVIEW'   => 'Visão geral das Tarefas Cron (com ordenação)',
	'CRONSTATUS_DESCRIPTION_PAGE_STATUS'     => 'Mostra o estado de cada Tarefa Cron',
	'CRONSTATUS_DESCRIPTION_PAGE_ABILITY'    => 'Pode executar manualmente qualquer tarefa pronta',
	'CRONSTATUS_DESCRIPTION_NOTICE'          => 'Aviso de Estado do Cron (opcional)',
	'CRONSTATUS_DESCRIPTION_NOTICE_OVERVIEW' => 'É mostrado na página principal do ACP quando o cron está bloqueado',
	'CRONSTATUS_DESCRIPTION_NOTICE_SETTINGS' => 'Pode ser desactivado nas Definições do Fórum',
));
