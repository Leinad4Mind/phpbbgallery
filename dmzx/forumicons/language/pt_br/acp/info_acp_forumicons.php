<?php

/**
 * @package phpBB Extension - Forum Icons for phpBB.
 * @copyright (c) 2015 dmzx - http://www.dmzx-web.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
	'AVAILABLE_FORUM_IMAGE'         => '<strong>Clique numa imagem para selecionar</strong>',
	'AVAILABLE_FORUM_IMAGE_EXPLAIN' => 'As imagens são mostradas com ~50% do tamanho real.',
	'SELECTED_FORUM_IMAGE'          => '<strong>Imagem do fórum selecionada</strong>',
	'CLEAR_BUTTON'                  => 'Limpar imagem do fórum',
]);
