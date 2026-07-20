<?php

/**
 * BBbreadcrumbs
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
	'ACP_BREADCRUMBS'    => 'BBbreadcrumbs',
	'SS_HELPER_NOTY'     => 'O SiteSplat BBcore não existe!<br />Faça o download do <a href="http://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
	'BREADCRUMBS_NOTICE' => '<div class="phpinfo"><p>Não existem definições específicas para esta extensão. O breadcrumb está habilitado e agora funcionará automaticamente em todas as páginas do fórum.</p></div>',
]);
