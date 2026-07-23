<?php

/**
 * Bookmark Post
 * @copyright (c) 2016 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
	'BOOKMARK_POST_TITLE'           => 'Gerenciar Postagens Salvas (Favoritos)',
	'BOOKMARK_POST'                 => 'Salvar esta postagem',
	'UNBOOKMARK_POST'               => 'Remover postagem salva',
	'TOOLTIP_BOOMARKED_POSTS'       => 'Você tem uma ou mais postagens salvas neste tópico',
	'TOOLTIP_BOOMARKED_FORUM_POSTS' => 'Você tem uma ou mais postagens salvas neste fórum',
	'POST_BOOKMARKED'               => 'Você salvou esta postagem',
	'POST_BOOKMARK_ADDED'           => 'Postagem salva com sucesso.<br><br><a href="%1$s">Voltar ao tópico</a><br><br><a href="%2$s">Ver todas as postagens salvas</a>',
	'POST_BOOKMARK_ADDED_AJAX'      => 'Postagem salva com sucesso.',
	'POST_BOOKMARK_REMOVED'         => 'Postagem removida dos favoritos com sucesso.<br><br><a href="%1$s">Voltar ao tópico</a><br><br><a href="%2$s">Ver todas as postagens salvas</a>',
	'POST_BOOKMARK_REMOVED_AJAX'    => 'Postagem removida dos favoritos com sucesso.',
]);
