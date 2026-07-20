<?php

/**
 * @package PM SPy for phpBB.
 * @copyright (c) 2016 ForumHulp.com
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
	'ACP_PM_SPY'          => 'Espião de MP',
	'AUTHOR_IP'           => 'IP do Autor',
	'DATE'                => 'Data',
	'LAST_ONLINE'         => 'Última data online:',
	'DELETE_PMS'          => 'Eliminar MP\'s',
	'NO_PM_SELECTED'      => 'Nenhuma MP selecionada',
	'NO_PM_DATA'          => 'SEM dados de MP\'s',
	'PM_BOX'              => 'Caixa de MP',
	'PM_SPY_READ'         => 'Espião de Mensagens Privadas',
	'PM_SPY_READ_EXPLAIN' => 'Aqui está uma lista de todas as mensagens privadas do seu fórum.',
	'READ_MESSAGE'        => 'Clique para ler esta mensagem',
	'TO'                  => 'Para',
	'TOTAL_USERS'         => 'Total de utilizadores',
	'PM_COUNT'            => 'Contagem de MP',
	'PM_HOLDBOX'          => 'Retidas',
	'PM_INBOX'            => 'Caixa de Entrada',
	'PM_NOBOX'            => 'Sem caixa',
	'PM_OUTBOX'           => 'Caixa de Saída',
	'PM_SAVED'            => 'Guardadas',
	'PM_SENTBOX'          => 'Enviadas',
	'SORT_FROM'           => 'De',
	'SORT_TO'             => 'Para',
	'SORT_BCC'            => 'BCC',
	'SORT_PM_BOX'         => 'Caixa de MP',
	'LOG_PM_SPY'          => '<strong>MP\'s eliminadas pelo Espião de MP</strong><br />',
	'FH_HELPER_NOTICE'    => 'A aplicação ajudante forumhulp não existe!<br />Descarregue <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> e copie a pasta helper para a pasta da sua extensão forumhulp.',
	'PMSPY_NOTICE'        => '<div class="phpinfo"><p class="entry">Esta extensão reside em %1$s » %2$s » %3$s.</p></div>',
]);
$lang = array_merge($lang, [
	'DESCRIPTION_PAGE'   => 'Descrição',
	'DESCRIPTION_NOTICE' => 'Nota da extensão',
	'ext_details'        => [
		'details' => [
			'DESCRIPTION_1' => 'Ordenável',
			'DESCRIPTION_2' => 'Limpeza automática de registos antigos',
			'DESCRIPTION_3' => 'Agrupado em encontrado e não encontrado na mensagem',
		],
		'note' => [
			'NOTICE_1' => 'Pronto para phpBB 3.2'
		]
	]
]);
