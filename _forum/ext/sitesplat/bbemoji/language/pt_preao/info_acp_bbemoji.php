<?php

/**
 * @package BBEmoji for phpBB.
 * @copyright (c) 2016-2022 SiteSplat All rights reserved
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
	'ACP_BBEMOJI'    => 'BBemoji',
	'SS_HELPER_NOTY' => 'O SiteSplat BBcore não existe!<br />Faça o download do <a href="https://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
	'BBEMOJI_NOTICE' => '<div class="phpinfo"><p>Não existem definições específicas para esta extensão.</p></div>',
]);
