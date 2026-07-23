<?php

/**
 * Imgur - forum images uploader
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
	'IMGUR_CLIENT_ID'         => 'ID de Cliente do IMGUR',
	'IMGUR_CLIENT_ID_EXPLAIN' => 'Precisas de registar uma aplicação Imgur para obteres o <strong>ID de Cliente</strong>.<br /> Para criares uma nova aplicação, vai a <a href="https://api.imgur.com/oauth2/addclient" target="_blank">esta página</a>. Depois, introduz aqui o ID de Cliente.',

	'IMGUR_UPLOAD_TITLE' => 'Fazer Upload de uma Imagem',
	'IMGUR_UPLOAD_MAIN'  => 'Faz upload de uma imagem para usares no tópico através do serviço <a href="https://imgur.com" target="_blank">IMGUR</a>. A imagem é automaticamente inserida no campo da mensagem acima assim que for submetida',
	'IMGUR_UPLOAD'       => 'Fazer Upload da Imagem Agora',
	'IMGUR_SELECT'       => 'Selecionar Imagem',
	'IMGUR_COPY'         => 'Copiar',

	'IMGUR_OUTPUT_LINK'         => 'Ligação direta',
	'IMGUR_OUTPUT_IMAGE'        => 'Tag BBcode',
	'IMGUR_OUTPUT_IMAGE_DELETE' => 'Ligação de eliminação',
	'IMGUR_OUTPUT_MARKDOWN'     => 'Markdown',
	'MARKDOWN_WHATIS'           => '<a href="https://themeforest.net/user/themesplat/portfolio?ref=ThemeSplat" title="para uso com a extensão Premium &#34;BBmarkdown&#34; para temas Premium do phpBB" target="_blank"><i class="fa fa-question-circle"></i></a>',
	'IMGUR_OUTPUT_PLACEHOLDER'  => 'A aguardar o upload da imagem...',

	'IMGUR_SIGNATURE' => 'Permitir o uso do upload de imagens IMGUR nas assinaturas dos utilizadores',

	'ALLOW_IMGUR'                 => 'Permitir avatares IMGUR',
	'AVATAR_DRIVER_IMGUR_TITLE'   => 'Avatar IMGUR',
	'AVATAR_DRIVER_IMGUR_EXPLAIN' => '',
	'IMGUR_AVATAR'                => 'Avatar IMGUR',

	'IMGUR_QUICKREPLY' => 'Permitir o IMGUR na Resposta Rápida Snappy',

]);
