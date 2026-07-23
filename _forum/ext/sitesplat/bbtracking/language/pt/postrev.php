<?php

/**
 * BBtracking
 * @copyright (c) 2018 Ken F. Innes IV <https://www.absoluteanime.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @copyright (c) 2017, Sitesplat
 * @license private
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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
// ’ « » “ ” …
//

$lang = array_merge($lang, [
	// Viewing posts
	'PRIMEPOSTREVISIONS_VIEW' => 'Ver histórico de mensagens',	// Text for the link to view the revision history
	'POSTREVISIONS_ICON_HELP' => 'Estas são as diferenças em relação a esta revisão acima',

	// Viewing revisions
	'PRIMEPOSTREVISIONS_VIEWING'         => 'A visualizar o histórico das mensagens',
	'PRIMEPOSTREVISIONS_VIEWING_EXPLAIN' => 'Esta página mostra todas as versões da mensagem, a começar pela versão mais atual.',
	'PRIMEPOSTREVISIONS_TITLE'           => 'A visualizar o histórico das mensagens',
	'PRIMEPOSTREVISIONS_FIRST'           => 'Mensagem original',
	'PRIMEPOSTREVISIONS_FINAL'           => 'Mensagem atual',
	'PRIMEPOSTREVISIONS_COUNT'           => 'Revisão %d',
	#'PRIMEPOSTREVISIONS_INFO'				=> 'Editado por %1$s a %2$s.',
	'PRIMEPOSTREVISIONS_EDIT_BY'     => 'Editado por',
	'PRIMEPOSTREVISIONS_NO_SUBJECT'  => '[sem assunto]',
	'PRIMEPOSTREVISIONS_COMPARE'     => 'Comparar',
	'PRIMEPOSTREVISIONS_VIEW_DENIED' => 'Faltam-te as permissões necessárias para visualizar estas revisões de mensagens.',

	// Delete a revision
	'PRIMEPOSTREVISIONS_DELETE'         => 'Eliminar Revisão',
	'PRIMEPOSTREVISIONS_DELETE_CONFIRM' => 'Tens a certeza de que pretendes eliminar esta revisão?',
	'PRIMEPOSTREVISIONS_DELETE_DENIED'  => 'Faltam-te as permissões necessárias para eliminar esta revisão.',
	'PRIMEPOSTREVISIONS_DELETE_FAILED'  => 'Ocorreu um erro ao tentar eliminar a revisão.',
	'PRIMEPOSTREVISIONS_DELETE_SUCCESS' => 'A revisão foi removida com sucesso.',
	'PRIMEPOSTREVISIONS_DELETE_INVALID' => 'Nenhuma revisão de mensagem foi selecionada para remoção.',

	// Delete all revisions
	'PRIMEPOSTREVISIONS_DELETES'         => 'Eliminar revisões selecionadas',
	'PRIMEPOSTREVISIONS_DELETES_CONFIRM' => 'Tens a certeza de que pretendes eliminar estas revisões?',
	'PRIMEPOSTREVISIONS_DELETES_DENIED'  => 'Faltam-te as permissões necessárias para eliminar estas revisões.',
	'PRIMEPOSTREVISIONS_DELETES_FAILED'  => 'Ocorreu um erro ao tentar eliminar estas revisões.',
	'PRIMEPOSTREVISIONS_DELETES_SUCCESS' => 'As revisões foram removidas com sucesso.',
	'PRIMEPOSTREVISIONS_DELETES_INVALID' => 'Nenhuma revisão de mensagem foi selecionada para remoção.',

	// Restore a revision
	'PRIMEPOSTREVISIONS_RESTORE'         => 'Restaurar Revisão',
	'PRIMEPOSTREVISIONS_RESTORE_CONFIRM' => 'Tens a certeza de que pretendes restaurar esta revisão?',
	'PRIMEPOSTREVISIONS_RESTORE_DENIED'  => 'Faltam-te as permissões necessárias para restaurar esta revisão.',
	'PRIMEPOSTREVISIONS_RESTORE_FAILED'  => 'Ocorreu um erro ao tentar restaurar a revisão.',
	'PRIMEPOSTREVISIONS_RESTORE_SUCCESS' => 'A mensagem foi restaurada com sucesso.',
	'PRIMEPOSTREVISIONS_RESTORE_INVALID' => 'Nenhuma revisão de mensagem foi selecionada para ser restaurada.',

]);
