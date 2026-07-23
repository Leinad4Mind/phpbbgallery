<?php

/**
 * @package Categorize CAS for phpBB.
 * @copyright (c) 2016 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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
	'ACP_CAS'        => 'Categorize CAS',
	'SS_HELPER_NOTY' => 'O SiteSplat BBcore não existe!<br />Transfere o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copia a pasta BBcore para a pasta da tua extensão sitesplat.',
	'CAS_NOTICE'     => '<div class="phpinfo"><p>Não existem definições específicas para esta extensão. Os anúncios globais e os tópicos fixos serão automaticamente categorizados.</p></div>',
]);
