<?php

/**
 * Nightstalker
 * @copyright (c) 2015 sitesplat.com <https://sitesplat.com>
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
	'ACP_NIGHT'      => 'Modo Nocturno (Nightstalker)',
	'SS_HELPER_NOTY' => 'O SiteSplat BBcore não existe!<br />Transfere o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copia a pasta BBcore para a pasta da tua extensão sitesplat.',
	'NIGHT_NOTICE'   => '<div class="phpinfo"><p>Não existem definições específicas para esta extensão.<br />O Nightstalker (Modo Nocturno) é activado clicando no modo Nightstalker a partir da navegação do utilizador.</p></div>',
]);
