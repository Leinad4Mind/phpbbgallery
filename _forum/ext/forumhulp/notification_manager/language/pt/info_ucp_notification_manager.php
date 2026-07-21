<?php

/**
 * Notification_manager for the phpBB Forum Software package.
 * @copyright (c) 2017 ForumHulp.com <http://forumhulp.com>
 * @license Proprietary
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
// ’ » “ ” …
//

$lang = array_merge(
	$lang, [
		'UCP_NOTIES'             => 'Gerir notificações',
		'UCP_NOTIES_EXPLAIN'     => 'Gere as tuas notificações',
		'MARK_DELETE_SINGLE'     => 'Marcar para Apagar',
		'MARK_READ_SINGLE'       => 'Marcar para Lida',
		'MARK_UNREAD_SINGLE'     => 'Marcar para Por Ler',
		'MARK_DELETE'            => 'Selecionar Todas para Apagar',
		'MARK_READ'              => 'Selecionar Todas para Lidas',
		'MARK_UNREAD'            => 'Selecionar Todas para Por Ler',
		'UNMARK_DELETE'          => 'Deselecionar Todas de Apagar',
		'UNMARK_READ'            => 'Deselecionar Todas de Lidas',
		'UNMARK_UNREAD'          => 'Deselecionar Todas de Por Ler',
		'MARK_DELETE_SELECTED'   => 'Apagar Marcadas',
		'MARK_READ_SELECTED'     => 'Marcar Lidas',
		'MARK_UNREAD_SELECTED'   => 'Marcar Por Ler',
		'UNMARK_DELETE_SELECTED' => 'Desmarcar Apagar',
		'UNMARK_READ_SELECTED'   => 'Desmarcar Lidas',
		'UNMARK_UNREAD_SELECTED' => 'Desmarcar Por Ler',
		'UCP_NOTIES_SUBMIT'      => 'Submeter Selecionadas',
	]
);
