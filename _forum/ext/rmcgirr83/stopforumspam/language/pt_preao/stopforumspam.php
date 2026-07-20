<?php

/**
 * Stop forum Spam extension for the phpBB Forum Software package.
 * @copyright (c) 2015 Rich McGirr (RMcGirr83)
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
// Some characters you may want to copy&paste:
// ’ » “ ” …

$lang = array_merge($lang, [
	'CANNOT_REPORT_ANONYMOUS'    => 'Não tem permissão para reportar a conta anónima.',
	'CANNOT_REPORT_ADMINS_MODS'  => 'Não pode reportar administradores ou moderadores deste fórum.',
	'FORUM_NOT_EXIST'            => 'O fórum selecionado não existe.',
	'INFO_NOT_FOUND'             => 'A combinação do ID do autor e o ID da publicação não existe.',
	'POST_NOT_EXIST'             => 'A publicação solicitada não existe.',
	'NO_SOUP_FOR_YOU'            => 'Sem sopa para si! Parece que foi sinalizado como spammer.<br>Se acha que esta decisão foi um erro %scontacte o administrador do fórum%s.',
	'NO_SOUP_FOR_YOU_NO_CONTACT' => 'Sem sopa para si! Parece que foi sinalizado como spammer.',
	'PM_NOT_EXIST'               => 'A MP não existe',
	'SFS_ANONYMIZED_IP'          => 'O IP do utilizador foi anonimizado, definido para 127.0.0.1, provavelmente devido a uma extensão.',
	'SFS_MISSING_DATA'           => 'Nem todas as informações foram fornecidas para reportar ao Stop Forum Spam.',
	'SFS_IP_STOPPED'             => '<a target="_blank" title="Verificar IP no StopForumSpam.com (abre numa nova janela)" href="http://www.stopforumspam.com/ipcheck/%1$s" rel="noreferrer noopener">%1$s</a>',
	'SFS_USERNAME_STOPPED'       => '<a target="_blank" title="Verificar Nome de Utilizador no StopForumSpam.com (abre numa nova janela)" href="http://www.stopforumspam.com/search/?q=%1$s" rel="noreferrer noopener">%1$s</a>',
	'SFS_EMAIL_STOPPED'          => '<a target="_blank" title="Verificar E-mail no StopForumSpam.com (abre numa nova janela)" href="http://www.stopforumspam.com/search/?q=%1$s" rel="noreferrer noopener">%1$s</a>',
	'SFS_FREQUENCY'              => ' » encontrado na base de dados SFS %d vezes',
	'SFS_IP_STOPPED'             => '<a target="_blank" title="Verificar IP no StopForumSpam.com (abre numa nova janela)" href="http://www.stopforumspam.com/ipcheck/%1$s" rel="noreferrer noopener">%1$s</a>',
	'SFS_USERNAME_STOPPED'       => '<a target="_blank" title="Verificar Nome de Utilizador no StopForumSpam.com (abre numa nova janela)" href="http://www.stopforumspam.com/search/?q=%1$s" rel="noreferrer noopener">%1$s</a>',
	'SFS_EMAIL_STOPPED'          => '<a target="_blank" title="Verificar E-mail no StopForumSpam.com (abre numa nova janela)" href="http://www.stopforumspam.com/search/?q=%1$s" rel="noreferrer noopener">%1$s</a>',
	'SFS_ERROR_MESSAGE'          => 'Infelizmente não podemos processar o seu pedido agora devido a problemas com uma entidade externa. Pode tentar novamente mais tarde.',
	'SFS_BANNED'                 => [
		1 => 'Encontrado na base de dados do Stop Forum Spam uma vez',
		2 => 'Encontrado na base de dados do Stop Forum Spam %d vezes',
	],
	'SFS_USER_BANNED'           => 'Banido devido a uma publicação no fórum',
	'SFS_REPORTED'              => 'A publicação já foi reportada',
	'SFS_PM_REPORTED'           => 'A MP já foi reportada',
	'REPORT_TO_SFS'             => 'Reportar ao Stop Forum Spam',
	'BUTTON_SFS'                => 'Reportar ao SFS',
	'SFS_SUCCESS_MESSAGE'       => 'O utilizador foi reportado com sucesso à base de dados stop forum',
	'SFS_WAS_REPORTED'          => 'A publicação foi reportada ao Stop Forum Spam',
	'SFS_PM_WAS_REPORTED'       => 'A MP foi reportada ao Stop Forum Spam',
	'SFS_PM_REPORT_NOT_ALLOWED' => 'O reporte não é permitido',
	'SFS_NEED_CURL'             => 'A extensão necessita de cURL que parece não estar instalado',
	'EXTENSION_REQUIREMENTS'    => 'A extensão requer pelo menos a versão %1$s do phpBB. Precisa de actualizar a sua versão do phpBB para utilizar esta extensão.',
	'CURL_REQUIREMENTS'         => 'A extensão requer que o cURL esteja instalado e compilado com um certificado SSL válido neste servidor',
	'CURL_ERROR'                => 'Erro de cURL',
	'INVALID_IP_ADDRESS'        => 'Endereço IP inválido',
	'SFS_CONFIRM'               => 'Reportar à base de dados stop forum?',
	'SFS_SUCCESS'               => 'Stop forum spam reportado com sucesso',
	'SFS_OPERATION_CANCELED'    => 'Operação cancelada',
	'SFS_NOT_CHECKED'           => ' » <em>O parâmetro não foi verificado de acordo com as configurações da extensão</em>',
]);
