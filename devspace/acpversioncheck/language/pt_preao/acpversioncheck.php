<?php

/**
 * @package ACP Version Check for phpBB.
 * @copyright (c) 2022 devspace
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

/**
 * DEVELOPERS PLEASE NOTE
 *
 * All language files should use UTF-8 as their encoding and the files must not contain a BOM.
 *
 * Placeholders can now contain order information, e.g. instead of
 * 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
 * translators to re-order the output of data while ensuring it remains correct
 *
 * You do not need this where single placeholders are used, e.g. 'Message %d' is fine
 * equally where a string contains only two placeholders which are used to wrap text
 * in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
 *
 * Some characters you may want to copy&paste:
 * ’ » “ ” …
 *
 */

$lang = array_merge($lang, [
	'CONSTANT_VERSION'   => 'Versão do phpBB em "includes/constants.php"',
	'DATABASE_VERSION'   => 'Versão do phpBB reportada pela base de dados',
	'HIDE'               => '« ocultar detalhes »',
	'LANG_NAME'          => 'Idiomas',
	'LANG_VERSION'       => 'Versão do idioma',
	'MISSING'            => '« Dados em falta »',
	'NOT_VALID_LANG'     => 'Não é um pacote de idioma válido para phpBB4',
	'NOT_VALID_STYLE'    => 'Não é um estilo válido para phpBB4',
	'PHPBB'              => 'phpBB',
	'PHPBB_VERSION'      => 'Versão do phpBB',
	'STYLE_NAME'         => 'Estilos',
	'STYLE_VERSION'      => 'Versão do estilo',
	'SYMFONY_VERSION'    => 'Versão Symfony',
	'TWIG_VERSION'       => 'Versão Twig',
	'VENDOR'             => 'Vendor',
	'VENDOR_VERSION'     => 'Versão do Vendor',
	'VERSION'            => 'Versão',
	'VERSION_INFO'       => 'Informação da versão',
	'VERSIONS_CORRECT'   => 'Todas as versões do phpBB neste fórum são consistentes.',
	'VERSIONS_INCORRECT' => 'Existem inconsistências com as versões do phpBB neste fórum',
	'VIEW'               => '« ver detalhes »',
]);
