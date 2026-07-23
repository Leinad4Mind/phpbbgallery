<?php

/**
 * Gyazo - forum images uploader
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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

$lang = array_merge($lang, [
	'GYAZO_CLIENT_ID'         => 'Token de Acesso do Gyazo',
	'GYAZO_CLIENT_ID_EXPLAIN' => 'Precisas de registar uma aplicação Gyazo para obteres o <strong>Token de Acesso</strong>.<br /> Para criares uma nova aplicação, vai a <a href="https://gyazo.com/api">https://gyazo.com/api</a>. Depois, introduz aqui o Token de Acesso.',

	'GYAZO_UPLOAD_TITLE' => 'Fazer Upload de uma Imagem',
	'GYAZO_UPLOAD_MAIN'  => 'Faz upload de uma imagem para usares no tópico através do serviço Gyazo. A imagem é automaticamente inserida no campo da mensagem acima assim que for submetida',
	'GYAZO_UPLOAD'       => 'Fazer Upload da Imagem Agora',
	'GYAZO_SELECT'       => 'Selecionar Imagem',
	'GYAZO_COPY'         => 'Copiar',

	'GYAZO_OUTPUT_LINK'         => 'Ligação direta',
	'GYAZO_OUTPUT_IMAGE'        => 'Tag BBcode',
	'GYAZO_OUTPUT_IMAGE_DELETE' => 'Ligação de eliminação',
	'GYAZO_OUTPUT_MARKDOWN'     => 'Markdown',
	'MARKDOWN_WHATIS'           => '<a href="https://themeforest.net/user/themesplat/portfolio?ref=ThemeSplat" title="para uso com a extensão Premium &#34;BBmarkdown&#34; para temas Premium do phpBB" target="_blank"><i class="fa fa-question-circle"></i></a>',
	'GYAZO_OUTPUT_PLACEHOLDER'  => 'A aguardar o upload da imagem...',

	'GYAZO_SIGNATURE' => 'Permitir o uso do upload de imagens Gyazo nas assinaturas dos utilizadores',

	'ALLOW_GYAZO'                 => 'Permitir avatares Gyazo',
	'AVATAR_DRIVER_GYAZO_TITLE'   => 'Avatar Gyazo',
	'AVATAR_DRIVER_GYAZO_EXPLAIN' => '',
	'GYAZO_AVATAR'                => 'Avatar Gyazo',

	'GYAZO_QUICKREPLY' => 'Permitir o Gyazo na Resposta Rápida Snappy',

]);
