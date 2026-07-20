<?php

/**
 * BBpostdated
 * @copyright (c) 2015 SiteSplat All rights reserved
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
	'FUTURE_DATE'             => 'Data ou datação estipulada para o futuro',
	'FUTURE_POST_ADDED'       => 'O Tópico foi enviado e dado como submetido à sua publicação numa predefinição bem-sucedida pelo que apenas este se virá a tornar presente perante o surgimento noutra data com as publicações ditadas face no seu devido tempo marcado de futuro.',
	'TOPIC_PENDING'           => 'Este Tópico encontra-se pendente e só resultará em publicações destituídas das suas devidas datações para o futuro.',
	'LOG_FUTURE_POST_APROVED' => 'Foi dada como devidamente publicada com sucesso uma publicação estipulada no passado ou destituída à indicação de futuro',
]);
