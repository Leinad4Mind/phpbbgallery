<?php

/**
 * Lightbox extension for the phpBB Forum Software package.
 * [English]
 * @copyright (c) 2015 Matt Friedman
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
 */

/**
 * DO NOT CHANGE
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
	'LIGHTBOX_SETTINGS'           => 'Redimensionamento de imagem Lightbox',
	'LIGHTBOX_MAX_WIDTH'          => 'Largura máxima da imagem em pixels',
	'LIGHTBOX_MAX_WIDTH_EXPLAIN'  => 'As imagens que excedam esta largura serão redimensionadas e podem ser ampliadas usando o efeito Lightbox. Define este valor como 0 para desactivar o redimensionamento de imagens por largura.',
	'LIGHTBOX_MAX_WIDTH_APPEND'   => 'Recomendação com base nas configurações de anexo da imagem: %spx',
	'LIGHTBOX_MAX_HEIGHT'         => 'Altura máxima da imagem',
	'LIGHTBOX_MAX_HEIGHT_EXPLAIN' => 'As imagens que excedam esta altura serão redimensionadas e podem ser ampliadas usando o efeito Lightbox. Define este valor como 0 para desactivar o redimensionamento de imagens por altura.',
	'LIGHTBOX_ALL_IMAGES'         => 'Incluir todas as imagens no efeito Lightbox',
	'LIGHTBOX_ALL_IMAGES_EXPLAIN' => 'Com esta opção activada, todas as imagens publicadas podem ser abertas no efeito Lightbox, mesmo que não estejam a ser redimensionadas.',
	'LIGHTBOX_GALLERY'            => 'Modo galeria',
	'LIGHTBOX_GALLERY_EXPLAIN'    => 'Permite navegar facilmente entre imagens redimensionadas usando o efeito Lightbox.',
	'LIGHTBOX_GALLERY_ALL'        => 'Todas as imagens redimensionadas na página',
	'LIGHTBOX_GALLERY_POSTS'      => 'Todas as imagens redimensionadas por mensagem',
	'LIGHTBOX_SIGNATURES'         => 'Redimensionar imagens de assinatura',
	'LIGHTBOX_SIGNATURES_EXPLAIN' => 'Permite que as imagens usadas em assinaturas sejam redimensionadas.',
	'LIGHTBOX_IMG_TITLES'         => 'Mostrar o nome de ficheiro da imagem',
	'LIGHTBOX_IMG_TITLES_EXPLAIN' => 'Os nomes das imagens aparecerão como legenda no efeito Lightbox.',
]);
