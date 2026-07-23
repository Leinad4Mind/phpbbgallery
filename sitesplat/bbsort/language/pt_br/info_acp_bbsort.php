<?php

/**
 * @package BBsort for phpBB.
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
	'ACP_BBSORT'     => 'BBsort',
	'SS_HELPER_NOTY' => 'O SiteSplat BBcore não existe!<br />Baixe o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
	'BBSORT_NOTICE'  => '<div class="phpinfo"><p>Não existem definições específicas para esta extensão. As paginações de fóruns e tópicos são automaticamente convertidas com o novo sistema de rolagem (scroll) e o filtro para o tópico também já está pronto para uso.</p></div>',
]);
