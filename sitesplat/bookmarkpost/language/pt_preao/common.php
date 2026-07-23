<?php

/**
 * Bookmark Post
 * @copyright (c) 2016 SiteSplat All rights reserved
 * @license Proprietary
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
	'BOOKMARK_POST_TITLE'           => 'Gerir Mensagens Guardadas (Favoritos)',
	'BOOKMARK_POST'                 => 'Guardar esta mensagem',
	'UNBOOKMARK_POST'               => 'Remover mensagem guardada',
	'TOOLTIP_BOOMARKED_POSTS'       => 'Tens uma ou mais mensagens guardadas neste tópico',
	'TOOLTIP_BOOMARKED_FORUM_POSTS' => 'Tens uma ou mais mensagens guardadas neste fórum',
	'POST_BOOKMARKED'               => 'Guardaste esta mensagem',
	'POST_BOOKMARK_ADDED'           => 'Mensagem guardada com sucesso.<br><br><a href="%1$s">Regressar ao tópico</a><br><br><a href="%2$s">Ver todas as mensagens guardadas</a>',
	'POST_BOOKMARK_ADDED_AJAX'      => 'Mensagem guardada com sucesso.',
	'POST_BOOKMARK_REMOVED'         => 'Mensagem removida dos favoritos com sucesso.<br><br><a href="%1$s">Regressar ao tópico</a><br><br><a href="%2$s">Ver todas as mensagens guardadas</a>',
	'POST_BOOKMARK_REMOVED_AJAX'    => 'Mensagem removida dos favoritos com sucesso.',
]);
