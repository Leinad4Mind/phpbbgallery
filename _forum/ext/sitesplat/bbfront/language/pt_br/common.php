<?php

/**
 * @package BBfront for phpBB.
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
	'BBFRONT_PAGE'               => 'Página Inicial',
	'ACP_BBFRONT_SETTING_SAVED'  => 'As configurações foram salvas com sucesso!',
	'BBFRONT_SHOW'               => 'Publicar na página inicial',
	'BBFRONT_MORE'               => 'Continuar Lendo',
	'BBFRONT_HIDE'               => 'Remover da página inicial',
	'NO_POSTS_SELECTED'          => 'Ainda Não Há Tópicos Publicados Ou Fórum Selecionado',
	'NO_POSTS_EOC'               => 'Fim do Conteúdo',
	'NO_POSTS_NMPTL'             => 'Não Há Mais Cartões Para Carregar',
	'BBFRONT_LOAD_MORE'          => 'CARREGAR MAIS CARTÕES',
	'REPLIES_ARY'                => [
		1	=> '%1$d resposta',
		2	=> '%1$d respostas',
	],
]);
