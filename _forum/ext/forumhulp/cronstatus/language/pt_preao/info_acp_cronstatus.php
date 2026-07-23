<?php

/**
 * @package Cron Status for phpBB.
 * @copyright (c) 2014 - 2021 Igor Lavrov, John Peskens, Leinad4Mind
 * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
	'ACP_CRON_STATUS_TITLE' => 'Estado do Cron',
	'LOG_CORE_INSTALLED'    => 'Ficheiros alterados com sucesso',
	'LOG_CORE_DEINSTALLED'  => 'Ficheiros revertidos com sucesso',
	'LOG_CORE_NOT_REPLACED' => 'Não foi possível substituir o(s) ficheiro(s)<br />» %s',
	'LOG_CORE_NOT_UPDATED'  => 'Não foi possível actualizar o(s) ficheiro(s)<br />» %s',
	'FH_HELPER_NOTICE'      => 'A aplicação ajudante forumhulp não existe!<br />Transfere <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> e copia a pasta helper para a pasta da tua extensão forumhulp.',
	'CRONSTAT_NOTICE'       => '<div class="phpinfo"><p class="entry">Esta extensão está localizada em %1$s » %2$s » %3$s.</p></div>',
]);

// Description of Donations extension
$lang = array_merge($lang, [
	'DESCRIPTION_PAGE'   => 'Descrição',
	'DESCRIPTION_NOTICE' => 'Nota da extensão',
	'ext_details'        => [
		'details' => [
			'DESCRIPTION_1' => 'Visão geral das Tarefas Cron (com ordenação)',
			'DESCRIPTION_2' => 'Mostra o estado de cada Tarefa Cron',
			'DESCRIPTION_3' => 'Podes executar qualquer tarefa pronta manualmente',
			'DESCRIPTION_4' => 'Reinicia o bloqueio do cron com um simples clique',
		],
		'note' => [
			'NOTICE_1' => 'Aviso do Estado do Cron na página principal do ACP',
			'NOTICE_2' => 'Configurável nas definições do fórum',
			'NOTICE_3' => 'Opção "Executar cron sempre" comutável',
			'NOTICE_4' => 'Compatível com phpBB 3.2',
		],
	],
]);
