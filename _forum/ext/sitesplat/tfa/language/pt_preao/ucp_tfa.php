<?php

/**
 * @package Two Factor Authentication for phpBB.
 * @copyright (c) 2016 SiteSplat All rights reserved
 * @license Proprietary
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

$lang = array_merge(
	$lang, [
		'TFA_NO_KEYS'             => 'N\D',
		'TFA_NO_KEY_FOUND'        => 'Nenhuma chave de autenticação de dois fatores encontrada. Faça o download da aplicação Google Authenticator no seu dispositivo móvel e associe a conta inserindo uma nova chave. <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="blank"><i class="fa fa-android"></i> Android</a> &#47; <a href="https://itunes.apple.com/ca/app/google-authenticator/id388497605" target="blank"><i class="fa fa-apple"></i> Apple</a>',
		'TFA_KEYS'                => 'Nesta página pode gerir as suas chaves de autenticação de dois fatores. Se perder as suas chaves, certifique-se de remover a chave do seu Authenticator! Pode redefinir a sua chave com a função de recuperar palavra-passe (esqueci-me da senha), depois poderá iniciar sessão novamente e criar uma nova chave.',
		'TFA_NO_MODE'             => 'Nenhum Modo',
		'TFA_KEYS_DELETED'        => 'Chaves selecionadas removidas.',
		'TFA_NEW'                 => 'Adicionar nova chave',
		'TFA_ERROR'               => 'Parece que algo correu mal...',
		'TFA_REG_FAILED'          => 'O registo falhou com o erro: ',
		'TFA_REG_EXISTS'          => 'A chave fornecida já foi registada na sua conta',
		'TFA_ADD_KEY'             => 'Registar nova chave',
		'TFA_KEY_ADDED'           => 'A sua chave de segurança foi adicionada e pode ser utilizada.',
		'TFA_INSERT_KEY'          => 'Insira a sua chave de segurança e prima o botão na chave',
		'TFA_REGISTERED'          => 'Chave registada',
		'TFA_LAST_USED'           => 'Última utilização da chave',
		'TFA_LOGIN_FROM'          => 'Último início de sessão (login) de',
		'TFA_MODULE_NOT_FOUND'    => 'O módulo selecionado (%s) não foi encontrado',
		'TFA_MODULE_NO_REGISTER'  => 'O módulo selecionado não aceita novas chaves para registo',
		'TFA_SELECT_NEW'          => 'Adicionar nova chave',
		'TFA_ADD_NEW_OTP_KEY'     => 'Adicione uma nova chave OTP à sua conta',
		'TFA_ADD_OTP_KEY_MAIN'    => 'Digitalize o código QR abaixo com a Aplicação (App) Google Authenticator para <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="blank"><i class="fa fa-android"></i> Android</a> &#47; <a href="https://itunes.apple.com/ca/app/google-authenticator/id388497605" target="blank"><i class="fa fa-apple"></i> Apple</a>, ou também pode utilizar a chave gerada abaixo.<br /> Uma vez concluído, insira o código fornecido pela sua aplicação Authenticator para associar finalmente a sua conta.',
		'TFA_OTP_KEY'             => 'Chave gerada aqui, em seguida carregue em submeter',
		'TFA_ADD_OTP_KEY_EXPLAIN' => '<span>%s</span>',
		'TFA_OTP_INVALID_KEY'     => 'Chave fornecida inválida.',
		'TFA_KEYTYPE'             => 'Tipo de chave',
		'TFA_KEY_NOT_USED'        => 'Ainda não utilizada',
	]
);
