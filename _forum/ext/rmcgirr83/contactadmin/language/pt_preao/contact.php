<?php

/**
 * Contact admin extension for the phpBB Forum Software package.
 * @copyright 2016 Rich McGirr (RMcGirr83)
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
// ’ » “ ” …
//

$lang = array_merge($lang, [
	'CONTACT_ADM'           => 'Contacte-nos',
	'CONTACT_BOT_SUBJECT'   => 'Mensagem de Contacto',
	'CONTACT_CONFIRM'       => 'Confirmar',
	'CONTACT_DISABLED'      => 'Não pode usar o formulário de contacto neste momento porque o mesmo encontra-se desactivado.',
	'CONTACT_MAIL_DISABLED' => 'Existe um erro com a configuração da extensão Contact Admin. A extensão está definida para enviar um e-mail, mas a configuração do fórum não permite envio de e-mails. Por favor avise o %sAdministrador do Fórum%s',
	'CONTACT_MSG_SENT'      => 'A sua mensagem foi enviada com sucesso',
	'CONTACT_NO_MSG'        => 'Não introduziu uma mensagem',
	'CONTACT_NO_SUBJ'       => 'Não introduziu um assunto',
	'CONTACT_REASON'        => 'Razão',
	'CONTACT_TEMPLATE'      => '[b]Nome:[/b] %1$s' . "\n" . '[b]Endereço de E-mail:[/b] %2$s' . "\n" . '[b]IP:[/b] %3$s' . "\n" . '[b]Assunto:[/b] %4$s' . "\n" . '[b]Introduziu a seguinte mensagem no formulário de contacto:[/b] %5$s',
	'CONTACT_TITLE'         => 'Contacto Administrativo',

	'CONTACT_YOUR_NAME'          => 'O seu nome',
	'CONTACT_YOUR_NAME_EXPLAIN'  => 'Por favor, introduza o seu nome, para a mensagem possuir uma identidade.',
	'CONTACT_YOUR_EMAIL'         => 'O seu endereço de e-mail',
	'CONTACT_YOUR_EMAIL_EXPLAIN' => 'Por favor, forneça o seu endereço de e-mail, para que possamos contactá-lo.',
	'CONTACT_YOUR_EMAIL_CONFIRM' => 'Confirmar o endereço de e-mail',
	'WRONG_DATA_EMAIL'           => 'Os endereços de e-mail não coincidem',

	'TOO_MANY_CONTACT_TRIES' => 'Excedeu o número máximo de tentativas na presente sessão. Por favor, tente de novo mais tarde.',
	'CONTACT_NO_NAME'        => 'Não introduziu um nome',
	'FORUM'                  => 'fórum',
	'USER'                   => 'utilizador',
	'CONTACT_REGISTERED'     => 'Utilizador Registado',
	'CONTACT_GUEST'          => 'Utilizador Visitante',

	'REASON_EXPLAIN'                => 'Por favor, escolha uma razão',
	'REASON_ERROR'                  => 'Por favor, escolha uma razão apropriada',
	'RETURN_CONTACT'                => '%sVoltar à página de contactos%s',
	'CONTACT_PRIVACYPOLICY'         => 'Política de privacidade',
	'CONTACT_PRIVACYPOLICY_EXPLAIN' => 'Confirmo que o nome fornecido, endereço de e-mail, texto da mensagem e o meu endereço de IP vão ser processados e retidos sob alçada do administrador do fórum, em estrita conformidade com a <a target="_blank" title="Ligação à Política de Privacidade" href="%s">Política de Privacidade</a>',
	'CONTACT_PRIVACYPOLICY_ERROR'   => 'Por favor, marque a caixa da política de privacidade. Sem a sua devida confirmação não será capaz de nos enviar nenhuma mensagem.',
]);
