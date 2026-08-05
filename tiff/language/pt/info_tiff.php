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
	'GALLERY_CORE_NOT_FOUND'        => 'O Core da phpBB Gallery tem de estar instalado e activado primeiro.',
	'GALLERY_TIFF_IMAGICK_REQUIRED' => 'O add-on TIFF requer a extensão PHP Imagick com suporte para leitura de TIFF e escrita de WebP.',
]);
