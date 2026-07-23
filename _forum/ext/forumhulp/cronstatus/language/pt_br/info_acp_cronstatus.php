<?php

/**
 * @package Cron Status for phpBB.
 * @copyright (c) 2014 - 2021 Igor Lavrov, John Peskens, Leinad4Mind
 * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
	'LOG_CORE_INSTALLED'    => 'Arquivos alterados com sucesso',
	'LOG_CORE_DEINSTALLED'  => 'Arquivos revertidos com sucesso',
	'LOG_CORE_NOT_REPLACED' => 'Não foi possível substituir o(s) arquivo(s)<br />» %s',
	'LOG_CORE_NOT_UPDATED'  => 'Não foi possível atualizar o(s) arquivo(s)<br />» %s',
	'FH_HELPER_NOTICE'      => 'O aplicativo auxiliar forumhulp não existe!<br />Baixe <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> e copie a pasta helper para a pasta da sua extensão forumhulp.',
	'CRONSTAT_NOTICE'       => '<div class="phpinfo"><p class="entry">Esta extensão está localizada em %1$s » %2$s » %3$s.</p></div>',
]);

// Description of Donations extension
$lang = array_merge($lang, [
	'DESCRIPTION_PAGE'   => 'Descrição',
	'DESCRIPTION_NOTICE' => 'Nota da extensão',
	'ext_details'        => [
		'details' => [
			'DESCRIPTION_1' => 'Visão geral das Tarefas Cron (com ordenação)',
			'DESCRIPTION_2' => 'Mostra o status de cada Tarefa Cron',
			'DESCRIPTION_3' => 'Você pode executar qualquer tarefa pronta manualmente',
			'DESCRIPTION_4' => 'Reinicie o bloqueio do cron com um simples clique',
		],
		'note' => [
			'NOTICE_1' => 'Aviso de Estado do Cron na página principal do ACP',
			'NOTICE_2' => 'Configurável nas configurações do fórum',
			'NOTICE_3' => 'Opção "Executar cron sempre" alternável',
			'NOTICE_4' => 'Compatível com phpBB 3.2',
		],
	],
]);
