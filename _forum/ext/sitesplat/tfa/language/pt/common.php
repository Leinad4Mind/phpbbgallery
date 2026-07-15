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
		'TFA'							=> 'Autenticação por 2 Factores',
		'TFA_REQUIRED_KEY_MISSING'      => 'O administrador do fórum requer que tenhas adicionado uma chave de Autenticação de 2 Factores para acederes a certos áreas deste fórum, no entanto, não tens nenhuma chave (compatível) associada à tua conta. Podes adicionar uma nova chave de segurança <a href="%s">aqui</a>.
												<br />Por razões de segurança, o fórum foi desactivado até que adiciones uma chave de segurança na tua conta. Pode ser necessário preencheres a tua palavra-passe enquanto adicionas uma chave de segurança!',
		// Controller
		'TFA_SOMETHING_WENT_WRONG'      => 'Ocorreu algo inesperado. Por favor, tente novamente mais tarde',
		'ERR_NO_MATCHING_REQUEST'       => 'Nenhuma solicitação correspondente encontrada',
		'ERR_NO_MATCHING_REGISTRATION'  => 'Nenhum registo correspondente encontrado',
		'ERR_AUTHENTICATION_FAILURE'    => 'Autenticação falhou',
		'ERR_UNMATCHED_CHALLENGE'       => 'Desafio do registo não corresponde',
		'ERR_ATTESTATION_SIGNATURE'     => 'A assinatura do atestado não corresponde',
		'ERR_ATTESTATION_VERIFICATION'  => 'O certificado do atestado não pode ser validado',
		'ERR_BAD_RANDOM'                => 'Não foi possível obter uma boa fonte de aleatoriedade',
		'ERR_COUNTER_TOO_LOW'           => 'Contador muito baixo',
		'ERR_PUBKEY_DECODE'             => 'Falha na descodificação da chave pública',
		'ERR_BAD_UA_RETURNING'          => 'Erro retornado pelo user-agent',
		'ERR_OLD_OPENSSL'               => 'O OpenSSL deve usar pelo menos a versão 1.0.0, a usada é a %s',
		'UNKNOWN_ERROR'                 => 'Ocorreu um erro desconhecido durante a validação da sua chave de segurança. Por favor, tente novamente mais tarde.',

		'ERR_TFA_NO_REQUEST_FOUND_IN_SESSION'	=> 'Nenhum pedido encontrado na sessão actual. Submeteste por alguma página diferente?',
		'TFA_TFA_NOT_REGISTERED'				=> 'A chave de segurança usada não se encontra associada à tua conta',

		'TFA_NO_ACCESS'						=> 'Parece que não tens acesso a esta página?',
		'TFA_UNABLE_TO_UPDATE_SESSION'		=> 'Incapaz de actualizar a sessão. Por favor, contacta o administrador do fórum',
		'TFA_DISABLED'						=> 'Autenticação por 2 Factores encontra-se desactivado',

		'TFA_OTP_KEY_LOG'					=> 'Gera aqui a chave e clica em submeter',
		'TFA_OTP_KEY_LOG_EXPLAIN'			=> 'Insere o código de verificação gerado pela App Authenticator do teu dispositivo móvel para puderes te conectar com extra segurança na tua conta.',
		'TFA_INCORRECT_KEY'					=> 'A chave indicada está errada.',
		'TFA_NO_KEY_PROVIDED'				=> 'Nenhuma chave providenciada',
		'TFA_KEY_REQUIRED'					=> 'Por favor, digita a tua chave de segurança',

		'TFA_OTP'					=> 'OTP',
	)
);
