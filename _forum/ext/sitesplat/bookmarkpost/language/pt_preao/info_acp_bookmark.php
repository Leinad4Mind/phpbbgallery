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
	'ACP_POSTBOOKMARK'    => 'PostBookmarks (Mensagens Guardadas)',
	'SS_HELPER_NOTY'      => 'O SiteSplat BBcore não existe!<br />Faça o download do <a href="http://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
	'POSTBOOKMARK_NOTICE' => '<div class="phpinfo"><p>Não existem definições específicas no ACP para esta extensão. Os utilizadores poderão agora guardar mensagens individuais nos favoritos e também revê-las na Visão Geral do seu Painel de Controlo do Utilizador (UCP).</p></div>',
]);
