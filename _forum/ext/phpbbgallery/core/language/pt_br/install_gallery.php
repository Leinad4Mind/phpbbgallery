<?php

/**
 * @package phpbbgallery/core for phpBB.
 * phpBB Gallery - ACP Core Extension
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
	'GALLERY_BBCODE_CONFLICT' => 'Não é possível instalar o BBCode %s porque essa tag pertence a um BBCode personalizado incompatível. Renomeie ou remova o BBCode personalizado e tente novamente.',
	'GALLERY_BBCODE_LIMIT_REACHED' => 'Não é possível instalar o BBCode %s porque o limite de BBCodes foi atingido. Remova um BBCode e tente novamente.',
	'GALLERY_CORE_ENABLE_SUCCESS' => 'A phpBB Gallery Core foi habilitada. Também estão disponíveis os complementos opcionais ACP Cleanup, ACP Import e EXIF.',
	'GALLERY_REQUIREMENTS_MISSING' => 'Não é possível habilitar a phpBB Gallery. Faltam componentes obrigatórios: %s.',
	'GALLERY_SUB_EXT_UNINSTALL'      => [
		1 => 'Você deve desinstalar a extensão: <br /><strong>%s</strong><br /> antes de desinstalar a extensão principal.',
		2 => 'Você deve desinstalar as extensões: <br /><strong>%s</strong><br /> antes de desinstalar a extensão principal.',
	],
]);
