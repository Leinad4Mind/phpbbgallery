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
	'ACP_POSTBOOKMARK'    => 'PostBookmarks (Mensagens Guardadas)',
	'SS_HELPER_NOTY'      => 'O SiteSplat BBcore não existe!<br />Baixe o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
	'POSTBOOKMARK_NOTICE' => '<div class="phpinfo"><p>Não existem definições específicas no ACP para esta extensão. Os usuários poderão agora salvar postagens individuais nos favoritos e também revê-las na Visão Geral do seu Painel de Controle do Usuário (UCP).</p></div>',
]);
