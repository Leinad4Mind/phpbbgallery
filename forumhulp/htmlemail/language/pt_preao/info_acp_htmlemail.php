<?php

/**
 * HTML email extension for the phpBB Forum Software package.
 * @copyright (c) 2015 ForumHulp.com <http://forumhulp.com>
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
// ’ « » “ ” …
//

$lang = array_merge($lang, [
	'FH_HELPER_NOTICE'   => 'A aplicação ajudante forumhulp não existe!<br />Transfere <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> e copia a pasta helper para a pasta da tua extensão forumhulp.',
	'HTML_EMAIL_NOTICE'  => '<div class="phpinfo"><p class="entry">A configuração desta extensão não é necessária.<br />Podes usá-la para a extensão email on birthday activando "usar html no email" em Funcionalidades do Fórum. Se quiseres usar html noutros emails, tens de indicar ao mensageiro que deve enviar emails html configurando o mensageiro com $messenger->set_mail_html(true). Actualiza os teus modelos de email como desejares.</p></div>',
	'DELETE_DATA_NOTICE' => '<div style="width:80%;margin:20px auto;"><p style="text-align:left;">Nem todos os ficheiros são substituídos! Por favor substitui manualmente o(s) ficheiro(s) mencionado(s) no registo de Administração</p></div>',
	'ENABLE_DATA_NOTICE' => '<div style="width:80%;margin:20px auto;"><p style="text-align:left;"><br />No entanto, nem todas as actualizações são feitas correctamente devido a permissões de ficheiros ou ficheiros em falta. Vê o registo de administração para uma visão geral.<br /><br />Por favor actualiza os ficheiros manualmente para usufruíres de todas as funções!</p></div>'
]);
