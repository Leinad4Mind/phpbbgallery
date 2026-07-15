<?php
/**
*
* @package Two Factor Authentication
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
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
	$lang = array();
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
	$lang, array(
		'TFA_NO_KEYS'				=> 'N\A',
		'TFA_NO_KEY_FOUND'			=> 'Nenhuma chave de autenticação por 2 factores encontrada. Transfere a app Google Authenticator no teu dispositivo móvel e associa a conta ao inserir uma nova chave. <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="blank"><i class="fa fa-android"></i> Android</a> &#47; <a href="https://itunes.apple.com/ca/app/google-authenticator/id388497605" target="blank"><i class="fa fa-apple"></i> Apple</a>',
		'TFA_KEYS'					=> 'Nesta página, podes gerir as tuas chaves de autenticação por dois fatores. Se perderes as tuas chaves, remove-as do teu autenticador! Podes redefinir a tua chave com o método de esquecer a senha, onde depois poderás efetuar login novamente e criar uma nova chave.',
		'TFA_NO_MODE'				=> 'Nenhum Modo',
		'TFA_KEYS_DELETED'			=> 'Chaves selecionadas removidas.',
		'TFA_NEW'                   => 'Adicionar nova chave',
		'TFA_ERROR'					=> 'Ocorreu um erro...',
		'TFA_REG_FAILED'			=> 'Registo falhou com o seguinte erro: ',
		'TFA_REG_EXISTS'			=> 'A chave providenciada já tinha sido associada à tua conta',
		'TFA_ADD_KEY'				=> 'Registar nova chave',
		'TFA_KEY_ADDED'				=> 'A tua chave de segurança foi adicionada e poderá ser usada.',
		'TFA_INSERT_KEY'			=> 'Introduz a tua chave de segurança, e clica no botão da chave',
		'TFA_REGISTERED'			=> 'Chave registada',
		'TFA_LAST_USED'				=> 'Última vez que a chave foi usada',
		'TFA_LOGIN_FROM'			=> 'Último login por',
		'TFA_MODULE_NOT_FOUND'		=> 'O módulo selecionado (%s) não foi encontrado',
		'TFA_MODULE_NO_REGISTER'	=> 'O módulo selecionado não aceita o registo de novas chaves',
		'TFA_SELECT_NEW'			=> 'Adicionar nova chave OTP',
		'TFA_ADD_NEW_OTP_KEY'		=> 'Adicionar uma nova chave OTP à tua conta',
		'TFA_ADD_OTP_KEY_MAIN'	    => 'Digitaliza o Código QR com a App Google Authenticator para <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="blank"><i class="fa fa-android"></i> Android</a> &#47; <a href="https://itunes.apple.com/ca/app/google-authenticator/id388497605" target="blank"><i class="fa fa-apple"></i> Apple</a>, ou podes usar a chave gerada em baixo.<br /> De seguida, introduz o código que a tua app Authenticator te vai providenciar para assim a associares à tua conta.',
		'TFA_OTP_KEY'				=> 'Gera a chave aqui e clica em submeter',
		'TFA_ADD_OTP_KEY_EXPLAIN'	=> '<span>%s</span>',
		'TFA_OTP_INVALID_KEY'		=> 'Chave providenciada errada.',
		'TFA_KEYTYPE'				=> 'Tipo da chave',
		'TFA_KEY_NOT_USED'			=> 'Ainda não foi usada',
	)
);
