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
	'UCP_POST_BOOKMARKS_TITLE' => 'Gerir mensagens guardadas',

	'POST_BOOKMARKS_EXPLAIN' => 'Podes guardar mensagens nos favoritos para referência futura. Selecciona a caixa de verificação correspondente a qualquer marcador que pretendas eliminar e, em seguida, clica no botão <em>Remover favoritos marcados</em>.',
	'POST_BOOKMARKS'         => 'Mensagens Guardadas',
]);
