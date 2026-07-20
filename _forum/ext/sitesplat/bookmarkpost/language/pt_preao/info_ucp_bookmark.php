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

	'POST_BOOKMARKS_EXPLAIN' => 'Você pode guardar mensagens nos favoritos para referência futura. Selecione a caixa de verificação correspondente a qualquer marcador que pretenda eliminar e, em seguida, prima o botão <em>Remover favoritos marcados</em>.',
	'POST_BOOKMARKS'         => 'Mensagens Guardadas',
]);
