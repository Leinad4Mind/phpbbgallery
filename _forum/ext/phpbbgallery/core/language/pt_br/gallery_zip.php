<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
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
	'ZIP_COMPRESSION_RATIO_EXCEEDED' => 'O arquivo ZIP contém uma entrada com uma taxa de compactação insegura.',
	'ZIP_DUPLICATE_PATH'              => 'O arquivo ZIP contém caminhos de arquivo duplicados.',
	'ZIP_EXTENSION_NOT_AVAILABLE'     => 'O upload de arquivos ZIP requer a extensão Zip do PHP.',
	'ZIP_EXTRACTION_FAILED'           => 'Não foi possível extrair o arquivo ZIP com segurança.',
	'ZIP_INVALID_ARCHIVE'             => 'O arquivo ZIP enviado é inválido ou não pode ser lido.',
	'ZIP_INVALID_IMAGE_TYPE'          => 'O arquivo “%s” no arquivo ZIP não é uma imagem válida do tipo declarado.',
	'ZIP_NO_IMAGES'                   => 'O arquivo ZIP não contém imagens permitidas.',
	'ZIP_SIZE_LIMIT_EXCEEDED'         => 'O arquivo ZIP excede o tamanho de extração permitido.',
	'ZIP_TOO_MANY_ENTRIES'            => 'O arquivo ZIP contém mais de %d entradas.',
	'ZIP_TOO_MANY_IMAGES'             => 'O arquivo ZIP contém mais de %d imagens permitidas.',
	'ZIP_UNSAFE_PATH'                 => 'O arquivo ZIP contém um caminho de arquivo inseguro.',
]);
