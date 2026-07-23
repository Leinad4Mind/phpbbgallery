<?php

/**
 * @package BBinfinitepagination for phpBB.
 * @copyright (c) 2019 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
 */

/**
 * DO NOT CHANGE
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
	'BBPAGINATION_NOTICE' => '<div class="phpinfo"><p>A configuração para esta extensão encontra-se em <strong>%1$s &#187; %2$s &#187; %3$s</strong>.</p></div>',
	'ACP_BBPAGINATION'    => 'BBinfinitepagination',
	'SS_HELPER_NOTY'      => 'O SiteSplat BBcore não existe!<br />Faça o download do <a href="https://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
]);
