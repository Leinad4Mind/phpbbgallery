<?php

/**
 * @package phpBB Extension - Activity Stats for phpBB.
 * @copyright (c) 2014 Robet Heim
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
// ’ » “ ” …
//

$lang = array_merge($lang, [
	'ACTIVITY_STATS_INSTALLED' => 'Versão Instalada: v%s',

	'ACTIVITY_STATS_TITLE'    => 'Estatísticas de Actividade',
	'ACTIVITY_STATS_DISP_SET' => 'Configurações de visualização',
	'ACTIVITY_STATS_OTHER'    => 'Outras configurações',

	// acp form
	'ACTIVITY_STATS_DISP_NEW_TOPICS'     => 'Mostrar novos tópicos',
	'ACTIVITY_STATS_DISP_NEW_TOPICS_EXP' => 'Apresentar a contagem de novos tópicos',
	'ACTIVITY_STATS_DISP_NEW_POSTS'      => 'Mostrar novas publicações',
	'ACTIVITY_STATS_DISP_NEW_POSTS_EXP'  => 'Apresentar a contagem de novas publicações',
	'ACTIVITY_STATS_DISP_NEW_USERS'      => 'Mostrar novos utilizadores',
	'ACTIVITY_STATS_DISP_NEW_USERS_EXP'  => 'Apresentar a contagem de novos utilizadores',

	'ACTIVITY_STATS_DISP_BOTS'        => 'Mostrar bots',
	'ACTIVITY_STATS_DISP_BOTS_EXP'    => 'Alguns utilizadores poderão questionar-se sobre o que são bots e temê-los.',
	'ACTIVITY_STATS_DISP_GUESTS'      => 'Mostrar visitantes',
	'ACTIVITY_STATS_DISP_GUESTS_EXP'  => 'Apresentar visitantes no contador?',
	'ACTIVITY_STATS_DISP_HIDDEN'      => 'Mostrar utilizadores ocultos',
	'ACTIVITY_STATS_DISP_HIDDEN_EXP'  => 'Os utilizadores ocultos devem ser apresentados na lista? (permissão necessária)',
	'ACTIVITY_STATS_DISP_TIME'        => 'Mostrar hora',
	'ACTIVITY_STATS_DISP_TIME_EXP'    => 'Todos os utilizadores veem isto ou nenhum. Nenhuma função especial para Administradores.',
	'ACTIVITY_STATS_DISP_TIME_FORMAT' => 'Formato de hora',
	'ACTIVITY_STATS_DISP_HOVER'       => 'Mostrar ao passar o rato',
	'ACTIVITY_STATS_DISP_IP'          => 'Mostrar IP do utilizador',
	'ACTIVITY_STATS_DISP_IP_EXP'      => 'Apenas para utilizadores com permissões administrativas, tal como no viewonline.php',

	'ACTIVITY_STATS_RECORD'            => 'Recorde',
	'ACTIVITY_STATS_RECORD_EXP'        => 'Apresentar e guardar recorde',
	'ACTIVITY_STATS_RECORD_TIMEFORMAT' => 'Formato de data para o recorde',
	'ACTIVITY_STATS_RESET'             => 'Repor recorde',
	'ACTIVITY_STATS_RESET_EXP'         => 'Repõe o tempo e o contador do recorde das Estatísticas de Actividade.',
	'ACTIVITY_STATS_RESET_TRUE'        => 'Se submeter este formulário, o recorde será reposto.',


	'ACTIVITY_STATS_SETTINGS_SAVED' => 'Configuração actualizada com sucesso.',
	'ACTIVITY_STATS_SORT_BY'        => 'Ordenar utilizadores por',
	'ACTIVITY_STATS_SORT_BY_EXP'    => 'Em que ordem devem os utilizadores ser apresentados?',
	'ACTIVITY_STATS_SORT_BY_0'      => 'Nome de Utilizador A -> Z',
	'ACTIVITY_STATS_SORT_BY_1'      => 'Nome de Utilizador Z -> A',
	'ACTIVITY_STATS_SORT_BY_2'      => 'Tempo de visita ascendente',
	'ACTIVITY_STATS_SORT_BY_3'      => 'Tempo de visita descendente',
	'ACTIVITY_STATS_SORT_BY_4'      => 'ID de Utilizador ascendente',
	'ACTIVITY_STATS_SORT_BY_5'      => 'ID de Utilizador descendente',

	'ACTIVITY_STATS_CACHE_TIME'     => 'Tempo de cache (segundos)',
	'ACTIVITY_STATS_CACHE_TIME_EXP' => 'Duração na qual os dados não são recalculados (melhora o desempenho)',

	'ACTIVITY_STATS_CHECK_PERMISSIONS'     => 'Verificar permissões',
	'ACTIVITY_STATS_CHECK_PERMISSIONS_EXP' => 'não=todos devem ver as estatísticas de actividade (ignora configurações de permissão); sim=usar permissões configuradas (ex: permitir apenas a utilizadores registados: ACP->permissões->permissões globais -> permissões de grupo -> utilizadores registados -> Permissões avançadas -> Diversos -> "Pode ver as estatísticas de actividade")',

	'ACTIVITY_STATS_MODE'             => 'Mostrar utilizadores de ...',
	'ACTIVITY_STATS_MODE_EXP'         => 'Apresenta utilizadores de hoje (desde 00:00 no fuso horário do fórum), ou do período definido na próxima opção.',
	'ACTIVITY_STATS_MODE_TODAY'       => 'Hoje',
	'ACTIVITY_STATS_MODE_PERIOD'      => 'Período de tempo',
	'ACTIVITY_STATS_MODE_PERIOD_EXP'  => 'escreva 0 se quiser apresentar os utilizadores das últimas 24h',
	'ACTIVITY_STATS_MODE_PERIOD_EXP2' => 'desactivado se escolheu "hoje"',
	'ACTIVITY_STATS_MODE_PERIOD_EXP3' => 'segundos',

]);
