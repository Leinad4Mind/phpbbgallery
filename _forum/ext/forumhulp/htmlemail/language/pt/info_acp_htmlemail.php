<?php

/**
 * HTML email extension for the phpBB Forum Software package.
 * @copyright (c) 2015 ForumHulp.com <http://forumhulp.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
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
// ’ « » “ ” …
//

$lang = array_merge($lang, [
	'FH_HELPER_NOTICE'   => 'A aplicação ajudante forumhulp não existe!<br />Descarregue <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> e copie a pasta helper para a pasta da sua extensão forumhulp.',
	'HTML_EMAIL_NOTICE'  => '<div class="phpinfo"><p class="entry">A configuração desta extensão não é necessária.<br />Pode usá-la para a extensão email on birthday ativando "usar html no email" em Funcionalidades do Fórum. Se quiser usar html noutros emails, tem de indicar ao mensageiro que deve enviar emails html configurando o mensageiro com $messenger->set_mail_html(true). Atualize os seus modelos de email como desejar.</p></div>',
	'DELETE_DATA_NOTICE' => '<div style="width:80%;margin:20px auto;"><p style="text-align:left;">Nem todos os ficheiros são substituídos! Por favor substitua manualmente o(s) ficheiro(s) mencionado(s) no registo de Administração</p></div>',
	'ENABLE_DATA_NOTICE' => '<div style="width:80%;margin:20px auto;"><p style="text-align:left;"><br />No entanto, nem todas as atualizações são feitas corretamente devido a permissões de ficheiros ou ficheiros em falta. Veja o registo de administração para uma visão geral.<br /><br />Por favor atualize os ficheiros manualmente para usufruir de todas as funções!</p></div>'
]);
