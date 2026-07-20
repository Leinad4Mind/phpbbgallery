<?php

/**
 * @package BBembed for phpBB.
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
	'ACP_BBEMBED'    => 'BBembed',
	'SS_HELPER_NOTY' => 'O SiteSplat BBcore não existe!<br />Faça o download do <a href="https://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
	'BBEMBED_NOTICE' => '<div class="phpinfo"><p>Não existem definições específicas para esta extensão. Cole apenas ligações (links) diretos nas publicações e a BBembed irá exibir magicamente e automaticamente os vídeos.</p></div>',
]);
