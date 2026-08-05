<?php
/**
 *
 * @package phpBB Extension - Forum Icons
 * @copyright (c) 2015 dmzx - https://www.dmzx-web.net
 * @license https://opensource.org/license/gpl-2-0 GNU General Public License v2
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
 *
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
	'AVAILABLE_FORUM_IMAGE'             => 'Imagens disponíveis para o fórum',
	'AVAILABLE_FORUM_IMAGE_EXPLAIN'     => 'Seleciona uma imagem PNG ou GIF. As pré-visualizações são ajustadas a 32 × 32 píxeis.',
	'SELECTED_FORUM_IMAGE'              => 'Imagem do fórum selecionada',
	'CLEAR_BUTTON'                      => 'Limpar imagem do fórum',
	'FORUMICONS_DIRECTORY_UNAVAILABLE' => 'A diretoria images/forumicons não existe ou não pode ser lida.',
	'FORUMICONS_NO_IMAGES'              => 'Não foram encontradas imagens PNG ou GIF na diretoria images/forumicons.',
	'FORUMICONS_LIMIT_REACHED'          => 'Apenas são mostradas as primeiras 500 imagens válidas. Remove os ficheiros que não sejam necessários para mostrar as restantes.',
]);
