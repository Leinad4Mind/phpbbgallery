<?php
/**
*
* Contact admin extension for the phpBB Forum Software package.
*
* @copyright 2016 Rich McGirr (RMcGirr83)
* @license GNU General Public License, version 2 (GPL-2.0)
*
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
	'ACP_CAT_CONTACTADMIN'		=> 'Contactar Administração',
	'ADD_ATTACHMENT_EXPLAIN'	=> 'If you wish to attach a file enter the details below.',
	'CONTACT_ERROR'			=> 'You can’t use the contact form at the moment because there is an error in the configuration.  An email has been sent to the founder.',
	'CONTACT_NONE'			=> 'The user %1$s tried to use the Contact Admin extension at %2$s to send a %3$s, but there are no Administrators that allow %3$ss by users. Please enter the Contact Admin Configuration in the Admin Extension Panel for the board %4$s and choose a different method for contact',
	'CONTACT_BOT_SUBJECT'		=> 'Erro na Extensão Contactar Administração',
	'CONTACT_BOT_MESSAGE'	=> 'The user %1$s tried to use the Contact Admin extension at %2$s, but the %3$s selected in the configuration is incorrect. Please visit the board %4$s and choose a different %3$s in the settings for the Contact Administration Extension.',
	'CONTACT_CONFIRM'			=> 'Confirmar',
	'CONTACT_DISABLED'			=> 'Não podes utilizar o formulário de momento porque o mesmo não se encontra ativo.',
	'CONTACT_MAIL_DISABLED'		=> 'There is an error with the configuration of the Contact  Admin extension. The extension is set to send an email but the board configuration isn’t setup to send emails.  Please notify the %sBoard Administrator%s',
	'CONTACT_MSG_SENT'			=> 'A tua mensagem foi enviada com sucesso',
	'CONTACT_NO_MSG'			=> 'Não escreveste nenhuma mensagem.',
	'CONTACT_NO_SUBJ'			=> 'Não colocaste nenhum assunto',
	'CONTACT_REASON'			=> 'Reason',
	'CONTACT_TEMPLATE'			=> '[b]Nome:[/b] %1$s' . "\n" . '[b]Endereço de E-mail:[/b] %2$s' . "\n" . '[b]IP:[/b] %3$s' . "\n" . '[b]Assunto:[/b] %4$s' . "\n" . '[b]Escreveu a seguinte mensagem:[/b] %5$s',
	'CONTACT_TITLE'				=> 'Contactar Administração',

	'CONTACT_YOUR_NAME'			=> 'O teu nome',
	'CONTACT_YOUR_NAME_EXPLAIN'	=> 'Por favor, introduz o teu nome, para que a tua mensagem corresponda a alguém.',
	'CONTACT_YOUR_EMAIL'		=> 'O teu e-mail',
	'CONTACT_YOUR_EMAIL_EXPLAIN'	=> 'Por favor, introduz um endereço de e-mail válido, para que te possamos contactar.',
	'CONTACT_YOUR_EMAIL_CONFIRM'	=> 'Confirma o teu e-mail',
	'WRONG_DATA_EMAIL'			=> 'Os endereços de e-mail não coincidem',

	'TOO_MANY_CONTACT_TRIES'	=> 'Excedeste o número de tentativas nesta sessão. Por favor, tenta mais tarde.',
	'CONTACT_NO_NAME'			=> 'Não inseriste um nome',
	'FORUM'						=> 'fórum',
	'USER'						=> 'utilizador',
	'CONTACT_REGISTERED'		=> 'Utilizador Registado',
	'CONTACT_GUEST'				=> 'Visitante',

	'REASON_EXPLAIN'			=> 'Por favor, escolhe uma razão',
	'REASON_ERROR'				=> 'Por favor, escolhe uma razão válida.',
	'RETURN_CONTACT'			=> '%sRegressar para a página de contacto%s',
	'CONTACT_PRIVACYPOLICY'				=> 'Política de Privacidade',
	'CONTACT_PRIVACYPOLICY_EXPLAIN'		=> 'Aceito que o nome, endereço de e-mail, mensagem e o endereço de IP providenciados serão processados e armazenados pela comunidade de acordo com a <a target="_blank" title="Link da Política de Privacidade" href="%s">Política de Privacidade</a>',
	'CONTACT_PRIVACYPOLICY_ERROR'		=> 'Por favor, aceita as condições da Política de Privacidade. Sem essa confirmação, não poderás submeter a tua mensagem.',
]);
