<?php

/**
 * PM Search extension for the phpBB Forum Software package.
 * @author Stanislav Atanasov | Leinad4Mind
 * @copyright 2014 Stanislav Atanasov | 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
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
// ’ » “ ” …
//

$lang = array_merge($lang, [
	// ACP general langauge
	'ACP_PMSEARCH_GRP' => 'Pesquisar em MPs',
	'ACP_PRVOPT'       => 'Configurações',

	//ACP PM Admin Settings page
	'PMSEARCH_ADMIN'             => 'Pesquisar em MPs',
	'PMSEARCH_ADMIN_EXPLAIN'     => 'A partir daqui você pode definir algumas das opções relacionadas com a pesquisa de usuários em MPs.',
	'PMSEARCH_SETTINGS'          => 'Opções',
	'PMSEARCH_PM_INDEX'          => 'Indexação de MPs',
	'PMSEARCH_PM_INDEX_EXPLAIN'  => 'A partir daqui você pode permitir a indexação <br /><b>(Aviso! A pesquisa não funcionará se não tiver indexação)</b>.',
	'PMSEARCH_PM_SEARCH'         => 'Permitir pesquisa',
	'PMSEARCH_PM_SEARCH_EXPLAIN' => 'Permitir (ou negar) globalmente a pesquisa em MPs.',
	'DELETE_INDEX'               => 'Excluir índices',
	'CREATE_INDEX'               => 'Criar índices',

	//ACP ACL
	'ACL_U_PMSEARCH' => 'O usuário pode pesquisar em MPs',

	//Other ACP
	'LOG_PMSEARCH_INDEX_REMOVED'   => '<strong>Índice de pesquisa removido por </strong><br />» %s',
	'LOG_PMSEARCH_INDEX_CREATED'   => '<strong>Índice de pesquisa criado por </strong><br />» %s',
	'TOTAL_WORDS'                  => 'Total de palavras indexadas',
	'TOTAL_MATCHES'                => 'Contagem total de relações de palavras',
	'SEARCH_INDEX_CREATE_REDIRECT' => [
		2 => 'Todas as mensagens até ao id de mensagem %2$d foram agora indexadas, das quais %1$d mensagens foram neste passo.<br />',
	],
	'SEARCH_INDEX_CREATE_REDIRECT_RATE' => [
		2 => 'A taxa atual de indexação é de aproximadamente %1$.1f mensagens por segundo.<br />Indexação em progresso…',
	],
]);
