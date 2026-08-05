<?php

/**
 * @package PostsStatistics for phpBB.
 * @copyright (c) 2014 ForumHulp.com
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
	'ACP_POSTSTATISTICS' => 'Estatísticas de Mensagens',
	'FH_HELPER_NOTICE'   => 'A aplicação ajudante forumhulp não existe!<br />Transfere <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> e copia a pasta helper para a pasta da tua extensão forumhulp.',
	'POSTSSTAT_NOTICE'   => '<div class="phpinfo"><p class="entry">Esta extensão reside em %1$s » %2$s » %3$s.<br>As definições de configuração estão dentro da aplicação.</p></div>',
]);
$lang = array_merge($lang, [
	'DESCRIPTION_PAGE'   => 'Descrição',
	'DESCRIPTION_NOTICE' => 'Nota da extensão',
	'ext_details'        => [
		'details' => [
			'DESCRIPTION_1' => 'Visão geral gráfica de mensagens',
			'DESCRIPTION_2' => 'Sem carga extra',
			'DESCRIPTION_3' => 'Visões gerais diárias, mensais e anuais',
			'DESCRIPTION_4' => 'Configurável',
		],
		'note' => [
			'NOTICE_1' => 'Gráficos Highchart',
			'NOTICE_2' => 'Imprimível',
			'NOTICE_3' => 'Pronto para phpBB 3.2'
		]
	]
]);
