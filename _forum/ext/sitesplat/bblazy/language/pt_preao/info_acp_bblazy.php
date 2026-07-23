<?php

/**
 * @package BBlazy for phpBB.
 * @copyright (c) 2018 SiteSplat All rights reserved
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
	'ACP_BBLAZY'     => 'BBlazy',
	'SS_HELPER_NOTY' => 'O SiteSplat BBcore não existe!<br />Transfere o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copia a pasta BBcore para a pasta da tua extensão sitesplat.',
	'BBLAZY_NOTICE'  => '<div class="phpinfo"><p>Não existem definições específicas para esta extensão. Todas as imagens do fórum serão carregadas de forma lenta (lazy loading) para melhorar o desempenho. Diverte-te!</p></div>',
]);
