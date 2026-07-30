<?php

/**
 * @package phpbbgallery/core for phpBB.
 * phpBB Gallery - ACP Core Extension
 * @author    satanasov
 * @author    Leinad4Mind
 * @copyright 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
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
	'GALLERY_BBCODE_CONFLICT' => 'Não é possível instalar o BBCode %s porque essa etiqueta pertence a um BBCode personalizado incompatível. Altera o nome ou remove o BBCode personalizado e tenta novamente.',
	'GALLERY_BBCODE_LIMIT_REACHED' => 'Não é possível instalar o BBCode %s porque foi atingido o limite de BBCodes. Remove um BBCode e tenta novamente.',
	'GALLERY_CORE_ENABLE_SUCCESS' => 'A phpBB Gallery Core foi activada. Também estão disponíveis os add-ons opcionais ACP Cleanup, ACP Import e EXIF.',
	'GALLERY_CORE_ENABLE_BBCODE_FALLBACK' => 'A phpBB Gallery Core foi activada. O BBCode [image] existente foi preservado por pertencer a outra definição; a Galeria utilizará [galleryimage] em conteúdo novo. [album] permanece oculto apenas para apresentar mensagens antigas e nunca será gerado.',
	'GALLERY_REQUIREMENTS_MISSING' => 'Não é possível activar a phpBB Gallery. Faltam componentes obrigatórios: %s.',
	'GALLERY_SUB_EXT_UNINSTALL'      => [
		1 => 'Tem de desinstalar a extensão: <br /><strong>%s</strong><br /> antes de desinstalar a extensão principal.',
		2 => 'Tem de desinstalar as extensões: <br /><strong>%s</strong><br /> antes de desinstalar a extensão principal.',
	],
]);
