<?php

/**
 * @package sitesplat BBlinks for phpBB.
 * @copyright (c) 2017 SiteSplat All rights reserved
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
	'ACP_BBLINKS'       => 'BBlinks',
	'ACP_BBLINKS_TITLE' => 'BBlinks',
	'SS_HELPER_NOTY'    => 'O SiteSplat BBcore não existe!<br />Faça o download do <a href="https://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
	'BBLINKS_NOTICE'    => '<div class="phpinfo"><p>As definições para esta extensão encontram-se na aba das <strong>EXTENSÕES</strong>.</p></div>',
]);
