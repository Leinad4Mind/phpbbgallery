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
	'UCP_POST_BOOKMARKS_TITLE' => 'Gerenciar postagens salvas',

	'POST_BOOKMARKS_EXPLAIN' => 'Você pode salvar postagens nos favoritos para referência futura. Selecione a caixa de verificação correspondente a qualquer marcador que queira excluir e, em seguida, clique no botão <em>Remover favoritos marcados</em>.',
	'POST_BOOKMARKS'         => 'Postagens Salvas',
]);
