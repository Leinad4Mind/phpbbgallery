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
		'TFA'                      => 'Autenticação de Dois Fatores (Two Factor Authentication)',
		'TFA_REQUIRED_KEY_MISSING' => 'O administrador deste fórum requer que tenhas adicionado uma chave de Autenticação de Dois Fatores para acesso a partes (limitadas) deste fórum, contudo, de momento não tens chaves (Compatíveis) registadas na tua conta. Podes adicionar uma nova chave de segurança <a href="%s">aqui</a>.
												<br />Por motivos de segurança, o fórum foi desactivado até adicionares uma chave de segurança à tua conta. Poderá ser-te exigido que preenchas a tua palavra-passe ao adicionares uma chave de segurança!',
		// Controller
		'TFA_SOMETHING_WENT_WRONG'     => 'Aconteceu algo inesperado. Por favor, tente novamente mais tarde',
		'ERR_NO_MATCHING_REQUEST'      => 'Nenhum pedido correspondente encontrado',
		'ERR_NO_MATCHING_REGISTRATION' => 'Nenhum registo correspondente encontrado',
		'ERR_AUTHENTICATION_FAILURE'   => 'A autenticação falhou',
		'ERR_UNMATCHED_CHALLENGE'      => 'O desafio de registo não corresponde',
		'ERR_ATTESTATION_SIGNATURE'    => 'A assinatura de atestado não corresponde',
		'ERR_ATTESTATION_VERIFICATION' => 'O certificado de atestado não pode ser validado',
		'ERR_BAD_RANDOM'               => 'Não foi possível obter uma boa fonte de aleatoriedade',
		'ERR_COUNTER_TOO_LOW'          => 'Contador demasiado baixo',
		'ERR_PUBKEY_DECODE'            => 'A descodificação da chave pública falhou',
		'ERR_BAD_UA_RETURNING'         => 'O User-agent (agente de utilizador) devolveu um erro',
		'ERR_OLD_OPENSSL'              => 'O OpenSSL tem de ser, pelo menos, a versão 1.0.0, esta é %s',
		'UNKNOWN_ERROR'                => 'Aconteceu um erro desconhecido durante a validação da sua chave de segurança. Por favor, tente novamente mais tarde.',

		'ERR_TFA_NO_REQUEST_FOUND_IN_SESSION' => 'Nenhum pedido encontrado na sessão actual. Submeteste através de uma página diferente?',
		'TFA_TFA_NOT_REGISTERED'              => 'A chave de segurança utilizada não estava registada na tua conta',

		'TFA_NO_ACCESS'                => 'Parece que não tens acesso a esta página?',
		'TFA_UNABLE_TO_UPDATE_SESSION' => 'Não foi possível actualizar a sessão. Por favor, contacta o administrador do fórum',
		'TFA_DISABLED'                 => 'A autenticação de dois factores foi desactivada',

		'TFA_OTP_KEY_LOG'         => 'Chave gerada aqui, em seguida carrega em submeter',
		'TFA_OTP_KEY_LOG_EXPLAIN' => 'Introduz o código de verificação gerado pela Aplicação (App) Authenticator do teu telemóvel para iniciares sessão de forma segura na tua conta.',
		'TFA_INCORRECT_KEY'       => 'A chave fornecida estava incorrecta.',
		'TFA_NO_KEY_PROVIDED'     => 'Nenhuma chave fornecida',
		'TFA_KEY_REQUIRED'        => 'Por favor, fornece a tua chave de segurança',

		'TFA_OTP' => 'OTP',
	]
);
