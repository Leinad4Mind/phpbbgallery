<?php

/**
 * Nightstalker
 * @copyright (c) 2015 sitesplat.com <https://sitesplat.com>
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
	'ACP_NIGHT'      => 'Modo Noturno (Nightstalker)',
	'SS_HELPER_NOTY' => 'O SiteSplat BBcore não existe!<br />Faça o download do <a href="https://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
	'NIGHT_NOTICE'   => '<div class="phpinfo"><p>Não existem definições específicas para esta extensão.<br />O Nightstalker (Modo Noturno) é ativado clicando no modo Nightstalker a partir da navegação do utilizador.</p></div>',
]);
