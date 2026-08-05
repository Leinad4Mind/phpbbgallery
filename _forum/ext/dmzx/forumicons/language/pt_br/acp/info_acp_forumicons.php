<?php
/**
 *
 * @package phpBB Extension - Forum Icons
 * @copyright (c) 2015 dmzx - https://www.dmzx-web.net
 * @license https://opensource.org/license/gpl-2-0 GNU General Public License v2
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
	'AVAILABLE_FORUM_IMAGE_EXPLAIN'     => 'Selecione uma imagem PNG ou GIF. As pré-visualizações são ajustadas a 32 × 32 pixels.',
	'SELECTED_FORUM_IMAGE'              => 'Imagem do fórum selecionada',
	'CLEAR_BUTTON'                      => 'Limpar imagem do fórum',
	'FORUMICONS_DIRECTORY_UNAVAILABLE' => 'O diretório images/forumicons não existe ou não pode ser lido.',
	'FORUMICONS_NO_IMAGES'              => 'Nenhuma imagem PNG ou GIF foi encontrada no diretório images/forumicons.',
	'FORUMICONS_LIMIT_REACHED'          => 'Somente as primeiras 500 imagens válidas são exibidas. Remova os arquivos desnecessários para exibir as restantes.',
]);
