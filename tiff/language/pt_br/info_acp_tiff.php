<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
if (empty($lang) || !is_array($lang))
{
	$lang = [];
}
$lang = array_merge($lang, [
	'ACP_GALLERY_TIFF'                      => 'Imagens TIFF',
	'ACP_GALLERY_TIFF_EXPLAIN'              => 'Aceita originais TIFF e gera imagens médias e miniaturas privadas em WebP a partir do primeiro frame.',
	'ACP_GALLERY_TIFF_SETTINGS'             => 'Configurações TIFF',
	'ACP_GALLERY_TIFF_ENABLE'               => 'Permitir envios TIFF',
	'ACP_GALLERY_TIFF_ENABLE_EXPLAIN'       => 'Permite arquivos .tif e .tiff nos envios normais, arquivos ZIP e substituições de imagens. As imagens TIFF existentes permanecem acessíveis quando esta opção está desativada.',
	'ACP_GALLERY_TIFF_WEBP_QUALITY'         => 'Qualidade dos derivados WebP',
	'ACP_GALLERY_TIFF_WEBP_QUALITY_EXPLAIN' => 'Qualidade de 1 a 100 usada nas imagens médias e miniaturas. Os originais TIFF não são convertidos, exceto quando os limites da Galeria exigem uma transformação.',
	'ACP_GALLERY_TIFF_UPDATED'              => 'As configurações TIFF foram atualizadas.',
	'GALLERY_TIFF_IMAGICK_REQUIRED'         => 'O add-on TIFF requer a extensão PHP Imagick com suporte para leitura de TIFF e gravação de WebP.',
]);
