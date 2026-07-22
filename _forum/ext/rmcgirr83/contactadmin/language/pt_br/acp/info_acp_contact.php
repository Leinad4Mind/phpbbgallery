<?php
/**
*
* Contact admin extension for the phpBB Forum Software package.
*
* @copyright 2016 Rich McGirr (RMcGirr83)
* @license GNU General Public License, version 2 (GPL-2.0)
* @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
*
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
// Some characters for use
// ’ » “ ” …


$lang = array_merge($lang, [
	// General config options
	'ACP_CAT_CONTACTADMIN'    => 'Contact Admin',
	'ACP_CONTACTADMIN_CONFIG' => 'Configuração',
	'FORUM_EMAIL_INACTIVE'    => 'Como você deseja que os usuários consigam entrar em contato.<br><span style="color:red;">Não é permitido e-mail de acordo com as configurações do fórum</span>',
	'NO_FORUM_ATTACHMENTS'    => 'Se definido, os anexos serão permitidos na publicação no fórum e em mensagens privadas. As extensões permitidas são as mesmas da configuração do fórum.<br><span style="color:red;">Não são permitidos anexos de acordo com as configurações do fórum!</span>',
	// Log entries
	'LOG_CONFIG_CONTACT_ADMIN' => '<strong>Alteradas as configurações da página da extensão Contact Admin</strong>',
	'LOG_CONTACT_BOT_INVALID'  => '<strong>O bot da extensão Contact Admin tem um ID de usuário inválido selecionado:</strong><br />ID de Usuário %1$s',
	'LOG_CONTACT_FORUM_INVALID' => '<strong>O fórum da extensão Contact Admin tem um fórum inválido selecionado:</strong><br />ID de Fórum %1$s',
	'LOG_CONTACT_EMAIL_INVALID' => '<strong>A extensão Contact Admin está permitindo e-mails, mas o fórum não está configurado para permitir e-mails. A extensão foi desabilitada.',
	'LOG_CONTACT_NONE'          => '<strong>Nenhum Administrador está permitindo que os usuários entrem em contato via %1$s na extensão Contact Admin</strong>',
	'LOG_CONTACT_CONFIG_UPDATE' => '<strong>Configurações do Contact Admin atualizadas</strong>',
	//Donation
	'PAYPAL_IMAGE_URL'      => 'https://www.paypalobjects.com/webstatic/en_US/i/btn/png/silver-pill-paypal-26px.png',
	'PAYPAL_ALT'            => 'Doe através do PayPal',
	'BUY_ME_A_BEER_URL'     => 'https://paypal.me/RMcGirr83',
	'BUY_ME_A_BEER'         => 'Me pague uma cerveja por criar esta extensão',
	'BUY_ME_A_BEER_SHORT'   => 'Faça uma doação para esta extensão',
	'BUY_ME_A_BEER_EXPLAIN' => 'Esta extensão é completamente gratuita. É um projeto ao qual dedico meu tempo, pelo gosto e para o uso da comunidade phpBB. Se você gosta de usar esta extensão, ou se ela beneficiou seu fórum, por favor considere <a href="https://paypal.me/RMcGirr83" target="_blank" rel="noreferrer noopener">me pagar uma cerveja</a>. Seria muito apreciado. <i class="fa fa-smile-o" style="color:green;font-size:1.5em;" aria-hidden="true"></i>',
]);
