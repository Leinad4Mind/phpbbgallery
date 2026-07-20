<?php

/**
 * @package Forumhulp Helper for phpBB.
 * @copyright (c) 2015 ForumHulp.com
 * @license Proprietary
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

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge(
	$lang, [
		'UCP_IR'                    => 'Redimensionador de Imagens',
		'IMAGE_RESIZE'              => 'Redimensionar Imagem',
		'IMAGE_RESIZE_EXPLAIN'      => 'Recorte o seu %1$s da imagem e confirme.',
		'IMAGE_RESIZE_ERROR'        => 'Nenhuma aplicação ou arquivo para enviar!',
		'IMAGERESIZE_NOTICE'        => '<div class="phpinfo"><p class="entry">Este módulo está oculto e não tem opções de configuração. No entanto, lembramos que deve definir o upload máximo no ACP.</p></div>',
		'ERROR_IMAGERESIZE_DISABLE' => 'Não pode desabilitar o Redimensionar Imagem devido a extensões ativas<br /><div class="phpinfo">» %s</div>',
		'FH_HELPER_NOTICE'          => 'A aplicação ajudante forumhulp não existe!<br />Descarregue <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> e copie a pasta helper para a pasta da sua extensão forumhulp.',
	]
);
