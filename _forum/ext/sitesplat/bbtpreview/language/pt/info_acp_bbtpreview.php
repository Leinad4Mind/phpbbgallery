<?php

/**
 * BBtpreview
 * @copyright (c) 2015 SiteSplat All rights reserved
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
	'BBTPREVIEW_NOTICE' => '<div style="width:auto;margin:20px auto;"><p>Não existem definições específicas para esta extensão. Passe o rato sobre a lista de tópicos para descobrir o botão de lupa para a pré-visualização do tópico. Divirta-se!</p></div>',
]);
