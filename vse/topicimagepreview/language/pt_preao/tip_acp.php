<?php

/**
 * Topic Image Preview. An extension for the phpBB Forum Software package.
 * @copyright (c) 2017, 2020, Matt Friedman
 * @license GNU General Public License, version 2 (GPL-2.0)
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
	'ACP_TIP_TITLE'               => 'Topic Image Preview',
	'ACP_TIP_DISPLAY_AGE'         => 'Exibir imagens de',
	'ACP_TIP_DISPLAY_AGE_EXPLAIN' => 'Selecciona "Mensagem mais recente" para exibir as imagens publicadas mais recentemente. Caso contrário, selecciona "Mensagem mais antiga" para exibir as imagens publicadas mais antigas.',
	'ACP_TIP_NEWEST_POST'         => 'Mensagem mais recente',
	'ACP_TIP_OLDEST_POST'         => 'Mensagem mais antiga',
	'ACP_TIP_DISPLAY_NUM'         => 'Número de imagens a exibir',
	'ACP_TIP_DISPLAY_NUM_EXPLAIN' => 'Número máximo de imagens a exibir nas pré-visualizações. Define como 0 para desactivar as pré-visualizações.',
	'ACP_TIP_DISPLAY_DIM_MIN'     => 'Tamanho máximo da imagem na pré-visualização pequena',
	'ACP_TIP_DISPLAY_DIM_MAX'     => 'Tamanho máximo da imagem na pré-visualização grande em popup',
	'ACP_TIP_DISPLAY_DIM_EXPLAIN' => 'Largura/altura máxima de cada imagem na pré-visualização.',
	'ACP_TIP_DISPLAY_SRT'         => 'Exibir nos tópicos dos resultados de pesquisa',
	'ACP_TIP_DISPLAY_PST'         => 'Exibir em tópicos semelhantes',
]);
